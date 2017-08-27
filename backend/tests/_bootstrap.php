<?php

use yii2lab\app\App;

$name = 'backend';
$path = '../..';
defined('YII_ENV') || define('YII_ENV', 'test');

require_once(__DIR__ . '/' . $path . '/vendor/yii2lab/yii2-app/src/App.php');

App::init($name);
