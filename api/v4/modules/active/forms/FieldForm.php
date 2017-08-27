<?php

namespace api\v4\modules\active\forms;



use api\v4\modules\active\entities\FieldEntity;
use api\v4\modules\active\models\Fields;
use common\base\Model;

class FieldForm extends Model
{
	public $id;
	public $title;
	public $active_id;
	public $type;
	public $sort;
	public $is_visible;
	public $is_hidden;
	public $is_has_button;
	public $is_readonly;
	public $mask;
	public $validations;
	public $options;
	public $name;
	public $priority;
	/**
	 * @inheritdoc
	 */
	public function rules() {
		$entity = new FieldEntity();
		return $entity->rules();
	}
	
}