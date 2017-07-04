<?php
/**
 * AjaxValidationTrait
 */
namespace common\traits;

use Yii;
use api\v4\modules\summary\helpers\ResourceHelper;

trait PictureTrait
{
	protected static $urlList = null;
	protected static $fromExt = ['.svg'];
	
	protected function picUrl($urlName) {
		if(empty($this->picture)) {
			return null;
		}
		$urlList = self::getUrlList();
		return $urlList[$urlName] . '/' . self::picToPng();
	}
	
	protected function picToPng() {
		if(empty($this->picture)) {
			return null;
		}
		return str_replace(static::$fromExt, '.png', $this->picture);
	}
	
	private static function getUrlList() {
		if(empty(static::$urlList)) {
			static::$urlList = ResourceHelper::getResourceByType('url');
		}
		return static::$urlList;
	}
}
