<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `bank_code`.
*/
class m170629_122036_create_bank_code_table extends Migration
{
	public $table = '{{%bank_code}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'code' => $this->integer(),
			'bik' => $this->text(),
			'name' => $this->text(),
			'bin' => $this->text(),
			'picture' => $this->string(50),
		];
	}

	public function afterCreate()
	{
		
	}

}
