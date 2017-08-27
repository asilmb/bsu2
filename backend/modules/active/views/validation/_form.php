<?php

use api\v4\modules\active\helpers\ActiveHelper;

use yii\grid\GridView;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model api\v4\modules\active\models\Validation */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="validation-form">
	
	<?php $form = ActiveForm::begin(); ?>
        
	<?= $form->field($model, 'field_id')->textInput(['readOnly' => true]) ?>
	
	<?= $form->field($model, 'type')->dropDownList(
		ActiveHelper::getValidationConstants()
	); ?>


	<?=$form->field($model, 'rules[min]')->textInput(['maxlength' => true])->label('min') ?>
	<?=$form->field($model, 'rules[max]')->textInput(['maxlength' => true])->label('max') ?>

    <div class="form-group">
	    <?= Html::submitButton(t('active/type', 'Approve') , ['class' => 'btn btn-success' ]) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>