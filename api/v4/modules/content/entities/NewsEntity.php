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


    public function getAvatarUrl() {
        if(empty($this->avatar_url)) {
            $repository = Yii::$app->account->repositories->avatar;
            if(empty($this->avatar)) {
                $this->avatar_url = env('url.static') . $repository->defaultName;
            } else {
                $baseUrl = env('url.static') . param('static.path.avatar') . '/';
                $this->avatar_url = $baseUrl . $this->avatar . '.' . $repository->format;
            }
        }
        return $this->avatar_url;
    }
}
