<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `currency`.
*/
class m170428_160208_create_currency_table extends Migration
{
	public $table = '{{%currency}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'code' => $this->primaryKey(),
			'symb_def' => $this->string(3),
			'name_cur' => $this->string(45),
			'descr' => $this->string(255),
		];

	}

	public function afterCreate()
	{
		
	}

}
