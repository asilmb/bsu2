<?php

/* @var $this yii\web\View */

//$this->title = t('this/main', 'title');
use yii\helpers\Html;
use yii\widgets\ActiveForm;

?>

<section class="main-page">
    <div class="container">
        <?= $this->render('extraNews/listNews', ['extraNews' => $extraNews]); ?>

        <div class="blog-section clearfix">
            <div class="director-image" style="border: black solid 1px">Фотография директора Балхаш Су</div>
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
<!--                --><?//= Html::a('Перейти в блог', '') ?>
            </div>


            <?php ActiveForm::end(); ?>
        </div>

        <div class="news">
            <h3> Новости</h3>
            <?= $this->render('news/listNews', ['news' => $news]); ?>
        </div>

    </div>
</section>

