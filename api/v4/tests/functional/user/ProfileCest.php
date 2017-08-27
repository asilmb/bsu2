<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use api\v4\tests\functional\enums\UserEnum;
use common\fixtures\UserProfileFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;

class ProfileCest extends RestCest
{
	const URI = 'profile';
	
	const PROFILE_FIRST_NAME = 'NewFirstName';
	const PROFILE_LAST_NAME = 'NewLastName';
	const PROFILE_SEX = 0;
	const PROFILE_BIRTH_DATE = '1989-02-19T10:42:46Z';
	const PROFILE_CITY = 77;
	const PROFILE_COUNTRY = 34;
	
	public $format = [
		'first_name' => Type::STRING_OR_NULL,
		'last_name' => Type::STRING_OR_NULL,
		'birth_date' => Type::DATE,
		'iin' => Type::STRING_OR_NULL,
		'sex' => Type::BOOLEAN_OR_NULL,
	];
	
	public function fixtures() {
		$this->loadFixtures([
			UserProfileFixture::className(),
		]);
	}

	public function checkPermission(FunctionalTester $I)
	{
		$data = [];
		$I->sendPUT(self::URI, $data);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function changeInfo(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			"first_name" => self::PROFILE_FIRST_NAME,
			"last_name" => self::PROFILE_LAST_NAME,
			"sex" => self::PROFILE_SEX,
		    "birth_date" => self::PROFILE_BIRTH_DATE,
		    "city_id" => self::PROFILE_CITY,
		    "country_id" => self::PROFILE_COUNTRY,
		];
		$I->sendPUT(self::URI, $data);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function getInfo(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	/*public function changeInfoBadData(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$data = [
			"name" => "NewName",
			"sex" => 'uuu',
			"birth_date" => "uuu",
			"city_id" => 'ttt',
			"country_id" => 'yyy',
		];
		$I->sendPUT(self::URI, $data);
		$I->seeUnprocessableEntity([
			[
				"field" => "birth_date",
				"message" => "The format of Birth Date is invalid."
			],
			[
				"field" => "sex",
				"message" => "Sex must be either \"1\" or \"0\"."
			],
			
			[
				"field" => "city_id",
				"message" => "City Id must be an integer."
			],
			[
				"field" => "country_id",
				"message" => "Country Id must be an integer."
			],
		]);
	}
	
	public function detailSuccess(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$I->sendGET(self::URI . '/381069');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function detailSuccessByLogin(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET(self::URI . '/77783177384');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function detailFail(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET(self::URI . '/361660');
		$I->SeeResponseCodeIs(HttpCode::FORBIDDEN);
	}
	
	public function updateSuccessInfo(FunctionalTester $I)
	{
		$I->auth($this->login);
		$data = [
			"name" => "Example",
			"sex" => false,
			"birth_date" => "1977-11-06T00:00:00Z",
			//"id_country" => "2",
			//"city_id" => "0"
		];
		$I->sendPUT(self::URI . '/381069', $data);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		
		$I->sendGET(self::URI . '/381069');
		$I->seeBody($data, true);
		
		$data = [
			"name" => "Example111",
			"sex" => true,
			"birth_date" => "1988-11-06T00:00:00Z",
			//"id_country" => "2",
			//"city_id" => "0"
		];
		$I->sendPUT(self::URI . '/381069', $data);
	}
	
	public function updateSuccessEmail(FunctionalTester $I)
	{
		$I->auth($this->login);
		$data = [
			"password" => "Wwwqqq111",
			"email" => "example@yandex.ru",
		];
		$I->sendPUT(self::URI . '/381069/email', $data);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		
		$I->sendGET(self::URI . '/381069');
		$I->seeBody($data, true);
		
		$data = [
			"password" => "Wwwqqq111",
			"email" => "example111@yandex.ru",
		];
		$I->sendPUT(self::URI . '/381069/email', $data);
	}

	public function updateSuccessPassword(FunctionalTester $I)
	{
		$I->auth($this->login);
		$data = [
			"password" => "Wwwqqq111",
			"new_password" => "Wwwqqq111",
		];
		$I->sendPUT(self::URI . '/381069/password', $data);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function viewFailUnauthorized(FunctionalTester $I)
	{
		$I->sendGET(self::URI . '/381069');
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updateFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT(self::URI . '/381069', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updateEmailFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT(self::URI . '/381069/email', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updatePasswordFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT(self::URI . '/381069/password', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function createFailMethodNotAllowed(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendPOST(self::URI, []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function deleteFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE(self::URI . '/1', []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function indexFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}*/
}