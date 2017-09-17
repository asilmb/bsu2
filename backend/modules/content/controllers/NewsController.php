<?php

namespace backend\modules\content\controllers;


use api\v4\modules\content\forms\NewsForm;
use api\v4\modules\user\forms\ImageForm;
use common\exceptions\UnprocessableEntityHttpException;
use common\widgets\Alert;
use Yii;
use yii\web\Controller;

/**
 * NewsController implements the CRUD actions for news model.
 */
class NewsController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'index' => [
				'class' => 'backend\modules\content\actions\IndexAction',
				'service' => Yii::$app->content->news,
				'view' => '/news',
			],
            'view' => [
                'class' => 'backend\modules\content\actions\ViewAction',
                'service' => Yii::$app->content->news,
                'view' => '/news',
            ],
			'create' => [
				'class' => 'backend\modules\content\actions\CreateAction',
				'service' => Yii::$app->content->news,
				'form' => 'NewsForm',
				'model' => new NewsForm(),
				'view' => '/news',
			],
			'update' => [
				'class' => 'backend\modules\content\actions\UpdateAction',
				'service' => Yii::$app->content->news,
				'form' => 'NewsForm',
				'model' => new NewsForm(),
				'view' => '/news'
			],
			'delete' => [
				'class' => 'backend\modules\content\actions\DeleteAction',
				'service' => Yii::$app->content->news,
			],
		];
	}

}
