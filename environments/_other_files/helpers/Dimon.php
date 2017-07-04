<?php
namespace yii2lab\misc\helpers;

use Yii;
use yii\helpers\VarDumper;
//use yii\helpers\Html;
use yii2lab\helpers\yii\ArrayHelper;
//use yii\base\Module;
use common\assets\CommentSmile;
//use yii\helpers\Url;
use yii2lab\helpers\yii\FileHelper;

class Dimon {

	const CACHE_MENU_TIME = 86400;

	/**
	 * Around all modules and build menu
	 * @return array
	 * */
	public static function getModulesMenu()
	{
		$cashKey = 'HC.ModulesMenu';
		$componentsMenu = [];
		if(Yii::$app->cache->exists($cashKey)) {
			$componentsMenu = Yii::$app->cache->get($cashKey);
		} else {
			foreach(array_keys(Yii::$app->getModules()) as $key => $moduleName) {
				if(Yii::$app->hasModule($moduleName) && ($module = Yii::$app->getModule($moduleName)) instanceof Module) {
					if(method_exists($module, 'getMenu')) {
						if (($menu = $module->getMenu()) === []) {
							continue;
						}
						$componentsMenu[] = $menu;
					}
				}
			}
			// Yii::$app->cache->set($cashKey, $componentsMenu, self::CACHE_MENU_TIME);
		}
		return $componentsMenu;
	}

	/**
	 * Truncates a string to the number of characters specified.
	 * @param string $string
	 * @param integer $count_symbol
	 * @param string $suffix
	 * @param boolean $strip_tags
	 * @return string
	 */
	public static function truncate($string, $count_symbol, $suffix = '...', $strip_tags = true)
	{
		$count_string = strlen($string);
		if ($count_string <= $count_symbol) {
			$string = $strip_tags ? strip_tags($string) : $string;
		} else {
			if($strip_tags) {
				$string = strip_tags(substr($string, 0, strpos($string, " ", $count_symbol))) . $suffix;
			} else {
				$string =substr($string, 0, strpos($string, " ", $count_symbol)) . $suffix;
			}
		}
		return $string;
	}
	/**
	 * get Gramm
	 * @param integer $count
	 * @param string $unit
	 * @param \common\modules\food\models\Product $product
	 * @return integer
	 */
	public static function getGramm($count, $unit, $product) {
		if (!$unit) {
			return 0;
		}
		if ($unit == 'kg') {
			return $count * 1000;
		} else if ($unit == 'g') {
			return $count;
		} else if ($unit == 'litr') {
			return $count * 1000;
		} else if ($unit == 'ml') {
			return $count;
		} else {
			$units = [
				'ch-spoon'  => 'unit_chl',
				'st-spoon'  => 'unit_stl',
				'stak'	  => 'unit_stak',
				'ht'		=> 'unit_sht',
				'ml'		=> 'unit_ml',
				'litr'	  => 'unit_l',
				'packing'   => 'unit_upak',
				'bank'	  => 'unit_ban',
				'puchok'	=> 'unit_puch',
				'twig'	  => 'unit_vet'
			];
			if ($product) {
				return isset($units[$unit]) ? ($product->$units[$unit] * $count) : 0;
			} else {
				return 0;
			}
		}
	}

	/**
	 * Words abs
	 * @param integer $n
	 * @param string $form1
	 * @param string $form2
	 * @param string $form5
	 * @return string
	*/
	public static function skl($n, $form1, $form2, $form5){
		$n = abs($n) % 100;
		$n1 = $n % 10;
		if ($n > 10 && $n < 20) return $form5;
		if ($n1 > 1 && $n1 < 5) return $form2;
		if ($n1 == 1) return $form1;return $form5;
	}

	/**
	 * get Smile
	 * @param string $str
	 * @return string
	 */
	public static function getSmile ($str) {
		$folder = Yii::$app->assetManager->getPublishedUrl(CommentSmile::$filePath) . '/smiles/';
		$output = str_replace(':-)','<img src="'.$folder.'1.gif">',$str);
		$output = str_replace(':-(','<img src="'.$folder.'2.gif">',$output);
		$output = str_replace(';-)','<img src="'.$folder.'3.gif">',$output);
		$output = str_replace(':-D','<img src="'.$folder.'4.gif">',$output);
		$output = str_replace(':-P','<img src="'.$folder.'5.gif">',$output);
		$output = str_replace('=-O','<img src="'.$folder.'6.gif">',$output);
		$output = str_replace('*JOKINGLY*','<img src="'.$folder.'7.gif">',$output);
		$output = str_replace(':-/','<img src="'.$folder.'8.gif">',$output);
		$output = str_replace(':-[','<img src="'.$folder.'9.gif">',$output);
		$output = str_replace('*THUMBS UP*','<img src="'.$folder.'10.gif">',$output);
		$output = str_replace(':-*','<img src="'.$folder.'11.gif">',$output);
		$output = str_replace(':`(','<img src="'.$folder.'12.gif">',$output);
		$output = str_replace(':`(','<img src="'.$folder.'12.gif">',$output);
		$output = str_replace('%)','<img src="'.$folder.'13.gif">',$output);
		$output = str_replace('*IN LOVE*','<img src="'.$folder.'14.gif">',$output);
		$output = str_replace('8-)','<img src="'.$folder.'15.gif">',$output);
		$output = str_replace('*NO*','<img src="'.$folder.'16.gif">',$output);
		$output = str_replace('*HELP*','<img src="'.$folder.'17.gif">',$output);
		$output = str_replace('*WALL*','<img src="'.$folder.'18.gif">',$output);
		$output = str_replace('*SORRY*','<img src="'.$folder.'19.gif">',$output);
		$output = str_replace('*YAHOO*','<img src="'.$folder.'20.gif">',$output);
		$output = str_replace('*DONT_KNOW*','<img src="'.$folder.'21.gif">',$output);
		$output = str_replace(':-X','<img src="'.$folder.'22.gif">',$output);
		$output = str_replace('*ROFL*','<img src="'.$folder.'23.gif">',$output);
		$output = str_replace('@=','<img src="'.$folder.'24.gif">',$output);
		$output = str_replace('*DRINK*','<img src="'.$folder.'25.gif">',$output);
		$output = str_replace(':-!','<img src="'.$folder.'26.gif">',$output);
		$output = str_replace('*HI*','<img src="'.$folder.'27.gif">',$output);
		$output = str_replace('*SCRATCH*','<img src="'.$folder.'28.gif">',$output);
		$output = str_replace(']:->','<img src="'.$folder.'29.gif">',$output);
		$output = str_replace(';D','<img src="'.$folder.'30.gif">',$output);
		return $output;
	}

	/**
	 * get Smile list
	 * @return string
	 */
	public static function getSmileList () {
		$folder = Yii::$app->assetManager->getPublishedUrl(CommentSmile::$filePath) . '/smiles/';
		$output = '
			<a href="#" alt=":-)" class="smile"><img src="'.$folder.'1.gif"></a>
			<a href="#" alt=":-(" class="smile"><img src="'.$folder.'2.gif"></a>
			<a href="#" alt=";-)" class="smile"><img src="'.$folder.'3.gif"></a>
			<a href="#" alt=":-D" class="smile"><img src="'.$folder.'4.gif"></a>
			<a href="#" alt=":-P" class="smile"><img src="'.$folder.'5.gif"></a>
			<a href="#" alt="=-O" class="smile"><img src="'.$folder.'6.gif"></a>
			<a href="#" alt="*JOKINGLY*" class="smile"><img src="'.$folder.'7.gif"></a>
			<a href="#" alt=":-/" class="smile"><img src="'.$folder.'8.gif"></a>
			<a href="#" alt=":-[" class="smile"><img src="'.$folder.'9.gif"></a>
			<a href="#" alt="*THUMBS UP*" class="smile"><img src="'.$folder.'10.gif"></a>
			<a href="#" alt=":-*" class="smile"><img src="'.$folder.'11.gif"></a>
			<a href="#" alt=":`(" class="smile"><img src="'.$folder.'12.gif"></a>
			<a href="#" alt="%)" class="smile"><img src="'.$folder.'13.gif"></a>
			<a href="#" alt="*IN LOVE*" class="smile"><img src="'.$folder.'14.gif"></a>
			<a href="#" alt="8-)" class="smile"><img src="'.$folder.'15.gif"></a>
			<a href="#" alt="*NO*" class="smile"><img src="'.$folder.'16.gif"></a>
			<a href="#" alt="*HELP*" class="smile"><img src="'.$folder.'17.gif"></a>
			<a href="#" alt="*WALL*" class="smile"><img src="'.$folder.'18.gif"></a>
			<a href="#" alt="*SORRY*" class="smile"><img src="'.$folder.'19.gif"></a>
			<a href="#" alt="*YAHOO*" class="smile"><img src="'.$folder.'20.gif"></a>
			<a href="#" alt="*DONT_KNOW*" class="smile"><img src="'.$folder.'21.gif"></a>
			<a href="#" alt=":-X" class="smile"><img src="'.$folder.'22.gif"></a>
			<a href="#" alt="*ROFL*" class="smile"><img src="'.$folder.'23.gif"></a>
			<a href="#" alt="@=" class="smile"><img src="'.$folder.'24.gif"></a>
			<a href="#" alt="*DRINK*" class="smile"><img src="'.$folder.'25.gif"></a>
			<a href="#" alt=":-!" class="smile"><img src="'.$folder.'26.gif"></a>
			<a href="#" alt="*HI*" class="smile"><img src="'.$folder.'27.gif"></a>
			<a href="#" alt="*SCRATCH*" class="smile"><img src="'.$folder.'28.gif"></a>
			<a href="#" alt="]:->" class="smile"><img src="'.$folder.'29.gif"></a>
			<a href="#" alt="*;D*" class="smile"><img src="'.$folder.'30.gif"></a>
		';
		return $output;
	}

	/**
	 * get Action Route
	 * @return string
	 */
	public static function getActionRoute() {
		$module = Yii::$app->controller->module->id;
		$controller = Yii::$app->controller->id;
		$action = Yii::$app->controller->action->id;
		return $controller.'/'.$action;
	}
	
}