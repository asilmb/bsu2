<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii2lab\helpers\Page;
use yii\helpers\Html;

AppAsset::register($this);
?>

<?php Page::beginDraw(['class' => "skin-blue sidebar-mini"]) ?>

<div class="wrapper">
	<header class="main-header">
		<?= Page::snippet('navbar') ?>
	</header>
	<?= Page::snippet('navMenu') ?>
	<div class="content-wrapper">
		<section class="content-header">
			<?php if(!empty(\Yii::$app->view->title)) {
				echo '<h1>' . Html::encode(\Yii::$app->view->title) . '</h1>';
			} ?>
			<?= Page::snippet('breadcrumbs') ?>
			<?= Page::snippet('alert', '@common') ?>
		</section>
		<section class="content">
			<div class="row">
				<div class="col-md-12">
					<?= $content ?>
				</div>
			</div>
		</section>
	</div>
	<footer class="main-footer" style="padding-bottom: 40px;">
		<?= Page::snippet('footer', '@common') ?>
	</footer>
</div>

<?php Page::endDraw() ?>
