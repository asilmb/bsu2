<?php
/**
 * Created by PhpStorm.
 * User: asundetov
 * Date: 17.08.2017
 * Time: 11:52
 */

namespace common\modules\user\forms;


use common\base\Model;



class AddressForm extends Model{
	
	public $country_id;
	public $region_id;
	public $city_id;
	public $district;
	public $street;
	public $home;
	public $apartment;
	public $post_code;
	
	/**
	 * @inheritdoc
	 */
	public function attributeLabels()
	{
		return [
			'country_id' => 'Cтрана',
			'region_id' =>'Регион',
			'city_id' =>'Город',
			'district' =>'Район',
			'street'=>'Улица',
			'home'=>'Дом',
			'apartment'=>'Квартира',
			'post_code'=>'Почтовый индекс',
		];
	}
}