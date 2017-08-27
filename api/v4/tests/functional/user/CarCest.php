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

class CarCest extends RestCest
{
	const URI = 'profile-car';
	
	const CAR_GOV_NUMBER = '345zxc09';
	const CAR_DOCUMENT_NUMBER = '23456789';
	
	public $format = [
		'gov_number' => Type::STRING_OR_NULL,
		'document_number' => Type::STRING_OR_NULL,
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
		    "gov_number" => self::CAR_GOV_NUMBER,
		    "document_number" => self::CAR_DOCUMENT_NUMBER,
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