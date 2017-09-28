<?php
namespace backend\modules\content\controllers;


use api\v4\modules\content\forms\ExtraNewsForm;
use common\widgets\Alert;
use Yii;
use yii\web\Controller;

class ExtraNewsController extends Controller
{
	/**
	 * @inheritdoc
	 */
    public function actions() {
        return [
            'index' => [
                'class' => 'backend\modules\content\actions\IndexAction',
                'service' => Yii::$app->content->extraNews,
                'view' => '/extraNews',
            ],
            'create' => [
                'class' => 'backend\modules\content\actions\CreateAction',
                'service' => Yii::$app->content->extraNews,
                'form' => 'ExtraNewsForm',
                'model' => new ExtraNewsForm(),
                'view' => '/extraNews',
            ],
            'update' => [
                'class' => 'backend\modules\content\actions\UpdateAction',
                'service' => Yii::$app->content->extraNews,
                'form' => 'ExtraNewsForm',
                'model' => new ExtraNewsForm(),
                'view' => '/extraNews'
            ],
            'delete' => [
                'class' => 'backend\modules\content\actions\DeleteAction',
                'service' => Yii::$app->content->extraNews,
                'view' => '/extraNews'
            ],
        ];
    }
}

