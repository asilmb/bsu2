<?php

namespace api\v4\modules\user\entities;

use common\ddd\BaseEntity;
use common\validators\IinValidator;
use Yii;

class ProfileEntity extends BaseEntity {
	
	protected $login;
	protected $first_name;
	protected $last_name;
	protected $iin;
	protected $birth_date;
	protected $sex;
	protected $avatar;
	protected $avatar_url;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['first_name', 'last_name', 'iin', 'birth_date'], 'trim'],
			//['birth_date', DateValidator::className()],
			[['sex'], 'boolean'],
			['iin', IinValidator::className()],
		];
	}
	
	public function getAvatarUrl() {
		if(empty($this->avatar_url)) {
			$repository = Yii::$app->account->repositories->avatar;
			if(empty($this->avatar)) {
				$this->avatar_url = env('url.static') . $repository->defaultName;
			} else {
				$baseUrl = env('url.static') . param('static.path.avatar') . '/';
				$this->avatar_url = $baseUrl . $this->avatar . '.' . $repository->format;
			}
		}
		return $this->avatar_url;
	}
	
}
