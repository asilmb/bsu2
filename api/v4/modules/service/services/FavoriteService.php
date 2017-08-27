<?php

namespace api\v4\modules\service\services;

use api\v4\modules\service\forms\ServiceFavoriteForm;
use common\ddd\helpers\ErrorCollection;
use common\ddd\services\ActiveBaseService;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\web\NotFoundHttpException;

class FavoriteService extends ActiveBaseService {

	public function create($data) {
		$data = $this->validate($data);
		$modeData['user_id'] = Yii::$app->user->id;
		$modeData['billinginfo']['model'] = $data['fields'];
		$modeData['billinginfo']['service_id'] = $data['service_id'];
		$modeData['name'] = $data['title'];
		$entity = $this->domain->factory->entity->create($this->id, $modeData);
		$entity->validate();
		$this->repository->insert($entity);
	}
	
	private function validate($body) {
		$this->validateForm(ServiceFavoriteForm::className(), $body);
		$service = $this->validateService($body['service_id']);
		if(empty($body['title'])) {
			$body['title'] = $service->title;
		}
		$body['fields'] = Yii::$app->service->field->validate($service->id, $body['fields']);
		return $body;
	}
	
	private function validateService($serviceId) {
		try {
			$service = Yii::$app->service->service->oneById($serviceId);
		} catch (NotFoundHttpException $e) {
			$error = new ErrorCollection();
			$error->add('service_id', 'service/service', 'not_found');
			throw new UnprocessableEntityHttpException($error);
		}
		return $service;
	}
}
