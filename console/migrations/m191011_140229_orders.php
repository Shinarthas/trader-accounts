<?php

use yii\db\Migration;

/**
 * Class m191011_140229_orders
 */
class m191011_140229_orders extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	
        $tableName = Yii::$app->db->tablePrefix . 'orders';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable($tableName);
        }
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
			'market_id' => $this->integer()->notNull(),
			'sell' => $this->integer()->notNull(),
            'currency_one' => $this->integer()->notNull(),
            'currency_two' => $this->integer()->notNull(),
			'account_id' => $this->integer()->notNull(),
			'tokens_count' => $this->float()->notNull(),
			'rate' => $this->float()->notNull(),
			'status' => $this->integer()->notNull(),
            'created_at' =>  $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191011_140229_orders cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_140229_orders cannot be reverted.\n";

        return false;
    }
    */
}
