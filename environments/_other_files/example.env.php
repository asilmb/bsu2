<?php

$domen = 'wooppay.yii';

return [
	'YII_DEBUG' => true,
	'YII_ENV' => 'dev',
	'url' => [
		'frontend' => 'http://' . $domen . '/',
		'backend' => 'http://admin.' . $domen . '/',
		'api' => 'http://api.' . $domen . '/',
	],
	'cookieValidationKey' => [
		'frontend' => '8-PoeCbP6P8L0hdD5497krQ61EO7CIk2',
		'backend' => '3vEw3w7F5Vp5_K3oLmfRWcxWs49O_6N0',
	],
	'connection' => [
		'main' => [
			'driver' => 'pgsql',
			
			'username' => 'logging',
			'password' => 'moneylogger',
			'host' => '192.168.8.138',
			
			/* 'username' => 'postgres',
			'password' => '',
			'host' => 'localhost', */
			'dbname' => 'wooppay',
			'defaultSchema' => 'woopdb',
		],
		'test' => [
			'username' => 'postgres',
			'password' => '',
			'host' => 'localhost',
		],
		/* 'main' => [
			'username' => 'root',
			'password' => '',
			'dbname' => 'wooppay_yii',
		],
		'test' => [
			'dbname' => 'wooppay_yii_test',
		], */
	],
	'servers' => [
		'tps' => [
			'webPath' => 'http://www.test.wooppay.com:8080/',
		],
	],
];

/* 
	'connection' => [
		'main' => [
			'driver' => 'pgsql',
			
			//'username' => 'logging',
			//'password' => 'moneylogger',
			//'host' => '192.168.8.138',
			
			'username' => 'postgres',
			'password' => '',
			'host' => 'localhost',
			//'defaultSchema' => 'woopdb',
			'dbname' => 'wooppay',
			'schemaMap' => [
				'pgsql' => [
					'class' => 'yii\db\pgsql\Schema',
					'defaultSchema' => 'woopdb' //specify your schema here, public is the default schema
				]
			], // PostgreSQL
		],
		'test' => [
			'username' => 'postgres',
			'password' => '',
			'host' => 'localhost',
			'schemaMap' => [
				'pgsql' => [
					'class' => 'yii\db\pgsql\Schema',
					'defaultSchema' => 'woopdb' //specify your schema here, public is the default schema
				]
			], // PostgreSQL
		],
		'main' => [
			'username' => 'root',
			'password' => '',
			'dbname' => 'wooppay_yii',
		],
		'test' => [
			'dbname' => 'wooppay_yii_test',
		],
	],
	'servers' => [
		'websocket' => [
			'webPath' => 'http://' . (($domen == 'wp.local') ? 'websocket.wp.local' : $domen) . ':3132',
		],
		'tps' => [
			'webPath' => 'http://www.test.wooppay.com:8080/',
		],
		'nat' => [
			'address' => $_SERVER['REMOTE_ADDR'],
		],
		'static' => [
			'address' => '192.168.8.10',
			'port' => '22',
			'username' => 'static',
			'password' => '',
			'publicPath' => '/var/www/sites/static.wooppay.com/storage/',
			'webPath' => 'http://static.' . str_replace('local', 'com', $domen) . '/',
			'publicKey' => dirname(__FILE__) . '/../../../keys/static.pub',
			'privateKey' => dirname(__FILE__) . '/../../../keys/static.ppk',
		],
	],
	'allowedIPs' => [
		'127.0.0.1',
	],
	'cors' => [
		'allow-origin' => ['*'],
		'allow-methods' => ['get', 'post', 'put', 'delete', 'options'],
		'allow-headers' => [
			'content-type', 'x-requested-with', 
			'authorization', 'registration-token'
		],
		'expose-headers' => [
			'link', 'access-token', 
			'x-pagination-total-count', 'x-pagination-page-count', 
			'x-pagination-current-page', 'x-pagination-per-page'
		],
	],
	
	'VENDOR_DIR' => '',
	'COMMON_DIR' => '',
	'FRONTEND_DIR' => '',
	'BACKEND_DIR' => '',
	'CONSOLE_DIR' => '',
	'VENDOR_DIR' => '',
	
	'connection' => [
		'main' => [
			'username' => 'root',
			'password' => '',
			'dbname' => 'yii_dev',
			//'dsn' => 'mysql:host=localhost;dbname=yii_dev',
			//'tablePrefix' => '',
			//'driver' => 'mysql',
			//'host' => 'localhost',
		],
		'test' => [
			'dbname' => 'yii_test',
		],
	],
	
 */
