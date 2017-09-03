<?php
namespace api\v4\modules\content\forms;

use yii2lab\misc\yii\base\Model;


class NewsForm extends Model {
	
	public $id;
	public $title;
	public $anons;
	public $create_time;
	public $body;
	
	public function rules() {
		return [
			[['title', 'body'], 'required'],
		];
	}
	
}
