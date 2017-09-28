<?php

/* @var $this yii\web\View */

//$this->title = t('this/main', 'title');

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
            <form>
                <div class="row-input">
                    <h3>Задать вопрос генеральному директору</h3>
                </div>
                <div class="row-input">
                    <div class="input-wrapper">
                        <input maxlength="18" tabindex="1" id="input1" type="text" placeholder="Ваше имя"
                               autocomplete="off">
                    </div>
                </div>
                <div class="row-input">
                    <div class="input-wrapper">
                        <input maxlength="18" tabindex="2" id="input2" type="text" placeholder="E-mail"
                               autocomplete="off">
                    </div>
                </div>
                <div class="row-input">
                    <div class="input-wrapper form--text">
                            <textarea rows="1" tabindex="3" placeholder="Напишите свой вопрос"
                                      id="textMessage"></textarea>
                    </div>
                </div>
                <div class="row-input">
                    <input type="submit" class="btn" value="Отправить">
                    <a href="#">Перейти в блог</a>
                </div>
            </form>
        </div>

        <div class="news">
            <h3> Новости</h3>
			<?= $this->render('news/listNews', ['news' => $news]); ?>
        </div>

    </div >
</section>
<script>

</script>
