<?php

use yii\db\Migration;

/**
 * Class m191015_141521_etc_error
 */
class m191015_141521_etc_error extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
	
        $tableName = Yii::$app->db->tablePrefix . 'etc_error';
        if (!(Yii::$app->db->getTableSchema($tableName, true) === null)) {
            $this->dropTable($tableName);
        }
        $this->createTable($tableName, [
            'id' => $this->primaryKey(),
			'input_json' => $this->text()->notNull(),
			'output_json' => $this->text()->notNull(),
			'info_json' => $this->text()->notNull(),
            'created_at' =>  $this->integer()->notNull()
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m191015_141521_etc_error cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m191015_141521_etc_error cannot be reverted.\n";

        return false;
    }
    */
}
