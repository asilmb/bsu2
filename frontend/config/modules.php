<?php

return [
	'modules' => [
		'error' => [
			'class' => 'yii2module\error\Module',
		],
		'balhash' =>[
			'class' => 'frontend\modules\balhash\Module'
		],
		'user' => [
			'class' => 'common\modules\user\Module',
		],
	],
];
