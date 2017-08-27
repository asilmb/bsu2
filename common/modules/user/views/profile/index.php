<?php
/**
 * @var $this yii\web\View
 * @var $model yii\base\Model
 */

use yii\helpers\Html;
use yii\widgets\ActiveForm;
?>

<?= $this->context->renderPartial('_navigation'); ?>

<div class="row">
	<div class="col-lg-3">
		<?php $form = ActiveForm::begin(); ?>

		<?= $form->field($model, 'first_name')->textInput(); ?>

		<?= $form->field($model, 'last_name')->textInput(); ?>

		<?= $form->field($model, 'birth_date')->textInput(); ?>

		<?= $form->field($model, 'iin')->textInput(); ?>

		<?= $form->field($model, 'sex')->radioList([
			0 => t('user/profile', 'sex_male'),
			1 => t('user/profile', 'sex_female'),
		]); ?>

		<div class="form-group">
			<?= Html::submitButton(t('action', 'SAVE'), ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
