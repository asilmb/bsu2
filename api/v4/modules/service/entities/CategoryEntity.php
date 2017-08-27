<?php

namespace api\v4\modules\service\entities;

use common\ddd\BaseEntity;
use Yii;

class CategoryEntity extends BaseEntity {

	protected $id;
	protected $parent_id;
	protected $title;
	protected $name;
	protected $picture;

	public function fieldType() {
		return [
			'id' => 'id',
			//'parent_id' => 'id',
		];
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
		return Yii::$app->summary->summary->url['service_menu_pictures'] . '/' . $this->getPicture();
	}
	
	public function fields() {
		$fields = parent::fields();
		$fields['picture_url'] = 'picture_url';
		return $fields;
	}

}
