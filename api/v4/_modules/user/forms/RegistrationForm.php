<?php
namespace api\v4\modules\user\forms;

use Yii;
use yii2lab\misc\yii\base\Model;
use api\v4\modules\user\models\UserRegistration;
use yii2woop\tps\models\SMS;
use yii2woop\tps\generated\exception\tps\TemporaryBlockedException;
use Exception;
use api\v4\modules\user\helpers\LoginHelper;
use api\v4\modules\user\helpers\TpsUserHelper;

/**
 * Login form
 */
class RegistrationForm extends Model
{
	const SCENARIO_CREATE_ACCOUNT = 'login';
	const SCENARIO_ACTIVATE_ACCOUNT = 'confirmation';
	const SCENARIO_SET_PASSWORD = 'password';
	
	public $login;
	public $email;
	public $password;
	public $activation_code;
   
	public function scenarios()
	{
		return [
			self::SCENARIO_CREATE_ACCOUNT => ['login', 'email'],
			self::SCENARIO_ACTIVATE_ACCOUNT => ['login', 'activation_code'],
			self::SCENARIO_SET_PASSWORD => ['login', 'activation_code', 'password'],
		];
	}
	
	public function rules()
	{
		return [
			[['login', 'activation_code'], 'required', 'on' => self::SCENARIO_ACTIVATE_ACCOUNT],
			[['login', 'activation_code', 'password'], 'required', 'on' => self::SCENARIO_SET_PASSWORD],
			[['password'], 'trim'],
			//['password', 'match', 'pattern' => '/(?=^.{8,}$)(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).*$/'],
			['password', 'string', 'min' => 6],
		];
	}
	
	public function save()
	{
		if(!$this->validate()) {
			return false;
		}
		if($this->scenario == self::SCENARIO_CREATE_ACCOUNT) {
			return $this->createLogin();
		}
		if($this->scenario == self::SCENARIO_ACTIVATE_ACCOUNT) {
			return $this->activateLogin();
		}
		if($this->scenario == self::SCENARIO_SET_PASSWORD) {
			return $this->createPassword();
		}
		return false;
	}
	
	protected function createPassword()
	{
		if($this->isLoginExists()) {
			return false;
		}
		$user = self::getUserByLogin();
		if(!$user) {
			return false;
		}
		if(!$user->validateActivationCode($this->activation_code)) {
			$this->addErrors($user->getErrors());
			return false;
		}
		$tps = new TpsUserHelper;
		$insertSubjectResult = $tps->insert($this->login, $this->password, $this->email);
		if ($insertSubjectResult) {
			$user->delete();
		} else {
			$this->addErrors($tps->getErrors());
		}
		return $insertSubjectResult;
	}
	
	protected function isLoginExists()
	{
		$tps = new TpsUserHelper;
		$isExists = $tps->isExists($this->login);
		if($isExists) {
			$this->addError('login', t('this/registration', 'user_already_exists'));
		}
		return $isExists;
	}
	
	protected function createLogin()
	{
		if($this->isLoginExists()) {
			return false;
		}
		/** @var UserRegistration $user */
		$user = Yii::createObject(UserRegistration::className());
		$user->login = $this->login;
		$user->email = $this->email;
		if(!$user->validate()) {
			$this->addErrors($user->getErrors());
			return false;
		}
		$user->save();
		$this->sendActivationCode($user->activation_code);
		return true;
	}
	
	protected function getUserByLogin()
	{
		$user = UserRegistration::findOne(['login' => $this->login]);
		if(!$user) {
			$this->addError('login', t('this/registration', 'user_not_found'));
			return false;
		}
		return $user;
	}
	
	protected function activateLogin()
	{
		
		if($this->isLoginExists()) {
			return false;
		}
		$user = self::getUserByLogin();
		if(!$user) {
			return false;
		}
		if(!$user->validateActivationCode($this->activation_code)) {
			$this->addErrors($user->getErrors());
			return false;
		}
		return true;
	}
	
	/**
	 * @param $smsCode
	 * @return bool
	 */
	private function sendActivationCode($smsCode)
	{
		if(!$smsCode) {
			return false;
		}
		if(YII_ENV_DEV || YII_ENV_TEST) {
			return true;
		}
		$sms = new SMS();
		$login = LoginHelper::parse($this->login);
		$sms->phones = $login['phone'];
		$activation_code = substr($smsCode, 0, 3) . ' ' .  substr($smsCode, 3, 3);
		$sms->message = t('this/registration', 'activate_account_sms {activation_code}', ['activation_code' => $activation_code]);
		try {
			return $sms->send();
		} catch(TemporaryBlockedException $e) {
			$this->addError('login', 'Ваш ip заблокирован');
		} catch (Exception $e){
			$this->addError('login', 'Технические неполадки');
		}
		return false;
	}
	
}
