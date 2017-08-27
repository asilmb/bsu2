<?php

namespace api\v4\modules\personal\helpers;


use api\v4\modules\personal\dto\BonusDto;
use api\v4\modules\user\entities\ActiveEntity;
use common\ddd\data\Query;
use Yii;

class CreateActive {
	//todo очень сыро. Понадобидтся следующие функции:
	public static function run(BonusDto $bonusDto) {
		$model = new ActiveEntity();
		$data['title'] = $bonusDto->title;
		$data['logo'] = $bonusDto->logo;
		$model->user_id = Yii::$app->account->auth->identity->id;
		$model->active_id = 2;
		$model->provider_id = $bonusDto->provider_id;
		$model->currency_code = 1;
		$model->data = $data;
		Yii::$app->account->active->createData($model);
		
		$query = new Query();
		$query->where('provider_id', $bonusDto->provider_id);
		$bonusEntity = Yii::$app->account->active->all($query);
		
		Yii::$app->account->active->updateAmountById($bonusEntity[0]->id,$bonusDto->amount);
	}
}