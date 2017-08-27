<?php

namespace api\v4\tests\functional\active;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use api\v4\tests\functional\enums\UserEnum;
use common\fixtures\ActiveFieldOptionFixture;
use common\fixtures\ActiveFieldValidationFixture;
use common\fixtures\ActiveProviderFixture;
use common\fixtures\ActiveTypeFixture;
use common\fixtures\CurrencyFixture;
use common\fixtures\UserActiveFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ActiveFieldFixture;

class UserCest extends RestCest
{
	
	const URI = 'user-active';
	const URI_EXISTS_ITEM = 'user-active/1';
	const URI_NOT_EXISTS_ITEM = 'user-active/1111111';
	
	public $format = [
		'id' => Type::INTEGER,
		'user_id' => Type::INTEGER,
		'active_id' => Type::INTEGER,
		'provider_id' => Type::INTEGER_OR_NULL,
		'amount' => Type::INTEGER,
		'data' => Type::ARR,
	];
	
	public $expandFormat = [
		'provider' => Type::ARR_OR_NULL,
		//'options' => Type::ARR_OR_NULL,
	];
	
	public function fixtures() {
		$this->loadFixtures([
			ActiveTypeFixture::className(),
			ActiveFieldFixture::className(),
			ActiveFieldValidationFixture::className(),
			ActiveFieldOptionFixture::className(),
			ActiveProviderFixture::className(),
			CurrencyFixture::className(),
			UserActiveFixture::className(),
		]);
	}
	
	public function getList(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(2);
	}
	
	/*public function getListWithExpand(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'expand' => 'validations,options',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType($this->expandFormat);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 4);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(4);
	}*/
	
	public function getListFieldsOnly(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'fields' => 'id,active_id',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'active_id',
		]);
	}
	
	public function getListByActiveId(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'active_id' => '1',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(1);
	}
	
	public function getListSortByActiveId(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'sort' => 'active_id',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(2);
		$I->seeSort(2, 1, 'id');
	}
	
	/*public function getListByBadExpandParameter(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'expand' => 'rrrrrrr',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_expand rrrrrrr"], true);
	}*/
	
	public function getListByBadWhereParameter(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'typeeeeeee' => 'string',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_whereFields typeeeeeee"], true);
	}
	
	public function getListByBadSortParameter(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI, [
			'sort' => 'titleeeeee',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_sortFields titleeeeee"], true);
	}
	
	public function getOne(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	/*public function getOneWithExpand(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI_EXISTS_ITEM, [
			'expand' => 'provider',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType($this->expandFormat);
	}*/
	
	public function getOneFieldsOnly(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI_EXISTS_ITEM, [
			'fields' => 'id,active_id',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'active_id',
		]);
	}
	
	public function getOneNotExisted(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI_NOT_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function create(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '1',
			'provider_id' => '1',
			'currency_code' => '1',
			'data' => [
				'username' => 'qwertyuiop',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createWithEmptyFieldData(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '1',
			'provider_id' => '1',
			'currency_code' => '1',
			'data' => [
				//'username' => 'qwertyuiop',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "username",
				"message" => 'Username cannot be blank.',
			],
		]);
	}
	
	/*public function createWithSmallFieldData(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '1',
			'provider_id' => '1',
			'currency_code' => '1',
			'data' => [
				'username' => 'qq',
			],
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "username",
				"message" => 'Username cannot be blank.',
			],
		]);
	}*/
	
	/*public function createEmpty(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "username",
				"message" => 'Username cannot be blank.',
			],
			[
				"field" => "title",
				"message" => 'Title cannot be blank.',
			],
			[
				"field" => "name",
				"message" => 'Name cannot be blank.',
			],
			[
				"field" => "active_id",
				"message" => 'Active Id cannot be blank.',
			],
			[
				"field" => "type",
				"message" => 'Type cannot be blank.',
			],
		]);
	}*/
	
	/*public function createNotExistsActiveType(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '11111',
			'name' => 'qwerty',
			'title' => 'qwerty',
			'type' => 'integer',
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'active_id',
				"message" => 'not_found',
			],
		]);
	}*/
	
	public function update(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '1',
			'provider_id' => '2',
			'currency_code' => '2',
			'data' => [
				'username' => 'qwertyuiop1111',
			],
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	/*public function updateNotExistsActiveType(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'active_id' => '11111',
			'provider_id' => '2',
			'currency_code' => '2',
			'data' => [
				'username' => 'qwertyuiop1111',
			],
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'active_id',
				"message" => 'not_found',
			],
		]);
	}*/
	
	public function updateNotExisted(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [];
		$I->sendPUT(self::URI_NOT_EXISTS_ITEM, $body);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function deleteNotExisted(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE(self::URI_NOT_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function delete(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		//$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	/*public function checkWriteAccess(FunctionalTester $I) {
		//$I->authAsRole(RBACRoles::UNKNOWN_USER);
		
		$I->sendPOST(self::URI, []);
		$I->SeeResponseCodeIs(HttpCode::FORBIDDEN);
		
		$I->sendDELETE(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::FORBIDDEN);
		
		$I->sendPUT(self::URI_EXISTS_ITEM, []);
		$I->SeeResponseCodeIs(HttpCode::FORBIDDEN);
	}
	
	public function checkWriteAccessGuest(FunctionalTester $I) {
		$I->sendPOST(self::URI, []);
		$I->SeeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendDELETE(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::UNAUTHORIZED);
		
		$I->sendPUT(self::URI_EXISTS_ITEM, []);
		$I->SeeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}*/
	
}
