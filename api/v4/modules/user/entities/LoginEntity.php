<?php

namespace api\v4\modules\user\entities;

use common\ddd\BaseEntity;
use yii\web\IdentityInterface;
use api\v4\modules\user\helpers\LoginHelper;

class LoginEntity extends BaseEntity implements IdentityInterface {

	protected $id;
	protected $login;
	protected $email;
	protected $subject_type = 3000;
	protected $token;
	protected $parent_id;
	protected $iin_fixed = false;
	protected $creation_date;
	protected $password_hash;
	protected $roles;
	protected $profile;
	protected $balance;
	
	private $isShowToken = false;

	public function getAvatar() {
		$avatar = param('url.frontend') . '/images/avatars/_default.jpg';
		return $avatar;
	}
	
	public function getCreatedAt() {
		return $this->creation_date;
	}

	public function getUsername() {
		return LoginHelper::format($this->login);
	}

	public function getIinFixed() {
		if(empty($this->iin_fixed)) {
			return  false;
		}
		return $this->iin_fixed;
	}
	
	public function fieldType() {
		return [
			'id' => 'integer',
			'parent_id' => 'integer',
			'subject_type' => 'integer',
			'balance' => [
				'type' => BalanceEntity::className(),
			],
			'profile' => [
				'type' => ProfileEntity::className(),
			],
		];
	}
	
	public function showToken() {
		$this->isShowToken = true;
	}

	public static function findIdentity($id) {}

	public static function findIdentityByAccessToken($token, $type = null) {}

	public function getId() {
		return intval($this->id);
	}

	public function getAuthKey() {
		return $this->token;
	}

	public function validateAuthKey($authKey) {
		return $this->getAuthKey() === $authKey;
	}

	public function fields()
	{
		$fields = parent::fields();
		unset($fields['password_hash']);
		if(!$this->isShowToken) {
			unset($fields['token']);
		}
		return $fields;
	}
}
