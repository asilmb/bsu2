<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\UserEnum;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;

class RestorePasswordCest extends RestCest
{

	const URI_REQUEST = 'auth/restore-password/request';
	const URI_CHECK_CODE = 'auth/restore-password/check-code';
	const URI_CONFIRM = 'auth/restore-password/confirm';

	public function request(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
		];
		$I->sendPOST(self::URI_REQUEST, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function requestEmptyData(FunctionalTester $I)
	{
		$data = [
			'login' => '',
		];
		$I->sendPOST(self::URI_REQUEST, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "Login cannot be blank."
			],
		]);
	}
	
	public function requestNotValidData(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::SMALL_LOGIN,
		];
		$I->sendPOST(self::URI_REQUEST, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function requestNotFoundLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
		];
		$I->sendPOST(self::URI_REQUEST, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_found"
			],
		]);
	}
	
	public function check(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_CHECK_CODE, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function checkEmptyData(FunctionalTester $I)
	{
		$data = [
			'login' => self::EMPTY_STRING,
			'activation_code' => self::EMPTY_STRING,
		];
		$I->sendPOST(self::URI_CHECK_CODE, $data);
		$I->seeUnprocessableEntity([
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
	
	public function checkNotValidData(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::SMALL_LOGIN,
			'activation_code' => UserEnum::SMALL_ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_CHECK_CODE, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
			[
				"field" => "activation_code",
				"message" => "Activation Code should contain 6 characters."
			],
		]);
	}
	
	public function checkNotFoundLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_CHECK_CODE, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_found"
			],
		]);
	}
	
	public function checkBadCode(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'activation_code' => UserEnum::BAD_ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_CHECK_CODE, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "invalid_activation_code"
			],
		]);
	}
	
	public function confirm(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_CONFIRM, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function confirmEmptyData(FunctionalTester $I)
	{
		$data = [
			'login' => self::EMPTY_STRING,
			'activation_code' => self::EMPTY_STRING,
			'password' => self::EMPTY_STRING,
		];
		$I->sendPOST(self::URI_CONFIRM, $data);
		$I->seeUnprocessableEntity([
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
	
	public function confirmBadCode(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'activation_code' => UserEnum::BAD_ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_CONFIRM, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "invalid_activation_code"
			],
		]);
	}
	
	public function confirmNotFoundLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_CONFIRM, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_found"
			],
		]);
	}
	
	public function confirmNotValidData(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::SMALL_LOGIN,
			'activation_code' => UserEnum::SMALL_ACTIVATION_CODE,
			'password' => UserEnum::SMALL_PASSWORD,
		];
		$I->sendPOST(self::URI_CONFIRM, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
			[
				"field" => "activation_code",
				"message" => "Activation Code should contain 6 characters."
			],
			[
				"field" => "password",
				"message" => "Password should contain at least 8 characters."
			],
		]);
	}
	
}