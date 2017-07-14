<?php

namespace common\modules\content\models;

use cyneek\yii2\uploadBehavior\UploadBehavior;
use cyneek\yii2\uploadBehavior\UploadImageBehavior;

/**
 * This is the model class for table "{{%news}}".
 *
 * @property integer $id
 * @property string  $title
 * @property string  $underTitle
 * @property string  $content
 * @property string  $created_at
 */
class News extends \yii\db\ActiveRecord {
	/**
	 * @inheritdoc
	 */
	public $file;
	public $avatar;
	public static function tableName() {
		return '{{%news}}';
	}
	
	public function rules() {
		return [
			[['title', 'content'], 'required'],
			[['content'], 'string'],
			[['title', 'underTitle'], 'string', 'max' => 255],
		];
	}
	
	public function getFile()
	{
		return $this->hasMany(NewsFiles::className(), ['customer_id' => 'id']);
	}
	public function setFile()
	{
		$file = new NewsFiles();
		$file->attributes = $_POST['attributes'];
	}
	public function getAvatar()
	{
		return $this->hasMany(NewsFiles::className(), ['customer_id' => 'id']);
	}
	public function setAvatar()
	{
		$file = new NewsFiles();
		$file->attributes = $_POST['attributes'];
	}
	public function attributeLabels() {
		return [
			'id' => t('content/news_create', 'ID'),
			'title' => t('content/news_create', 'news_name'),
			'underTitle' => t('content/news_create', 'news_underTitle'),
			'content' => t('content/news_create', 'сontent'),
			'created_at' => t('content/news_create', 'Created At'),
		];
	}
	
	function behaviors() {
		return [
			[
				'class' => UploadBehavior::className(),
				'attribute' => 'file',
				'scenarios' => ['default'],
				'fileActionOnSave' => 'delete',
			],
			[
				'class' => UploadImageBehavior::className(),
				'attribute' => 'avatar',
				'scenarios' => ['default'],
				'fileActionOnSave' => 'delete',
				'imageActions' => [['action' => 'thumbnail', 'width' => '900', 'height' => '400']],
			],
		];
	}
	
}
