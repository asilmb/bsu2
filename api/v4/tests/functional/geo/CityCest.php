<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CityFixture;
use common\fixtures\CountryFixture;

class CityCest extends RestCest
{
	
	public $format = [
		'id' => 'integer',
		'id_country' => 'integer',
		'region_id' => 'integer',
		'city_name' => 'string',
		'position' => 'integer',
		'status' => 'integer',
		'date_change' => self::TYPE_DATE,
	];
	public $uri = 'city';

	public function _fixtures() {
		return [
			CountryFixture::className(),
			CityFixture::className(),
		];
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getListWithRelations(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?expand=country');
		$I->seeResponseCodeIs(HttpCode::OK);
		$format = $this->format;
		$countryCest = new CountryCest();
		$format['country'] = $countryCest->format;
		$I->seeResponseMatchesJsonType($format);
	}

	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/1');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
	}
	
	public function createSuccess(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'id' => '45',
			'id_country' => '1',
			'region_id' => '1',
			'city_name' => 'Москва',
			'position' => '102',
			'status' => '1',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::CREATED);
	}
	
	public function createExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		// existed city_name field
		$body = [
			'id' => '12',
			'id_country' => '1',
			'region_id' => '1',
			'city_name' => 'Темиртау',
			'position' => '23',
			'status' => '0',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "city_name",
				"message" => 'City Name "Темиртау" has already been taken.'
			],
		]);
		
		// existed id field
		$body = [
			'id' => '1',
			'id_country' => '1',
			'region_id' => '1',
			'city_name' => 'Бостон',
			'position' => '23',
			'status' => '0',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "id",
				"message" => 'Id "1" has already been taken.'
			],
		]);
	}
	
	public function createFail(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'region_id' => '1',
			'city_name' => 'Москва',
			'position' => '102',
			'status' => '1',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "id",
				"message" => 'Id cannot be blank.'
			],
			[
				"field" => "id_country",
				"message" => 'Id Country cannot be blank.'
			],
		]);
	}
	
	public function createNotExistedCountry(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'id' => '123',
			'id_country' => '178',
			'region_id' => '1667',
			'city_name' => 'Бостон 23',
			'position' => '23',
			'status' => '0',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "id_country",
				"message" => 'Id Country is invalid.'
			],
		]);
	}
	
	public function updateSuccess(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'city_name' => 'Киев',
			'id_country' => '2',
		];
		
		$I->sendPUT($this->uri . '/1', $body);
		$I->seeResponse(HttpCode::OK);
		$I->seeResponseContainsJson([
			'city_name' => 'Киев',
		]);
		
		// check Login Updated User
		//$this->checkAuth($authData);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'city_name' => 'Киев',
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
