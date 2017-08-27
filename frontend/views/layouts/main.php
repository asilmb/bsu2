<?php
use frontend\assets\AppAsset;
use yii2lab\helpers\Page;
AppAsset::register($this);
?>

<?php Page::beginDraw() ?>

    <div class="wrap">
		<?= Page::snippet('header') ?>
		<?= Page::snippet('navbar') ?>
        
			<?= $content ?>
       
    </div>

    <footer class="footer">
        <div class="container">
			<?= Page::snippet('footer') ?>
        </div>
    </footer>

<?php Page::endDraw() ?>