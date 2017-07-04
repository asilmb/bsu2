<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;

class CardCest extends RestCest
{
	
	public $format = [
		'id' => 'integer',
		'hb_id' => 'integer',
		'mask' => 'string',
		'approve' => 'boolean',
		'reference' => 'string',
		'bank' => 'array|null',
	];
	public $uri = 'card';
	public $login = '77004163092';

	public function getList(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/7955');
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/11111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
	}
	
	public function getDetailsNotAllowed(FunctionalTester $I) {
		$I->auth('77783177384');
		$I->sendGET($this->uri . '/7955');
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
}
