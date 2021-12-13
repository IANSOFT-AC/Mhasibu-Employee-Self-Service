<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%testable}}`.
 */
class m201230_191444_create_testable_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%testable}}', [
            'id' => $this->primaryKey(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%testable}}');
    }
}
