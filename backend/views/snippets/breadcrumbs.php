<?php

use yii2lab\helpers\Page;

$controller = Yii::$app->controller->id;
$action = Yii::$app->controller->action->id;

/* $this->params['breadcrumbs'][] = [
	'label' => $controller, 
	'url' => ['/' . $controller]
]; */

if(empty($this->params['breadcrumbs'])) {
	$this->params['breadcrumbs'][] = $this->title;
}

?>

<?= Page::snippet('breadcrumbs', '@common') ?>
