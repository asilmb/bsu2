<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 21.07.2017
 * Time: 12:13
 */

namespace api\v4\modules\transaction\forms;


use common\yii\base\Model;

class ApiPaymentRequest extends Model
{
	const SCENARIO_API_CHECK = 'apiCheck';
	/**
	 * @var string $service_id
	 * @var string $fields
	 */
	public $service_id;
	public $group_id;
	public $fields;
	public $cardId;
	
	
	public function rules()
	{
		return array(
			array('service_id, fields', 'required'),
			array('group_id', 'number'),
			array('service_id, fields, cardId', 'safe')
		);
	}
	
	
	public function scenarios()
	{
		return [
			self::SCENARIO_API_CHECK => ['service_id', 'fields','group_id','cardId'],
		
		];
	}
}