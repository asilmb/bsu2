<?php

namespace api\v4\modules\card\services\card;

use api\v4\modules\card\services\approve\Entity as ApproveEntity;

interface ServiceInterface {
	
	public function findById($id);
	public function findAll();
	public function delete(Entity $entity);
	public function approve(Entity $entity, $reference);
	
}
