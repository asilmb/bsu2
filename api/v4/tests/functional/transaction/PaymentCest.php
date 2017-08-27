<?php

namespace api\v4\tests\functional\transaction;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;
use common\fixtures\ServiceFixture;
use common\fixtures\ServiceFieldFixture;
use common\fixtures\ServiceFieldTranslateFixture;
use common\fixtures\ServiceFieldValidationFixture;
use common\fixtures\ServiceMenuFixture;
use common\fixtures\ServiceMenuServiceFixture;

class PaymentCest extends RestCest
{
	
	const URI = 'payment';
	const URI_CHECK = 'payment/check';
	const URI_PAY = 'payment/pay';
	const URI_PAY_FROM_CARD = 'payment/pay-from-card';
	const URI_COMMISSION = 'payment/commission';
	
	public $format = [
		"service_id" => Type::INTEGER,
		"fields" => [
			"txn_id" => Type::STRING,
			"serviceId" => Type::INTEGER,
			"service_id" => Type::INTEGER,
			"commission" => Type::INTEGER,
			"operationId" => Type::STRING,
		]
	];

	public function fixtures() {
		$this->loadFixtures([
			ServiceFixture::className(),
			ServiceFieldFixture::className(),
			//ServiceFieldTranslateFixture::className(),
			ServiceFieldValidationFixture::className(),
			ServiceMenuFixture::className(),
			ServiceMenuServiceFixture::className(),
		]);
	}
	
	public function check(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => 2,
			'fields' => [
				'amount' => '500',
				'account' => '7777416309',
			],
		];
		$I->sendPOST(self::URI_CHECK, $body);
		$I->SeeResponseCodeIs(HttpCode::OK);
		/*$I->seeResponseMatchesJsonType([
			"txn_id"=>"string",
			"operationId"=> "string",
             "amount"=> "integer",
             "account"=> "string",
			"service_id"=> "integer"
		]);*/
	}
	
	public function checkNoValidAccount(FunctionalTester $I)
	{
		$this->noValidAccount($I, self::URI_CHECK);
	}

	public function checkNotFoundService(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '1111111',
			'fields' => [
				'amount' => '9',
				'account' => '7055556699',
			],
		];
		$I->sendPOST(self::URI_CHECK, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "service_id",
				"message" => "not_found",
			],
		]);
	}
/* 
	public function pay(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'fields' => [
				'amount' => '9',
				'account' => '7055556699',
			],
		];
		$I->sendPOST(self::URI_PAY, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
	}
 */
	public function payNoValidAccount(FunctionalTester $I)
	{
		$this->noValidAccount($I, self::URI_PAY);
	}
/* 
	public function payFromCard(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'fields' => [
				'amount' => '9',
				'account' => '7055556699',
			],
		];
		$I->sendPOST(self::URI_PAY_FROM_CARD, $body);
		$I->SeeResponseCodeIs(HttpCode::CREATED);
		$I->seeResponseMatchesJsonType([
			'operation_id' => Type::STRING
		]);
	}

	public function payFromCardNoValidAccount(FunctionalTester $I)
	{
		$this->noValidAccount($I, self::URI_PAY_FROM_CARD);
	} */

	private function noValidAccount(FunctionalTester $I, $url)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'fields' => [
				'amount' => '9',
				'account' => '111',
			],
		];
		$I->sendPOST($url, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "account",
				"message" => "Account is invalid.",
			],
		]);
	}

	public function commission(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2',
			'amount' => '9',
		];
		$I->sendPOST(self::URI_COMMISSION, $body);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType([
			'amount' => Type::FLOAT
		]);
	}

	public function commissionReal(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '15',
			'amount' => '1234',
		];
		$I->sendPOST(self::URI_COMMISSION, $body);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeBody([
			'amount' => 24.68,
		]);
	}

	public function commissionBadParameters(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '2g',
			'amount' => 'h9',
		];
		$I->sendPOST(self::URI_COMMISSION, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "service_id",
				"message" => "Service Id must be an integer.",
			],
			[
				"field" => "amount",
				"message" => "Amount must be a number.",
			],
		]);
	}

	public function commissionNotFoundService(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '1111111',
			'amount' => '9',
		];
		$I->sendPOST(self::URI_COMMISSION, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "service_id",
				"message" => "not_found",
			],
		]);
	}

	public function commissionBigAmount(FunctionalTester $I)
	{
		$I->auth(AccountEnum::USER_2);
		$body = [
			'service_id' => '15',
			'amount' => '12345',
		];
		$I->sendPOST(self::URI_COMMISSION, $body);
		$I->seeUnprocessableEntity([
			[
				"field" => "amount",
				"message" => "big_amount",
			],
		]);
	}

}
