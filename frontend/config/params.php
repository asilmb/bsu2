<?php

return [
	'params' => ['CardLinkingType'=>'wooppay'],
	'mainMenu' => [
		[
			'label' => 'Rest',
			'url' => 'rest-client',
			'access' => ['rest-client.*'],
		],
	],
	'rightMenu' => [
		[
			'label' => 'User',
			'module' => 'user',
			'class' => 'common\modules\user\helpers\Navigation',
		],
	],
];