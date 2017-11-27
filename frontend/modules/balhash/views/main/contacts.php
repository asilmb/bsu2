<?php

/* @var $this yii\web\View */

//$this->title = t('this/main', 'title');
use yii\helpers\Html;
use yii\widgets\ActiveForm;
$this->registerJsFile('https://api-maps.yandex.ru/2.1/?lang=ru_RU');
$this->registerJsFile('/js/ymap.min.js');
?>
<section class="main-page">
    <div class="container">
        <div class="contacts-section clearfix">
			<h3 class="contacts-section--title">
				Как нас найти
			</h3>
            <div class="contacts-section--info">
				<p>г.Балхаш ул.Ленина д.32</p>
				<p>тел.6-50-96, 4-78-29 </p>
				<p>pokaz.bsy@mail.ru  </p>
            </div>

            <div class="contacts-section--map" id="map" >

            </div>
			<div class="contacts-section--socials">
				<a href="" class="scl-btn twitter"></a>
				<a href="" class="scl-btn facebook"></a>
				<a href="" class="scl-btn google"></a>
			</div>



        </div>


    </div>
</section>


