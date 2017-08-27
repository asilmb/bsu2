<?php

use common\widgets\Menu;
use yii2lab\helpers\MenuHelper;

$mainMenu = param('mainMenu');
echo Menu::widget([
	'options'=>['class' => 'sidebar-menu'],
	'linkTemplate' => '<a href="{url}">{icon}<span>{label}</span>{right-icon}{badge}</a>',
	'submenuTemplate' => "\n<ul class=\"treeview-menu\">\n{items}\n</ul>\n",
	'activateParents' => true,
	'items' => MenuHelper::gen($mainMenu),
]);
