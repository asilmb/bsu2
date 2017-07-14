<?php

namespace api\v4\modules\card\services\card;

interface RepositoryInterface {
	
	public function findById($id);
	public function findAll();
	public function delete(Entity $card);
	public function update(Entity $card);
	public function approve(Entity $card);
	
}