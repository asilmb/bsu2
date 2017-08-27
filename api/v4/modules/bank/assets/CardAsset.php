<?php

namespace api\v4\modules\bank\assets;

use Yii;
use yii\web\AssetBundle;

class CardAsset extends AssetBundle
{
	public $sourcePath = '@api/v4/modules/bank/assets';
	public $js = [
		'js/application.js'
	];
	public $css = [
		
	];
	public $depends = [
		//'yii\web\JqueryAsset',
		'yii\web\YiiAsset',
		//'yii\bootstrap\BootstrapPluginAsset',
	];
	private $addonJs = '
			
		';
	private $addonCss = '
			
		';
	
	function init() {
		parent::init();
		//Yii::$app->view->registerJs($this->addonJs);
		//Yii::$app->view->registerCss($this->addonCss);
	}
	
}
