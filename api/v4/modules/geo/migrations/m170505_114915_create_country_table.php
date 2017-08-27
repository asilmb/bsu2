<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `country`.
*/
class m170505_114915_create_country_table extends Migration
{
	public $table = '{{%country}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'code' => $this->primaryKey(),
			'name_short' => $this->string(50),
			'name_full' => $this->string(255),
			'symb_def2' => $this->string(2),
			'symb_def3' => $this->string(3),
			'code_curr' => $this->integer(),
			'date_change' => $this->timestamp(),
		];

	}

	public function afterCreate()
	{
		//$this->myCreateIndexUnique(['name_short']);
		//$this->myCreateIndexUnique(['name_full']);
	}

}
