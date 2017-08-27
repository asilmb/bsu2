<?php
/**
 * @var $this CardController
 * @var array $data
 * @var $model EpayCardLinkOperation|WooppayCardLinkOperation
 * @var string $step
 */
use api\v4\modules\bank\controllers\FrameController;
use api\v4\modules\bank\helpers\AcquiringHelper;
use yii\helpers\Html;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;
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
   
       <!--Запомните  чтобы работал фрейм необходимо следующие вещи.-->
       <!--1) все sendmessage кроме последнего sendmessage 3 следует оборачивать в ready.-->
       <!--2) jquery, jquery form styler и script.js распологать в head.-->
       <!--3) если будут какие то взаимодествия jquery в форме оборачивайте их в ready.-->
       <!--4) делайте проверку на наличее селектора, если скрипт лежит в ready и использует Например formstyler. Без наличия селектора все валится. И вылитает js exception.-->
       <!--5) ДА ПОМОЖЕТ ВАМ БОГ!-->
    
    <div id="frame-wrapper">
		<?= Html::beginForm(
			$model->getAction(),
			'post',
			['name' => 'linkingForm', 'target' => 'cardLinkingFrame', 'id' => 'linkingForm', 'class' => 'linkingForm']
		);
		$params = $model->post_params_for_frame();
		$params['template'] = 'wp-mobile-linking.xsl';
		?>
		<?= AcquiringHelper::toHiddenFields($params); ?>
		<?= Html::endForm(); ?>
        <iframe src="javascript:void(0);" name="cardLinkingFrame" id="cardLinkingFrame"
                class="cardLinkingFrame"></iframe>
    </div>
    <script type="text/javascript">
		setTimeout(function () {
			$('#linkingForm').submit();
		}, 500);
        /*$(document).ready(function () {
         showLoader('#frame-wrapper');
         });*/
    </script>


<?php echo $model->script_for_communication_with_frame(
	';',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=1&reference=" + message.data.referenceId;',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=3&error=" + encodeURI(err_info);',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=2&error=" + encodeURI(err_info);',
	'$("#cardLinkingFrame").remove(); window.location = "js-call://message?data=8&error=" + encodeURI(err_info);',
	'linkingReceiver',
	'linking'
);
?>

 