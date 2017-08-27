<?php

use api\v4\modules\active\helpers\ActiveHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */

/* @var $form yii\widgets\ActiveForm */
?>

<div class="active-type-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'parent_id')->dropDownList(
		ActiveHelper::getTypes()
	); ?>

	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    
    <div class="form-group">
		<?= Html::submitButton(t('active/type', 'Approve') , ['class' => 'btn btn-success' ]) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>