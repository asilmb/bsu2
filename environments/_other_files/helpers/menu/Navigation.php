<?php
namespace yii2lab\helpers\menu;

use yii2lab\helpers\yii\Html;

class Navigation {
	
	static function getItemList() {
		return [
			[
				'label' => 'Dashboard',
				'icon' => 'icon-home4',
				'url' => ['/welcome/default/index'],
			],
			[
				'label' => 'Messages',
				'icon' => 'icon-comment-discussion',
				'badge' => '2',
				'badgeType' => 'primary',
				'url' => ['#'],
				'permissions' => ['backend.*'],
			],
			[
				'options' => ['class'=>'navigation-divider'],
			],
			[
				'label' => 'Starter kit',
				'icon' => 'icon-tree6',
				'url' => ['#'],
				'items' => [
					[
						'label' => 'Chart',
						'icon' => ' icon-chart',
						'url' => ['#'],
					],
					[
						'label' => 'Menu',
						'icon' => 'icon-list',
						'url' => ['#'],
						'linkOptions' => [
							'onclick' => "$('#form_logout').submit()",
						],
						'items' => [
							[
								'label' => 'Sub item',
								'icon' => 'icon-circle-small',
								'url' => ['#'],
							],
						],
					],
					[
						'label' => 'Work',
						'icon' => 'icon-briefcase3',
						'url' => ['#'],
					],
				],
			],
			[
				'label' => t('user/auth', 'logout_action'),
				'icon' => 'icon-switch2',
				'url' => ['#'],
				'linkOptions' => [
					'onclick' => "$('#form_logout').submit()",
				],
			],
		];
	}
	
}
