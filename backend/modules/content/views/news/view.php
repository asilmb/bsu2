<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model common\modules\content\models\news */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => t('content/news_create', 'News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a(t('content/news_create', 'Update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a(t('content/news_create', 'Delete'), ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => t('content/news_create', 'Are you sure you want to delete this item?'),
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            'title',
            'underTitle',
            'content:ntext',
            'created_at',
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
			    if ($action === 'delete') {
				    $url = 'field/delete?id=' . $model->id;
				    return $url;
			    }
		    },
	    ],
    ]) ?>

</div>
