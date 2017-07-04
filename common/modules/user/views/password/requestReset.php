<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model \common\models\PasswordResetRequestForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

$this->title = t('user/password', 'title');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-request-password-reset">
	<h1><?= Html::encode($this->title) ?></h1>

	<p><?= t('user/password', 'request_text') ?></p>

	<div class="row">
		<div class="col-lg-5">
			<?php $form = ActiveForm::begin(['id' => 'request-password-reset-form']); ?>

				<?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>

				<div class="form-group">
					<?= Html::submitButton(t('user/password', 'request_action'), ['class' => 'btn btn-primary']) ?>
				</div>

			<?php ActiveForm::end(); ?>
		</div>
	</div>
</div>
