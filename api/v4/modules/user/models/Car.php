<?php

namespace api\v4\modules\user\models;

use yii\db\ActiveRecord;

/**
 * Confirm model
 *
 * @property string $login
 * @property string $action
 * @property string $activation_code
 * @property string $created_at
 */
class Car extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_car}}';
	}
	
}
