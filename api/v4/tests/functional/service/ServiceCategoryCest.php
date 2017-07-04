<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceMenuFixture;

class ServiceCategoryCest extends RestCest
{
	
	public $format = [
		'id' => 'integer',
		'parent_id' => 'integer|null',
		'name' => 'string',
		'title' => 'string',
		'picture' => 'string|null',
		'picture_url' => 'string|null',
	];
	public $uri = 'service-category';

	public function _fixtures() {
		return [
			ServiceMenuFixture::className(),
		];
	}

	public function getList(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/10');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->sendGET($this->uri . '/11111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
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
