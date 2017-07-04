<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_field`.
*/
class m170525_084311_create_service_field_table extends Migration
{
	public $table = '{{%service_field}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_param_id' => $this->primaryKey(),
			'service_id' => $this->integer(),
			'name' => $this->string(45),
			'type' => $this->string(55),
			'sort' => $this->integer(3),
			'hidden' => $this->integer(1),
			'button' => $this->integer(1),
			'visible' => $this->string(50),
			'readonly' => $this->integer(1),
			'mask' => $this->string(25),
			'unmask' => $this->integer(1)->defaultValue(1),
			'value' => $this->string(255),
			'steps' => $this->string(),
		];
	}

	public function afterCreate()
	{
		$this->myCreateIndex('service_id');
		$this->myAddForeignKey(
			'service_id',
			'{{%service}}',
			'service_id',
			'CASCADE',
			'CASCADE'
		);
	}

}
