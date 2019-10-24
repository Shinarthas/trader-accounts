<?php

use yii\db\Migration;

/**
 * Class m191024_113011_proxy
 */
class m191024_113011_proxy extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableName = Yii::$app->db->tablePrefix . 'proxy';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable($tableName);
        }
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
			'address' => $this->string()->notNull(),
			'country' => $this->string()->notNull(),
            'active' => $this->integer()->notNull(),
            'available' => $this->integer()->notNull(),
			'last_check' => $this->integer()->notNull(),
			'speed' => $this->integer()->notNull(),
            'errors' =>  $this->integer()->notNull(),
			'downloaded_at' =>  $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191024_113011_proxy cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191024_113011_proxy cannot be reverted.\n";

        return false;
    }
    */
}
