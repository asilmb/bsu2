<?php

namespace common\modules\user\forms;

use common\base\Model;

class AdditionalForm extends Model
{
	
	public $first_name;
	public $last_name;

	public $iin;
	public $birth_date;
	public $sex;


	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'first_name' 		=> t('user/profile', 'first_name'),
			'last_name' 		=> t('user/profile', 'last_name'),
			'iin'=>'Иин',
			'birth_date'=>'Дата рождения',
			'sex'=>'Пол',
		];
	}
	
}
