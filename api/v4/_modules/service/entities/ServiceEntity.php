<?php

namespace api\v4\modules\service\entities;

use api\v4\modules\summary\helpers\ResourceHelper;
use common\ddd\BaseEntity;
use api\v4\modules\service\entities\FieldsEntity;
use yii\base\InvalidCallException;

class ServiceEntity extends BaseEntity {

	protected $id;
	protected $name;
	protected $parent_id;
	protected $title;
	protected $description;
	protected $picture;
	protected $synonyms;
	protected $fields;
	protected $categories;
	
	/*public function hideIfNullFields() {
		return true;
	}*/
	
	public function extraFields() {
		return [
			'categories',
		];
	}
	
	public function getPrivateKey() {
		return $this->id;
	}

	public static function primaryKey() {
		return ['id'];
	}
	
	public function getId() {
		return $this->id;
	}
	
	public function setId($value) {
		if(!isset($this->id)) {
			$this->id = $value;
		} else {
			throw new InvalidCallException('Setting read-only property: ' . get_class($this) . '::id');
		}
	}
	
	public function getFields() {
		return $this->fields;
	}

	public function setFields($value) {
		if(empty($value)) {
			return [];
		}
		foreach($value as $item) {
			if(is_object($item) && is_a($item, BaseEntity::className())) {
				$this->fields[] = $item;
			} else {
				$this->fields[] = new FieldsEntity($item);
			}

		}
	}

	public function getPicture() {
		if(empty($this->picture)) {
			return null;
		}
		return str_replace('.svg', '.png', $this->picture);
	}

	public function getPictureUrl() {
		if(empty($this->picture)) {
			return null;
		}
		/** todo: make mock for summary */
		return ResourceHelper::getResourceByType('url')['service_pictures'] . '/' . $this->getPicture();
	}

	public function fields() {
		$fields = parent::fields();
		$fields['picture_url'] = 'picture_url';
		return $fields;
	}

}
