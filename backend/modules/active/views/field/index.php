<?php


use yii\bootstrap\Html;
use yii\grid\GridView;

?>

<?= GridView::widget([
	'dataProvider' => $dataProvider,
	'layout' => '{summary}{items}',
	'columns' => [
		[
			'attribute' => 'id',
			'label' => t('active/field', 'id'),
		],
		[
			'attribute' => 'active_id',
			'label' => t('active/field', 'active_id'),
		],
		[
			'attribute' => 'title',
			'label' => t('active/field', 'title'),
		],
		[
			'attribute' => 'name',
			'label' => t('active/field', 'name'),
		],
		[
			'attribute' => 'priority',
			'label' => t('active/field', 'priority'),
		],
		[
			'attribute' => 'sort',
			'label' => t('active/field', 'sort'),
		],
		[
			'attribute' => 'is_hidden',
			'label' => t('active/field', 'is_hidden'),
		],
		[
			'attribute' => 'is_visible',
			'label' => t('active/field', 'is_visible'),
		],
		[
			'attribute' => 'is_has_button',
			'label' => t('active/field', 'is_has_button'),
		],
		[
			'attribute' => 'is_readonly',
			'label' => t('active/field', 'is_readonly'),
		],
		[
			'attribute' => 'mask',
			'label' => t('active/field', 'mask'),
		],
		
		[
			'class' => '\yii\grid\ActionColumn',
			'template' => '{update}{view}{delete}',
			'buttons' => [
				'update' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
						'title' => t('active/field', 'update_action'),
					]);
				},
				'view' => function ($url, $model) {
					return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
						'title' => t('active/field', 'view_action'),
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
					$url = 'field/update?id=' . $model->id;
					return $url;
				}
				if ($action === 'view') {
					$url = 'field/view?id=' . $model->id;
					return $url;
				}
				if ($action === 'delete') {
					$url = 'field/delete?id=' . $model->id;
					return $url;
				}
			},
		],
	],
]); ?>
<?= Html::a(t('active/type', 'Create'), 'field/create?active_id=' . $active_id, ['class' => 'btn btn-success']) ?>