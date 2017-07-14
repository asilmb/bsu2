<?php
namespace api\v4\modules\geo\modelsDeco;

use api\v4\modules\geo\models\Currency as BaseCurrency;
use yii\behaviors\AttributeTypecastBehavior;

class Currency extends BaseCurrency
{

	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['typecast'] = [
			'class' => AttributeTypecastBehavior::className(),
			'attributeTypes' => [
				'code' => AttributeTypecastBehavior::TYPE_INTEGER,
			],
			'typecastAfterFind' => true,
		];
		return $behaviors;
	}
	
}
