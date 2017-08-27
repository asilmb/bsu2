<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active`.
*/
class m170802_091642_create_active_table extends Migration
{
	public $table = '{{%active}}';
	public $comment = 'Типы активов';
	
	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'parent_id' => $this->integer()->comment('ID родительского типа актива'),
			'handler_id' => $this->integer()->comment('ID обработчика'),
			'title' => $this->string()->notNull(),
		];
	}

	public function afterCreate()
	{
		$this->myAddForeignKey(
			'parent_id',
			'{{%active}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
	}

}
