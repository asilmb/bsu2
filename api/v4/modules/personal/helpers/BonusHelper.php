<?php


namespace api\v4\modules\personal\helpers;

use api\v4\modules\personal\dto\BonusDto;
use Yii;
use yii\web\NotFoundHttpException;


class BonusHelper {
	
	const DREAMCLUB = 'KZT';
	const BRANDPOINTS = 'RPO';
	const GRACIOPOINTS = 'GRC';
	//const HEALTHPOINTS = 'HBK';
	const WIN_BALANCE = 'PAP';
	
	public static function responseHandler($response) {
		$data = [];
		$resultArray = json_decode($response, true);
		if ($resultArray['success'] == true) {
			$listProvider = Yii::$app->personal->bonus->getBonusClubList();
			if (isset($resultArray['data']['balances']['currency'])) {
				$resultArray['data']['balances'] = [$resultArray['data']['balances']];
			}
			
			foreach ($resultArray['data']['balances'] as $balance) {
				$provider = self::findBonusProvider($balance['currency'], $listProvider);
				if ($balance['currency'] == 'RLB') {
					continue;
				}
				if (empty($balance['amount'])) {
					continue;
				}
				if (empty($provider)) {
					continue;
				}
				
				$bonus = new BonusDto();
				$bonus->provider_id = $provider->id;
				$bonus->title = $provider->title;
				$bonus->logo = $provider->logo;
				$bonus->amount = $balance['amount'];
				
				$data[ $bonus->title ] = $bonus;
			}
			
		} else {
			throw new NotFoundHttpException('not_bonus_api_response');
		}
		
		return $data;
	}
	
	public static function findBonusProvider($currency, $listProvider) {
		
		foreach ($listProvider as $provider) {
			if ($provider->api_sign == $currency) {
				return $provider;
			}
		}
		
	}
	
	public static function checkBonusCreated($listActive, $listBonus) {
		$activeArray = [];
		$bonusArray = [];
		
		if (empty($listActive)) {
			return $listBonus;
		}
		foreach ($listActive as $active) {
			$activeArray[ $active->provider_id ] = $active;
		}
		foreach ($listBonus as $bonus) {
			$bonusArray[ $bonus->provider_id ] = $bonus;
			
		}
		
		$listDelete = array_diff_key($activeArray, $bonusArray);
		
		$listToCreate = array_diff_key($bonusArray, $activeArray);
		
		// удаляем все лишние активы из таблицы
		foreach ($listDelete as $toDelete) {
			Yii::$app->account->active->deleteById($toDelete->id);
		}
		
		return $listToCreate;
	}
	
	

}