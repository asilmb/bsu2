<?php

namespace backend\modules\content\controllers;

use common\modules\content\models\News;
use common\modules\content\models\NewsSearch;
use Yii;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * NewsController implements the CRUD actions for news model.
 */
class NewsController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function behaviors() {
		return [
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'delete' => ['POST'],
				],
			],
		];
	}
	

}
