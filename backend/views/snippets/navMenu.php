<?php

use common\widgets\Menu;
use yii2lab\helpers\MenuHelper;

if($modules = config("modules.rbac")) {
	$item['rbac'] = [
		'label' => 'RBAC',
		'url' => ['#'],
		'icon' => '<i class="fa fa-users"></i>',
		'items' => [
			MenuHelper::genMenuItem('Permission', 'rbac'),
			MenuHelper::genMenuItem('Role', 'rbac'),
			MenuHelper::genMenuItem('Rule', 'rbac'),
			MenuHelper::genMenuItem('Assignment', 'rbac'),
		],
	];
}

if(Yii::$app->user->can('backend.*')) {
	$modules = param('mainMenu');
	foreach($modules as $module) {
		if(!empty($module['name'])) {
			if(isset($item[$module['name']])) {
				$menuItems[] = $item[$module['name']];
			} else {
				$menuItems[] = MenuHelper::genMenu($module);
			}
		} else {
			$menuItems[] = $module;
		}
	}
} else {
	$menuItems[] = [
		'label' => 'Empty menu',
		'options' => ['class' => 'header'],
	];
}

?>
<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar">
	<!-- sidebar: style can be found in sidebar.less -->
	<section class="sidebar">
		<? /* if ($this->beginCache('ADMIN_LEFT_MENU_PROFILE', [
			'duration' => 300,
			'variations' => [Yii::$app->language],
		])): */?>
		<!-- Sidebar user panel (optional) -->
		<!-- <div class="user-panel">
			<div class="pull-left image">
				<img src="<?= Yii::$app->user->getAvatarUrl(true); ?>" class="img-circle" alt="User Image" />
			</div>
			<div class="pull-left info">
				<p><?= Yii::$app->user->getAttribute('username'); ?></p>
				<a href="#"><i class="fa fa-circle text-success"></i> Online</a>
			</div>
		</div> -->
		<!-- Sidebar Menu -->
		<?
		/* $this->endCache();
		endif; */
		?>
		
		<?= Menu::widget([
			'options'=>['class' => 'sidebar-menu'],
			'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
			'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
			'activateParents' => true,
			'items' => $menuItems,
		]) ?>
		
		<!-- /.sidebar-menu -->
	</section>
	<!-- /.sidebar -->
</aside>