<?php

namespace api\v4\modules\user\validators;

use api\v4\modules\user\helpers\LoginHelper;
use yii\validators\Validator;

class LoginValidator extends Validator
{
    /**
     * @inheritdoc
     */
    public function init()
    {
        parent::init();
        if ($this->message === null) {
            $this->message = t('this/registration', 'login_not_valid');
        }
    }

    /**
     * @inheritdoc
     */
    protected function validateValue($value)
    {
	    $valid = LoginHelper::validate($value);
        return $valid ? null : [$this->message, []];
    }
	
}
