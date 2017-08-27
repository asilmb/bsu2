<?php

namespace api\v4\tests\functional\active;

use api\tests\FunctionalTester;
use common\fixtures\ActiveFieldOptionFixture;
use common\fixtures\ActiveFieldValidationFixture;
use common\fixtures\ActiveTypeFixture;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ActiveFieldFixture;

class ValidationCest extends RestCest
{
	
	const URI = 'active-validation';
	const URI_EXISTS_ITEM = 'active-validation/1';
	const URI_NOT_EXISTS_ITEM = 'active-validation/1111111';
	
	public $format = [
		'id' => Type::INTEGER,
		'field_id' => Type::INTEGER,
		'type' => Type::STRING,
		'rules' => Type::ARR_OR_NULL,
	];
	
	public function fixtures() {
		$this->loadFixtures([
			ActiveTypeFixture::className(),
			ActiveFieldFixture::className(),
			ActiveFieldValidationFixture::className(),
			ActiveFieldOptionFixture::className(),
		]);
	}
	
	public function getList(FunctionalTester $I)
	{
		$I->sendGET(self::URI);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(2);
	}
	
	public function getListFieldsOnly(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'fields' => 'id,type',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'type',
		]);
	}
	
	public function getListByFieldId(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'field_id' => '2',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(2);
	}
	
	public function getListSortByType(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'sort' => 'type',
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
	
	public function getListByBadWhereParameter(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'typeeeeeee' => 'string',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_whereFields typeeeeeee"], true);
	}
	
	public function getListByBadSortParameter(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'sort' => 'titleeeeee',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_sortFields titleeeeee"], true);
	}
	
	public function getOne(FunctionalTester $I)
	{
		$I->sendGET(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function getOneFieldsOnly(FunctionalTester $I)
	{
		$I->sendGET(self::URI_EXISTS_ITEM, [
			'fields' => 'id,type',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'type',
		]);
	}
	
	public function getOneNotExisted(FunctionalTester $I)
	{
		$I->sendGET(self::URI_NOT_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function create(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'field_id' => '1',
			'type' => 'required',
		];
		$I->sendPOST(self::URI, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createWithBadType(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'field_id' => '1',
			'type' => 'requiredddddd',
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "type",
				"message" => 'Type is invalid.',
			],
		]);
	}
	
	public function createEmpty(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "field_id",
				"message" => 'Field Id cannot be blank.',
			],
			[
				"field" => "type",
				"message" => 'Type cannot be blank.',
			],
		]);
	}
	
	public function createNotExistsActiveType(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'field_id' => '11111',
			'type' => 'integer',
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'field_id',
				"message" => 'not_found',
			],
		]);
	}
	
	public function update(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'field_id' => '1',
			'type' => 'string',
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function updateNotExistsFieldId(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'field_id' => '1111',
			'type' => 'string',
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'field_id',
				"message" => 'not_found',
			],
		]);
	}
	
	public function updateNotExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [];
		$I->sendPUT(self::URI_NOT_EXISTS_ITEM, $body);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function deleteNotExisted(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE(self::URI_NOT_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function delete(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendPUT(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function checkWriteAccess(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::UNKNOWN_USER);
		
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
	}
	
}
