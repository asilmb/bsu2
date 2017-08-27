<?php

namespace api\v4\modules\user\helpers;

class UserFixture {
	
	private static $passwordHash = '$2y$13$pX5m2S3tAlk9LiBNzsQi6u4z2bZ1xye926WQS5uCi0l1gO5hrB6oy';

	public static function generate($user) {
		$user['username'] = isset($user['username']) ? $user['username'] : $user['login'];
		$user['status'] = isset($user['status']) ? $user['status'] : 10;
		$user['email'] = isset($user['email']) ? $user['email'] : $user['login'] . '@ya.ru';
		$user['role'] = isset($user['role']) ? $user['role'] : 'rUnknownUser';
		$user['password_hash'] = isset($user['password_hash']) ? $user['password_hash'] : self::$passwordHash;
		$user['auth_key'] = md5($user['id'] . $user['login'] . $user['role']);
		$user['password_reset_token'] = null;
		$user['created_at'] = 1497349018;
		$user['updated_at'] = 1497349018;
		$user['balance'] = [
			'blocked' => 111,
			'active' => 222,
			'pay_delayed' => 0,
			'acc_base' => 0,
			'acc_commission' => 0,
		];
		return $user;
	}

	public static function generateAll($all) {
		foreach($all as &$user) {
			$user = self::generate($user);
		}
		return $all;
	}
	
}
