<?php

namespace api\v4\modules\service\models;

use yii\data\ActiveDataProvider;
use api\v4\modules\service\modelsDeco\Service;

class ServiceSearch extends Service
{
	public $category;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['category'], 'integer'],
		];
	}

	public function search($params) {
		$query = Service::find();
		$dataProvider = new ActiveDataProvider([
			'query' => $query,
		]);
		$this->load($params, '');
		if (!$this->validate()) {
			return $dataProvider;
		}
		if ($this->category) {
			$query
				->joinWith('serviceCategories')
				->where(['service_menu_service.service_menu_id' => $this->category]);
		}
		return $dataProvider;
	}
}
