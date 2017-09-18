<?php

namespace api\v4\modules\content\services;

use common\ddd\services\ActiveBaseService;
use Yii;

class ImageService extends ActiveBaseService {
	
	public function oneByNews($id) {
		$news = $this->domain->news->oneById($id);
		$entity = $this->repository->forgeEntity([
			'name' => $news->image,
			'url' => $news->image_url,
		]);
		return $entity;
	}
	public function updateSelf($image, $id) {
		$name = $this->repository->save($image, Yii::$app->user->id);
		$this->changeImageInNews($name, $id);
	}
	
	public function deleteSelf($id) {
		$this->domain->repositories->image->delete(Yii::$app->user->id);
		$this->changeImageInNews(null, $id);
	}
	
	private function changeImageInNews($name, $id) {
		$news = $this->domain->news->oneById($id);
		$body['image'] = $name;
		$this->domain->news->updateById($news->id, $body);
	}
	
}
