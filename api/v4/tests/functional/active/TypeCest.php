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

class TypeCest extends RestCest
{
	
	const URI = 'active-type';
	const URI_EXISTS_ITEM = 'active-type/1';
	const URI_NOT_EXISTS_ITEM = 'active-type/1111111';
	
	public $format = [
		'id' => Type::INTEGER,
		'title' => Type::STRING,
		'parent_id' => Type::INTEGER_OR_NULL,
	];
	public $expandFormat = [
		'fields' => Type::ARR_OR_NULL,
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
	
	public function getListWithExpand(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'expand' => 'fields',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType($this->expandFormat);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(2);
	}
	
	public function getListFieldsOnly(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'fields' => 'id,title',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'title',
		]);
	}
	
	public function getListByTitle(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'title' => 'Бонус',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(1);
	}
	
	public function getListSortByTitle(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'sort' => 'title',
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
	
	public function getListByBadExpandParameter(FunctionalTester $I)
	{
		$I->sendGET(self::URI, [
			'expand' => 'rrrrrrr',
		]);
		$I->SeeResponseCodeIs(HttpCode::BAD_REQUEST);
		$I->seeBody(["message" => "not_allowed_to_use_parameter_in_expand rrrrrrr"], true);
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
	
	public function getOneWithExpand(FunctionalTester $I)
	{
		$I->sendGET(self::URI_EXISTS_ITEM, [
			'expand' => 'fields',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType($this->expandFormat);
	}
	
	public function getOneFieldsOnly(FunctionalTester $I)
	{
		$I->sendGET(self::URI_EXISTS_ITEM, [
			'fields' => 'id,title',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'title',
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
			'parent_id' => '',
			'title' => 'qwerty',
		];
		$I->sendPOST(self::URI, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createWithParentId(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'parent_id' => '1',
			'title' => 'qwerty',
		];
		$I->sendPOST(self::URI, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
	
	public function createEmpty(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "title",
				"message" => 'Title cannot be blank.',
			],
		]);
	}
	
	public function createNotExistsParent(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'parent_id' => '11111',
			'title' => 'qwerty',
		];
		$I->sendPOST(self::URI, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'parent_id',
				"message" => 'not_found',
			],
		]);
	}
	
	public function update(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'parent_id' => '1',
			'title' => 'qwerty111',
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->SeeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
	public function updateNotExistsParent(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$body = [
			'parent_id' => '1111',
			'title' => 'qwerty111',
		];
		$I->sendPUT(self::URI_EXISTS_ITEM, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => 'parent_id',
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
