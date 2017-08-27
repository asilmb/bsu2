<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\Validation */

$this->title = 'Create Option';
$this->params['breadcrumbs'][] = ['label' => 'Validations', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="validation-create">
	
	<?= $this->render('_form', [
		'model' => $model,
	]) ?>

</div>