<?php
namespace common\modules\user\controllers;

use Yii;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use api\v4\modules\user\forms\LoginForm;
use common\exceptions\UnprocessableEntityHttpException;
use common\widgets\Alert;

/**
 * AuthController controller
 */
class AuthController extends Controller
{
	public $defaultAction = 'login';

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
						'actions' => ['logout'],
						'allow' => true,
						'roles' => ['@'],
					],
					[
						'actions' => ['login'],
						'allow' => true,
						'roles' => ['?'],
					],
				],
			],
			'verbs' => [
				'class' => VerbFilter::className(),
				'actions' => [
					'logout' => ['post'],
				],
			],
		];
	}

	/**
	 * Logs in a user.
	 *
	 * @return mixed
	 */
	public function actionLogin()
	{
		$form = new LoginForm();
		$body = Yii::$app->request->post();
		$isValid = $form->load($body) && $form->validate();
		if ($isValid) {
			try {
				Yii::$app->account->auth->authenticationFromWeb($form->login, $form->password, $form->rememberMe);
				if(!$this->isBackendAccessAllowed()) {
					Yii::$app->account->auth->logout();
					Alert::add(['user/auth', 'login_access_error'], Alert::TYPE_DANGER);
					return $this->goHome();
				}
				Alert::add(['user/auth', 'login_success'], Alert::TYPE_SUCCESS);
				return $this->goBack();
			} catch(UnprocessableEntityHttpException $e) {
				$form->addErrorsFromException($e);
			}
		}
		
		return $this->render('login', [
			'model' => $form,
		]);
	}

	/**
	 * Logs out the current user.
	 *
	 * @return mixed
	 */
	public function actionLogout()
	{
		Yii::$app->account->auth->logout();
		Alert::add(['user/auth', 'logout_success'], Alert::TYPE_SUCCESS);
		return $this->goHome();
	}
	
	private function isBackendAccessAllowed()
	{
		if(APP != BACKEND) {
			return true;
		}
		if (Yii::$app->user->can('backend.*')) {
			return true;
		}
		return false;
	}
	
}
