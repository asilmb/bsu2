<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 18.08.2017
 * Time: 16:24
 */

namespace common\modules\user\forms;

use api\v4\modules\user\forms\ChangePasswordForm as ApiChangePasswordForm;
use yii\helpers\ArrayHelper;

class ChangePasswordForm  extends ApiChangePasswordForm {
	
	public $new_password_repeat;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return ArrayHelper::merge(parent::rules(), [
			[['new_password_repeat'], 'trim'],
			[['new_password_repeat'], 'required'],
			[['new_password_repeat'], 'string', 'min' => 8],
			['new_password_repeat', 'compare', 'compareAttribute' => 'new_password',],
		]);
	}
	
	public function attributeLabels()
	{
		return ArrayHelper::merge(parent::attributeLabels(), [
			'new_password_repeat' => t('user/security', 'new_password_repeat'),
		]);
	}
}