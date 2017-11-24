<?php

/* @var $this yii\web\View */

//$this->title = t('this/main', 'title');
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>
<div class="nav--sections">
    <div class="container">
        <a href="#" class="section-item"><img src="/images/receiving.png"/>
            <p><span>Приём показаний</span></p></a>
        <a href="#" class="section-item"><img src="./images/debt.png"/>
            <p><span>Проверка задолженности</span></p></a>
        <a href="#" class="section-item"><img src="/images/forum.png"/>
            <p><span>Форум потребителей</span></p></a>
        <a href="#" class="section-item"><img src="/images/sealing.png"/>
            <p><span>Заявка на опломбировку</span></p></a>
        <a href="#" class="section-item"><img src="/images/emergency_service.png"/>
            <p><span>Заявка на аварийную службу</span></p></a>
        <a href="#" class="section-item"><img src="/images/smart_water.png"/>
            <p><span>Smart Вода</span></p></a>
    </div>
</div>
<section class="main-page">
    <div class="container">
        <div class="contacts-section clearfix">
            <div class="contacts-section--info">
                г.Балхаш ул.Ленина д.32
                тел.6-50-96, 4-78-29
                pokaz.bsy@mail.ru
            </div>

            <div class="contacts-section--map" id="map">

            </div>




        </div>


    </div>
</section>
<?php $this->registerJsFile('https://maps.googleapis.com/maps/api/js?key=AIzaSyDnkvoAuIU_mkku-BYTR0TxlMjDcm-V9Io&callback=initMap',['async'=> true, 'defer'=>true]) ?>

