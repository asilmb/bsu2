<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\Validation */

$this->title = 'Update Validation: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Validations', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="validation-update">

    <h1><?= Html::encode($this->title) ?></h1>
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>