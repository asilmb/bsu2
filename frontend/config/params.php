<?php

return [
	'mainMenu' => [
		[
			'label' => 'Rest',
			'name' => 'rest-client',
			//'url' => ['/rest-client'],
			'access' => ['rest-client.*'],
		],
		/*[
			'label' => 'Rest test',
			'name' => 'rest-client-test',
			//'url' => ['/rest-client'],
			'access' => ['rest-client.*'],
		],*/
	],
	'rightMenu' => [
		[
			'label' => 'User',
			'name' => 'user',
			'class' => 'common\modules\user\helpers\Navigation',
		],
	],
];
