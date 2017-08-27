<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CurrencyFixture;

class CurrencyCest extends RestCest
{
	
	public $format = [
		'code' => Type::INTEGER,
		'symb_def' => Type::STRING,
		'name_cur' => Type::STRING,
		'descr' => Type::STRING,
	];
	public $uri = 'currency';

	public function fixtures() {
		$this->loadFixtures([
			CurrencyFixture::className(),
		]);
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
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
			'code' => '3',
			'symb_def' => 'USD',
			'name_cur' => 'Американский доллар',
			'descr' => 'Валюта Америки',
		];
		$I->sendPOST($this->uri, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		// existed symb_def field
		$body = [
			'code' => '1111',
			'symb_def' => 'KZT',
			'name_cur' => 'Казахстанский тенге1',
			'descr' => 'Валюта Республики Казахстан1',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "symb_def",
				"message" => 'already_exists KZT'
			],
		]);
		
		// existed code field
		$body = [
			'code' => '1',
			'symb_def' => 'KZT1',
			'name_cur' => 'Казахстанский тенге1',
			'descr' => 'Валюта Республики Казахстан1',
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
			'code' => '345',
			'symb_def' => 'BYR',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "name_cur",
				"message" => 'Name Cur cannot be blank.'
			],
		]);
	}
	
	public function updateSuccess(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'name_cur' => 'Казахстанский тенге 1',
		];
		
		$I->sendPUT($this->uri . '/1', $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
		/*$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseContainsJson([
			'name_cur' => 'Казахстанский тенге 1',
		]);*/
		
		// check Login Updated User
		//$this->checkAuth($authData);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'name_cur' => 'Казахстанский тенге 1',
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
