<?php
/**
 * @var $this yii\web\View
 */
use yii\helpers\Html;
$this->context->layout = '/print';
?>

<p>
    <img src="<?= $entity->file_url ?>" />
</p>

<p>
    Текст о способах применения QR-кода
</p>
