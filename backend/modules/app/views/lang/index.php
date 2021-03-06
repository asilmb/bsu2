<?php
use yii\helpers\Html;
use yii\grid\GridView;
use yii\data\ArrayDataProvider;

/* @var $this yii\web\View */

$this->title = t('app/lang', 'title');

$dataProvider = new ArrayDataProvider([
		'allModels' => Yii::$app->lng->getAllLanguages(),
		'sort' => [
			'attributes' => ['title', 'code', 'locale', 'is_main'],
		],
		'pagination' => [
			'pageSize' => Yii::$app->params['pageSize'],
		],
	]);
?>

<div class="box box-primary">
	<div class="box-body">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => '{summary}{items}',
			'columns' => [
				[
					'attribute' => 'title',
					'label' => t('app/lang', 'language'),
				],
				[
					'attribute' => 'code',
					'label' => t('app/lang', 'code'),
				],
				[
					'attribute' => 'locale',
					'label' => t('app/lang', 'locale'),
				],
				[
					'attribute' => 'is_main',
					'label' => t('app/lang', 'main_as_default'),
					'format' => 'html',
					'value' => function ($arr) {
						return  $arr['is_main'] ? '<span class="label label-success"><i class="fa fa-check"></i> '.t('yii', 'Yes').'</span>' : '<span class="label label-danger"><i class="fa fa-times"></i> '.t('yii', 'No').'</span>';
					},
				],
			],
		]); ?>
	</div>
</div>
