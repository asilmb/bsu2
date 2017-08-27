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
	
	<!-- Left side column. contains the logo and sidebar -->
	<aside class="main-sidebar">
		<!-- sidebar: style can be found in sidebar.less -->
		<section class="sidebar">
			<!-- Sidebar user panel (optional) -->
			<?/* = Page::snippet('userPanel') */ ?>
			<!-- Sidebar Menu -->
			<?= Page::snippet('sidebarMenu') ?>
			<!-- /.sidebar-menu -->
		</section>
		<!-- /.sidebar -->
	</aside>
	
	<div class="content-wrapper">
		<section class="content-header">
			<?php if(!empty($this->title)) { ?>
				<h1>
					<?= Html::encode($this->title) ?>
				</h1>
			<?php } ?>
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
	<footer class="main-footer" style="padding-bottom: 30px; padding-top: 10px;">
		<?= Page::snippet('footer', '@common') ?>
	</footer>
</div>

<?php Page::endDraw() ?>
