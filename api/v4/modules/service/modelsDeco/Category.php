<?php
namespace api\v4\modules\service\modelsDeco;

use api\v4\modules\service\models\Category as BaseCategory;
use common\traits\PictureTrait;
use yii\behaviors\AttributeTypecastBehavior;

class Category extends BaseCategory
{
	use PictureTrait;
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['typecast'] = [
			'class' => AttributeTypecastBehavior::className(),
			'attributeTypes' => [
				'parent_id' => AttributeTypecastBehavior::TYPE_INTEGER,
			],
			'typecastAfterFind' => true,
		];
		return $behaviors;
	}
	
	public function fields()
	{
		$fields['id'] = 'id';
		$fields['parent_id'] = 'parent_id';
		$fields['title'] = 'name';
		$fields['name'] = 'title';
		$fields['picture'] = function () {
			return $this->picToPng();
		};
		$fields['picture_url'] = function () {
			return $this->picUrl('service_menu_pictures');
		};
		return $fields;
	}
	
	public static function find() {
		$query = parent::find();
		$query->where([
			'status'   => 1,
			'group_id' => 0,
		]);
		$query->orderBy(['position' => SORT_DESC]);
		return $query;
	}
	
}
