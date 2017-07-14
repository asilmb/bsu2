<?php
namespace api\v4\modules\geo\models;

use yii\db\ActiveRecord;

class Currency extends ActiveRecord 
{

	/**
	 * @inheritdoc
	 */
	public static function tableName()
	{
		return '{{%currency}}';
	}

	public function scenarios()
	{
		$scenarios = parent::scenarios();
		$scenarios['update'] = $scenarios['create'] =
			['code', 'symb_def', 'name_cur', 'descr'];
		return $scenarios;
	}
	
	public function rules()
	{
		return [
			[['code', 'symb_def', 'name_cur'], 'required', 'on' => 'create'],
			[['code', 'symb_def', 'name_cur'], 'unique'],
			[['symb_def', 'name_cur', 'descr'], 'trim'],
			[['symb_def', 'name_cur'], 'string', 'min' => 2],
			[['code'], 'integer'],
			//[['id_country'], 'exist', 'skipOnError' => true, 'targetClass' => Country::className(), 'targetAttribute' => ['id' => 'code']],
		];
	}
	
}
