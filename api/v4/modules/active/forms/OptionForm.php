<?php

namespace api\v4\modules\active\forms;



use common\base\Model;

class OptionForm extends Model
{
	public $id;
	public $field_id;
	public $key;
	public $title;
	
	public function rules() {
		return [
			[['field_id', 'key', 'title'], 'required'],
			[['field_id'], 'integer'],
		];
	}
}
