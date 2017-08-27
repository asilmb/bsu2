<?php


use api\v4\modules\active\helpers\ActiveHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="fields-form row">
	
	<?php $form = ActiveForm::begin(); ?>

    <div class="col-xs-6">
		<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
		
		<?= $form->field($model, 'sort')->textInput() ?>
		
		<?= $form->field($model, 'mask')->textInput(['maxlength' => true]) ?>
        
	    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>
        
	    <?= $form->field($model, 'priority')->textInput(['maxlength' => true]) ?>

        <div class="form-group">
	        <?= Html::submitButton(t('active/type', 'Approve') , ['class' => 'btn btn-success' ]) ?>
        </div>
    </div>
    <div class="col-xs-6">
		<?= $form->field($model, 'active_id')->dropDownList(ActiveHelper::getTypes(),['readOnly' => true]); ?>
		
		<?= $form->field($model, 'type')->dropDownList(ActiveHelper::getFieldConstants()); ?>
		
		<?= $form->field($model, 'is_hidden')->checkbox() ?>
        
		<?= $form->field($model, 'is_visible')->checkbox() ?>
		
		<?= $form->field($model, 'is_has_button')->checkbox() ?>
		
		<?= $form->field($model, 'is_readonly')->checkbox() ?>

    </div>
	
	<?php ActiveForm::end(); ?>

</div>