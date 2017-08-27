<?php

namespace api\v4\tests\functional\service;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceFixture;
use common\fixtures\ServiceFieldFixture;
use common\fixtures\ServiceFieldTranslateFixture;
use common\fixtures\ServiceFieldValidationFixture;
use common\fixtures\ServiceMenuFixture;
use common\fixtures\ServiceMenuServiceFixture;

class ServiceCest extends RestCest
{
	
	public $format = [
		'id' => Type::INTEGER,
		'name' => Type::STRING,
		'parent_id' => Type::INTEGER_OR_NULL,
		'title' => Type::STRING,
		'description' => Type::STRING_OR_NULL,
		'picture' => Type::STRING_OR_NULL,
		'picture_url' => Type::STRING_OR_NULL,
		'synonyms' => Type::STRING_OR_NULL,
		'fields' => Type::ARR_OR_NULL,
	];
	public $uri = 'service';
	
	public function fixtures() {
		$this->loadFixtures([
			ServiceFixture::className(),
			ServiceFieldFixture::className(),
			ServiceFieldTranslateFixture::className(),
			ServiceFieldValidationFixture::className(),
			ServiceMenuFixture::className(),
			ServiceMenuServiceFixture::className(),
		]);
	}
	
	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(20);
	}
	
	public function getListAndSortById(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?sort=id');
		$body = $I->getResponseBody();
		expect($body[0]['id'] == 1)->equals(true);
	}
	
	public function getListAndSortByIdRevert(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?sort=-id');
		$body = $I->getResponseBody();
		expect($body[0]['id'] == 80)->equals(true);
	}
	
	public function getListNextPage(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?page=2');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 2);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(13);
	}

	public function getListNextPageWithPerPage(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?page=2&per-page=19');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 2);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 19);
		$I->seeListCount(14);
	}
	
	public function getListByCategory(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?category=7');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 4);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 99999999);
		$I->seeListCount(4);
	}
	
	public function getListByCategoryAndSortById(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?category=7&sort=id');
		$body = $I->getResponseBody();
		expect($body[0]['id'] == 1)->equals(true);
	}
	
	public function getListByCategoryAndSortByIdRevert(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?category=7&sort=-id');
		$body = $I->getResponseBody();
		expect($body[0]['id'] == 22)->equals(true);
	}
	
	public function getListWithFields(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?fields=id,name');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseJsonFieldsOnly([
			'id',
			'name',
		]);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/1');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	/* public function getDetailsWithCategories(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/19', ['expand' => 'categories']);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$body = $I->getResponseBody();
		expect($body['categories'][0]['id'])->equals(14);
	} */
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	/* public function createFailMethodNotAllowed(FunctionalTester $I) {
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendPOST($this->uri, []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function updateFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendPUT($this->uri . '/1', []);
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	}
	
	public function deleteFailMethodNotAllowed(FunctionalTester $I)
	{
		$I->authAsRole(RBACRoles::ADMINISTRATOR);
		$I->sendDELETE($this->uri . '/1');
		$I->seeResponseCodeIs(HttpCode::METHOD_NOT_ALLOWED);
	} */
}
