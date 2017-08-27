<?php

/* @var $this \yii\web\View */
/* @var $content string */

use frontend\assets\AppAsset;
use yii2lab\helpers\Page;

AppAsset::register($this);
?>

<?php Page::beginDraw() ?>

<div class="wrap">
    <header class="main-header">
			<?= Page::snippet('navbar');?>

    </header>
    <div class="container">
		<?= Page::snippet('breadcrumbs', '@common') ?>
		<?= Page::snippet('alert', '@common') ?>
		<?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
		<?= Page::snippet('footer', '@common') ?>
    </div>
</footer>

<?php Page::endDraw() ?>
