<?php
/**
 * Created by PhpStorm.
 * User: amubarak
 * Date: 25.08.2017
 * Time: 10:43
 */

namespace api\v4\modules\bank\helpers;


use frontend\modules\account\dto\BankingDto;

class BankingHelper {
	
	public static function createRequest(BankingDto $bankingDto,  $is_new_session = false){
		$session = [
			"@create" => $is_new_session,
			"@id" => $bankingDto->auth_id,
			"@institution" => $bankingDto->provider,
		];
		
		$bankingDto->request_body = [
			'request' => [
				'@method' => "PARSING_DATA_R",
				'@rid' => $bankingDto->auth_id,
				'@service' => 'salempay',
				$bankingDto->method => $bankingDto->method_content,
				"session" => $session,
			],
		];
	
	}
}