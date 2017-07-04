<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `summary_resource`.
*/
class m170525_125142_create_summary_resource_table extends Migration
{
	public $table = '{{%summary_resource}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'name' => $this->string(),
			'type' => $this->string(),
			'value' => $this->string(),
			'date_change' => $this->timestamp(),
		];
	}

	public function afterCreate()
	{
		$this->myAddPrimaryKey(['name', 'type']);
	}

}
