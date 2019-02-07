<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%teams}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%urls}}`
 */
class m190206_181236_create_teams_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%teams}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'url_id' => $this->integer()->notNull()->unique(),
            'maps_played' => $this->integer(),
            'wins' => $this->integer(),
            'draws' => $this->integer(),
            'losses' => $this->integer(),
            'total_kills' => $this->integer(),
            'total_deaths' => $this->integer(),
            'rounds_played' => $this->integer(),
            'kd_ratio' => $this->float(),
            'created_at' => $this->datetime(),
        ]);

        // creates index for column `url_id`
        $this->createIndex(
            '{{%idx-teams-url_id}}',
            '{{%teams}}',
            'url_id'
        );

        // add foreign key for table `{{%urls}}`
        $this->addForeignKey(
            '{{%fk-teams-url_id}}',
            '{{%teams}}',
            'url_id',
            '{{%urls}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%urls}}`
        $this->dropForeignKey(
            '{{%fk-teams-url_id}}',
            '{{%teams}}'
        );

        // drops index for column `url_id`
        $this->dropIndex(
            '{{%idx-teams-url_id}}',
            '{{%teams}}'
        );

        $this->dropTable('{{%teams}}');
    }
}
