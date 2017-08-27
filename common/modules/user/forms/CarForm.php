<?php

namespace common\modules\user\forms;

use api\v4\modules\user\entities\CarEntity;
use common\base\Model;

class CarForm extends Model
{
	
	public $gov_number;
	public $document_number;
	
	public function rules()
	{
		$entity = new CarEntity();
		return $entity->rules();
	}
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'gov_number' 		=> t('user/car', 'gov_number'),
			'document_number' 		=> t('user/car', 'document_number'),
		];
	}
	
}
