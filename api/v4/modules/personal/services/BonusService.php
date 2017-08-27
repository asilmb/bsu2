<?php

namespace api\v4\modules\personal\services;

use api\v4\modules\personal\helpers\BonusHelper;
use api\v4\modules\personal\helpers\CreateActive;
use common\ddd\services\ActiveBaseService;
use Yii;

class BonusService extends ActiveBaseService {
	
	public $entityClass = 'api\v4\modules\user\entities\ActiveEntity';
	public $userAccessOnly = true;
	public $forbiddenChangeFields = ['amount'];
	public $foreignServices = [
		'active.type' => [
			'field' => 'active_id',
			'notFoundMessage' => ['active/type', 'not_found'],
		],
		'active.provider' => [
			'field' => 'provider_id',
			'notFoundMessage' => ['active/provider', 'not_found'],
		],
		'active.currency' => [
			'field' => 'currency_id',
			'notFoundMessage' => ['geo/currency', 'not_found'],
		],
	];
	
	public function getBonusClubList($query = null) {
		$query = $this->forgeQuery($query);
		$query->where('type_id', '2');
		return Yii::$app->active->provider->all($query);
	}
	
	public function getBonusList($query = null) {
		$query = $this->forgeQuery($query);
		$query->where('active_id', '2');
		return Yii::$app->account->active->all($query);
	}
	
	public function findAll() {
		return $this->repository->allByPhone();
	}
	
	public function createBonuses() {
		$listBonus = $this->findAll();
		$listActive = $this->getBonusList();
		
		$listToCreate = BonusHelper::checkBonusCreated($listActive, $listBonus);
		
		foreach ($listToCreate as $bonus) {
			CreateActive::run($bonus);
		}
		return $listToCreate;
	}
	
	public function checkAmountDifferent() {
		$listBonus = $this->findAll();
		$listActive = $this->getBonusList();
		
		$activeArray = [];
		$bonusArray = [];
		
		foreach ($listActive as $active) {
			$activeArray[ $active->provider_id ] = $active;
		}
		foreach ($listBonus as $bonus) {
			$bonusArray[ $bonus->provider_id ] = $bonus;
			if ($bonusArray[ $bonus->provider_id ]->amount != $bonusArray[ $bonus->provider_id ]->amount) {
				Yii::$app->account->active->updateAmountById($active->id, $bonus->amount);
			}
		}
	}
	
}
