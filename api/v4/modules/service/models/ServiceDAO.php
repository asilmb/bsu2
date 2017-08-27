<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 21.07.2017
 * Time: 12:07
 */

namespace api\v4\modules\service\models;


use yii\db\ActiveRecord;

class ServiceDAO extends ActiveRecord {
	
	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service}}';
	}
	

}