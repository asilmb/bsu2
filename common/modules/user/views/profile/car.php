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

		<?= $form->field($model, 'gov_number')->textInput(); ?>

		<?= $form->field($model, 'document_number')->textInput(); ?>
  
		<div class="form-group">
			<?= Html::submitButton(t('action', 'SAVE'), ['class' => 'btn btn-primary']) ?>
		</div>

		<?php ActiveForm::end(); ?>
	</div>
</div>
