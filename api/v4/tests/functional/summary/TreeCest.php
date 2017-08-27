<?php

namespace api\v4\tests\functional\summary;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use common\fixtures\SummaryResourceFixture;

class TreeCest extends RestCest
{
	
	public $format = [
		'url' => [
			'avatars' => Type::URL,
			'bank_pictures' => Type::URL,
			'service_menu_pictures' => Type::URL,
			'service_pictures' => Type::URL,
		],
		'static_id' => [
			'category_root' => Type::INTEGER,
			'addressless_transfer' => Type::INTEGER,
			'cnp_withdrawal' => Type::INTEGER,
			'iban_payment' => Type::INTEGER,
		],
		'last_modified' => [
			'city' => Type::DATE,
			'country' => Type::DATE,
			//'summary_url' => Type::DATE,
			//'summary_id' => Type::DATE,
			'service' => Type::DATE,
			'service_category' => Type::DATE,
		],
	];
	public $uri = 'summary';
	
	public function fixtures() {
		$this->loadFixtures([
			SummaryResourceFixture::className(),
		]);
	}
	
	public function listSuccess(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->SeeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
}