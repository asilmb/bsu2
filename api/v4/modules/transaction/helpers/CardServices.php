<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 02.08.2017
 * Time: 15:38
 */

namespace api\v4\modules\transaction\helpers;


use api\v4\modules\service\models\ServiceDAO;
use Yii;

use yii2woop\tps\components\TransfersReportFilter;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\enums\ErrorType;
use yii2woop\tps\generated\enums\OperationDataType;
use yii2woop\tps\generated\enums\OperationSubType;
use yii2woop\tps\generated\exception\tps\AcquiringOperationWastedException;
use yii2woop\tps\generated\exception\tps\CallCounterExceededException;
use yii2woop\tps\generated\exception\tps\CashInFromCardForbiddenException;
use yii2woop\tps\generated\exception\tps\ConfirmOperationException;
use yii2woop\tps\generated\exception\tps\ExternalOperationNotPaidException;
use yii2woop\tps\generated\exception\tps\MoneyPaymentException;
use yii2woop\tps\generated\exception\tps\NoCommissionException;
use yii2woop\tps\generated\exception\tps\NotRegisteredCardholderException;
use yii2woop\tps\generated\exception\tps\OperationAlreadyPerformedException;
use yii2woop\tps\generated\exception\tps\OperationInProcessException;
use yii2woop\tps\generated\exception\tps\OperationLimitExceededException;
use yii2woop\tps\generated\exception\tps\ValidationException;
use yii2woop\tps\generated\exception\tps\WithdrawalDeclinedException;
use yii2woop\tps\generated\exception\tps\WithdrawalInputPendingException;
use yii2woop\tps\generated\exception\tps\WrongApprovalCodeException;
use yii2woop\tps\generated\exception\TpsException;
use yii2woop\tps\generated\request\report\filter\TransferPaymentReportFilter;
use yii2woop\tps\generated\transport\TpsCommands;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\generated\transport\TpsReports;
use yii2woop\tps\models\BaseCardOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;

class CardServices {
	
	const CARD_TYPE_RESMI = 2;
	const TEST_RESMI = 387631547;
	const SUBJECT_RESMI = 'resmi_salem_sub';
	
	public $acquiring_access;
	
	private $card_operation;
	private $operationId;
	
	
	public function getTerminalType($testMod = null) {
		if ($testMod == null) {
			return self::CARD_TYPE_RESMI;
		} elseif ($testMod) {
			return self::TEST_RESMI;
		}
		return null;
	}
	
	
	public function createCardOperation($operationId, $serviceId, $amount, $cardId) {
		$baseCard = BaseCardOperation::getModel(param('AcquiringAccess'), param('AcquiringType'));
		//Обращение к ТПС, получение данных по этой операции
		$pay_operations = TpsCommands::getOperationsData([(intval($operationId))])->send();
		
		$this->operationId = $operationId;
		if (!empty($pay_operations)) {
			
			
			$pay_operation_info = $pay_operations[0];
			
			if (!empty($pay_operation_info->parentId)) {
				$card_operation['setOperationId'] = $pay_operation_info->parentId;
				
				$card_operations = TpsCommands::getOperationsData([$pay_operation_info->parentId])->send();
				
				if (!empty($card_operations)) {
					$card_operation_info = $card_operations[0];
					$baseCard->setSign($card_operation_info->document);
					$baseCard->setAmount($pay_operation_info->amount);
					//$card_operation['setSign'] = $card_operation_info->document;
					//$card_operation['setAmount'] = $pay_operation_info->amount;
					$this->card_operation = $card_operation;
					//$this->putOperationInfoIntoCookies();//сделать запись в базу и в куки id платежа
					return $card_operation;
				}
			}
			
			//Получение полной суммы платежа сумма+коммиссия
			$amount = $this->getFullAmount($serviceId, $amount);
			//
			//if ($operationId) {
			//	if (self::chekCardLinkingType()) {
			//		//$card_operation->terminalType = EpayCardLinkOperation::getAcquiringTerminal();
			//	} else {
			//		//$card_operation->terminalType = self::CARD_TYPE_RESMI;
			//	}
			//}
			try {
				if ($this->create($cardId, $amount, $operationId)) {
					//$this->putOperationInfoIntoCookies();// записать операцию в куки
					$this->updatePendingReplanishmentCount();
					
					return $this->operationId;
				}
			} catch (OperationLimitExceededException $e) {
				$this->cancel(); // Надо написать метод для отмены операции
				throw $e;
			} catch (CashInFromCardForbiddenException $e) {
				$this->cancel();
				throw $e;
			}
			
		}
	}
	
	
	public static function getCommissionBySpec($service, $amount, $gatewaySpec, $round = true) {
		if (is_numeric($service)) {
			$service = ServiceDAO::findAll($service);
		} else {
			$service = ServiceDAO::find()->where(['service_name' => $service]);
		}
		if ($service) {
			$commission = self::getCommissionBySpecInner($service[0]->merchant, $service[0]->service_id, $amount, $gatewaySpec);
			if ($round) {
				$commission = round($commission, 2);
			}
		} else {
			throw new NoCommissionException('Service not found', ErrorType::ERROR_NO_COMMISSION);
		}
		
		return ($commission);
	}
	
	public static function getCommissionBySpecInner($merchant, $service_id, $amount, $gatewaySpec) {
		if (is_array($amount) || is_object($amount)) {
			$amount = (float) array_reduce((array) $amount, function ($result, $item) {
				return $result + $item;
			}, 0);
		} else {
			$amount = (float) $amount;
		}
		
		$commission = TpsOperations::getCommission(Yii::$app->user->identity->login, (int) $service_id, $amount, $gatewaySpec)->send();
		
		$commission = round($commission, 2);
		return $commission;
	}
	
	
	public function cancel() {
		$data = TpsOperations::cancel([$this->operationId])->send();
		if (is_array($data) && array_pop($data)) {
			$this->updatePendingReplanishmentCount();
			return true;
		}
		return false;
	}
	
	//Получение полной суммы оплаты, сумма+коммиссия
	public function getFullAmount($serviceId, $amount) {
		//Обращение к репозиторию, получение коммиссии
		$commission = Yii::$app->transaction->payment->getCommissionByServiceId($serviceId, $amount);
		
		return $amount + floatval($commission);
	}
	
	
	//Проверка типа привязанной карты, зависит каким Эквайрингом пользуемся
	public static function chekCardLinkingType() {
		return param('CardLinkingType') == 'epay';
	}
	
	
	public function create($cardId, $amount, $operationId) {
		if ($cardId) {
			$data = TpsOperations::newLinkedCard($amount, self::CARD_TYPE_RESMI, AcquiringType::RESMI_WOOPPAY_LINKED, OperationSubType::SIMPLE, strval($cardId), null, $operationId)->send();
			
			if (is_array($data)) {
				$operationId = $data['operationId'];
				$this->card_operation = $data['document'];
			} else {
				$operationId = $data;
			}
			$this->operationId = $operationId;
			//$report = TpsReports::transferPaymentExtended();
			
			$operation = TpsCommands::getOperationsData([$operationId])->send();
			
			if (!empty($operation)) {
				$this->updatePendingReplanishmentCount();
				
				return true;
			} else {
			
				TpsOperations::cancel($this->operationId)->send();
				
				
				
				return false;
			}
		}
	}

	public function updatePendingReplanishmentCount() {
		if (!\Yii::$app->user->isGuest) {
			$cnt = 0;
		
			$services = ServiceDAO::find()->where(['type' => ServicesType::ACQUIRING])->all();
			
			if (!empty($services)) {
				
				$report = TpsReports::transferPaymentExtended();
				$report->filter->filter = new TransferPaymentReportFilter();
				$report->filter->filter->operationStatus = [
					OperationStatus::CREATED,
					OperationStatus::CONFIRMED,
				];
				$report->filter->filter->operationDirection = OperationDirection::INCOMING;
				$report->filter->filter->viewOwn = true;
				$report->filter->filter->viewType = TransfersReportFilter::VIEW_TYPE_ALL;
				
				$report->limit = 0;
				$report->offset = 0;
				$cnt = $report->send()->count;
			}
		
			return $cnt;
		} else {
			return 0;
		}
	}
	
	
	static public function updateNewPaymentsCount() {
		if (Yii::$app->user->isGuest) {
			return 0;
		}
		$count = 0;
		
	
		$services = ServiceDAO::find()->where([
			'type' => [
				ServicesType::BILLING,
				ServicesType::NOT_BILLING,
				ServicesType::CUSTOM_DONATE,
				ServicesType::CUSTOM_INVOICE,
				ServicesType::INVOICE,
				ServicesType::TRANSFER,
				ServicesType::ADDRESSLESS_TRANSFER,
				ServicesType::WITHDRAWAL_BANK,
				ServicesType::WITHDRAWAL_CARD,
				ServicesType::ATM_CASHOUT,
				ServicesType::KAZPOST_CASHOUT,
			],
		])->all();
		if (!empty($services)) {
			$service_ids = [];
			foreach ($services as $s) {
				$service_ids[] = (int) $s->service_id;
			}
			$report = TpsReports::transferPaymentExtended();
			$report->filter->filter = new TransferPaymentReportFilter();
			$report->filter->filter->operationStatus = [
				OperationStatus::CREATED,
			];
			$report->filter->filter->operationDirection = OperationDirection::OUTGOING;
			$report->filter->filter->viewOwn = true;
			$report->filter->filter->viewType = TransfersReportFilter::VIEW_TYPE_ALL;
			$report->filter->filter->serviceId = $service_ids;
			$report->limit = 0;
			$report->offset = 0;
			$count = $report->send()->count;
		}

		return $count;
	}
	
	
	public function cardConfirm($operationId) {
		
		$operation = TpsCommands::getOperationsData([(int) $operationId])->send();
		
		if (!empty($operation[0])) {
			$operationId = $operation[0]->parentId != 0 ? $operation[0]->parentId : $operation[0]->id;
			$cardOperation = BaseCardOperation::getModelForOperation($operationId);
			
			$cardOperation->setOperationId($operationId);
			
			$try_counter = 1;
			$acquiring_result = null;
			$operationResult = false;
			
			if ($operation[0]->parentId != 0) {
				try {
					
					$cardId = TpsCommands::getOperationAdditionalData($cardOperation->getOperationId(), OperationDataType::CARD_ID)->send();
					
					if (!empty($cardId)) {
						$cardOperation->setCardId($cardId);
					}
				} catch (TpsException $ignore) {
				}
				TRY_CONFIRM_OPERATION_BEGIN:
				try {
					$result = 1;
					// подтверждаем, учитывая возможность того, что операция может быть уже подтверждена/проведена
					try {
						if ($cardOperation->getCardId()) {
							
							$result = TpsOperations::linkedCardDirectConfirm($cardOperation->getOperationId())->send();
							
						} else {
							$result = TpsOperations::acquiringDirectConfirm($cardOperation->getOperationId(), $cardOperation->authCode)->send();
						}
						$operationResult = true;
					} catch (OperationAlreadyPerformedException $e) {
						$result = 0;
					} catch (CallCounterExceededException $e) {
						$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
					} catch (ConfirmOperationException $e) {
						$cardOperations = TpsCommands::getOperationsData([$cardOperation->getOperationId()])->send();
						if (empty($cardOperations)) {
							$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
						} else {
							$cardOperation_info = $cardOperations[0];
							if ($cardOperation_info->status == OperationStatus::CONFIRMED) {
								$result = 0;
							} elseif ($cardOperation_info->status == OperationStatus::FINISHED) {
								$acquiring_result = BaseCardOperation::ACQUIRING_SUCCESS;
							} elseif ($cardOperation_info->status == OperationStatus::DELETED) {
								$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
							} else {
								$result = 1;
							}
						}
					} catch (WithdrawalInputPendingException $e) {
						$acquiring_result = BaseCardOperation::ACQUIRING_INPUT_PENDING;
					} catch (WithdrawalDeclinedException $e) {
						$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
					}
					if ($result == 0 && $acquiring_result === null) {
						// проводим, учитывая возможность того, что операция может быть уже проведена
						try {
							if ($cardOperation->getCardId()) {
								$result = TpsOperations::linkedCardDirectPayment($cardOperation->getOperationId(), self::SUBJECT_RESMI)->send();
							} else {
								$result = TpsOperations::acquiringDirectPayment($cardOperation->getOperationId(), self::SUBJECT_RESMI)->send();
							}
						} catch (OperationAlreadyPerformedException $e) {
							$result = 0;
						} catch (MoneyPaymentException $e) {
							$cardOperations = TpsCommands::getOperationsData([$cardOperation->getOperationId()])->send();
							if (empty($cardOperations)) {
								$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;//$this->markOperationAsDeleted();
							} else {
								$cardOperation_info = $cardOperations[0];
								if ($cardOperation_info->status == OperationStatus::FINISHED) {
									$acquiring_result = BaseCardOperation::ACQUIRING_SUCCESS;
								} elseif ($cardOperation_info->status == OperationStatus::DELETED) {
									$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
								} else {
									throw new MoneyPaymentException('', ErrorType::ERROR_PAYMENT_FAILED);
								}
							}
						} catch (WithdrawalDeclinedException $e) {
							$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
						}
						if ($result == 0 && $acquiring_result === null) {
							$acquiring_result = BaseCardOperation::ACQUIRING_SUCCESS;
						} elseif ($acquiring_result === null) {
							throw new ConfirmOperationException('', ErrorType::ERROR_CONFIRM_OPERATION_FAILED);
						}
					} elseif ($acquiring_result === null) {
						throw new ConfirmOperationException('', ErrorType::ERROR_CONFIRM_OPERATION_FAILED);
					}
				} catch (NotRegisteredCardholderException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_EMPTY_AUTH_CODE;
				} catch (WrongApprovalCodeException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_WRONG_AUTH_CODE;
				} catch (ExternalOperationNotPaidException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_NO_EXTERNAL_OPERATION;
				} catch (OperationLimitExceededException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
				} catch (CashInFromCardForbiddenException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
				} catch (AcquiringOperationWastedException $e) {
					if ($e->newOperationId) {
						$this->card_operation = BaseCardOperation::getModelForOperation($e->newOperationId);
					}
					$acquiring_result = BaseCardOperation::ACQUIRING_WASTED_OPERATION;
				} catch (OperationInProcessException $e) {
					if ($try_counter < 10) {
						sleep(2);
						$try_counter++;
						goto TRY_CONFIRM_OPERATION_BEGIN;
					} else {
						//$acquiring_result = BaseCardOperation::checkOperationStatus($cardOperation->getOperationId());
					}
				}
			} else {
				TRY_CONFIRM_OPERATION_BEGIN_REFILL:
				try {
					$operationResult = $cardOperation->confirm();
					
				} catch (NotRegisteredCardholderException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_EMPTY_AUTH_CODE;
				} catch (WrongApprovalCodeException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_WRONG_AUTH_CODE;
				} catch (ExternalOperationNotPaidException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_NO_EXTERNAL_OPERATION;
				} catch (AcquiringOperationWastedException $e) {
					if ($e->newOperationId) {
						$this->card_operation = BaseCardOperation::getModelForOperation($e->newOperationId);
					}
					$acquiring_result = BaseCardOperation::ACQUIRING_WASTED_OPERATION;
				} catch (OperationInProcessException $e) {
					if ($try_counter < 10) {
						
						sleep(2);
						$try_counter++;
						goto TRY_CONFIRM_OPERATION_BEGIN_REFILL;
					} else {
						$acquiring_result = BaseCardOperation::checkOperationStatus($cardOperation->getOperationId());
					}
				} catch (OperationAlreadyPerformedException $e) {
					$operationResult = true;
				} catch (OperationLimitExceededException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
				} catch (CallCounterExceededException $e) {
					$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
				} catch (MoneyPaymentException $e) {
					$cardOperations = TpsCommands::getOperationsData([$cardOperation->getOperationId()])->send();
					if (empty($cardOperations)) {
						$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;//$this->markOperationAsDeleted();
					} else {
						$cardOperation_info = $cardOperations[0];
						if ($cardOperation_info->status == OperationStatus::FINISHED) {
							$acquiring_result = BaseCardOperation::ACQUIRING_SUCCESS;
						} elseif ($cardOperation_info->status == OperationStatus::DELETED) {
							$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
						} else {
							throw new MoneyPaymentException('', ErrorType::ERROR_PAYMENT_FAILED);
						}
					}
				}
				//catch (ConfirmOperationException $e) {
				$cardOperations = TpsCommands::getOperationsData([$cardOperation->getOperationId()])->send();
				
				if (empty($cardOperations)) {
					$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
				} else {
					$cardOperation_info = $cardOperations[0];
					if ($cardOperation_info->status == OperationStatus::CONFIRMED) {
						$operationResult = true;
					} elseif ($cardOperation_info->status == OperationStatus::FINISHED) {
						$acquiring_result = BaseCardOperation::ACQUIRING_SUCCESS;
					} elseif ($cardOperation_info->status == OperationStatus::DELETED) {
						$acquiring_result = BaseCardOperation::ACQUIRING_FAIL;
					} else {
						
						$operationResult = false;
					}
				}
				//}
				//if ($cardOperation->hasErrors()) {
				//	$e = new ValidationException();
				//	$e->data = $cardOperation->getErrors();
				//	throw $e;
				//}
			}
		} else {
			//throw new InternalNoOperationException('Operation not found', InternalException::ERROR_NO_OPERATION);
		}
		$response = ['success' => $operationResult, 'errorCode' => $acquiring_result];
		
		return $response;
	}
	
}