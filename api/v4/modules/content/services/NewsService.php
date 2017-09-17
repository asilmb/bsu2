<?php

namespace api\v4\modules\content\services;

use common\ddd\services\ActiveBaseService;
use Yii;
use yii\web\NotFoundHttpException;
use yii2mod\helpers\ArrayHelper;

class NewsService extends ActiveBaseService {

    //todo передавать сюда id  новости
    public function getSelf() {
        $login = Yii::$app->user->identity->login;
        try {
            $profile = $this->oneById($login);
        } catch (NotFoundHttpException $e) {
            $this->create(['login' => $login]);
            $profile = $this->oneById($login);
        }
        return $profile;
    }

    public function updateSelf($body) {
        $profile = $this->getSelf();
        $body = ArrayHelper::toArray($body);
        unset($body['avatar']);
        $this->updateById($profile->login, $body);
    }

}
