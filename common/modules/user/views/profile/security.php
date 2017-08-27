<?php
/**
 * @var $this yii\web\View
 * @var $modelPassword yii\base\Model
 * @var $modelEmail yii\base\Model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?php   echo $this->context->renderPartial('_navigation'); ?>

<div class="row">
	<div class="col-lg-3">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($modelPassword, 'new_password')->passwordInput() ?>

		<?= $form->field($modelPassword, 'new_password_repeat')->passwordInput() ?>

		<?= $form->field($modelPassword, 'password')->passwordInput() ?>

		<div class="form-group">
			<?= Html::submitButton(t('action', 'UPDATE'), ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>

	<div class="col-lg-1"></div>

	<div class="col-lg-3">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($modelEmail, 'email')->textInput(['placeholder'=>$modelEmail->email]) ?>

		<?= $form->field($modelEmail, 'password')->passwordInput() ?>

		<div class="form-group">
			<?= Html::submitButton(t('action', 'UPDATE'), ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
