<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceFixture;
use common\fixtures\FavoriteFixture;

class ServiceFavoriteCest extends RestCest
{

	public $format = [
		'id' => 'integer',
		'service_id' => 'integer',
		'name' => 'string|null',
		'parent_id' => 'integer|null',
		'title' => 'string',
		'description' => 'string|null',
		'picture' => 'string|null',
		'picture_url' => 'string|null',
		'synonyms' => 'string|null',
		'fields' => 'array|null',
	];
	public $uri = 'favorite';
	public $login = '77004163092';

	public function _fixtures() {
		return [
			ServiceFixture::className(),
			FavoriteFixture::className(),
		];
	}

	public function getList(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/524');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
	}
	
	public function createSuccess(FunctionalTester $I) {
		$I->auth($this->login);
		$body = [
			'service_id' => '1',
			'title' => 'qwertyuiop',
			'fields' => [
				'amount' => 100,
				'account' => '1234567890',
			],
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::CREATED);
	}
	
	/*public function createFailNotExistsField(FunctionalTester $I) {
		$I->auth($this->login);
		$body = [
			'service_id' => '20',
			'title' => 'qwertyuiop',
			'fields' => [
				'amountyyy' => 100,
				'accounttyyy' => '1234567890',
			],
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "fields",
                "message" => "field_not_found accountt",
			],
		]);
	}*/
	
	public function createFailEmptyTitle(FunctionalTester $I) {
		$I->auth($this->login);
		$body = [
			'service_id' => '1',
			'title' => '',
			'fields' => [
				'amount' => 100,
				'account' => '1234567890',
			],
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				'field' => 'title',
				'message' => 'Title cannot be blank.',
			],
		]);
	}
	
	public function createFailEmptyServiceId(FunctionalTester $I) {
		$I->auth($this->login);
		$body = [
			'service_id' => '',
			'title' => 'qwertyuiop',
			'fields' => [
				'amount' => 100,
				'account' => '1234567890',
			],
		];
		$I->sendPOST($this->uri, $body);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				'field' => 'service_id',
				'message' => 'Service Id cannot be blank.',
			],
		]);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendPUT($this->uri . '/111111', []);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function deleteSuccess(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendDELETE($this->uri . '/524');
		$I->seeResponse(HttpCode::NO_CONTENT);
	}
	
	public function deleteNotExisted(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendDELETE($this->uri . '/111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
	}
	
	public function checkAuthFail(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/524');
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendDELETE($this->uri . '/524');
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPUT($this->uri . '/524', []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPOST($this->uri, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendGET($this->uri, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function checkAuthNoneSelf(FunctionalTester $I)
	{
		$I->auth('77783177384');
		
		$I->sendGET($this->uri . '/524');
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
		
		$I->sendDELETE($this->uri . '/524');
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
		
		$I->sendPUT($this->uri . '/524', []);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
}
