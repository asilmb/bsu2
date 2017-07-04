<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\CurrencyFixture;

class CurrencyCest extends RestCest
{
	
	public $format = [
		'code' => 'integer',
		'symb_def' => 'string',
		'name_cur' => 'string',
		'descr' => 'string',
	];
	public $uri = 'currency';

	public function _fixtures() {
		return [
			CurrencyFixture::className(),
		];
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
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
			'code' => '3',
			'symb_def' => 'USD',
			'name_cur' => 'Американский доллар',
			'descr' => 'Валюта Америки',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::CREATED);
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
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "symb_def",
				"message" => 'Symb Def "KZT" has already been taken.'
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
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "code",
				"message" => 'Code "1" has already been taken.'
			],
		]);
	}
	
	public function createFail(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'code' => '3',
			'symb_def' => 'USD',
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
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
		$I->seeResponse(HttpCode::OK);
		$I->seeResponseContainsJson([
			'name_cur' => 'Казахстанский тенге 1',
		]);
		
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
