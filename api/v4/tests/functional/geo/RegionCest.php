<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use common\fixtures\RegionFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CountryFixture;
use common\fixtures\CurrencyFixture;

class RegionCest extends RestCest
{

	public $format = [
		'id' => Type::INTEGER,
		'country_id' => Type::INTEGER,
		'title' => Type::STRING,
		'country' => Type::ARR_OR_NULL,
		'cities' => Type::ARR_OR_NULL,

	];
	public $expandFormat = [

	];
	public $uri = 'region';

	public function fixtures() {
		$this->loadFixtures([
			RegionFixture::className(),
			CurrencyFixture::className(),
			CountryFixture::className(),
		]);
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function getListWithRelations(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?expand=country,cities');
		$I->seeResponseCodeIs(HttpCode::OK);
		$format = $this->format;
		$countryCest = new CountryCest();
		$format['country'] = $countryCest->format;
		//$cityCest = new CityCest();
		//$format['city'] = $cityCest->format;
		$I->seeResponseMatchesJsonType($format);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/1');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}

	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function createSuccess(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'id' => '2',
			'country_id' => '1',
			'title' => 'Алматинская область',
		];
		$I->sendPOST($this->uri, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		// existed many field
		$body = [
			'id' => '1',
			'country_id' => '1',
			'title' => 'Карагандинская область',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'id',
				"message" => 'already_exists 1'
			],
		]);
	}
	
	public function createFail(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'id' => 333,
			'title' => '',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "title",
				"message" => 'Title cannot be blank.'
			],
			[
				"field" => "country_id",
				"message" => 'Country Id cannot be blank.'
			],
		]);
	}
	
	public function updateSuccess(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'title' => '1111111',
		];
		
		$I->sendPUT($this->uri . '/1', $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'title' => '1111111',
		];
		$I->sendPUT($this->uri . '/222', $body);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}

	public function deleteSuccess(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE($this->uri . '/1');
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function deleteFailNotExisted(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE($this->uri . '/1111');
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function checkAuthFail(FunctionalTester $I)
	{
		$I->sendDELETE($this->uri . '/1');
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPUT($this->uri . '/1', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPOST($this->uri, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
}
