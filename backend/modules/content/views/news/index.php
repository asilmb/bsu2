<?php

use yii\grid\GridView;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $searchModel common\modules\content\models\NewsSearch */
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
		'filterModel' => $searchModel,
		'columns' => [
			['class' => 'yii\grid\SerialColumn'],
			
			'id',
			'title',
			'underTitle',
			'content:ntext',
			'created_at',
			
			['class' => 'yii\grid\ActionColumn'],
		],
	]); ?>
</div>
