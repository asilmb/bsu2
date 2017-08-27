<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CountryFixture;
use common\fixtures\CurrencyFixture;

class CountryCest extends RestCest
{

	public $format = [
		'code' => Type::INTEGER,
		'name_short' => Type::STRING,
		'name_full' => Type::STRING,
		'symb_def2' => Type::STRING,
		'symb_def3' => Type::STRING,
		'code_curr' => Type::INTEGER,
		'date_change' => Type::DATE,
	];
	public $uri = 'country';

	public function fixtures() {
		$this->loadFixtures([
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
		$I->sendGET($this->uri . '?expand=currency');
		$I->seeResponseCodeIs(HttpCode::OK);
		$format = $this->format;
		$currencyCest = new CurrencyCest();
		$format['currency'] = $currencyCest->format;
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
			'code' => 3,
			'name_short' => 'Америка',
			'name_full' => 'СОЕДИНЕННЫЕ ШТАТЫ АМЕРИКИ',
			'symb_def2' => 'US',
			'symb_def3' => 'USA',
			'code_curr' => 3,
		];
		$I->sendPOST($this->uri, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		// existed many field
		$body = [
			'code' => '11111',
			'name_short' => 'Казахстан',
			'name_full' => 'РЕСПУБЛИКА КАЗАХСТАН',
			'symb_def2' => 'KZ',
			'symb_def3' => 'KAZ',
			'code_curr' => '1',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "name_short",
				"message" => 'already_exists Казахстан'
			],
			[
				"field" => "name_full",
				"message" => 'already_exists РЕСПУБЛИКА КАЗАХСТАН'
			],
			[
				"field" => "symb_def2",
				"message" => 'already_exists KZ'
			],
			[
				"field" => "symb_def3",
				"message" => 'already_exists KAZ'
			],
			[
				"field" => "code_curr",
				"message" => 'already_exists 1'
			],
		]);
		
		// existed id field
		$body = [
			'code' => '1',
			'name_short' => 'Казахстан1',
			'name_full' => 'РЕСПУБЛИКА КАЗАХСТАН1',
			'symb_def2' => 'KZ1',
			'symb_def3' => 'KAZ1',
			'code_curr' => '11',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "code",
				"message" => 'already_exists 1'
			],
		]);
	}
	
	public function createFail(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'code' => 333,
			'name_short' => 'America',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "name_full",
				"message" => 'Name Full cannot be blank.'
			],
			[
				"field" => "symb_def2",
				"message" => 'Symb Def2 cannot be blank.'
			],
			[
				"field" => "symb_def3",
				"message" => 'Symb Def3 cannot be blank.'
			],
		]);
	}
	
	public function updateSuccess(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'name_short' => 'Казахстан1',
			'name_full' => 'РЕСПУБЛИКА КАЗАХСТАН1',
		];
		
		$I->sendPUT($this->uri . '/1', $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
		/*$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseContainsJson([
			'name_short' => 'Казахстан1',
			'name_full' => 'РЕСПУБЛИКА КАЗАХСТАН1',
		]);*/
		
		// check Login Updated User
		//$this->checkAuth($authData);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'name_short' => 'Казахстан1',
			'name_full' => 'РЕСПУБЛИКА КАЗАХСТАН1',
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
