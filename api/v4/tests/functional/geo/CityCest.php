<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CityFixture;
use common\fixtures\CountryFixture;

class CityCest extends RestCest
{
	
	public $format = [
		'id' => Type::INTEGER,
		'id_country' => Type::INTEGER,
		'region_id' => Type::INTEGER,
		'city_name' => Type::STRING,
		'position' => Type::INTEGER,
		'status' => Type::INTEGER,
		'date_change' => Type::DATE,
	];
	public $uri = 'city';

	public function fixtures() {
		$this->loadFixtures([
			CountryFixture::className(),
			CityFixture::className(),
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
			'id' => '45',
			'id_country' => '1',
			'region_id' => '1',
			'city_name' => 'Москва',
			'position' => '102',
			'status' => '1',
		];
		$I->sendPOST($this->uri, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
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
		$I->seeUnprocessableEntity([
			[
				"field" => "city_name",
				"message" => 'already_exists Темиртау'
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
		$I->seeUnprocessableEntity([
			[
				"field" => "id",
				"message" => 'already_exists 1'
			],
		]);
	}
	
	public function createFail(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'region_id' => '123',
			'city_name' => 'Moscow',
			'position' => '102',
			'status' => '1',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
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
		$I->seeUnprocessableEntity([
			[
				"field" => "id_country",
				"message" => 'not_found'
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
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
		/*$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseContainsJson([
			'city_name' => 'Киев',
		]);*/
		
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
