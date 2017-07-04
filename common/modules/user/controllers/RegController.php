<?php
namespace common\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\modules\user\forms\SignupForm;
use common\widgets\Alert;

/**
 * AuthController controller
 */
class RegController extends Controller
{
	public $defaultAction = 'signup';

	/**
	 * @inheritdoc
	 */
	public function behaviors()
	{
		return [
			'access' => [
				'class' => AccessControl::className(),
				'rules' => [
					[
						'actions' => ['signup'],
						'allow' => true,
						'roles' => ['?'],
					]
				],
			],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionSignup()
	{
		$model = new SignupForm();
		if ($model->load(Yii::$app->request->post())) {
			if ($user = $model->signup()) {
				Alert::add(['user/registration', 'user_create_success'], Alert::TYPE_SUCCESS);
				if (Yii::$app->getUser()->login($user)) {
					return $this->goHome();
				}
			}
		}

		return $this->render('signup', [
			'model' => $model,
		]);
	}

}
