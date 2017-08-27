<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `service_field_value`.
*/
class m170703_120514_create_service_field_value_table extends Migration
{
	public $table = '{{%service_field_value}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'service_field_value_id' => $this->primaryKey(),
			'service_field_id' => $this->integer(),
			'key' => $this->string(45),
			'value' => $this->string(45),
		];
	}

	public function afterCreate()
	{
		
	}

}
