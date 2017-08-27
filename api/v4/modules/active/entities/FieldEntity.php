<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;

class FieldEntity extends BaseEntity {
	
	const TYPE_STRING = 'string';
	const TYPE_INTEGER = 'integer';
	const TYPE_SELECT = 'select';
	const TYPE_BOOLEAN = 'boolean';
	const TYPE_DATE = 'date';
	
	protected $id;
	protected $name;
	protected $title;
	public $active_id;
	protected $type;
	protected $sort;
	protected $is_visible = false;
	protected $is_hidden = false;
	protected $is_has_button = false;
	protected $is_readonly = false;
	protected $mask;
	protected $validations;
	protected $options;
	protected $priority;
	
	// todo: apply fieldType in other entity
	
	public function fieldType() {
		return [
			'is_visible' => 'boolean',
			'is_hidden' => 'boolean',
			'is_has_button' => 'boolean',
			'is_readonly' => 'boolean',
			'validations' => [
				'type' => ValidationEntity::className(),
				'isCollection' => true,
			],
			'options' => [
				'type' => OptionEntity::className(),
				'isCollection' => true,
			],
		];
	}
	
	public function rules() {
		$types = $this->getConstantEnum('type');
		return [
			[['title', 'name', 'active_id', 'type'], 'required'],
			[['active_id'], 'integer'],
			[['type'], 'in', 'range' => $types],
		];
	}
	
}