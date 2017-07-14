<?php

namespace api\v4\modules\card\services\card;

use Yii;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;
use yii2lab\helpers\yii\ArrayHelper as WoopArrayHelper;
use api\v4\modules\card\services\approve\Entity as ApproveEntity;
use common\services\ErrorEntity;

class RepositoryTps extends Repository /*implements RepositoryInterface*/ {
	
	public function findById($id) {
		$all = $this->getAll();
		$item = WoopArrayHelper::findOne($all, ['cardId' => $id]);
		$item = $this->fields($item);
		$entity = $this->forgeEntity($item, Entity::className());
		$this->reset();
		return $entity;
	}
	
	public function findAll() {
		$data = $this->getAll();
		$all = $this->fields($data);
		$collection = $this->forgeEntityCollection($all, Entity::className());
		$this->reset();
		return $collection;
	}
	
	public function delete(Entity $card) {
		$types = $this->getTypes();
		$request =  TpsOperations::deleteLinkedCard($types['terminalType'], $types['acquiringType'], $card->id);
		return $request->send();
	}
	
	public function approve(Entity $card, $amount) {
		$types = $this->getTypes();
		$request =  TpsOperations::approveLinkedCard($types['terminalType'], $types['acquiringType'], $card->id, $card->reference, $amount);
		return $request->send();
	}
	
	protected function field($item) {
		$result['id'] = intval($item['cardId']);
		$result['hb_id'] = intval($item['hbId']);
		$result['mask'] = $item['cardMask'];
		$result['approve'] = $item['approve'];
		$result['reference'] = $item['reference'];
		if(in_array('bank', $this->with)) {
			$result['bank'] = Yii::$app->bank->getBankByCardNumber($item['cardMask']);
		}
		return $result;
	}
	
	private function getTypes() {
		if (BaseCardOperation::isHbpay()) {
			$result['terminalType'] = EpayCardLinkOperation::getAcquiringTerminal();
			$result['acquiringType'] = AcquiringType::HBPAY;
		} else {
			$result['terminalType'] = WooppayCardLinkOperation::getAcquiringTerminal();
			$result['acquiringType'] = AcquiringType::WOOPPAY_LINKED;
		}
		return $result;
	}
	
	private function getAll() {
		$types = $this->getTypes();
		$request = TpsOperations::getLinkedCardList($types['terminalType'], $types['acquiringType']);
		return $request->send();
	}
	
}