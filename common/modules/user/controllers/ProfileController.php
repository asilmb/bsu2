<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 16.08.2017
 * Time: 15:22
 */

namespace common\modules\user\controllers;

use api\v4\modules\user\forms\AvatarForm;
use api\v4\modules\user\forms\ChangeEmailForm;
use common\modules\user\forms\CarForm;
use common\modules\user\forms\ChangePasswordForm;
use common\ddd\data\Query;
use common\exceptions\UnprocessableEntityHttpException;
use common\modules\user\forms\AdditionalForm;
use common\modules\user\forms\addressForm;
use common\modules\user\forms\SetSecurityForm;
use common\widgets\Alert;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii2mod\helpers\ArrayHelper;

class ProfileController extends Controller {
	
	public function behaviors() {
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	public function actionIndex() {
		$model = new AdditionalForm();
		$body = Yii::$app->request->post('AdditionalForm');
		if($body) {
			$model->setAttributes($body, false);
			if($model->validate()) {
				try{
					Yii::$app->account->profile->updateSelf($model);
					Alert::add(['user/profile', 'saved_success'], Alert::TYPE_SUCCESS);
				} catch (UnprocessableEntityHttpException $e){
					$model->addErrorsFromException($e);
				}
			}
		} else {
			$entity = Yii::$app->account->profile->getSelf();
			$model->setAttributes($entity->toArray(), false);
		}
		return $this->render('index', ['model' => $model]);
	}
	
	public function actionCar() {
		$model = new CarForm();
		$body = Yii::$app->request->post('CarForm');
		if($body) {
			$model->setAttributes($body, false);
			if($model->validate()) {
				try{
					Yii::$app->account->car->updateSelf($model);
					Alert::add(['user/car', 'saved_success'], Alert::TYPE_SUCCESS);
				} catch (UnprocessableEntityHttpException $e){
					$model->addErrorsFromException($e);
				}
			}
		} else {
			$entity = Yii::$app->account->car->getSelf();
			$model->setAttributes($entity->toArray(), false);
		}
		return $this->render('car', ['model' => $model]);
	}
	
	public function actionQr($action = false) {
		$entity = Yii::$app->account->qr->getSelf();
		if($action == 'download') {
			Yii::$app->response->xSendFile($entity->file_path);
		}
		if($action == 'print') {
			return $this->render('qr_print', ['entity' => $entity]);
		}
		return $this->render('qr', ['entity' => $entity]);
	}
	
	public function actionAvatar() {
		$model = new AvatarForm();
		if(Yii::$app->request->isPost) {
			if(Yii::$app->request->post('submit')==='delete') {
				Yii::$app->account->avatar->deleteSelf();
				Alert::add(['user/avatar', 'delete_success'], Alert::TYPE_SUCCESS);
			} else {
				if($model->validate()) {
					try{
						Yii::$app->account->avatar->updateSelf($model->imageFile);
						Alert::add(['user/avatar', 'uploaded_success'], Alert::TYPE_SUCCESS);
					} catch (UnprocessableEntityHttpException $e){
						$model->addErrorsFromException($e);
					}
				}
			}
		}
		$entity = Yii::$app->account->avatar->getSelf();
		return $this->render('avatar', ['model' => $model, 'avatar' => $entity]);
	}
	
	public function actionAddress(){
		$model = new addressForm();
		
		if(Yii::$app->request->post()){
			$body = Yii::$app->request->post();
			$model->setAttributes($body['addressForm'], false);
			$entities= $this->entitiesRegionAndCountry();
			try{
				Yii::$app->account->address->updateSelf($model);
				Alert::add(['user/profile', 'saved_success'], Alert::TYPE_SUCCESS);
			}catch (UnprocessableEntityHttpException $e){
				$model->addErrorsFromException($e);
			}
		}else{
			$entity = Yii::$app->account->address->getSelf();
			$model->setAttributes($entity->toArray(), false);
			$entities= $this->entitiesRegionAndCountry();
		}
		if(Yii::$app->request->isAjax){
			$codeRegion = Yii::$app->request->get('codeRegion');
			//if(!empty($code)){
			//	$entitiesRegionByCountryId = Yii::$app->geo->region->allByCountryId($code);
			//	$arrayRegionByCountryId = ArrayHelper::toArray($entitiesRegionByCountryId);
			//	$region = ArrayHelper::map($arrayRegionByCountryId,'id','title');
			//	echo json_encode($region,JSON_UNESCAPED_UNICODE);
			//}
				$entitiesCityByRegionId = Yii::$app->geo->city->allByRegionId($codeRegion);
				$arrayCityByCountryId = ArrayHelper::toArray($entitiesCityByRegionId);
				$country = ArrayHelper::map($arrayCityByCountryId,'id','city_name');
				echo json_encode($country,JSON_UNESCAPED_UNICODE);
			
			Yii::$app->end();
		}
		$country = $entities[0];
		$city = $entities[1];
		$region = $entities[2];
		return  $this->render('address',['region'=>$region,'model'=>$model,'city'=>$city,'country'=>$country]);
	}

	
	
	private function entitiesRegionAndCountry(){
			$entityCountry = Yii::$app->geo->country->all();
			$country = ArrayHelper::map($entityCountry,'code','name_short');
			$entityRegion = Yii::$app->geo->region->all();
			$region = ArrayHelper::map($entityRegion,'id','title');
			$entityCity = Yii::$app->geo->city->all();
			$city = ArrayHelper::map($entityCity,'id','city_name');
			return [$country,$city,$region];
}
	
	public function actionSecurity() {
		return $this->render('security', [
			'modelPassword' => $this->passwordForm(),
			'modelEmail' => $this->emailForm(),
		]);
	}

	private function emailForm() {
		$model = new ChangeEmailForm();
		$body = Yii::$app->request->post('ChangeEmailForm');
		if (!empty($body)) {
			$model->setAttributes($body, false);
			if($model->validate()) {
				try {
					Yii::$app->account->security->changeEmail($model->getAttributes());
					Alert::add(['user/profile', 'email_changed_success'], Alert::TYPE_SUCCESS);
				} catch (UnprocessableEntityHttpException $e) {
					$model->addErrorsFromException($e);
				}
			}
		} else {
			$model->email = Yii::$app->account->auth->identity->email;
		}
		return $model;
	}

	private function passwordForm() {
		$model = new ChangePasswordForm();
		$body = Yii::$app->request->post('ChangePasswordForm');
		if(!empty($body)) {
			$model->setAttributes($body, false);
			if($model->validate()) {
				$bodyPassword = $model->getAttributes(['password', 'new_password']);
				try {
					Yii::$app->account->security->changePassword($bodyPassword);
					Alert::add(['user/profile', 'password_changed_success'], Alert::TYPE_SUCCESS);
				} catch (UnprocessableEntityHttpException $e) {
					$model->addErrorsFromException($e);
				}
			}
		}
		return $model;
	}

}