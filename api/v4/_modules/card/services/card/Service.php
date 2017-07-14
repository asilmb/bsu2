<?php

namespace api\v4\modules\card\services\card;

use common\services\BaseService;
use api\v4\modules\card\services\approve\Entity as ApproveEntity;

class Service extends BaseService /*implements ServiceInterface*/ {
	
	public function findById($id) {
		return $this->repository->findById($id);
	}
	
	public function findAll() {
		return $this->repository->findAll();
	}
	
	public function delete(Entity $entity) {
		$this->repository->delete($entity);
	}
	
	public function approve(Entity $entity, $approve) {
		$entity->reference = $approve['reference'];
		if(!$entity->validate()) {
			$this->addErrors($entity->getErrors());
		} else {
			$this->repository->approve($entity, $approve['amount']);
		}
	}
	
	public function withBank() {
		$this->repository->withBank();
	}
	
}
