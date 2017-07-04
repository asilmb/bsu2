<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;

class ProfileCest extends RestCest
{
	public $format = [
		'id' => 'integer',
		'parent_id' => 'integer|null',
		'name' => 'string',
		'subject_type' => 'integer',
		'creation_date' => self::TYPE_DATE,
		'sex' => 'boolean',
		'birth_date' => self::TYPE_DATE,
		'city' => 'integer',
		'country' => 'integer',
		'email' => 'string',
		//'iin_fixed' => '',
		'balance' => 'array|null',
		'roles' => 'array',
	];
	public $login = '77783177384';
	public $uri = 'profile';
	
	public function detailSuccess(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/381069');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function detailSuccessByLogin(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/77783177384');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function detailFail(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/361660');
		$I->seeResponse(HttpCode::FORBIDDEN);
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
		$I->sendPUT($this->uri . '/381069', $data);
		$I->seeResponse(HttpCode::OK);
		
		$I->sendGET($this->uri . '/381069');
		$I->seeBody($data, true);
		
		$data = [
			"name" => "Example111",
			"sex" => true,
			"birth_date" => "1988-11-06T00:00:00Z",
			//"id_country" => "2",
			//"city_id" => "0"
		];
		$I->sendPUT($this->uri . '/381069', $data);
	}
	
	public function updateSuccessEmail(FunctionalTester $I)
	{
		$I->auth($this->login);
		$data = [
			"password" => "Wwwqqq111",
			"email" => "example@yandex.ru",
		];
		$I->sendPUT($this->uri . '/381069/email', $data);
		$I->seeResponse(HttpCode::OK);
		
		$I->sendGET($this->uri . '/381069');
		$I->seeBody($data, true);
		
		$data = [
			"password" => "Wwwqqq111",
			"email" => "example111@yandex.ru",
		];
		$I->sendPUT($this->uri . '/381069/email', $data);
	}

	public function updateSuccessPassword(FunctionalTester $I)
	{
		$I->auth($this->login);
		$data = [
			"password" => "Wwwqqq111",
			"new_password" => "Wwwqqq111",
		];
		$I->sendPUT($this->uri . '/381069/password', $data);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function viewFailUnauthorized(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/381069');
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updateFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT($this->uri . '/381069', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updateEmailFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT($this->uri . '/381069/email', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function updatePasswordFailUnauthorized(FunctionalTester $I)
	{
		$I->sendPUT($this->uri . '/381069/password', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function createFailMethodNotAllowed(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendPOST($this->uri, []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function deleteFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE($this->uri . '/1', []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function indexFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendGET($this->uri);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
}