<?php
namespace api\v4\modules\service\modelsDeco;

use api\v4\modules\service\models\Category as BaseCategory;

class Category extends BaseCategory
{

	public function fields()
	{
		$fields['id'] = 'id';
		$fields['parent_id'] = 'parent_id';
		$fields['title'] = 'title';
		$fields['name'] = 'name';
		$fields['picture'] = 'picture';
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
