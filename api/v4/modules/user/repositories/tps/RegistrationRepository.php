<?php

namespace api\v4\modules\user\repositories\tps;

use api\v4\modules\user\interfaces\repositories\RegistrationInterface;
use common\ddd\repositories\TpsRepository;
use Yii;

class RegistrationRepository extends TpsRepository implements RegistrationInterface {

	public function generateActivationCode() {
		return rand(100001, 999999);
	}
	
	public function create($login, $password, $email) {
		Yii::$app->account->login->create($login, $password, $email);
	}
	
	public function isExists($login) {
		return $this->domain->repositories->login->isExistsByLogin($login);
	}
	
}