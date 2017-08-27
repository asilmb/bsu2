<?php

namespace api\v4\modules\user\interfaces\repositories;

interface AuthInterface {

	public function authentication($login, $password);
	public function updateBalance();
	public function getBalance();
	public function setToken($token);

}