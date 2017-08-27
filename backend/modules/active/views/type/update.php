<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\ActiveType */

$this->title = t('active/type', 'Update {modelClass}: ', [
		'modelClass' => 'Active Type',
	]) . $model->title;
$this->params['breadcrumbs'][] = ['label' => t('active/type', 'Active Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->title, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = t('active/type', 'Update');
?>
<div class="active-type-update">
	
	<!--<h1>--><?//= Html::encode($this->title) ?><!--</h1>-->
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>