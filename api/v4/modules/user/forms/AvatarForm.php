<?php

namespace api\v4\modules\user\forms;

use common\base\Model;
use Yii;
use yii\web\UploadedFile;

class AvatarForm extends Model
{
	public $imageFile;
	
	public function init()
	{
		if(Yii::$app->request->isPost) {
			$this->imageFile = UploadedFile::getInstance($this, 'imageFile');
		}
	}
	
	public function rules()
	{
		return [
			[['imageFile'], 'file', 'skipOnEmpty' => false, 'extensions' => 'png, jpg'],
		];
	}
	
}
