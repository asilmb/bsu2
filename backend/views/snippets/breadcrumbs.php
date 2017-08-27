<?php

use yii2lab\helpers\Page;

if(empty($this->params['breadcrumbs'])) {
	$this->params['breadcrumbs'][] = $this->title;
}

?>

<?= Page::snippet('breadcrumbs', '@common') ?>
