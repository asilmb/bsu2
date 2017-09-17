<?php

namespace backend\modules\content\actions;

use api\v4\modules\content\forms\ImageForm;
use common\widgets\Alert;
use Yii;
use yii\base\Action;
use yii\data\ArrayDataProvider;
use yii\web\UnprocessableEntityHttpException;

class ViewAction extends Action
{

    public $service;
    public $view;

    public function run()
    {
        $model = new ImageForm();
        if (Yii::$app->request->isPost) {
            if (Yii::$app->request->post('submit') === 'delete') {
                Yii::$app->content->image->deleteSelf();
                Alert::add(['user/avatar', 'delete_success'], Alert::TYPE_SUCCESS);
            } else {
                if ($model->validate()) {
                    try {
                        Yii::$app->content->image->updateSelf($model->imageFile);
                        Alert::add(['content/image', 'uploaded_success'], Alert::TYPE_SUCCESS);
                    } catch (UnprocessableEntityHttpException $e) {
                        $model->addErrorsFromException($e);
                    }
                }
            }
        }
        //todo изменить на нахождение через новость. Передавать сюда новость
        $entity = Yii::$app->news->image->oneById($id);
        return $this->controller->render($this->view .'/view', ['model' => $model, 'image' => $entity]);
    }
}
