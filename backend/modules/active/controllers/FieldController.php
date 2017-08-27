<?php
namespace backend\modules\active\controllers;

use api\v4\modules\active\entities\FieldEntity;
use api\v4\modules\active\forms\FieldForm;
use common\ddd\data\Query;
use common\widgets\Alert;
use Yii;
use yii\data\ArrayDataProvider;
use yii\web\Controller;


class FieldController extends Controller {
	/**
	 * @inheritdoc
	 */
	public function actions() {
		return [
			'create' => [
				'class' => 'backend\modules\active\actions\CreateAction',
				'service' => Yii::$app->active->field,
				'form' => 'FieldForm',
				'model' => new FieldForm(),
				'view' => '/field'
			],
			'update' => [
				'class' => 'backend\modules\active\actions\UpdateAction',
				'service' => Yii::$app->active->field,
				'form' => 'FieldForm',
				'model' => new FieldForm(),
				'view' => '/field'
			],
			'delete' => [
				'class' => 'backend\modules\active\actions\DeleteAction',
				'service' => Yii::$app->active->field,
			],
		];
	}

	public function actionView($id) {
		$entity = Yii::$app->active->field->oneById($id);
		$query = new Query();
		$query->where('field_id', $entity->id);
		if ($entity->type == FieldEntity::TYPE_SELECT) {
			$allModels = Yii::$app->active->option->all($query);
		} else {
			$allModels = Yii::$app->active->validation->all($query);
		}
		$dataProvider = new ArrayDataProvider([
			'allModels' => $allModels,
			'sort' => [
				'attributes' => ['id', 'parent_id', 'title'],
			],
			'pagination' => [
				'pageSize' => Yii::$app->params['pageSize'],
			],
		]);
		$form = new FieldForm();
		$form->setAttributes($entity->toArray(), false);
		return $this->render('view', [
			'model' => $form,
			'dataProvider' => $dataProvider,
		]);
	}
}

