<?php

namespace api\v4\modules\user\interfaces\repositories;

interface RestorePasswordInterface {
	
	public function requestNewPassword($login);
	public function checkActivationCode($login, $code);
	public function setNewPassword($login, $code, $password);
	public function isExists($login);

}