<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `news`.
*/
class m170903_051852_create_news_table extends Migration
{
	public $table = '{{%news}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			
		];

	}

	public function afterCreate()
	{
		
	}

}
