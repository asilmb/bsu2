<?php

use yii\helpers\Html;


/* @var $this yii\web\View */


$this->title = t('active/type', 'Create Field');
$this->params['breadcrumbs'][] = ['label' => t('active/type', 'Field'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;


?>
<div class="active-type-create">
	
	<h1><?= Html::encode($this->title) ?></h1>
	<?= $this->render('_form', [
		'model' => $model,
        'type' => !empty($type) ? $type : null
    ]) ?>

</div>

