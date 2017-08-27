<?php

namespace api\v4\modules\user\interfaces\repositories;

interface LoginInterface {
	
	public function isExistsByLogin($login);
	public function oneByLogin($login);
	public function oneByToken($token, $type = null);
	public function getBalance($login);

}