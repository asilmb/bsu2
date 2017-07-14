<?php

namespace api\v4\modules\service\controllers;

use Yii;
use yii2lab\rest\rest\ActiveController as Controller;
use yii2lab\misc\yii\base\Model;

class DefaultController extends Controller
{
 
	public $modelClass = 'api\v4\modules\service\models\ServiceSearch';
	public $updateScenario = Model::SCENARIO_UPDATE;
	public $createScenario = Model::SCENARIO_CREATE;
	
	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
				'only' => ['create', 'update', 'delete'],
			],
			'access' => [
				'class' => 'yii\filters\AccessControl',
				'only' => ['create', 'update', 'delete'],
				'rules' => [
					[
						'allow' => true,
						'roles' => ['service.service.manage'],
					],
				],
			],
		];
	}
	
	/**
	 * @inheritdoc
	 */
	public function actions()
	{
		$actions = parent::actions();
		unset($actions['index']);
		unset($actions['view']);
		unset($actions['delete']);
		unset($actions['update']);
		return $actions;
	}

	public function actionView($id)
	{
		$params = Yii::$app->request->get();
		return Yii::$app->service->findOne($id, $params);
	}

	public function actionDelete($id)
	{
		if(Yii::$app->service->delete($id)) {
			Yii::$app->response->setStatusCode(204);
		}
	}
	
	public function actionUpdate($id)
	{
		$body = Yii::$app->getRequest()->getBodyParams();
		if(Yii::$app->service->update($id, $body)) {
			Yii::$app->response->setStatusCode(200);
		}
	}
	
	public function actionIndex()
	{
		$params = Yii::$app->request->get();
		return Yii::$app->service->getDataProvider($params);
	}
}
