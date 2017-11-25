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
			<div class="nav--sections">
				<div class="container">
					<a href="#" class="section-item"><img src="/images/receiving.png"/>
						<p><span>Приём показаний</span></p></a>
					<a href="https://epos.kz/kommun/balhashsu.php" class="section-item"><img src="./images/debt.png"/>
						<p><span>Оплата задолжности</span></p></a>
					<a href="#" class="section-item"><img src="/images/forum.png"/>
						<p><span>Форум потребителей</span></p></a>
<!--					<a href="#" class="section-item"><img src="/images/sealing.png"/>-->
<!--						<p><span>Заявка на опломбировку</span></p></a>-->
<!--					<a href="#" class="section-item"><img src="/images/emergency_service.png"/>-->
<!--						<p><span>Заявка на аварийную службу</span></p></a>-->
<!--					<a href="#" class="section-item"><img src="/images/smart_water.png"/>-->
<!--						<p><span>Smart Вода</span></p></a>-->
				</div>
			</div>

            <?= $content ?>
        </div>

        <?= Page::snippet('footer') ?>

    </div>

<?php Page::endDraw() ?>