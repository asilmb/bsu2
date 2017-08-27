<?php

namespace api\v4\modules\user\services;

use api\v4\modules\user\forms\ChangeEmailForm;
use api\v4\modules\user\forms\ChangePasswordForm;
use common\ddd\services\BaseService;

class SecurityService extends BaseService {
	
	public function changeEmail($body) {
		$body = $this->validateForm(ChangeEmailForm::className(), $body);
		$this->repository->changeEmail($body['password'], $body['email']);
	}
	
	public function changePassword($body) {
		
		$body = $this->validateForm(ChangePasswordForm::className(), $body);
		$this->repository->changePassword($body['password'], $body['new_password']);
	}

}
