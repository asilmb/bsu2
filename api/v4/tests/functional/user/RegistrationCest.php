<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use common\fixtures\UserRegistrationFixture;

class RegistrationCest extends RestCest
{
	
	public $format = [
		'token' => 'string',
	];
	public $login = '77968422586';
	public $uri = 'registration';
	
	public function _fixtures() {
		return [
			UserRegistrationFixture::className(),
		];
	}
	
	public function createAccountSuccess(FunctionalTester $I)
	{
		$data = [
			'login' => $this->login,
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
		
		$data = [
			'login' => '77021112233',
			'email' => 'example@ya.ru',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
		
		$data = [
			'login' => 'B77021112233',
			'email' => 'example@ya.ru',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createAccountFailInvalidLogin(FunctionalTester $I)
	{
		$data = [
			'login' => 'tt',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createAccountFailLowLengthLogin(FunctionalTester $I)
	{
		$data = [
			'login' => '7702444556',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createAccountFailHightLengthLogin(FunctionalTester $I)
	{
		$data = [
			'login' => '770244455669',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createAccountFailNotFoundPrefix(FunctionalTester $I)
	{
		$data = [
			'login' => 'RX77024445566',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createAccountFailInvalidEmail(FunctionalTester $I)
	{
		$data = [
			'login' => $this->login,
			'email' => 'exampleya.ru',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "email",
				"message" => "Email is not a valid email address."
			],
		]);
	}
	
	public function createAccountFailEmptyParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST($this->uri . '/create-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "Login cannot be blank."
			],
		]);
	}
	
	public function activateNewAccountSuccess(FunctionalTester $I)
	{
		$data = [
			'login' => '77024445566',
		];
		$I->sendPOST($this->uri . '/create-account', $data);
		
		$data['activation_code'] = '123456';
		$I->sendPOST($this->uri . '/activate-account', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function activateAccountSuccess(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
		];
		$I->sendPOST($this->uri . '/activate-account', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function activateAccountFailEmptyParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST($this->uri . '/activate-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "Login cannot be blank."
			],
			[
				"field" => "activation_code",
				"message" => "Activation Code cannot be blank."
			],
		]);
	}
	
	public function activateAccountFailInvalidActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
			'activation_code' => '111111',
		];
		$I->sendPOST($this->uri . '/activate-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "activation_code",
				"message" => "activation_code_not_valid"
			],
		]);
	}
	
	public function activateAccountFailEmptyActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
		];
		$I->sendPOST($this->uri . '/activate-account', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "activation_code",
				"message" => "Activation Code cannot be blank."
			],
		]);
	}
	
	public function setPasswordSuccess(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
			'password' => 'foiwenownamlmsxc',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function setPasswordFailDouble(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
			'password' => 'foiwenownamlmsxc',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
		
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
			'password' => 'foiwenownamlmsxc',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponseCodeIs(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "user_not_found"
			],
		]);
	}
	
	public function setPasswordFailEmptyAllParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "login",
				"message" => "Login cannot be blank."
			],
			[
				"field" => "activation_code",
				"message" => "Activation Code cannot be blank."
			],
			[
				"field" => "password",
				"message" => "Password cannot be blank."
			],
		]);
	}
	
	public function setPasswordFailEmptyActivationCodeAndPassword(FunctionalTester $I) {
		$data = [
			'login' => '77026665544',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "activation_code",
				"message" => "Activation Code cannot be blank."
			],
			[
				"field" => "password",
				"message" => "Password cannot be blank."
			],
		]);
	}
	
	public function setPasswordFailEmptyPassword(FunctionalTester $I) {
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "password",
				"message" => "Password cannot be blank."
			],
		]);
	}
	
	public function setPasswordFailEmptyActivationCode(FunctionalTester $I) {
		$data = [
			'login' => '77026665544',
			'password' => 'foiwenownamlmsxc',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "activation_code",
				"message" => "Activation Code cannot be blank."
			],
		]);
	}
	
	public function setPasswordFailInvalidPassword(FunctionalTester $I) {
		$data = [
			'login' => '77026665544',
			'activation_code' => '123456',
			'password' => 'foiw',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "password",
				"message" => "Password should contain at least 6 characters."
			],
		]);
	}
	
	public function setPasswordFailInvalidActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => '77026665544',
			'activation_code' => '111111',
			'password' => 'foiwenownamlmsxc',
		];
		$I->sendPOST($this->uri . '/set-password', $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "activation_code",
				"message" => "activation_code_not_valid"
			],
		]);
	}
	
}