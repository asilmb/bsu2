<?php
namespace api\v4\modules\user\models;

use Yii;
use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;
use yii2lab\helpers\Helper;
use api\v4\modules\user\helpers\LoginHelper;

/**
 * User model
 *
 * @property string $login
 * @property string $email
 * @property string $activation_code
 * @property string $create_time
 * @property string $update_time
 */
class UserRegistration extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%user_registration}}';
	}
	
	public static function primaryKey()
	{
		return ['login'];
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'create_time',
					//ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['create_time'] = function () {
			return Helper::timeForApi($this->create_time);
		};
		/*$fields['update_time'] = function () {
			return Helper::timeForApi($this->update_time);
		};*/
		return $fields;
	}
	
}
