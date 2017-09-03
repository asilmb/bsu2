<?php

use dosamigos\ckeditor\CKEditor;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="news-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'anons')->textInput(['maxlength' => true]) ?>
	<?= $form->field($model, 'body')->widget(CKEditor::className(), [
		'options' => ['rows' => 6],
		'preset' => 'full',
	]) ?>
    <div class="form-group">
		<?= Html::submitButton(t('content/news_create', 'create'), ['class' => 'btn btn-success']) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>
