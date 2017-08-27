<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `bank_bin`.
*/
class m170815_035419_create_bank_bin_table extends Migration
{
	public $table = '{{%bank_bin}}';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'bin' => $this->primaryKey(),
			'bank_id' => $this->string(),
			'payment_system' => $this->string()
		];

	}

	public function afterCreate()
	{
		
	}

}


