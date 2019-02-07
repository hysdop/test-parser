<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%urls}}`.
 */
class m190206_181221_create_urls_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%urls}}', [
            'id' => $this->primaryKey(),
            'url' => $this->string()->notNull(),
            'created_at' => $this->datetime(),
        ]);
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%urls}}');
    }
}
