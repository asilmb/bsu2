<?php

use yii2lab\app\helpers\Db;

return [
	'components' => [
		'db' => Db::getConfig([
			'enableSchemaCache' => false,
		], 'test'),
	],
];
