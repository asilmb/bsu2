
<style>


</style>


<div class="notifications">
    <div class="notifications-slider owl-carousel owl-theme">

    <?php
    foreach ($extraNews as $oneNews) {
        echo $this->render('listNewsItem', ['oneNews' => $oneNews]);
    } ?>
    </div>
</div>

