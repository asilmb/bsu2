<?php

namespace api\v4\modules\transfer\controllers;

use common\ddd\rest\Controller;
use yii\filters\VerbFilter;

class DefaultController extends Controller {
	
	public $serviceName = 'transfer.default';
	public $usePagination = false;
	
	/**
	 * @inheritdoc
	 */
	//public function behaviors() {
	//	return [
	//		'authenticator' => [
	//			'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
	//		],
	//		'verbFilter' => [
	//			'class' => VerbFilter::className(),
	//			'actions' => $this->verbs(),
	//		],
	//	];
	//}
	
	//protected function verbs()
	//{
	//	return [
	//		'check' => ['POST'],
	//		'pay' => ['POST'],
	//		'pay-from-card' => ['POST'],
	//		'commission' => ['POST'],
	//		'debt' => ['POST'],
	//	];
	//}
	//
	public function actions() {
		return [
			'wallet-wallet' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 201,
				'serviceMethod' => 'walletToWallet',
				'serviceMethodParams' => ['from','to'],
			],
			//'wallet-card' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'pay',
			//],
			//'wallet-bonus' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'payFromCard',
			//],
			//'bonus-wallet' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'commission',
			//],
			//'bonus-card' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'debt',
			//],
			//'bonus-bonus' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'debt',
			//],
			//'card-bonus' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'debt',
			//],
			//'card-wallet' => [
			//	'class' => 'common\ddd\rest\UniAction',
			//	'service' => $this->service,
			//	'successStatusCode' => 201,
			//	'serviceMethod' => 'debt',
			//],
		];
	}
}
