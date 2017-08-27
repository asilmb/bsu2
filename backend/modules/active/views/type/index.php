<?php


use yii\bootstrap\Html;
use yii\grid\GridView;


$this->title = t('active/type', 'title');

?>


    <div class="box box-primary">
		<?= GridView::widget([
			'dataProvider' => $dataProvider,
			'layout' => '{summary}{items}',
			'columns' => [
				[
					'attribute' => 'id',
					'label' => t('active/type', 'id'),
				],
				[
					'attribute' => 'parent_id',
					'label' => t('active/type', 'parent_id'),
				],
				[
					'attribute' => 'title',
					'label' => t('active/type', 'type_name'),
				],
				[
					'class' => '\yii\grid\ActionColumn',
					'template' => '{update}{view}{delete}',
					'buttons' => [
						'update' => function ($url, $model) {
							return Html::a('<span class="glyphicon glyphicon-pencil"></span>', $url, [
								'title' => t('active/type', 'update_action'),
							]);
						},
						'view' => function ($url, $model) {
							return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', $url, [
								'title' => t('active/field', 'view_action'),
							]);
						},
						'delete' => function ($url, $model) {
							return Html::a('<span class="glyphicon glyphicon-trash"></span>', $url, [
								'title' => t('active/type', 'delete_action'),
							]);
						},
					],
					'urlCreator' => function ($action, $model, $key, $index) {
						if ($action === 'update') {
							$url ='active/update?id='.$model->id;
							return $url;
						}
						if ($action === 'view') {
							$url = 'active/view?id=' . $model->id;
							return $url;
						}
						if ($action === 'delete') {
							$url ='active/delete?id='.$model->id;
							return $url;
						}
					}
				],
			],
		
		
	]); ?>
    </div>

<?= Html::a(t('active/type', 'Create'),'active/create', ['class' => 'btn btn-success']) ?>