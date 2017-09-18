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


    public function getImageUrl() {
        if(empty($this->image_url)) {
            $repository = Yii::$app->account->repositories->image;
            if(empty($this->image)) {
                $this->image_url = env('url.static') . $repository->defaultName;
            } else {
                $baseUrl = env('url.static') . param('static.path.image') . '/';
                $this->image_url = $baseUrl . $this->image . '.' . $repository->format;
            }
        }
        return $this->image_url;
    }
}
