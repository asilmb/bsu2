<?php

?>
<style>
    p.news--entity-title {
        font-size: 24px;
        margin-bottom: 20px;
    }

    .news--entity-image img {height: 400px;}

    .news--entity-image {
        text-align: center;
        float: right;
    }
</style>
<section class="main-page" >
    <div class="container">
        <div class="news--entity clearfix">
            <p class="news--entity-title"><?= $newsEntity->title ?></p>
            <div class="news--entity-image">
                <img src="<?= $newsEntity->image_url ?>"/>
            </div>
            <p class="news--entity-body"><?= $newsEntity->body ?></p>
        </div>
        <div class="news news-bottom">
            <h3> Новости</h3>
            <?= $this->render('listNews', ['news' => $news]); ?>
        </div>
    </div>

</section>
