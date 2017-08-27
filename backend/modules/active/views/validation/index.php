<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

?>
<div class="validation-index">
	
	
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			[
				'attribute' => 'id',
				'label' => t('active/validation', 'id'),
			],
			[
				'attribute' => 'field_id',
				'label' => t('active/validation', 'field_id'),
			],
			[
				'attribute' => 'type',
				'label' => t('active/validation', 'type'),
			],
					
			[
				'class' => '\yii\grid\ActionColumn',
				'template' => '{update}{delete}',
				'buttons' => [
					'update' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
							'title' => t('active/field', 'update_action'),
						]);
					},
					'delete' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
							'title' => t('active/field', 'delete_action'),
						]);
					},
				],
				'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'update') {
						$url = '/active/validation/update?id=' . $model->id;
						return $url;
					}
					if ($action === 'delete') {
						$url = '/active/validation/delete?id=' . $model->id;
						return $url;
					}
				},
			],
		],
	]); ?>
</div>
<p>
	<?= Html::a(t('active/validation', 'Create'), '/active/validation/create?field_id=' . $field_id, ['class' => 'btn btn-success']) ?>
</p>