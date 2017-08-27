<?php

use api\v4\modules\active\helpers\ActiveHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\Validation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="validation-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	    
	<?= $form->field($model, 'field_id')->textInput(['readOnly' => true]) ?>
    
	
	<?= $form->field($model, 'key')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
    <div class="form-group">
	    <?= Html::submitButton(t('active/type', 'Approve') , ['class' => 'btn btn-success' ]) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>