<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\UserEnum;
use common\fixtures\NotifyFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use common\fixtures\UserRegistrationFixture;

class RegistrationCest extends RestCest
{

	const URI_CREATE_ACCOUNT = 'registration/create-account';
	const URI_ACTIVATE_ACCOUNT = 'registration/activate-account';
	const URI_SET_PASSWORD = 'registration/set-password';

	public function fixtures() {
		$this->unloadFixtures([
			NotifyFixture::className(),
			UserRegistrationFixture::className(),
		]);
	}
	
	public function createTempUser(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createExistedTempUser(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "user_already_exists_but_not_activation"
			],
		]);
	}

	public function createExistedTpsUser(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TPS_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "user_already_exists_and_activated"
			],
		]);
	}

	public function createBeeline(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_BEELINE_LOGIN,
			'email' => UserEnum::EMAIL,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}

	public function createShotLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::SMALL_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createBigLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::BIG_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createBadPrefix(FunctionalTester $I)
	{
		$data = [
			'login' => 'RX' . UserEnum::NOT_EXISTED_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}
	
	public function createInvalidEmail(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'email' => UserEnum::NOT_VALID_EMAIL,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "email",
				"message" => "email is not a valid email address."
			],
		]);
	}

	public function createEmptyParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login cannot be blank."
			],
		]);
	}

	/*public function createWithEmail(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'email' => UserEnum::EMAIL,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}*/

	public function activateEmptyParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST(self::URI_ACTIVATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login cannot be blank."
			],
			[
				"field" => "activation_code",
				"message" => "activation_code cannot be blank."
			],
		]);
	}
	
	public function activateNotActualActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
			'activation_code' => UserEnum::BAD_ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_ACTIVATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "invalid_activation_code"
			],
		]);
	}
	
	public function activateEmptyActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
		];
		$I->sendPOST(self::URI_ACTIVATE_ACCOUNT, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "activation_code cannot be blank."
			],
		]);
	}

	public function setPasswordEmptyParams(FunctionalTester $I)
	{
		$data = [];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login cannot be blank."
			],
			[
				"field" => "activation_code",
				"message" => "activation_code cannot be blank."
			],
			[
				"field" => "password",
				"message" => "Password cannot be blank."
			],
		]);
	}

	public function setPasswordEmptyPassword(FunctionalTester $I) {
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "Password cannot be blank."
			],
		]);
	}
	
	public function setPasswordEmptyActivationCode(FunctionalTester $I) {
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "activation_code cannot be blank."
			],
		]);
	}

	public function setPasswordInvalidActivationCode(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
			'activation_code' => UserEnum::BAD_ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "activation_code",
				"message" => "invalid_activation_code"
			],
		]);
	}

	public function setPasswordInvalidPassword(FunctionalTester $I) {
		$data = [
			'login' => UserEnum::EXISTED_TEMP_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
			'password' => UserEnum::SMALL_PASSWORD,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "Password should contain at least 8 characters."
			],
		]);
	}

	public function create(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
		];
		$I->sendPOST(self::URI_CREATE_ACCOUNT, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}

	public function activate(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
		];
		$I->sendPOST(self::URI_ACTIVATE_ACCOUNT, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}

	public function setPassword(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}

	public function setPasswordRepeat(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::NOT_EXISTED_LOGIN,
			'activation_code' => UserEnum::ACTIVATION_CODE,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI_SET_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "temp_user_not_found"
			],
		]);
	}

}