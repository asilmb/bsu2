<?php
namespace api\v4\modules\notify\models;

use yii\db\ActiveRecord;
use yii\behaviors\TimestampBehavior;

class Transport extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%notify}}';
	}
	
	public function behaviors()
	{
		return [
			'timestamp' => [
				'class' => TimestampBehavior::className(),
				'attributes' => [
					ActiveRecord::EVENT_BEFORE_INSERT => 'created_at',
					//ActiveRecord::EVENT_BEFORE_UPDATE => 'date_change',
				],
				'value' => function() { return date('Y-m-d H:i:s'); },
			],
		];
	}
	
}
