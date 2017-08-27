<?php

namespace api\v4\modules\active\forms;



use api\v4\modules\active\entities\ValidationEntity;
use common\base\Model;
use common\ddd\helpers\ReflectionHelper;

class ValidationForm extends Model
{
	public $id;
	public $field_id;
	public $type;
	public $rules;
	
	public function rules() {
		$types = ReflectionHelper::getConstantsValuesByPrefix(ValidationEntity::className(), 'type');
		return [
			[['field_id', 'type'], 'required'],
			[['field_id'], 'integer'],
			[['type'], 'in', 'range' => $types],
		];
	}
}
