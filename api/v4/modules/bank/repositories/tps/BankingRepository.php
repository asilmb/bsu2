<?php

namespace api\v4\modules\bank\repositories\tps;


use common\ddd\repositories\TpsRepository;
use common\exceptions\UnprocessableEntityHttpException;
use Exception;
use frontend\modules\account\dto\BankingDto;
use Yii;

class BankingRepository extends TpsRepository {
	
	
	public static function sendRequest(BankingDto $bankingDto) {
		
		$body = json_encode($bankingDto->request_body);
		
		$timestamp = strtotime('now');
		$hash = hash_hmac('sha1', 'salempay' . $timestamp . '/api/json/control/parsing-data-r/' . $body, '303d6d01b19334905ac88a144354f0060d3d8415');
		
		$serviceId = 'salempay:' . $timestamp;
		
		$client = Yii::createObject('yii\httpclient\Client');
		$client->baseUrl = 'https://developer.cashoff.ru/api/json/control/parsing-data-r/';
		try {
			$response = $client->createRequest()->setMethod("post")->setContent($body)->setHeaders([
				"Connection" => "close",
				"Expect" => "",
				'Content-Type' => 'application/json',
				'Co-Auth' => $serviceId . ':' . $hash,
			])->send();
		} catch(Exception $e) {
			throw new UnprocessableEntityHttpException($e);
		}

		return $response->data;
	}
}
//	{
//"request": {
//"@method":"PARSING_DATA_R",
//"@rid":"771fa9a021644d588a11c562642cae7c1",
//"@service":"service-4321",
//"session":{	"@id":"881fa9a021644d588a11c562642cae7c","@institution":"sber","@create":true},
//"parse":{"@type":"products"}}}