<?php

namespace api\v4\modules\transaction\helpers;

use api\v4\modules\service\modelsDeco\Service;
use ReflectionClass;
use yii2woop\tps\components\OperationService;
use yii2woop\tps\components\TransfersReport;
//use yii2woop\tps\generated\enums\ServicesStatus;
//use yii2woop\tps\generated\enums\ServicesType;
use yii2woop\tps\generated\enums\OperationDirection;
use yii2woop\tps\generated\request\report\filter\TransferPaymentReportFilter;
use yii2woop\tps\generated\request\report\filter\TransferPaymentReportFilterBranch;
use yii2woop\tps\generated\transport\TpsReports;
use yii2woop\tps\generated\exception\tps\NotAuthenticatedException;
use yii\web\UnauthorizedHttpException;
use yii2mod\helpers\ArrayHelper;
use yii2lab\helpers\Helper;

class HistoryHelper {
	
	public static function findOne($id) {
		$filterBranch = self::createFilter();
		$filterBranch->filter->operationId = [intval($id)];
		$report = self::createReport($filterBranch);
		$report->offset = 0;
		$report->limit = 1;
		$result = self::sendReport($report);
		
		return ArrayHelper::first($result->data);
	}
	
	public static function findAll() {
		$filterBranch = self::createFilter();
		$filterBranch->filter->dateDoneFrom = self::formatTime('2002-03-05');
		$report = self::createReport($filterBranch);
		$result = self::sendReport($report);
		return $result;
	}
	
	private static function formatTime($date) {
		$date = strtotime($date . ' 00:00:00') - OperationService::TIME_DIFFERENCE;
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
		$serviceListArrayIndexed = self::getServiceList($result->data);
		$result->data = self::fields($result->data, $serviceListArrayIndexed);
		return $result;
	}
	
	private static function getServiceList($data) {
		$serviceIdList = self::getServiceIdList($data);
		$serviceList = Service::find()->where(['service_id' => $serviceIdList])->all();
		$serviceListArray = ArrayHelper::toArray($serviceList);
		$serviceListArrayIndexed = ArrayHelper::index($serviceListArray, 'id');
		return $serviceListArrayIndexed;
	}
	
	private static function getServiceIdList($data) {
		$serviceIdList = [];
		foreach($data as &$item) {
			$serviceIdList[] = $item['serviceId'];
		}
		$serviceIdList = array_unique($serviceIdList);
		$serviceIdList = array_values($serviceIdList);
		return $serviceIdList;
	}
	
	private static function fields($data, $serviceList) {
		if(ArrayHelper::isIndexed($data)) {
			foreach($data as &$item) {
				$item = self::field($item, $serviceList[$item['serviceId']]);
			}
		} else {
			$data = self::field($data, $serviceList[$data['serviceId']]);
		}
		return $data;
	}
	
	private static function getFieldAmount($item) {
		$result = null;
		if(!empty($item['billingInfo']['fields']['amount'])) {
			$result = intval($item['billingInfo']['fields']['amount']);
		}
		return $result;
	}
	
	private static function calcCommission($item) {
		$result = null;
		if(empty($item['amount'])) {
			return $result;
		}
		$fieldAmount = self::getFieldAmount($item);
		if($fieldAmount === null) {
			return $result;
		}
		return intval($item['amount']) - $fieldAmount;
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
		$result['dateOper'] = Helper::timeForApi($data['dateOper']);
 		$result['dateDone'] = Helper::timeForApi($data['dateDone']);
		$result['dateModify'] = Helper::timeForApi($data['dateModify']);
		$result['reqStat'] = ArrayHelper::getValue($data, 'reqStat');
		$result['receipt'] = self::getReceipt($data);
		$result['billingInfo'] = !empty($data['billingInfo']) ? $data['billingInfo'] : null;
		
		return $result;
	}
	
}
