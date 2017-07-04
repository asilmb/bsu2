<?php

namespace api\v4\tests\functional\user;

use api\tests\FunctionalTester;
use yii2lab\test\RestCest;
use Codeception\Util\HttpCode;
use common\fixtures\UserFixture;

class AuthCest extends RestCest
{
	
	public $format = [
		'token' => 'string',
	];
	public $login = '77783177384';
	public $uri = 'auth';
	
	public function _fixtures() {
		if(config('components.user.identityClass') == 'yii2lab\user\models\identity\Db') {
			return [
				UserFixture::className(),
			];
		}
		return [];
	}
	
	public function successLogin(FunctionalTester $I)
	{
		$data = [
			'login' => $this->login,
			'password' => 'Wwwqqq111',
		];
		$I->sendPOST($this->uri, $data);
		$I->seeResponse(HttpCode::OK);
	}

	public function failLogin(FunctionalTester $I)
	{
		$data = [
			'login' => $this->login,
			'password' => '111',
		];
		$I->sendPOST($this->uri, $data);
		$I->seeResponse(HttpCode::UNPROCESSABLE_ENTITY, [
			[
				"field" => "password",
				"message" => "incorrect_login_or_password"
			],
		]);
	}

	public function successInfo(FunctionalTester $I)
	{
		$I->auth($this->login);
		$I->sendGET($this->uri);
		$I->seeResponseCodeIs(HttpCode::OK);
		$I->seeResponseMatchesJsonType([
			'id' => 'integer',
			'login' => 'string',
			'email' => 'string',
			//'name' => 'string',
			'roles' => 'array',
			//'creation_date' => 'string',
			//'parent_id' => 'integer',
			//'subject_type' => 'integer',
			//'sex' => 'boolean',
			//'birth_date' => 'string',
			//'city' => 'integer',
			//'country' => 'integer',
			//'iin_fixed' => 'string|boolean',
			//'balance' => 'array',
		]);
		$I->dontSeeResponseJsonMatchesJsonPath('$.auth_key');
		$I->dontSeeResponseJsonMatchesJsonPath('$.password_hash');
		$I->dontSeeResponseJsonMatchesJsonPath('$.password_reset_token');
	}
	
	public function checkAuthFail(FunctionalTester $I)
	{
		$I->sendGET($this->uri);
		$I->seeResponseCodeIs(HttpCode::UNAUTHORIZED);
	}

}