<?php

namespace api\v4\modules\bank\repositories\test;

use api\v4\modules\bank\entities\CardEntity;
use api\v4\modules\bank\repositories\tps\CardRepository as TpsCardRepository;
use common\ddd\BaseEntity;
use Yii;

class CardRepository extends TpsCardRepository {
	
	public function approve($cardId, $reference, $amount) {
	
	}
	
	public function update(BaseEntity $entity) {
	
	}
	
	public function delete(BaseEntity $entity) {
	
	}
	
	protected function field($item) {
		return $item;
	}
	
	protected function data() {
		$login = Yii::$app->user->identity->login;
		if($login != "77771111111" && $login != "77026142577") {
			return [];
		}
		return [
			[
				'cardId' => '7953',
				'hbId' => '2863',
				'cardMask' => '440564-XX-XXXX-6374',
				'approve' => '',
				'reference' => '170427114625',
				'bank' => [
					'id' => '31',
					'code' => '926',
					'bik' => 'KZKOKZKX',
					'name' => 'АО "КАЗКОММЕРЦБАНК"',
					'bin' => '911040000021',
					'picture' => '',
				],
			],
			[
				'cardId' => '7955',
				'hbId' => '2137',
				'cardMask' => '548318-XX-XXXX-0293',
				'approve' => '1',
				'reference' => '170412144734',
				'bank' => [
					'id' => '31',
					'code' => '926',
					'bik' => 'KZKOKZKX',
					'name' => 'АО "КАЗКОММЕРЦБАНК"',
					'bin' => '911040000021',
					'picture' => '',
				],
			],
		];
	}

}