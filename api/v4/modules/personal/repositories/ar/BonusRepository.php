<?php
namespace api\v4\modules\personal\repositories\ar;


use api\v4\modules\personal\helpers\BonusHelper;
use common\ddd\repositories\ActiveArRepository;
use Exception;
use Yii;

class BonusRepository extends ActiveArRepository {
	
	const BASE_URL = "https://api2.dreamclub.kz/v2/partner/operation/balance/phone/+";
	
	protected $modelClass = 'api\v4\modules\user\models\Active';
	
	public function allByPhone() {
		$url =  Yii::$app->account->auth->identity->login;
		$bonuses = $this->sendApi($url);
		return $bonuses;
	}
	
	public function oneByPhone($phone, $currency) {
		$url = Yii::$app->account->auth->identity->login . ($currency ? ('?currency=' . $currency) : '');
		$bonus = $this->sendApi($url);
		return $bonus;
	}
	
	//public function payByPhone($phone, $currency, $amount) {
	//	$url = "https://api2.dreamclub.kz/v2/partner/operation/balance/phone/+" . Yii::$app->account->auth->identity->login . ($currency ? ('?currency=' . $currency) : '');
	//	$bonus = $this->sendApi($url);
	//	return $bonus;
	//}
	
	public static function sendApi($url){
		try {
			$curl = curl_init();
			curl_setopt($curl, CURLOPT_URL, self::BASE_URL.$url);
			curl_setopt($curl, CURLOPT_BINARYTRANSFER, 1);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
			curl_setopt($curl, CURLOPT_HTTPHEADER, array(
				'Accept: application/json',
				'authorization: Basic MmE5MTM1NDEtZjNhYy00MjJmLWI3MzgtNjViZjZiMTA5ZmYxOjE=',
			));
			curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, 10);
			curl_setopt($curl, CURLOPT_TIMEOUT, 120);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, 0);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, 0);
		
			return  BonusHelper::responseHandler(curl_exec($curl));
		
		} catch (Exception $e) {
			return ['status' => 'error'];
		}
		//todo перейти на client
		
		//$client = Yii::createObject('yii\httpclient\Client');
		//$client->baseUrl = self::BASE_URL;
		//try {
		//	$response = $client->createRequest()
		//		->setMethod("post")
		//		->setUrl($url)
		//		->setHeaders([
		//			'Accept' => 'application/json',
		//			'authorization' => 'Basic MmE5MTM1NDEtZjNhYy00MjJmLWI3MzgtNjViZjZiMTA5ZmYxOjE=',
		//		])
		//		->send();
		//} catch(Exception $e) {
		//
		//}
		//return $response;
	}
}