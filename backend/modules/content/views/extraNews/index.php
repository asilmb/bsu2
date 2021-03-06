<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = t('content/news_create', 'News');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-index">

    <h1><?= Html::encode($this->title) ?></h1>
	<?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <p>
		<?= Html::a(t('content/news_create', 'Create News'), ['create'], ['class' => 'btn btn-success']) ?>
    </p>
	<?= GridView::widget([
		'dataProvider' => $dataProvider,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],

			'title',
			'create_time',

			[
				'class' => '\yii\grid\ActionColumn',
				'template' => '{update}{view}{delete}',
				'buttons' => [
					'update' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
							'title' => t('content/news', 'update_action'),
						]);
					},
					'view' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
							'title' => t('content/news', 'view_action'),
						]);
					},
					'delete' => function ($url, $model) {
						return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
							'title' => t('content/news', 'delete_action'),
						]);
					},
				],
				'urlCreator' => function ($action, $model, $key, $index) {
					if ($action === 'update') {
						$url = 'extraNews/update?id=' . $model->id;
						return $url;
					}
					if ($action === 'view') {
						$url = 'extraNews/view?id=' . $model->id;
						return $url;
					}
					if ($action === 'delete') {
						$url = 'extraNews/delete?id=' . $model->id;
						return $url;
					}
				},
			],
		],
	]); ?>
</div>
