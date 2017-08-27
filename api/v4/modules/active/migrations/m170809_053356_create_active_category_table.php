<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_category`.
*/
class m170809_053356_create_active_category_table extends Migration
{
	public $table = '{{%active_category}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'title' => $this->string()->notNull(),
			'description' => $this->string(),
			'logo' => $this->string(),
			'position' => $this->integer(),
		];
	}

	public function afterCreate()
	{
	
	}

}
