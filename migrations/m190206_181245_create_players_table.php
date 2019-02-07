<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%players}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%teams}}`
 */
class m190206_181245_create_players_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%players}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'team_id' => $this->integer(),
            'maps' => $this->string(),
            'kd_diff' => $this->integer(),
            'kd' => $this->float(),
            'rating' => $this->float(),
            'created_at' => $this->datetime(),
        ]);

        // creates index for column `team_id`
        $this->createIndex(
            '{{%idx-players-team_id}}',
            '{{%players}}',
            'team_id'
        );

        // add foreign key for table `{{%teams}}`
        $this->addForeignKey(
            '{{%fk-players-team_id}}',
            '{{%players}}',
            'team_id',
            '{{%teams}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%teams}}`
        $this->dropForeignKey(
            '{{%fk-players-team_id}}',
            '{{%players}}'
        );

        // drops index for column `team_id`
        $this->dropIndex(
            '{{%idx-players-team_id}}',
            '{{%players}}'
        );

        $this->dropTable('{{%players}}');
    }
}
