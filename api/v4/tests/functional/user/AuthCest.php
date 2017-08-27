<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\UserEnum;
use common\fixtures\UserProfileFixture;
use Yii;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use common\fixtures\UserFixture;

class AuthCest extends RestCest
{
	
	const URI = 'auth';
	
	public $format = [
		'id' => Type::INTEGER,
		'login' => Type::STRING,
		'email' => Type::STRING,
		
		'roles' => Type::ARR,
		//'creation_date' => Type::DATE,
		'parent_id' => Type::INTEGER_OR_NULL,
		'subject_type' => Type::INTEGER,
		
		
		'profile' => [
			'first_name' => Type::STRING_OR_NULL,
			'last_name' => Type::STRING_OR_NULL,
			'birth_date' => Type::DATE,
			'iin' => Type::STRING_OR_NULL,
			'sex' => Type::BOOLEAN_OR_NULL,
		],
		//'iin_fixed' => 'string|boolean',
		'balance' => [
			'blocked' => Type::FLOAT,
			'active' => Type::FLOAT,
			'pay_delayed' => Type::FLOAT,
			'acc_base' => Type::FLOAT,
			'acc_commission' => Type::FLOAT,
		],
	];

	public function fixtures() {
		$this->loadFixtures([
			UserProfileFixture::className(),
		]);
		if(Yii::$app->account->repositories->login->driver != 'ar') {
			return;
		}
		$this->loadFixtures([
			UserFixture::className(),
		]);
	}

	public function login(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType(['token' => Type::STRING]);
	}

	public function loginWithFormattedLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::FORMATTED_LOGIN,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->SeeResponseCodeIs(HttpCode::OK);
	}

	public function loginWithShotLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::SMALL_LOGIN,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}

	public function loginWithBigLogin(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::BIG_LOGIN,
			'password' => UserEnum::PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "login",
				"message" => "login_not_valid"
			],
		]);
	}

	public function loginWithShotPassword(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'password' => UserEnum::SMALL_PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "password should contain at least 8 characters."
			],
		]);
	}

	public function loginWithBadPassword(FunctionalTester $I)
	{
		$data = [
			'login' => UserEnum::EXISTED_LOGIN,
			'password' => UserEnum::BAD_PASSWORD,
		];
		$I->sendPOST(self::URI, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "password",
				"message" => "incorrect_login_or_password"
			],
		]);
	}

	public function info(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->dontSeeResponseJsonFields([
			'token',
			'auth_key',
			'password_hash',
			'password_reset_token'
		]);
	}
	
	public function infoByGuest(FunctionalTester $I)
	{
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}

}