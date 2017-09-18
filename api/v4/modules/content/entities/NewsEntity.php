<?php

namespace api\v4\modules\content\entities;

use common\ddd\BaseEntity;
use Yii;

class NewsEntity extends BaseEntity {
	
	protected $id;
	protected $title;
	protected $anons;
	protected $image;
	protected $image_url;
	protected $create_time;
	protected $body;
	
	/**
	 * @return mixed
	 */
	public function getImageUrl() {
		$repository = Yii::$app->content->repositories->image;
		if(empty($this->image)) {
			$this->image_url = env('servers.static.domain') . $repository->defaultName;
		} else {
			$baseUrl = '/' . env('servers.static.domain') . param('static.path.image') . '/';
			$this->image_url = $baseUrl . $this->image . '.' . $repository->format;
		}
		return $this->image_url;
	}
	
	
}
