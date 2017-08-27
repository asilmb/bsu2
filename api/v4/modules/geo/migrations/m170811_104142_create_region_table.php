<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `region`.
*/
class m170811_104142_create_region_table extends Migration
{
	public $table = '{{%region}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'country_id' => $this->integer(),
			'title' => $this->string(),
			'date_change' => $this->timestamp(),
		];

	}

	public function afterCreate()
	{
		
	}

}
