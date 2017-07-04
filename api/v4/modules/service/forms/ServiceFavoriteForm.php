<?php

namespace api\v4\modules\service\forms;

use common\yii\base\Model;
use api\v4\modules\service\modelsDeco\Service;
use api\v4\modules\service\models\Favorite;
use yii\helpers\ArrayHelper;
use api\v4\modules\service\helpers\FieldsHelper;

/**
 * Signup form
 */
class ServiceFavoriteForm extends Model
{
	public $favorite_id;
	public $service_id;
	public $title;
	public $fields;
	
	/**
	 * @inheritdoc
	 */
	public function rules()
	{
		return [
			[['name'], 'trim'],
			[['service_id', 'title'], 'required'],
			['service_id', 'integer'],
			['service_id', 'exist', 'targetClass' => Service::className(), 'targetAttribute' => 'service_id', 'skipOnError' => true],
			['fields', 'validateFields'],
		];
	}
	
	public function scenarios()
	{
		return [
			self::SCENARIO_CREATE => ['service_id', 'title', 'fields'],
			self::SCENARIO_UPDATE => ['title', 'fields'],
		];
	}
	
	protected function assignBilling($fields = [])
	{
		$result = [];
		if(func_num_args() == 0) {
			$fields = $this->fields;
		}
		if(!empty($fields)) {
			foreach($fields as $fieldName => $fieldValue) {
				$result[$fieldName] = $fieldValue;
			}
		}
		return $result;
	}
	
	public function save($id = null)
	{
		if($this->scenario == self::SCENARIO_UPDATE) {
			$this->favorite_id = $id;
		}
		if (!$this->validate()) {
			return null;
		}
		if($this->scenario == self::SCENARIO_CREATE) {
			$model = new Favorite;
			$billing['service_id'] = $this->service_id;
			$billing['model'] = $this->assignBilling();
		} elseif($this->scenario == self::SCENARIO_UPDATE) {
			$model = Favorite::find()
				->where(['favorite_id' => $id])
				->one();
			$billing = $model->getBillinginfo();
			$billing['model'] = $this->assignBilling();
		}
		
		$model->setBillinginfo($billing);
		$model->name = $this->title;
		
		return $this->saveModel($model);
	}
	
	public function validateFields()
	{
		if ($this->hasErrors()) {
			return;
		}
		$fields = FieldsHelper::findFields($this);
		if (empty($fields)) {
			return;
		}
		foreach($this->fields as $fieldName => $fieldValue) {
			if(!isset($fields[$fieldName])) {
				$this->addError('fields', t('service/favorite', 'field_not_found {name}', ['name' => $fieldName]));
			}
		}
	}
}
