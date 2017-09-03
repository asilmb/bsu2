<?php

use yii\helpers\Html;





$this->title = t('content/news_create', 'title');
$this->params['breadcrumbs'][] = ['label' => t('content/news_create', 'news'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
