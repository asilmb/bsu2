<?php

namespace api\v4\modules\content\services;

use common\ddd\services\ActiveBaseService;
use Yii;

class ImageService extends ActiveBaseService {
	
	public function getSelf($id) {
		$news = $this->domain->news->oneById($id);
		$entity = $this->repository->forgeEntity([
			'name' => $news->image,
			'url' => $news->image_url,
		]);
		return $entity;
	}
	
	public function updateSelf($image) {
		$name = $this->repository->save($image, Yii::$app->user->id);
		$this->changeImageInnews($name);
	}
	
	public function deleteSelf() {
		$this->domain->repositories->image->delete(Yii::$app->user->id);
		$this->changeImageInNews(null);
	}
	
	private function changeImageInNews($name) {
		$news = $this->domain->news->getSelf();
		$body['image'] = $name;
		$this->domain->news->updateById($news->login, $body);
	}
	
}
