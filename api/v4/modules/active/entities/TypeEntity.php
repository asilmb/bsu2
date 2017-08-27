<?php

namespace api\v4\modules\active\entities;

use common\ddd\BaseEntity;
use Yii;

class TypeEntity extends BaseEntity {
	
	protected $id;
	protected $handler_id;
	protected $parent_id = null;
	protected $title;
	protected $handler;
	
	public function getHandler() {
		if(!empty($this->handler_id)) {
			return Yii::$app->active->handler->oneById($this->handler_id);
		}
	}
	
	public function fields() {
		$fields = parent::fields();
		$fields['handler'] = 'handler';
		return $fields;
	}
	protected $fields;
	
	public function fieldType() {
		return [
			'fields' => [
				'type' => FieldEntity::className(),
				'isCollection' => true,
				//'isHideIfNull' => true,
			],
		];
	}
	
	public function rules() {
		return [
			[['title'], 'required'],
			[['parent_id'], 'integer'],
		];
	}
	

}
