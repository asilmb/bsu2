<?php
namespace backend\modules\app\models;

use Yii;
use yii2lab\misc\yii\base\Model;
use yii\helpers\FileHelper;

/**
 * Cash form
 */
class Cash extends Model
{
	
	public function clearCash($app)
	{
		$dir = Yii::getAlias('@' . $app) . DS . 'runtime' . DS . 'cache';
		FileHelper::removeDirectory($dir);
	}

}
