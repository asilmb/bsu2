<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `news`.
*/
class m170903_052420_create_news_table extends Migration
{
	public $table = '{{%news}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'title' => $this->string(),
            'image' => $this->string(),
            'image_url' => $this->string(),
			'anons' => $this->string(),
			'body' =>$this->string(),
			'create_time'=> $this->timestamp()->notNull()->defaultExpression('CURRENT_TIMESTAMP')
		];

	}

	public function afterCreate()
	{
		
	}

}
