<?php

namespace common\assets;

use Yii;
use yii\web\AssetBundle;

class AdminLteAsset extends AssetBundle
{
	public $sourcePath = '@bower/admin-lte/dist';
	public $js = [
		'js/app.min.js'
	];
	public $css = [
		'css/AdminLTE.min.css',
		'css/skins/skin-blue.min.css'
	];
	public $depends = [
		'yii\web\JqueryAsset',
		'yii\bootstrap\BootstrapPluginAsset',
		'common\assets\FontAwesomeAsset',
	];
	private $addonJs = '
			if (Boolean(sessionStorage.getItem("sidebar-toggle-collapsed"))) {
				$("body").addClass("sidebar-collapse");
			}
			$(".sidebar-toggle").click(function(e) {
				e.preventDefault();
				if (Boolean(sessionStorage.getItem("sidebar-toggle-collapsed"))) {
					sessionStorage.setItem("sidebar-toggle-collapsed", "");
				} else {
					sessionStorage.setItem("sidebar-toggle-collapsed", "1");
				}
			});
		';
	private $addonCss = '
			.sidebar-menu li > a > .pull-right {
				margin-top: -7px;
				position: absolute;
				right: 10px;
				top: 50%;
			}
		';
	
	function init() {
		parent::init();
		Yii::$app->view->registerJs($this->addonJs);
		Yii::$app->view->registerCss($this->addonCss);
	}
	
}
