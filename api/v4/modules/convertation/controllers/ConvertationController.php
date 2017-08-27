<?php

namespace api\v4\modules\convertation\controllers;

use common\ddd\rest\ActiveController as Controller;
use yii\filters\VerbFilter;

class ConvertationController extends Controller
{
	
	public $serviceName = 'convertation.convertation';
	//public $usePagination = true;
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['authenticator'] = [
			'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
		];
		return $behaviors;
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		$result['account-to-card'] = [
			'class' => 'common\ddd\rest\UniAction',
			'service' => $this->service,
			'serviceMethod' => 'accountToCard',
		];
		$result['account-to-account'] = [
			'class' => 'common\ddd\rest\UniAction',
			'service' => $this->service,
			'serviceMethod' => 'accountToAccount',
		];
		$result['card-to-account'] = [
			'class' => 'common\ddd\rest\UniAction',
			'service' => $this->service,
			'serviceMethod' => 'cardToAccount',
		];

		return $result;
	}

	protected function verbs()
	{
		return [
			'index' => ['GET', 'HEAD', 'POST'],
			//'create' => ['GET', 'HEAD'],
		];
	}
}
