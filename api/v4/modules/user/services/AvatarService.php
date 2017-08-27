<?php

namespace api\v4\modules\user\services;

use common\ddd\services\ActiveBaseService;
use Yii;

class AvatarService extends ActiveBaseService {
	
	public function getSelf() {
		$profile = $this->domain->profile->getSelf();
		$entity = $this->repository->forgeEntity([
			'name' => $profile->avatar,
			'url' => $profile->avatar_url,
		]);
		return $entity;
	}
	
	public function updateSelf($avatar) {
		$name = $this->repository->save($avatar, Yii::$app->user->id);
		$this->changeAvatarInProfile($name);
	}
	
	public function deleteSelf() {
		$this->domain->repositories->avatar->delete(Yii::$app->user->id);
		$this->changeAvatarInProfile(null);
	}
	
	private function changeAvatarInProfile($name) {
		$profile = $this->domain->profile->getSelf();
		$body['avatar'] = $name;
		$this->domain->profile->updateById($profile->login, $body);
	}
	
}
