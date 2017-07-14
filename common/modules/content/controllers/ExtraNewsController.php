<?php
namespace common\modules\app\controllers;

use common\modules\content\models\forms\NewsForm;
use common\modules\content\models\News;
use common\widgets\Alert;
use Yii;
use yii\web\Controller;

class ExtraNewsController extends Controller
{
	/**
	 * @inheritdoc
	 */
	public function actionIndex()
	{
		$form = new NewsForm();
		$model = new News();
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
					Alert::add(['news/news', 'cache_successfully_flushed'], Alert::TYPE_SUCCESS);
				} else {
					Alert::add(['news/news', 'select_cache_section_to_flush'], Alert::TYPE_DANGER);
				}
				return $this->refresh();
			}
		}
		return $this->render('index', [
			'model' => $form,
		]);
	}
}

