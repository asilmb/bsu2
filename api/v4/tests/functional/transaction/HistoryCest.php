<?php

namespace api\v4\tests\functional\geo;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2woop\tps\components\RBACRoles;

class HistoryCest extends RestCest
{
	
	public $format = [
		'id' => 'integer',
		'amount' => 'float|integer',
		'status' => 'integer',
		'description' => 'string|null',
		'type' => 'integer',
		'service_name' => 'string|null',
		'paymentAccount' => 'string|null',
		'direction' => 'integer',
		'serviceId' => 'integer',
		'picture_url' => 'string|null',
		'externalId' => 'string|null',
		//'service_logo' => 'string|null',
		'dateOper' => self::TYPE_DATE,
		'dateDone' => self::TYPE_DATE,
		'dateModify' => self::TYPE_DATE,
		'reqStat' => 'string',
		'receipt' => 'array',
		'billingInfo' => 'array|null',
	];
	public $formatExtra = [
		'receipt' => [
			'subjectFrom' => 'string',
			'subjectTo' => 'string',
		],
		'billingInfo' => [
			'fields' => [
				'amount' => 'integer|null',
				'txn_id' => 'string',
				'service_id' => 'integer',
				'account' => 'string',
			],
		],
	];
	public $uri = 'history';
	public $login = '77026142577';

	public function getList(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/50010329');
		$I->seeResponse(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->formatExtra);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri . '/11111111');
		$I->seeResponse(HttpCode::NOT_FOUND);
	}
	
	public function getDetailsNotAllowed(FunctionalTester $I) {
		$I->auth('77783177384');
		$I->sendGET($this->uri . '/50010329');
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
}
