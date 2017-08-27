<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

class m170104_202556_create_user_table extends Migration
{
	
	public  $table = '{{%user}}';
	
	public function getColumns()
	{
		return [
			'id' => $this->primaryKey(),
			'login' => $this->string()->unique(),
			'username' => $this->string(),
			'email' => $this->string()->notNull()->unique(),
			'role' => $this->string()->notNull(),
			'status' => $this->smallInteger()->notNull()->defaultValue(10), // в статусе должно быть предусмотрено: активный, бан, премодерация, активация
			
			'auth_key' => $this->string(32)->notNull(),
			'password_hash' => $this->string()->notNull(),
			'password_reset_token' => $this->string(),
			
			'created_at' => $this->integer()->notNull(),
			'updated_at' => $this->integer()->notNull(),
			'balance' => $this->string(),
		];
	}
	
}
