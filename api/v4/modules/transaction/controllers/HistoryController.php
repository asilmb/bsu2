<?php

namespace api\v4\modules\transaction\controllers;

use common\ddd\rest\ActiveControllerWithQuery as Controller;
use yii\filters\VerbFilter;

class HistoryController extends Controller
{
	
	public $serviceName = 'transaction.history';
	public $usePagination = true;
	
	public function format() {
		return [
			'dateOper' => 'time:api',
			'dateDone' => 'time:api',
			'dateModify' => 'time:api',
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		$actions = parent::actions();
		$result['index'] = [
			'class' => 'common\ddd\rest\IndexActionWithQuery',
			'service' => $this->service,
			'serviceMethod' => 'getDataProvider2',
		];
		$result['get-operation-types'] = [
			'class' => 'common\ddd\rest\IndexActionWithQuery',
			'service' => $this->service,
			'serviceMethod' => 'getOperationTypes',
		];
		$result['get-states'] = [
			'class' => 'common\ddd\rest\IndexActionWithQuery',
			'service' => $this->service,
			'serviceMethod' => 'getOperationStates',
		];
		$result['get-categories-list'] = [
			'class' => 'common\ddd\rest\IndexActionWithQuery',
			'service' => \Yii::$app->service->category,
			'serviceMethod' => 'categoriesTree',
		];
		
		$result['view'] = $actions['view'];
		return $result;
	}
	
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
			/*'index' => ['GET', 'HEAD'],
			'view' => ['GET', 'HEAD'],
			'approve' => ['PUT'],
			'delete' => ['DELETE'],*/
		];
	}
	
	
	
	
}
