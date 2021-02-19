<?php

use yii\db\Migration;

/**
 * Class m210218_173649_taskListTable
 */
class m210218_173649_taskListTable extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('task_list', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'description' => $this->text()->notNull(),
            'create_date' => $this->timestamp(),
            'is_done' => $this->boolean()->defaultValue(0),
        ]);

        $this->createIndex(
            'idx-task_list-title',
            'task_list',
            'title'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m210218_173649_taskListTable cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m210218_173649_taskListTable cannot be reverted.\n";

        return false;
    }
    */
}
