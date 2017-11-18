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
        <?= $this->render('extraNews/listNews', ['extraNews' => $extraNews]); ?>

        <div class="blog-section clearfix">
            <div class="director-image"></div>
            <?php $form = ActiveForm::begin(); ?>
            <div class="row-input">
                <h3>Задать вопрос генеральному директору</h3>
            </div>
            <div class="row-input">
                <div class="input-wrapper">
                    <?= $form->field($directorMailModel, 'fromName')->textInput(['maxlength' => '18', 'class' => 'input-wrapper',
                        'tabindex' => '3', 'rows' => "1", 'placeholder' => "Ваше имя", 'autocomplete' => "off"])->label(false) ?>
                </div>
            </div>
            <div class="row-input">
                <div class="input-wrapper">
                    <?= $form->field($directorMailModel, 'fromEmail')->textInput(['maxlength' => '18', 'class' => 'input-wrapper',
                        'tabindex' => '3', 'rows' => "1", 'placeholder' => "E-mail", 'autocomplete' => "off"])->label(false) ?>
                </div>
            </div>
            <div class="row-input">
                <div class="input-wrapper">
                    <?= $form->field($directorMailModel, 'body')->textarea(['maxlength' => '300', 'class' => 'input-wrapper form--text',
                        'tabindex' => '3', 'rows' => "1", 'placeholder' => "Напишите свой вопрос", 'autocomplete' => "off"])->label(false) ?>
                </div>
            </div>
            <div class="row-input">
                <?= Html::submitButton('Отправить', ['class' => 'btn']) ?>
                <?= Html::a('Перейти в блог', '') ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>

        <div class="news">
            <h3> Новости</h3>
            <?= $this->render('news/listNews', ['news' => $news]); ?>
        </div>

    </div>
</section>

