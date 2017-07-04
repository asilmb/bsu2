<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main frontend application asset bundle.
 */
class AppAsset extends AssetBundle
{
	public $basePath = '@webroot';
	public $baseUrl = '@web';
	public $css = [
		'css/app/main.css',
	];
	public $js = [
	];
	public $depends = [
		'yii\web\YiiAsset',
		'common\assets\AdminLteAsset',
		'yii2lab\ubuntu_font\assets\UbuntuAsset',
	];
}
