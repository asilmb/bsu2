<?php

use yii\widgets\Breadcrumbs;

?>

<?= Breadcrumbs::widget([
	'tag'=>'ol',
	'homeLink'=>[
		'label' => '<i class="fa fa-home" title="' . t('main','main_page') . '"></i>',
		'encode' => false,
		'url' => ['/'],
	],
	'links' => isset(Yii::$app->view->params['breadcrumbs']) ? Yii::$app->view->params['breadcrumbs'] : [],
]);
?>
