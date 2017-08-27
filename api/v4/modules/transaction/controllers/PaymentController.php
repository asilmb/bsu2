<?php

namespace api\v4\modules\transaction\controllers;

use yii\filters\VerbFilter;
use common\ddd\rest\Controller;

class PaymentController extends Controller
{
	
	public $serviceName = 'transaction.payment';
	public $usePagination = false;
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
			'verbFilter' => [
				'class' => VerbFilter::className(),
				'actions' => $this->verbs(),
			],
		];
	}
	
	protected function verbs()
	{
		return [
			'check' => ['POST'],
			'pay' => ['POST'],
			'pay-from-card' => ['POST'],
			'commission' => ['POST'],
			'debt' => ['POST'],
			'confirm' => ['POST'],
		];
	}
	
	public function actions() {
		return [
			'check' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'check',
			],
			'pay' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'pay',
			],
			'pay-from-card' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'payFromCard',
			],
			'commission' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'commission',
			],
			'debt' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'debt',
			],
			'confirm' => [
				'class' => 'common\ddd\rest\UniAction',
				'service' => $this->service,
				'successStatusCode' => 200,
				'serviceMethod' => 'confirm',
			],
		];
	}
	
	/** todo: create action for repeat payment */
	
}
