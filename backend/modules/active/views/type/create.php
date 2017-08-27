<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\ActiveType */

$this->title = t('active/type', 'Create Active Type');
$this->params['breadcrumbs'][] = ['label' => t('active/type', 'Active Types'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="active-type-create">
	
	<h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>