<?php
use yii\helpers\Html;
use kartik\widgets\ActiveForm;
//use common\widgets\Alert;
use kartik\widgets\SwitchInput;

/* @var $model backend\models\forms\CashForm */

$this->title = t('app/cache','title');

?>

<div class="box box-primary">
	<? $form = ActiveForm::begin([
		'options' => ['class' => 'form-vertical'],
	]);?>
		<div class="box-body">
			<?/* = Alert::widget([
				'delay' => 5000,
			]); */?>
			
			<?php
				$pluginOptions = [
					'pluginOptions' => [
						'handleWidth' => 50,
						'onText' => t('yii', 'Yes'),
						'offText' => t('yii', 'No'),
						'onColor' => 'success',
						'offColor' => 'danger',
					]
				];
			?>
			
			<?= $form->field($model, 'backend_app')->widget(SwitchInput::classname(), $pluginOptions);?>
			<?= $form->field($model, 'frontend_app')->widget(SwitchInput::classname(), $pluginOptions);?>
			<?= $form->field($model, 'api_app')->widget(SwitchInput::classname(), $pluginOptions);?>
		</div>
		<div class="box-footer">
			<?= Html::submitButton('<i class="fa fa-trash-o"></i> '.t('main','clear'), ['class' => 'btn btn-danger', 'name' => 'clear-button']);?>
		</div>
	<? ActiveForm::end(); ?>
</div>
