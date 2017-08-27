<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\modules\content\models\news */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="news-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'underTitle')->textInput(['maxlength' => true]) ?>
	
	<?= $form->field($model, 'content')->textarea(['rows' => 6]) ?>
    
	<?= $form->field($model, 'file')->fileInput() ?>
    
    <div class="form-group">
		<?= Html::submitButton($model->isNewRecord ? t('content/news_create', 'create') : t('content/news_create', 'update'), ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>
