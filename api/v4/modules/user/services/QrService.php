<?php

namespace api\v4\modules\user\services;

use Yii;

use common\ddd\services\ActiveBaseService;

class QrService extends ActiveBaseService {
	
	public function getSelf() {
		$identity = Yii::$app->user->identity;
		$qrData['user_id'] = $identity->id;
		$url = $this->genUrl('payment?data=', $qrData);
		$entity = $this->repository->getOne($url);
		return $entity;
	}
	
	public function genUrl($uri, $data) {
		$dataJson = json_encode($data);
		$dataJsonBase64 = base64_encode($dataJson);
		$url = env('url.static') . $uri . $dataJsonBase64;
		return $url;
	}
}
