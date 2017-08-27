<?php

namespace api\v4\modules\user\repositories\ar;

use common\ddd\BaseEntity;
use common\ddd\repositories\ActiveArRepository;
use Yii;
use yii\db\ActiveRecord;

class ProfileRepository extends ActiveArRepository {
	
	protected $primaryKey = 'login';
	
	public function insert(BaseEntity $entity) {
		$entity->validate();
		$model = Yii::createObject($this->model->className());
		$this->massAssignmentForInsert($model, $entity);
		$this->saveModel($model);
	}
	
	protected function massAssignmentForInsert(ActiveRecord $model, BaseEntity $entity) {
		$data = $entity->toArray();
		$data = $this->unsetNotExistedFields($model, $data);
		Yii::configure($model, $data);
	}
}
