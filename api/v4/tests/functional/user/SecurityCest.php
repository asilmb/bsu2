<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\UserEnum;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;

class SecurityCest extends RestCest
{
	
	const URI_CHANGE_PASSWORD = 'security/password';
	const URI_CHANGE_EMAIL = 'security/email';
	
	public function changePasswordWithEmptyData(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => '',
			'new_password' => '',
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password cannot be blank."
			],
			[
				"field" => "new_password",
				"message" => "new_password cannot be blank."
			],
		]);
	}
	
	public function changePasswordWithSmallPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::SMALL_PASSWORD,
			'new_password' => UserEnum::SMALL_PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password should contain at least 8 characters."
			],
			[
				"field" => "new_password",
				"message" => "new_password should contain at least 8 characters."
			],
		]);
	}
	
	public function changePasswordWithBadOldPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::BAD_PASSWORD,
			'new_password' => UserEnum::PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "incorrect_password"
			],
		]);
	}
	
	public function changePasswordWithoutOldPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'new_password' => UserEnum::PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password cannot be blank."
			],
		]);
	}
	
	public function changePasswordCompareOldPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::PASSWORD,
			'new_password' => UserEnum::PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "new_password",
				"message" => "new_password must not be equal to \"password\"."
			],
		]);
	}
	
	public function changePasswordMethodNotAllowed(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [];
		$I->sendPOST(self::URI_CHANGE_PASSWORD, $data);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	/*public function changePassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::PASSWORD,
			'new_password' => UserEnum::CHANGED_PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function changePasswordReturnOldPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::CHANGED_PASSWORD,
			'new_password' => UserEnum::PASSWORD,
		];
		$I->sendPUT(self::URI_CHANGE_PASSWORD, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}*/
	
	public function changeEmailWithSmallPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::SMALL_PASSWORD,
			'email' => UserEnum::EMAIL,
		];
		$I->sendPUT(self::URI_CHANGE_EMAIL, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password should contain at least 8 characters."
			],
		]);
	}
	
	public function changeEmailWithBadPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::BAD_PASSWORD,
			'email' => UserEnum::EMAIL,
		];
		$I->sendPUT(self::URI_CHANGE_EMAIL, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "incorrect_password"
			],
		]);
	}
	
	public function changeEmailWithoutOldPassword(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'email' => UserEnum::CHANGED_EMAIL,
		];
		$I->sendPUT(self::URI_CHANGE_EMAIL, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password cannot be blank."
			],
		]);
	}
	
	public function changeEmailMethodNotAllowed(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [];
		$I->sendPOST(self::URI_CHANGE_EMAIL, $data);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function changeEmail(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			'password' => UserEnum::PASSWORD,
			'email' => UserEnum::EMAIL,
		];
		$I->sendPUT(self::URI_CHANGE_EMAIL, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
}