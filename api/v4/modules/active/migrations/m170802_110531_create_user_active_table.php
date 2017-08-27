<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
* Handles the creation of table `active_user`.
*/
class m170802_110531_create_user_active_table extends Migration
{
	public $table = '{{%user_active}}';
	public $comment = 'Значения активов пользователя';

	/**
	 * @inheritdoc
	 */
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'user_id' => $this->integer()->notNull()->comment('ID пользователя'),
			'active_id' => $this->integer()->notNull()->comment('ID типа актива'),
			'provider_id' => $this->integer()->notNull()->comment('ID провайдера актива'),
			'currency_code' => $this->integer()->notNull()->comment('Валюта'),
			'amount' => $this->double()->notNull()->comment('Итоговая сумма'),
			'data' => $this->string()->notNull()->comment('Массив значений полей'),
		];
	}

	public function afterCreate()
	{
		//$this->myCreateIndexUnique(['user_id', 'active_id']);
		$this->myAddForeignKey(
			'active_id',
			'{{%active}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->myAddForeignKey(
			'provider_id',
			'{{%active_provider}}',
			'id',
			'CASCADE',
			'CASCADE'
		);
		$this->myAddForeignKey(
			'currency_code',
			'{{%currency}}',
			'code',
			'CASCADE',
			'CASCADE'
		);
	}

}
