
<style>
    .news-body {
        overflow: hidden;
        height: 250px;
        width: 100%;
    }

    .news-body .news--item {
        -webkit-column-width: 150px;
        -moz-column-width: 150px;
        column-width: 150px;
        height: 100%;
    }
</style>


<div class="news-body owl-carousel owl-theme">

    <?php
    foreach ($news as $oneNews) {
        echo $this->render('listNewsItem', ['oneNews' => $oneNews]);
    } ?>
</div>