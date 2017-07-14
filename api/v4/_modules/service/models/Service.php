<?php

namespace api\v4\modules\service\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Service extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%service}}';
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'modify_date',
					ActiveRecord::EVENT_BEFORE_UPDATE => 'modify_date',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
	public function getServiceCategories()
	{
		return $this->hasMany(ServiceMenuService::className(), ['service_id' => 'service_id']);
	}
	
	public function getCategories()
	{
		return $this
			->hasMany(Category::className(), ['id' => 'service_menu_id'])
			->via('serviceCategories');
	}
	
	public function rules()
	{
		return [
			['parent_id', 'integer']
		];
	}
}
