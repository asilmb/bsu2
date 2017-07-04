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
		'css/slick.css',
		'css/slick-theme.css',
		'css/style.min.css',
	];
	public $js = [
		'js/jquery-3.2.1.min.js',
		'js/slick.js',
		'js/application.min.js',
	];
	public $depends = [
	
	];
	
}

