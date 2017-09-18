<?php

namespace api\v4\modules\content\services;

use common\ddd\services\ActiveBaseService;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\helpers\ArrayHelper;

class NewsService extends ActiveBaseService {

    public function updateSelf($body) {
        $profile = $this->getSelf();
        $body = ArrayHelper::toArray($body);
        unset($body['avatar']);
        $this->updateById($profile->login, $body);
    }

}
