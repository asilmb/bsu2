<?php

namespace frontend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';

	public $css = [
		'css/style.min.css',
	];
	public $js = [
		'js/jquery-3.2.1.min.js',
		'js/sly.min.js',
		'js/application.min.js',
	];
	public $depends = [
	
	];
	
}

