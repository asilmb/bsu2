<?php
namespace api\v4\modules\transaction\helpers;
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 31.07.2017
 * Time: 10:57
 */
use api\v4\modules\service\models\ServiceDAO;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Cookie;
use common\exceptions\UnprocessableEntityHttpException;
use yii\db\ActiveRecord;
use api\v4\modules\service\models;

class BlackHole {
 
	//Принимает на вход массив разных шаблонов, на выходе выходит один
	public static function storm($response,$body)
	{
		$service = ServiceDAO::findOne(array('service_id'=>$body['service_id']));
		
		//Если у сервис имеет шаблон taxInfo
		if($service->template == 'taxInfo')
		{
			$model['button'] = $response['button'];
			$model['txn_id'] = $response['txn_id'];
			$model['amount'] = $response['amount'];
			$model['service_id'] = $response['service_id'];
			$model['account'] = $response['account'];
			//для debtInfo
			$model['address'] = null;
			$model['invoices']['formedDate'] = null;
			$model['invoices']['invoiceId'] = null;
			$model['invoices']['expireDate'] = null;
			
			foreach ($response['debtInfo']['data'] as $fromData)
			{
				$model['debtInfo'][] = (['amount'=>$fromData['amount']['paramValue'],'invoiceNum'=>$fromData['invoiceNumShow']['paramValue'],'serviceName'=>null,'invoiceId'=>$fromData['invoiceId']['paramValue'],'serviceId'=>null]);
			}
			foreach ($response['debtInfo']['params'] as $fromParams)
			{
				$model['privateData'][] = $fromParams['paramValue'];
			}
			
			return $model;
		}
		
		//Если у сервис имеет шаблон debtInfo
		if($service->template == 'debtInfo')
		{
			$model['button'] = $response['button'];
			$model['txn_id'] = $response['txn_id'];
			$model['amount'] = $response['amount'];
			$model['service_id'] = $response['service_id'];
			$model['account'] = $response['account'];
			$model['address'] = $response['debtInfo']['address'];
			$model['invoices']['formedDate'] = $response['debtInfo']['invoices'][0]['formedDate'];
			$model['invoices']['invoiceId'] = $response['debtInfo']['invoices'][0]['invoiceId'];
			$model['invoices']['expireDate'] = $response['debtInfo']['invoices'][0]['expireDate'];
			
			foreach ($response['debtInfo']['invoices'][0]['services'] as $fromService)
			{
				$model['debtInfo'][] = (['amount'=>$fromService['fixSum'],'invoiceNum'=> null,'serviceName'=>$fromService['serviceName'],'invoiceId'=>null,'serviceId'=>$fromService['serviceId']]);
			}
			foreach ($response['debtInfo']['params'] as $fromParams)
			{
				$model['privateData'][$fromParams['paramName']] = $fromParams['paramValue'];
			}
			
			return $model;
		}
		
		//Казактелеком 980 по номеру, 978 по лицевому счету
		if($service->service_id == 980 || $service->service_id == 978){
			return $response;
		}
		
		return $response;
	}

	
	
}