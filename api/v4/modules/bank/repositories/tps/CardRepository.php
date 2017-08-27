<?php

namespace api\v4\modules\bank\repositories\tps;

use api\v4\modules\bank\entities\CardEntity;
use common\ddd\BaseEntity;
use common\ddd\data\Query;
use common\ddd\helpers\ErrorCollection;
use common\ddd\interfaces\repositories\ReadInterface;
use common\ddd\interfaces\repositories\ModifyInterface;
use common\ddd\repositories\TpsRepository;
use common\exceptions\UnprocessableEntityHttpException;
use Yii;
use yii\helpers\ArrayHelper;
use yii2woop\tps\generated\enums\acquiring\AcquiringType;
use yii2woop\tps\generated\exception\tps\acquiring\AcquiringAmountMismatchException;
use yii2woop\tps\generated\exception\tps\CallCounterExceededException;
use yii2woop\tps\generated\transport\TpsOperations;
use yii2woop\tps\models\BaseCardOperation;
use yii2woop\tps\models\EpayCardLinkOperation;
use yii2woop\tps\models\WooppayCardLinkOperation;
use yii2lab\helpers\yii\ArrayHelper as WoopArrayHelper;

class CardRepository extends TpsRepository implements ReadInterface, ModifyInterface {
	
	public function oneById($id, Query $query = null) {
		$all = $this->data();
		$item = WoopArrayHelper::findOne($all, ['cardId' => $id]);
		$item = $this->fields($item);
		$entity = $this->forgeEntity($item, CardEntity::className());
		return $entity;
	}

	public function all(Query $query = null) {
		return $this->findAll();
	}

	public function count(Query $query = null) {
		return count($this->data());
	}
	
	public function findOneByReference($reference) {
		$all = $this->data();
		$item = WoopArrayHelper::findOne($all, ['reference' => $reference]);
		$item = $this->fields($item);
		$entity = $this->forgeEntity($item, CardEntity::className());
		return $entity;
	}

	public function findAllApproved() {
		$all = $this->findAll();
		$result = [];
		foreach($all as $card) {
			if(!$card->approve) {
				$result[] = $card;
			}
		}
		return $result;
	}
	
	public function findAll() {
		$all = $this->data();
		$all = $this->fields($all);
		$collection = $this->forgeEntity($all, CardEntity::className());
		return $collection;
	}
	
	public function insert(BaseEntity $entity) {}
	public function update(BaseEntity $entity) {}
	
	public function delete(BaseEntity $card) {
		$types = $this->getTypes();
		$request =  TpsOperations::deleteLinkedCard($types['terminalType'], $types['acquiringType'], (string)$card->id);
		return $this->send($request);
	}

	public function approve($cardId, $reference, $amount) {
		$types = $this->getTypes();
		$request =  TpsOperations::approveLinkedCard($types['terminalType'], $types['acquiringType'], (string) $cardId, $reference, (float) $amount);
		try {
			return $this->send($request);
		} catch(CallCounterExceededException $e) {
			$error = new ErrorCollection;
			$error->add(null, 'bank/card', 'call_counter_exceeded');
			throw new UnprocessableEntityHttpException($error);
		} catch(AcquiringAmountMismatchException $e) {
			$error = new ErrorCollection;
			$error->add('amount', 'bank/card', 'acquiring_amount_mismatch');
			throw new UnprocessableEntityHttpException($error);
		}
	}
	
	public function fieldAlias() {
		return [
			'id' => 'cardId',
			'hb_id' => 'hbId',
			'mask' => 'cardMask',
		];
	}

	protected function field($item) {
		$item['bank'] = Yii::$app->bank->repositories->bank->getBankByCardNumber($item['cardMask']);
		return $item;
	}
	
	protected function fields($data) {
		if(empty($data)) {
			return [];
		}
		if(ArrayHelper::isIndexed($data)) {
			foreach($data as &$item) {
				$item = static::field($item);
			}
		} else {
			$data = static::field($data);
		}
		return $data;
	}

	private function getTypes() {
		if (BaseCardOperation::isHbpay()) {
			$result['terminalType'] = EpayCardLinkOperation::getAcquiringTerminal();
			$result['acquiringType'] = AcquiringType::HBPAY;
			//$result['model'] = new EpayCardLinkOperation();
		} else {
			$result['terminalType'] = WooppayCardLinkOperation::getAcquiringTerminal();
			$result['acquiringType'] = AcquiringType::WOOPPAY_LINKED;
			//$result['model'] = new WooppayCardLinkOperation();
		}
		return $result;
	}
	
	protected function data() {
		$types = $this->getTypes();
		$request = TpsOperations::getLinkedCardList($types['terminalType'], $types['acquiringType']);
		$all = $this->send($request);
		$all = ArrayHelper::toArray($all);
		return $all;
	}

}