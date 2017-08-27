<?php
/**
 * @var $this CardController
 * @var array $data
 * @var $model EpayCardLinkOperation|WooppayCardLinkOperation
 * @var string $step
 */
use api\v4\modules\bank\helpers\AcquiringHelper;
use yii\helpers\Html;

?>
	<style>
		.cardLinkingFrame {
			position: relative;
			height: 600px;
			width: 100%;
			display: block;
			margin: 0;
			border: none;
			background: none;
			padding: 0;
			overflow: hidden;
		}
		
		.linkingForm {
			position: relative;
			height: 0;
			width: 100%;
			opacity: 0;
			margin: 0;
			padding: 0;
			overflow: hidden;
		}
	</style>
	
	<div id="frame-wrapper">
		<?= Html::beginForm(
			$model->getAction(),
			'post',
			['name' => 'linkingForm', 'target' => 'cardLinkingFrame', 'id' => 'linkingForm', 'class' => 'linkingForm']
		);
		?>
		<?= AcquiringHelper::toHiddenFields($model->post_params_for_frame()); ?>
		<?= Html::endForm(); ?>
		<iframe src="javascript:void(0);" name="cardLinkingFrame" id="cardLinkingFrame" class="cardLinkingFrame"></iframe>
	</div>
	<script type="text/javascript">
		setTimeout(function () {
			$('#linkingForm').submit();
		}, 500);
		$(document).ready(function() {
			showLoader('#frame-wrapper');
		});
	</script>

<?= $model->script_for_communication_with_frame(
	'hideLoader("#frame-wrapper"); window.location = "js-call://message?data=4";',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=1&reference=" + message.data.referenceId;',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=3&error=" + encodeURI(err_info);',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=2&error=" + encodeURI(err_info);',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=8&error=" + encodeURI(err_info);',
	'linkingReceiver',
	'linking'
); ?>