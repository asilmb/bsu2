<?php

namespace api\v4\modules\active\forms;



use common\base\Model;

class ActiveTypeForm extends Model
{
	public $id;
	public $parent_id;
	public $title;
	
	public function rules() {
		return [
			[['title'], 'required'],
			[['parent_id'], 'integer'],
		];
	}
}
