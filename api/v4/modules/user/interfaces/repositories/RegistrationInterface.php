<?php

namespace api\v4\modules\user\interfaces\repositories;

interface RegistrationInterface {
	
	public function generateActivationCode();
	public function create($login, $password, $email);
	public function isExists($login);

}