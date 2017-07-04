<?php
namespace api\v4\modules\geo\modelsDeco;

use yii2lab\helpers\Helper;
use api\v4\modules\geo\models\Country as BaseCountry;
use yii\behaviors\AttributeTypecastBehavior;

class Country extends BaseCountry
{
	
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['typecast'] = [
			'class' => AttributeTypecastBehavior::className(),
			'attributeTypes' => [
				'code' => AttributeTypecastBehavior::TYPE_INTEGER,
				'code_curr' => AttributeTypecastBehavior::TYPE_INTEGER,
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
	
}
