<?php
namespace common\modules\user\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use common\modules\user\forms\PasswordRequestResetForm;
use common\modules\user\forms\PasswordResetForm;
use common\widgets\Alert;

/**
 * PasswordController controller
 */
class PasswordController extends Controller
{
	public $defaultAction = 'reset-request';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		$behaviors = parent::behaviors();
		$behaviors['access'] = [
			'class' => 'yii\filters\AccessControl',
			'rules' => [
				[
					'allow' => true,
					'roles' => ['?'],
				],
			],
		];
		return $behaviors;
	}

	/**
	 * Requests password reset.
	 *
	 * @return mixed
	 */
	public function actionResetRequest()
	{
		$model = new PasswordRequestResetForm();
		if ($model->load(Yii::$app->request->post()) && $model->validate()) {
			if ($model->sendEmail()) {
				Alert::add(['user/password', 'send_request_success'], Alert::TYPE_SUCCESS);
				return $this->goHome();
			} else {
				Alert::add(['user/password', 'send_request_error'], Alert::TYPE_DANGER);
			}
		}

		return $this->render('requestReset', [
			'model' => $model,
		]);
	}

	/**
	 * Resets password.
	 *
	 * @param string $token
	 * @return mixed
	 * @throws BadRequestHttpException
	 */
	public function actionReset($token)
	{
		try {
			$model = new PasswordResetForm($token);
		} catch (InvalidParamException $e) {
			throw new BadRequestHttpException($e->getMessage());
		}

		if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
			Alert::add(['user/password', 'new_password_saved_success'], Alert::TYPE_SUCCESS);
			return $this->goHome();
		}

		return $this->render('reset', [
			'model' => $model,
		]);
	}
	
}
