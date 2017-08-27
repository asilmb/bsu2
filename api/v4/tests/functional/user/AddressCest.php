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

class AddressCest extends RestCest
{
	const URI = 'profile-address';
	
	const PROFILE_FIRST_NAME = 'NewFirstName';
	const PROFILE_LAST_NAME = 'NewLastName';
	const PROFILE_SEX = 0;
	const PROFILE_BIRTH_DATE = '1989-02-19T10:42:46Z';
	const PROFILE_CITY = 77;
	const PROFILE_COUNTRY = 34;
	
	public $format = [
		'country_id' => Type::INTEGER_OR_NULL,
		'region_id' => Type::INTEGER_OR_NULL,
		'city_id' => Type::INTEGER_OR_NULL,
		'district' => Type::STRING_OR_NULL,
		
		'street' => Type::STRING_OR_NULL,
		'home' => Type::STRING_OR_NULL,
		'apartment' => Type::INTEGER_OR_NULL,
		'post_code' => Type::INTEGER_OR_NULL,
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
	
}