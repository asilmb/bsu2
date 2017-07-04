<?php

use yii2lab\helpers\yii\Html;

?>

<?= Html::a(Html::fa('pencil') . NBSP2X . Yii::t('main', 'update'), ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>

<?= Html::a(Html::fa('trash') . NBSP2X . Yii::t('main', 'delete'), ['delete', 'id' => $model->id], [
	'class' => 'btn btn-danger',
	'data' => [
		'confirm' => Yii::t('yii', 'Are you sure you want to delete this item?'),
		'method' => 'post',
	],
]) ?>