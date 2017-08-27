<?php

namespace api\v4\tests\functional\service;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use common\fixtures\ServiceFieldFixture;
use common\fixtures\ServiceFieldValidationFixture;
use common\fixtures\ServiceFieldValueFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceFixture;
use common\fixtures\FavoriteFixture;

class ServiceFavoriteCest extends RestCest
{

	const URI = 'favorite';
	const URI_EXISTED_ITEM = 'favorite/1';
	const URI_NOT_EXISTED_ITEM = 'favorite/11111';
	
	public $format = [
		'id' => Type::INTEGER,
		'service_id' => Type::INTEGER,
		'name' => Type::STRING_OR_NULL,
		'parent_id' => Type::INTEGER_OR_NULL,
		'title' => Type::STRING,
		'description' => Type::STRING_OR_NULL,
		'picture' => Type::STRING_OR_NULL,
		'picture_url' => Type::STRING_OR_NULL,
		'synonyms' => Type::STRING_OR_NULL,
		'fields' => Type::ARR_OR_NULL,
	];
	
	public function fixtures() {
		$this->loadFixtures([
			ServiceFixture::className(),
			ServiceFieldFixture::className(),
			ServiceFieldValidationFixture::className(),
			ServiceFieldValueFixture::className(),
			FavoriteFixture::className(),
		]);
	}
	
	public function getList(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendGET(self::URI);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeListHttpHeaders([
			HttpHeader::TOTAL_COUNT => 2,
			HttpHeader::PAGE_COUNT => 1,
			HttpHeader::CURRENT_PAGE => 1,
			HttpHeader::PER_PAGE => 20,
		]);
	}
	
	public function getListOfUser1(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeListHttpHeaders([
			HttpHeader::TOTAL_COUNT => 3,
			HttpHeader::PAGE_COUNT => 1,
			HttpHeader::CURRENT_PAGE => 1,
			HttpHeader::PER_PAGE => 20,
		]);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendGET(self::URI_EXISTED_ITEM);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendGET(self::URI_NOT_EXISTED_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function createSuccess(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'title' => 'qwertyuiop',
			'fields' => [
				'amount' => 500,
				'account' => '7777416301',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createFailNotExistsField(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'title' => 'qwertyuiop',
			'fields' => [
				'amountyyy' => 100,
				'accounttyyy' => '1234567890',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "account",
                "message" => "Заполните поле",
			],
			[
				"field" => "amount",
				"message" => "Заполните поле",
			],
		]);
	}
	
	public function createFailEmptyServiceId(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '',
			'title' => 'qwertyuiop',
			'fields' => [
				'amount' => 100,
				'account' => '1234567890',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				'field' => 'service_id',
				'message' => 'Service Id cannot be blank.',
			],
		]);
	}
	
	public function updateNotExisted(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendPUT(self::URI_NOT_EXISTED_ITEM, []);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function deleteSuccess(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendDELETE(self::URI_EXISTED_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function deleteNotExisted(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$I->sendDELETE(self::URI_NOT_EXISTED_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function checkAuthFail(FunctionalTester $I)
	{
		$I->sendGET(self::URI_EXISTED_ITEM);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendDELETE(self::URI_EXISTED_ITEM);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPUT(self::URI_EXISTED_ITEM, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPOST(self::URI, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendGET(self::URI, []);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	public function checkAuthNoneSelf(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		
		$I->sendGET(self::URI_EXISTED_ITEM);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
		
		$I->sendDELETE(self::URI_EXISTED_ITEM);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
		
		$I->sendPUT(self::URI_EXISTED_ITEM, []);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
}
