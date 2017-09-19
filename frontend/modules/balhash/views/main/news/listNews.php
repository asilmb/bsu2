
<style>
    .news-body {
        overflow: hidden;
        height: 200px;
        width: 300px;
    }

    .news-body .news--item {
        -webkit-column-width: 150px;
        -moz-column-width: 150px;
        column-width: 150px;
        height: 100%;
    }
</style>


<div class="news-body">

    <?php
    foreach ($news as $oneNews) {
        echo $this->render('listNewsItem', ['news' => $news]);
    } ?>
</div>