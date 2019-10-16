<?php

use yii\db\Migration;

/**
 * Class m191011_132252_accounts
 */
class m191011_132252_accounts extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('account', [
            'id' => $this->primaryKey(),
			'type' => $this->integer()->notNull(),
            'name' => $this->string()->notNull(),
			'country' => $this->string()->notNull(),
			'last_proxy_id' => $this->integer()->notNull(),
			'data_json' => $this->text()->notNull(),
			'created_at' => $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191011_132252_accounts cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191011_132252_accounts cannot be reverted.\n";

        return false;
    }
    */
}
