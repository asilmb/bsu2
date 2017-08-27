<?php
/**
 * Created by PhpStorm.
 * User: amubarak
 * Date: 07.08.2017
 * Time: 11:27
 */

namespace api\v4\modules\active\helpers;


use api\v4\modules\active\entities\FieldEntity;
use api\v4\modules\active\entities\ValidationEntity;
use common\ddd\helpers\ReflectionHelper;
use Yii;

class ActiveHelper {
	public function getTypes() {
		$types = Yii::$app->active->type->all();
		$arrayTypes = [null => 'Не выбрано'];
		foreach ($types as $type) {
			$arrayTypes[ $type->id ] = $type->title;
		}
		return $arrayTypes;
	}
	public function getTypeNameById($type_id) {
		$types = Yii::$app->active->type->oneById($type_id);
		return $types->title;
	}
	
	public function getFieldConstants() {
		$fieldConstants = ReflectionHelper::getConstantsValuesByPrefix(FieldEntity::className(), 'type');
		foreach ($fieldConstants as $fieldConstant) {
			$enums[ $fieldConstant ] = t('active/field', $fieldConstant);
		}
		return $enums;
	}
	public function getValidationConstants() {
		$fieldConstants = ReflectionHelper::getConstantsValuesByPrefix(ValidationEntity::className(), 'type');
		foreach ($fieldConstants as $fieldConstant) {
			$enums[ $fieldConstant ] = t('active/field', $fieldConstant);
		}
		return $enums;
	}
}