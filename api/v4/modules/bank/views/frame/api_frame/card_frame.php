<?php
/**
 * @var array $_data_
 * @var $this CardController
 * @var $model EpayCardOperation|CnpCardOperation|WooppayCardOperation|EpayCardLinkOperation|WooppayCardLinkOperation
 */
use api\v4\modules\bank\helpers\AcquiringHelper;
use yii\helpers\Html;

?>
<style>
	.replenishmentFrame {
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

	.replenishmentForm {
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
	<?php
	echo Html::beginForm(
		!empty($model->getCardId()) ? $model->getActionApprove() : $model->getAction(),
		'post',
		array('name' => 'replenishmentForm', 'target' => 'replenishmentFrame', 'id' => 'replenishmentForm')
	);
	echo AcquiringHelper::toHiddenFields(array(
		'Signed_Order_B64' => !empty($model->getCardId()) ? $model->getApproveSign() : $model->getSign(),
		'email' => Yii::$app->user->email,
		'Language' => 'rus',
		'template' => !empty($model->getCardId()) ? $model->getTemplateForFrameApprove() : $model->getTemplateForFrame(),
		'BackLink' => $model->getBackUrl(),
		'FailureBackLink' => $model->getBackUrl(),
		'PostLink' => $model->getAcquiringPostUrl(),
		'FailurePostLink' => $model->getAcquiringPostUrl()
	));
	?>
	<?= Html::endForm(); ?>
	<?= Html::hiddenField('CardOperationId', $model->getOperationId(), array('id' => 'CardOperationId')); ?>
	<iframe src='javascript: return false;' name='replenishmentFrame' id='replenishmentFrame'
			class="replenishmentFrame"></iframe>
</div>
<?= $model->script_for_communication_with_frame(
	'/*hideLoader("#frame-wrapper");*/ window.location = "js-call://message?data=4";',
	'$("#replenishmentFrame").remove(); window.location = "js-call://message?data=1";',
	'$("#replenishmentFrame").remove(); window.location = "js-call://message?data=3&error=" + encodeURI(err_info);',
	'$("#replenishmentFrame").remove(); window.location = "js-call://message?data=2&error=" + encodeURI(err_info);',
	'$("#replenishmentFrame").remove(); window.location = "js-call://message?data=8&error=" + encodeURI(err_info);',
	!empty($model->getCardId()) ? 'cvvReceiver' : 'rechargeReceiver',
	!empty($model->getCardId()) ? 'cvv' : 'recharge'
); ?>
<script type="text/javascript">
	setTimeout(function () {
		$('#replenishmentForm').submit();
	}, 500);
	$(document).ready(function () {
		showLoader('#frame-wrapper');
	});
</script>