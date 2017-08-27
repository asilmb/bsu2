<?php
namespace api\v4\modules\geo\modelsDeco;

use yii2lab\helpers\Helper;
use api\v4\modules\geo\models\City as BaseCity;
use yii\behaviors\AttributeTypecastBehavior;

class City extends BaseCity
{
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['typecast'] = [
			'class' => AttributeTypecastBehavior::className(),
			'attributeTypes' => [
				'id' => AttributeTypecastBehavior::TYPE_INTEGER,
				'id_country' => AttributeTypecastBehavior::TYPE_INTEGER,
				'region_id' => AttributeTypecastBehavior::TYPE_INTEGER,
				'position' => AttributeTypecastBehavior::TYPE_INTEGER,
				'status' => AttributeTypecastBehavior::TYPE_INTEGER,
			],
			'typecastAfterFind' => true,
		];
		return $behaviors;
	}
	
	public function fields()
	{
		$fields = parent::fields();
		$fields['date_change'] = function () {
			return Helper::timeForApi($this->date_change);
		};
		return $fields;
	}
	
	/**
	 * @inheritdoc
	 */
	public function getCountry()
	{
		return $this->hasOne(Country::className(), ['code' => 'id_country']);
	}
}
