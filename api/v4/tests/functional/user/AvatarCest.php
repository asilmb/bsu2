<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use api\v4\tests\functional\enums\AccountEnum;
use api\v4\tests\functional\enums\UserEnum;
use common\fixtures\UserProfileFixture;
use GuzzleHttp\Psr7\UploadedFile;
use yii\helpers\FileHelper;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use yii2lab\test\Util\Type;
use yii2woop\tps\components\RBACRoles;

class AvatarCest extends RestCest
{
	const URI = 'profile-avatar';
	
	public $format = [
		'name' => Type::STRING_OR_NULL,
		'url' => Type::URL,
	];
	
	public function fixtures() {
		$this->loadFixtures([
			UserProfileFixture::className(),
		]);
	}

	public function checkPermission(FunctionalTester $I)
	{
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}
	
	/*public function upload(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		
		$tmpFileName = tempnam('/tmp', 'test_');
		file_put_contents($tmpFileName, 'test data');
		
		$fileName = 'avatar.jpg';
		$files = [
			'imageFile' => [
				'name' => $fileName,
				'type' => 'image/jpeg',
				'error' => UPLOAD_ERR_OK,
				'size' => filesize(codecept_data_dir($fileName)),
				'tmp_name' => codecept_data_dir($fileName),
			],
		];
		$I->sendPOST(self::URI, null, $files);
		
		$I->seeResponseCodeIs(HttpCode::CREATED);
	}*/
	
	public function get(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$I->sendGET(self::URI);
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType($this->format);
	}
	
	public function delete(FunctionalTester $I)
	{
		$I->auth(UserEnum::EXISTED_LOGIN);
		$I->sendDELETE(self::URI);
		$I->seeResponseCodeIs(HttpCode::NO_CONTENT);
	}
	
}