
<style>


</style>


<div class="news-body owl-carousel owl-theme">

    <?php
    foreach ($news as $oneNews) {
        echo $this->render('listNewsItem', ['oneNews' => $oneNews]);
    } ?>
</div>