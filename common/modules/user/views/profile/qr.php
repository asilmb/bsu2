<?php
/**
 * @var $this yii\web\View
 */
use yii\helpers\Html;

?>

<?= $this->context->renderPartial('_navigation'); ?>

<div class="row">
	<div class="col-lg-12">

        <p>
            <img src="<?= $entity->file_url ?>" />
        </p>
        
        <p>
            Текст о способах применения QR-кода
        </p>

        <p>
			<?= Html::a(t('action', 'SAVE'), [null, 'action' => 'download'], ['class' => 'btn btn-default']) ?>
			<?= Html::a(t('action', 'PRINT'), [null, 'action' => 'print'], ['class' => 'btn btn-default', 'target'=> '_blank']) ?>
        </p>
        
	</div>
</div>
