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
					ActiveRecord::EVENT_BEFORE_UPDATE => 'update_time',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['update'] = $scenarios['create'] =
			['login', 'email', 'activation_code'];
		return $scenarios;
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['create_time'] = function () {
			return Helper::timeForApi($this->create_time);
		};
		$fields['update_time'] = function () {
			return Helper::timeForApi($this->update_time);
		};
		return $fields;
	}
	
	public function extraFields()
	{
		return ['country'];
	}
	
	public function rules()
	{
		return [
			[['login'], 'required'],
			[['login'], 'unique'],
			[['login', 'email', 'activation_code'], 'trim'],
			['email', 'email'],
			['login', 'validateLogin'],
			['login', 'string', 'min' => 6],
			['activation_code', 'integer', 'min' => 100001, 'max' => 999999],
		];
	}
	
	public function validateLogin($attribute)
	{
		if(!LoginHelper::validate($this->$attribute)) {
			$this->addError($attribute, t('this/registration', 'login_not_valid'));
			return false;
		}
		return true;
	}
	
	public function validateActivationCode($activationCode)
	{
		if($this->activation_code != $activationCode ) {
			$this->addError('activation_code', t('this/registration', 'activation_code_not_valid'));
			return false;
		}
		return true;
	}
	
	public function beforeSave($insert)
	{
		if (parent::beforeSave($insert)) {
			$this->activation_code = $this->generateActivationCode();
			return true;
		} else {
			return false;
		}
	}
	
	public function beforeValidate() {
		$this->login = LoginHelper::pregMatchLogin($this->login); // для правильной проверки уникальности
		return parent::beforeValidate();
	}
	
	private function generateActivationCode()
	{
		if(YII_ENV_DEV || YII_ENV_TEST) {
			$activation_code =  '123456';
		} else {
			$activation_code = rand(100001, 999999);
		}
		return $activation_code;
	}
	
}
