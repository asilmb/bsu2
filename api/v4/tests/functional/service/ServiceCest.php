<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
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
		'id' => 'integer',
		'name' => 'string',
		'parent_id' => 'integer|null',
		'title' => 'string',
		'description' => 'string|null',
		'picture' => 'string|null',
		'picture_url' => 'string|null',
		'synonyms' => 'string|null',
		'fields' => 'array|null',
	];
	public $uri = 'service';

	public function _fixtures() {
		return [
			ServiceFixture::className(),
			ServiceFieldFixture::className(),
			ServiceFieldTranslateFixture::className(),
			ServiceFieldValidationFixture::className(),
			ServiceMenuFixture::className(),
			ServiceMenuServiceFixture::className(),
		];
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(20);
	}
	
	public function getListNextPage(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?page=2');
		$I->seeResponse(HttpCode::OK);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 2);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 20);
		$I->seeListCount(13);
	}

	public function getListNextPageWithPerPage(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '?page=2&per-page=19');
		$I->seeResponse(HttpCode::OK);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 33);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 2);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 19);
		$I->seeListCount(14);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/1');
		$I->seeResponse(HttpCode::OK);
	}
	
	/* public function getDetailsWithCategories(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/19', ['expand' => 'categories']);
		$I->seeResponse(HttpCode::OK);
		$body = $I->getResponseBody();
		expect($body['categories'][0]['id'])->equals(14);
	} */
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
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
