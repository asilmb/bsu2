<?php

namespace api\v4\tests\functional\summary;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use common\fixtures\SummaryResourceFixture;

class TreeCest extends RestCest
{
	
	public $format = [
		'url' => [
			'avatars' => 'string:url',
			'bank_pictures' => 'string:url',
			'service_menu_pictures' => 'string:url',
			'service_pictures' => 'string:url',
		],
		'static_id' => [
			'category_root' => 'integer',
			'addressless_transfer' => 'integer',
			'cnp_withdrawal' => 'integer',
			'iban_payment' => 'integer',
		],
		'last_modified' => [
			'city' => self::TYPE_DATE,
			'country' => self::TYPE_DATE,
			//'summary_url' => self::TYPE_DATE,
			//'summary_id' => self::TYPE_DATE,
			'service' => self::TYPE_DATE,
			'service_category' => self::TYPE_DATE,
		],
	];
	public $uri = 'summary';
	
	public function _fixtures() {
		return [
			SummaryResourceFixture::className(),
		];
	}
	
	public function listSuccess(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponse(HttpCode::OK);
	}
	
}