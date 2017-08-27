<?php

namespace api\v4\tests\functional\service;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\HttpHeader;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceMenuFixture;

class ServiceCategoryCest extends RestCest
{
	
	public $format = [
		'id' => Type::INTEGER,
		'parent_id' => Type::INTEGER_OR_NULL,
		'name' => Type::STRING,
		'title' => Type::STRING,
		'picture' => Type::STRING_OR_NULL,
		'picture_url' => Type::STRING_OR_NULL,
	];
	public $uri = 'service-category';

	public function fixtures() {
		$this->loadFixtures([
			ServiceMenuFixture::className(),
		]);
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function getListWithPerPage(FunctionalTester $I)
	{
		$I->sendGET($this->uri, [
			'page' => '2',
			'per-page' => '19',
		]);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 10);
		$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 1);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 19);
		$I->seeListCount(10);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/10');
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function createFailMethodNotAllowed(FunctionalTester $I) {
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
	}
}
