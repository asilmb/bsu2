<?php
return [
	'mainMenu' => [
		[
			'label' => 'application',
			'options' => ['class' => 'header'],
		],
		[
			'name' => 'app',
		],
		[
			'name' => 'gii',
			'icon' => '<i class="fa fa-flask"></i>',
		],
		[
			'label' => 'modules',
			'options' => ['class' => 'header'],
		],
		[
			'name' => 'rbac',
		],
		[
			'name' => 'logreader',
		],
		/* [
			'name' => 'rbac',
			'icon' => '<i class="fa fa-users"></i>',
			'label' => 'User',
		], */
		[
			'name' => 'backuprestore',
			'icon' => '<i class="fa fa-database"></i>',
			'label' => 'Dump DB',
		],
		/* [
			'name' => 'settings',
			'icon' => '<i class="fa fa-cog"></i>',
			'label' => 'Settings',
		], */
	],
];
