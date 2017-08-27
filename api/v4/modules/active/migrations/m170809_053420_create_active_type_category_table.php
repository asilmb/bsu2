<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_type_category`.
*/
class m170809_053420_create_active_type_category_table extends Migration
{
	public $table = '{{%active_type_category}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'active_id' => $this->integer()->notNull(),
			'category_id' => $this->integer()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'active_id',
			'{{%active}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->myAddForeignKey(
			'category_id',
			'{{%active_category}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}
