<?php

namespace api\v4\modules\content\controllers;

use api\v4\modules\user\forms\imageForm;
use common\ddd\rest\Controller;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;

class ImageController extends Controller {
	
	public $serviceName = 'content.image';
	
	public function format() {
		return [
			'sex' => 'boolean',
			'birth_date' => 'time:api',
		];
	}
	
	public function getSelf() {
		return $this->repository->getSelf();
	}
	
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'authenticator' => [
				'class' => 'yii2woop\tps\filters\auth\HttpTpsAuth',
			],
		];
	}
	
	public function actionView() {
		return $this->service->getSelf();
	}
	
	public function actionDelete() {
		$this->service->deleteSelf();
		Yii::$app->response->setStatusCode(204);
	}
	
	public function actionUpdate() {
		$model = new ImageForm();
		if(!$model->validate()) {
			return $model;
		}
		try {
			$this->service->updateSelf($model->imageFile);
			Yii::$app->response->setStatusCode(201);
		} catch(UnprocessableEntityHttpException $e) {
			return $e->getErrors();
		}
	}
	
}