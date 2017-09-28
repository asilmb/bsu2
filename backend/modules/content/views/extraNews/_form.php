<?php


use mihaildev\ckeditor\CKEditor;
use mihaildev\elfinder\ElFinder;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>


<div class="news-form">
	
	<?php $form = ActiveForm::begin(); ?>
	
	<?= $form->field($model, 'title')->textInput(['maxlength' => '50']) ?>
	<?= $form->field($model, 'anons')->textInput(['maxlength' => '130']) ?>

    <div class="form-group">
		<?= Html::submitButton(t('content/news_create', 'create'), ['class' => 'btn btn-success']) ?>
    </div>
	
	<?php ActiveForm::end(); ?>

</div>
