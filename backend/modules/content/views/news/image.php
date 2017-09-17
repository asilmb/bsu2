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
        
        <img src="<?= $avatar->url ?>" />
        
		<?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>
		
		<?= $form->field($model, 'imageFile')->fileInput() ?>

        <div class="form-group">
			<?= Html::submitButton(t('action', 'UPLOAD'), ['class' => 'btn btn-primary']) ?>
        </div>
        
		<?php ActiveForm::end() ?>
		
        <?php if($avatar->name) { ?>
	        <?php $form = ActiveForm::begin(['options' => ['enctype' => 'multipart/form-data']]) ?>

            <div class="form-group">
		        <?= Html::submitButton(t('action', 'DELETE'), [
			        'class' => 'btn btn-danger',
			        'value' => 'delete',
			        'name' => 'submit',
		        ]) ?>
            </div>
	
	        <?php ActiveForm::end() ?>
        <?php } ?>
	</div>
</div>
