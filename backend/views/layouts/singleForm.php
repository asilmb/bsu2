<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii2lab\helpers\Page;

AppAsset::register($this);
?>

<?php Page::beginDraw(['class' => "hold-transition login-page"]) ?>

	<?= Page::snippet('alert', '@common') ?>
	
	<?= $content ?>

<?php Page::endDraw() ?>
