<?php
return [
	'mainMenu' => [
		[
			'label' => ['admin', 'main'],
			'isHeader' => true,
		],
		[
			'label' => ['admin', 'app'],
			'icon' => 'square-o',
			'module' => 'app',
			'items' => [
				[
					'label' => ['app/cache', 'title'],
					'url' => 'app/cache',
				],
				[
					'label' => ['app/lang', 'title'],
					'url' => 'app/lang',
				],
			],
		],
		[
			'label' => ['content/news', 'content'],
			'icon' => 'square-o',
			'module' => 'content',
			'items' => [
				[
					'label' => ['content/news', 'title'],
					'url' => 'news',
				],
                [
                    'label' => ['content/extraNews', 'title'],
                    'url' => 'extraNews',
                ],
			],
		],
		[
			'label' => ['admin', 'rbac'],
			'icon' => 'users',
			'module' => 'rbac',
			'items' => [
				[
					'label' => ['admin', 'rbac_permission'],
					'url' => 'rbac/permission',
				],
				[
					'label' => ['admin', 'rbac_role'],
					'url' => 'rbac/role',
				],
				[
					'label' => ['admin', 'rbac_rule'],
					'url' => 'rbac/rule',
				],
				[
					'label' => ['admin', 'rbac_assignment'],
					'url' => 'rbac/assignment',
				],
			],
		],
		[
			'label' => ['admin', 'logreader'],
			'icon' => 'database',
			'url' => 'logreader',
			'module' => 'logreader',
		],
		[
			'label' => ['admin', 'develop'],
			'isHeader' => true,
		],
		[
			'label' => ['admin', 'gii'],
			'icon' => 'flask',
			'url' => 'gii',
		],
	],
];
