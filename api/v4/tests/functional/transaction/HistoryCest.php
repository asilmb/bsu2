<?php

namespace api\v4\tests\functional\transaction;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use yii2lab\test\Util\HttpHeader;

class HistoryCest extends RestCest
{
	
	const URI_EXISTS_ITEM = 'history/50010329';
	const URI_NOT_EXISTS_ITEM = 'history/11111111';
	
	public $format = [
		'id' => Type::INTEGER,
		'amount' => Type::FLOAT,
		'status' => Type::INTEGER,
		'description' => Type::STRING_OR_NULL,
		'type' => Type::INTEGER,
		'title' => Type::STRING_OR_NULL,
		'paymentAccount' => Type::STRING_OR_NULL,
		'direction' => Type::INTEGER,
		'serviceId' => Type::INTEGER,
		'picture_url' => Type::STRING_OR_NULL,
		'externalId' => Type::STRING_OR_NULL,
		//'service_logo' => Type::STRING_OR_NULL,
		'dateOper' => Type::DATE,
		'dateDone' => Type::DATE,
		'dateModify' => Type::DATE,
		'reqStat' => Type::STRING,
		'receipt' => Type::ARR_OR_NULL,
		'billingInfo' => Type::ARR_OR_NULL,
	];
	public $formatExtra = [
		'receipt' => [
			'subjectFrom' => Type::STRING,
			'subjectTo' => Type::STRING,
		],
		'billingInfo' => [
			'fields' => [
				'amount' => Type::INTEGER_OR_NULL,
				'txn_id' => Type::STRING,
				'service_id' => Type::INTEGER,
				'account' => Type::STRING,
			],
		],
	];
	public $uri = 'history';

	public function getList(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_3);
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}

	public function getFilterByDate(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$params = [
			'done' => ['from' => '2017-07-23', 'to' => '2017-07-24'],
		];
		$I->sendGET($this->uri, $params);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);

		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 10);
	}

	public function getFilterByOperationTypeId(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$params = [
			'done' => ['from' => '2017-07-23', 'to' => '2017-07-24'],
			'operationTypeId' => 203,
		];
		$I->sendGET($this->uri, $params);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);

		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 10);
	}

	public function getFilterByOperationStatus(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$params = [
			'date' => ['from' => '2017-04-26', 'to' => '2017-04-27'],
			'operationTypeId' => 203,
			'operationStatus' => 14,
		];
		$I->sendGET($this->uri, $params);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);

//		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 22);
		//$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 10);
		//$I->seeListCount(10);
	}
	
	public function getFilterByServicesId(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_2);
		$params = [
			'date' => ['from' => '2017-05-26', 'to' => '2017-05-28'],
			'serviceId' => array(1393),
		];
		$I->sendGET($this->uri, $params);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		
		$I->seeHttpHeader(HttpHeader::TOTAL_COUNT, 1);
		//$I->seeHttpHeader(HttpHeader::PAGE_COUNT, 2);
		$I->seeHttpHeader(HttpHeader::CURRENT_PAGE, 1);
		$I->seeHttpHeader(HttpHeader::PER_PAGE, 10);
		//$I->seeListCount(10);
		$I->seeContainValues([
			'serviceId' => 1393,
		]);
	}
	
	public function getDetails(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_3);
		$I->sendGET(self::URI_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
		$I->seeResponseMatchesJsonType($this->formatExtra);
	}
	
	public function getDetailsNotExists(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_3);
		$I->sendGET(self::URI_NOT_EXISTS_ITEM);
		$I->SeeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
	public function getDetailsNotAllowed(FunctionalTester $I) {
		$I->auth(AccountEnum::USER_1);
		$I->sendGET(self::URI_EXISTS_ITEM);
		$I->seeResponseCodeIs(HttpCode::NOT_FOUND);
	}
	
}
