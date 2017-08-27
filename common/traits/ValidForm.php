<?php
namespace common\traits;

use common\exceptions\UnprocessableEntityHttpException;
use Yii;

trait ValidForm {
	
	public function validateForm($form, $callback) {
		$body = Yii::$app->request->post();
		$isValid = $form->load($body) && $form->validate();
		if ($isValid) {
			try {
				return call_user_func_array($callback, [$form]);
			} catch (UnprocessableEntityHttpException $e) {
				$form->addErrorsFromException($e);
			}
		}
	}
	
}