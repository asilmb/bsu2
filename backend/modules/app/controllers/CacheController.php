<?php
namespace backend\modules\app\controllers;

use Yii;
use yii\web\Controller;
use backend\modules\app\models\forms\CashForm;
use backend\modules\app\models\Cash;
use common\widgets\Alert;

class CacheController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actionIndex()
	{
		$form = new CashForm();
		$model = new Cash();
		if(Yii::$app->request->getIsPost()){
			$success = false;
			if ($form->load(Yii::$app->request->post()) && $form->validate()) {
				if ($form->backend_app) {
					$model->clearCash('backend');
					$success = true;
				}

				if ($form->frontend_app) {
					$model->clearCash('frontend');
					$success = true;
				}
				
				if ($form->api_app) {
					$model->clearCash('api');
					$success = true;
				}
				if ($success) {
					Alert::add(['app/cache', 'cache_successfully_flushed'], Alert::TYPE_SUCCESS);
				} else {
					Alert::add(['app/cache', 'select_cache_section_to_flush'], Alert::TYPE_DANGER);
				}
				return $this->refresh();
			}
		}
		return $this->render('index', [
			'model' => $form,
		]);
	}
}

