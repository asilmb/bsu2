<?php

use yii2lab\migration\db\MigrationCreateTable as Migration;

/**
 * Handles the creation of table `news`.
 */
class m170710_115833_create_news_table extends Migration {
	public $table = '{{%news}}';
	
	/**
	 * @inheritdoc
	 */
	public function getColumns() {
		return [
			'id' => $this->primaryKey()->unique(),
			'title' => $this->string()->notNull(),
			'underTitle' => $this->string(),
			'content' => $this->text(),
			'created_at' => $this->dateTime(),
			'update_at' => $this->dateTime(),
		];
	}
	
	public function afterCreate() {
		$this->alterColumn('{{news}}', 'id', $this->smallInteger(8) . ' NOT NULL AUTO_INCREMENT');
		$this->alterColumn('{{news}}', 'created_at', $this->dateTime() . ' NOT NULL DEFAULT NOW()');
		$this->alterColumn('{{news}}', 'update_at', $this->dateTime() . ' NOT NULL DEFAULT NOW()');
	}
	
}
