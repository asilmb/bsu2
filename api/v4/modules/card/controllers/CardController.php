<?php

namespace api\v4\modules\card\controllers;

use Yii;
use yii2lab\rest\rest\Controller as Controller;
use yii\web\NotFoundHttpException;
use yii\web\ForbiddenHttpException;

class CardController extends Controller
{
 
	public $card;
	
	/**
	 * @inheritdoc
	 */
	public function init() {
		parent::init();
		$this->card = Yii::$app->card;
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
		];
	}
	
	public function actionView($id) {
		$this->card->withBank();
		return $this->getEntity($id);
	}
	
	public function actionIndex() {
		$this->card->withBank();
		return $this->card->findAll();
	}
	
	public function actionDelete($id) {
		$entity = $this->getEntity($id);
		if(empty($entity)) {
			return null;
		}
		if($this->card->delete($entity)) {
			Yii::$app->response->setStatusCode(204);
		} else {
			throw new ForbiddenHttpException();
		}
	}
	
	public function actionUpdate($id) {
		$entity = $this->getEntity($id);
		$body = Yii::$app->getRequest()->getBodyParams();
		$this->card->approve($entity, $body);
		if($this->card->hasErrors()) {
			Yii::$app->response->setStatusCode(422);
			return $this->card->getErrors();
		}
		return $entity;
	}
	
	private function getEntity($id) {
		$entity = $this->card->findById($id);
		if(empty($entity)) {
			throw new NotFoundHttpException();
		}
		return $entity;
	}
	
}
