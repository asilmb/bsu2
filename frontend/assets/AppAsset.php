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
    public $jsOptions = array(
        'position' => \yii\web\View::POS_HEAD
    );
	public $css = [
		'css/style.min.css',
        'css/owl.carousel.min.css',
        'css/owl.theme.default.min.css'
	];
	public $js = [
		'js/jquery-3.2.1.min.js',
		'js/owl.carousel.min.js',
		'js/application.min.js',
		'https://api-maps.yandex.ru/2.1/?lang=ru_RU'
	];
	public $depends = [
	
	];
	
}

