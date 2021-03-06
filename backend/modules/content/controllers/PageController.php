<?php
namespace backend\modules\app\controllers;


use Yii;
use yii\web\Controller;

use common\widgets\Alert;

class PageController extends Controller
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

