<?php

namespace api\v4\modules\transaction\repositories\tps;

use common\ddd\interfaces\repositories\ReadInterface;
use common\ddd\repositories\TpsRepository;
use api\v4\modules\service\modelsDeco\Service;
use common\ddd\data\Query;
use ReflectionClass;
use Yii;
use yii2woop\tps\components\OperationService;
use yii2woop\tps\components\TransfersReport;
use yii2woop\tps\generated\enums\OperationDirection;
use yii2woop\tps\generated\request\report\filter\TransferPaymentReportFilter;
use yii2woop\tps\generated\request\report\filter\TransferPaymentReportFilterBranch;
use yii2woop\tps\generated\transport\TpsReports;
use yii2woop\tps\generated\exception\tps\NotAuthenticatedException;
use yii\web\UnauthorizedHttpException;
use yii2mod\helpers\ArrayHelper;
use yii2lab\helpers\Helper;

class HistoryRepository extends TpsRepository implements ReadInterface {

	// todo: переименовать findOne на oneById
	
	public function oneById($id, Query $query = null) {
		$filterBranch = self::createFilter();
		$filterBranch->filter->operationId = [intval($id)];
		$report = self::createReport($filterBranch);
		$report->offset = 0;
		$report->limit = 1;
		$result = self::sendReport($report);
		$result = self::fields($result['data']);
		$item = ArrayHelper::first($result);
		//return $item;
		return $this->forgeEntity($item);
	}
	
	public function all(Query $query = null) {
		$result = self::findAll($query);
		$result->data = self::fields($result->data);
		//$result->data = $this->forgeEntity($result->data);
		//prr($result->data);
		return $result;
	}
	
	public function count(Query $query = null) {
	
	}
	
	public static function findOne($id) {
		$filterBranch = self::createFilter();
		$filterBranch->filter->operationId = [intval($id)];
		$report = self::createReport($filterBranch);
		$report->offset = 0;
		$report->limit = 1;
		$result = self::sendReport($report);
		return ArrayHelper::first($result->data);
	}
	
	// todo: переименовать findOne на all
	
	public static function findAll(Query $query = null) {
		$params = $query->data();
		$filterBranch = self::createFilter();
		
		$filterBranch->filter->dateFrom = ($query->getParam('where.date.from') !== null) ? self::formatTime($params['where']['date']['from'] . ' 00:00:00') : date('Y-m-d H:i:s', time() - 7776000);
		$filterBranch->filter->dateTo = ($query->getParam('where.date.to') !== null) ? self::formatTime($params['where']['date']['to'] . ' 23:59:59') : date('Y-m-d H:i:s', time());
		
		$filterBranch->filter->operationTypeId = ($query->getParam('where.operationTypeId') !== null) ? [intval($params['where']['operationTypeId'])] : null;
		$filterBranch->filter->subjectFrom = ($query->getParam('where.subjectFrom') !== null) ? [$params['where']['subjectFrom']] : null;
		
		// потому что при фильтрации по категории, к одной категории может пренадлежать несколько sereviceID (оставлено для возможности возврата к фильтрации по конкретному сервису)
		/*if($query->getParam('where.serviceId') !== null) {
			foreach ($params['where']['serviceId'] as $key => $val) {
				$serviceIdValues[] = intval($val);
			}
		}else {*/
		
		// проверяем наличие ID категории в параметрах для фильтрации
		if(intval($query->getParam('where.operationCategoryId')) > 0) {
			// получаем все serviceID по categoryID
			$servicesListInCategories = \Yii::$app->service->service->allByCategoryId(intval($query->getParam('where.operationCategoryId')));
			// формируем правильный массив значений serviceID
			if(count($servicesListInCategories) > 0) {
				foreach($servicesListInCategories as $key => $val) {
					$serviceIdValues[] = intval($val->id);
				}
			}else {
				/* это для того что бы если категория все же выбрана в фильтре но к ней нет принадлежащих сервисов,
				то фильтр по сервисам не должен назначаться как null и соответственно не выдавать все, а выдавать пустой результат (ничего не найдено) по выбранной категории */
				if(strval($query->getParam('where.operationCategoryId')) !== "") {
					$serviceIdValues[] = intval(-808080);
				}else {
					$serviceIdValues = null;
				}
			}
		}else {
			$serviceIdValues = null;
		}
		//}
		$filterBranch->filter->serviceId = (!empty($serviceIdValues)) ? $serviceIdValues : null;
		
		$report = self::createReport($filterBranch);
		// потому что от мобильного приложения парметры приходят методом GET напрямую (без предварительного формирования как с фронтэнда)
		if(intval($query->getParam('where.limit')) > 0) {
			$report->limit = intval($query->getParam('where.limit'));
		}else if(intval($query->getParam('limit')) > 0) {
			$report->limit = intval($query->getParam('limit'));
		}else {
			$param = \Yii::$app->request->get();
			if(array_key_exists('limit', $param)) {
				$report->limit = intval($param['limit']);
			}else {
				$report->limit = intval(10);
			}
		}
		if(intval($query->getParam('where.offset')) > 0) {
			$report->offset = intval($query->getParam('where.offset'));
		}else if(intval($query->getParam('offset')) > 0) {
			$report->offset = intval($query->getParam('offset'));
		}else {
			$param = \Yii::$app->request->get();
			if(array_key_exists('offset', $param) or isset($param['offset'])) {
				$report->offset = intval($param['offset']);
			}else {
				$report->offset = intval(0);
			}
		}
		if(array_key_exists('order', $params)) {
			$report->order = array($params['order']);
		}

		$result = self::sendReport($report);
		return $result;
	}

	private static function formatTime($date) {
		$date = strtotime($date)/* - OperationService::TIME_DIFFERENCE*/;
		return date('Y-m-d H:i:s', $date);
	}

	private static function createReport($filterBranch) {
		$report = TpsReports::transferPaymentExtended();
		$report->filter->filter = new TransferPaymentReportFilter();
		$report->filter->children = array($filterBranch);
		return $report;
	}

	private static function createFilter($type = 'and') {
		$filterBranch = new TransferPaymentReportFilterBranch();
		$filterBranch->filter = new TransferPaymentReportFilter();
		$filterBranch->type = $type;
		return $filterBranch;
	}

	private static function sendReport($report) {
		try {
			$result = $report->send();
		} catch (NotAuthenticatedException $e) {
			throw new UnauthorizedHttpException;
		}
		$result->data = TransfersReport::addBillingInfo($result->data);
		//$serviceListArrayIndexed = self::getServiceList($result->data);
		//$result->data = self::fields($result->data, $serviceListArrayIndexed);
		return $result;
	}

	private static function getServiceList($data) {
		$serviceIdList = self::getServiceIdList($data);
		$query = new Query;
		$query->where('id', $serviceIdList);
		$serviceList = Yii::$app->service->service->all($query);
		$serviceListArray = ArrayHelper::toArray($serviceList);
		$serviceListArrayIndexed = ArrayHelper::index($serviceListArray, 'id');
		return $serviceListArrayIndexed;
	}

	private static function getServiceIdList($data) {
		$serviceIdList = [];
		foreach($data as $item) {
			$serviceIdList[] = $item['serviceId'];
		}
		$serviceIdList = array_unique($serviceIdList);
		$serviceIdList = array_values($serviceIdList);
		return $serviceIdList;
	}

	private static function fields($data) {
		$result = ArrayHelper::toArray($data);
		$serviceList = self::getServiceList($result);
		if(ArrayHelper::isIndexed($data)) {
			foreach($data as &$item) {
				$item = self::field($item, $serviceList[intval($item['serviceId'])]);
			}
		} else {
			$data = self::field($data, $serviceList[$data['serviceId']]);
		}
		return $data;
	}

	private static function getFieldAmount($item) {
		$result = $item['amount'];
		if(!empty($item['billingInfo']['fields']['amount'])) {
			$result = intval($item['billingInfo']['fields']['amount']);
		}
		return $result;
	}

	private static function calcCommission($item) {
		$fieldAmount = self::getFieldAmount($item);
		if($fieldAmount == $item['amount']) {
			return 0;
		} else {
			return intval($item['amount']) - $fieldAmount;
		}
	}

	private static function getDirection($value) {
		static $constantsIndexed = null;
		if(empty($constantsIndexed)) {
			$reflectionClass = new ReflectionClass('yii2woop\tps\generated\enums\OperationDirection');
			$constants = $reflectionClass->getConstants();
			$constantsValues = array_values($constants);
			$constantsIndexed = array_flip($constantsValues);
		}
		return isset($constantsIndexed[$value]) ? $constantsIndexed[$value] : null;
	}

	private static function getReceipt($data) {
		$result['subjectFrom'] = $data['subjectFrom'];
		$result['subjectFromLastName'] = $data['subjectFromLastName'];
		$result['subjectTo'] = ArrayHelper::getValue($data, 'subjectTo');
		$result['subjectToId'] = $data['subjectToId'];
		$result['specialistId'] = $data['specialistId'];
		$result['specialist'] = $data['specialist'];
		$result['specialistLastName'] = $data['specialistLastName'];
		$result['commission'] = self::calcCommission($data);
		$result['amount'] = self::getFieldAmount($data);
		return $result;
	}

	private static function field($item, $service) {
		$data = ArrayHelper::toArray($item);
		$result['id'] = ArrayHelper::getValue($data, 'id');
		$result['amount'] = ArrayHelper::getValue($data, 'amount');
		$result['status'] = ArrayHelper::getValue($data, 'status');
		$result['description'] = ArrayHelper::getValue($data, 'description');
		$result['type'] = ArrayHelper::getValue($data, 'type');
		$result['title'] = ArrayHelper::getValue($service, 'title');
		$result['paymentAccount'] = ArrayHelper::getValue($data, 'paymentAccount');
		$result['direction'] = self::getDirection($data['direction']);
		$result['serviceId'] = ArrayHelper::getValue($data, 'serviceId');
		$result['picture_url'] = ArrayHelper::getValue($service, 'picture_url');
		$result['externalId'] = ArrayHelper::getValue($data, 'externalId');
		$result['dateOper'] = $data['dateOper'];
 		$result['dateDone'] = $data['dateDone'];
		$result['dateModify'] = $data['dateModify'];
		$result['reqStat'] = ArrayHelper::getValue($data, 'reqStat');
		$result['receipt'] = self::getReceipt($data);
		$result['billingInfo'] = !empty($data['billingInfo']) ? $data['billingInfo'] : null;

		return $result;
	}
	
}