<?php
use frontend\assets\AppAsset;
use yii2lab\helpers\Page;

AppAsset::register($this);
?>

<?php Page::beginDraw() ?>

    <div class="wrapper">
        <div class="content">
            <?= Page::snippet('header') ?>
            <?= Page::snippet('navbar') ?>

            <?= $content ?>
        </div>

        <?= Page::snippet('footer') ?>

    </div>

<?php Page::endDraw() ?>