<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model yii\base\Model */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = t('user/registration', 'set_address_title');
$this->params['breadcrumbs'][] = t('user/registration', 'title');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container">
    <h1><?= Html::encode($this->title) ?></h1>

    <p><?= t('user/registration', 'set_address_text') ?></p>

    <div class="row">
        <div class="col-lg-5">
        
			<?php $form = ActiveForm::begin(['id' => 'form-create']); ?>

            <?= $form->field($model, 'district') ?>
	
	        <?= $form->field($model, 'post_code') ?>
            
            <div class="form-group">
				<?= Html::submitButton(t('action', 'complete'), [
					'class' => 'btn btn-primary',
					'name' => 'create-button',
				]) ?>
            </div>
			
			<?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
