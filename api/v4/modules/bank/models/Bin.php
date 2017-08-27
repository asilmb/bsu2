<?php

namespace api\v4\modules\bank\models;

use api\v4\modules\active\models\Provider;
use yii\db\ActiveRecord;

class Bin extends ActiveRecord
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%bank_bins}}';
	}
	public function extraFields()
	{
		return ['provider'];
	}
	public function getProvider()
	{
		return $this->hasOne(Provider::className(), [
			'id' => 'bank_id',
		]);
	}
}
