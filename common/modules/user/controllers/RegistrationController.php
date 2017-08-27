<?php
namespace common\modules\user\controllers;

use api\v4\modules\user\forms\RegistrationForm;
use common\exceptions\UnprocessableEntityHttpException;
use common\modules\user\forms\AdditionalForm;
use common\modules\user\forms\SetSecurityForm;
use common\traits\ValidForm;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use common\widgets\Alert;

/**
 * AuthController controller
 */
class RegistrationController extends Controller
{
	
	use ValidForm;
	
	public $defaultAction = 'create';

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
						'actions' => ['create', 'set-password'],
						'allow' => true,
						'roles' => ['?'],
					],
					[
						'actions' => ['set-name', 'set-address'],
						'allow' => true,
						'roles' => ['@'],
					],
				],
			],
		];
	}

	/**
	 * Signs user up.
	 *
	 * @return mixed
	 */
	public function actionCreate()
	{
		$form = new RegistrationForm();
		$form->scenario = RegistrationForm::SCENARIO_CHECK;
		$callback = function($form) {
			Yii::$app->account->registration->activateAccount($form->login, $form->activation_code);
			$session['login'] = $form->login;
			$session['activation_code'] = $form->activation_code;
			Yii::$app->session->set('registration', $session);
			return $this->redirect(['/user/registration/set-password']);
		};
		$this->validateForm($form,$callback);
		return $this->render('create', [
			'model' => $form,
		]);
	}
	
	public function actionSetPassword()
	{
		$session = Yii::$app->session->get('registration');
		if(empty($session['login']) || empty($session['activation_code'])) {
			return $this->redirect(['/user/registration']);
		}
		$isExists = Yii::$app->account->repositories->temp->isExists($session['login']);
		if(!$isExists) {
			Alert::add(['user/registration', 'temp_user_not_found'], Alert::TYPE_DANGER);
			return $this->redirect(['/user/registration']);
		}
		$form = new SetSecurityForm();
		$callback = function($form) use ($session) {
			Yii::$app->account->registration->createTpsAccount($session['login'], $session['activation_code'], $form->password, $form->email);
			Yii::$app->account->auth->authenticationFromWeb($session['login'], $form->password, true);
			return $this->redirect(['/user/registration/set-name']);
		};
		$this->validateForm($form,$callback);
		return $this->render('set_password', [
			'model' => $form,
			'login' => $session['login'],
		]);
	}
	
	public function actionSetName()
	{
		$form = new AdditionalForm();
		$callback = function($form) {
			Yii::$app->account->profile->updateSelf($form->toArray());
			return $this->redirect(['/user/registration/set-address']);
		};
		$this->validateForm($form,$callback);
		return $this->render('set_name', [
			'model' => $form,
		]);
	}
	
	public function actionSetAddress()
	{
		$form = new AdditionalForm();
		$callback = function($form) {
			Yii::$app->account->address->updateSelf($form->toArray());
			return $this->goHome();
		};
		$this->validateForm($form,$callback);
		return $this->render('set_address', [
			'model' => $form,
		]);
	}
}
