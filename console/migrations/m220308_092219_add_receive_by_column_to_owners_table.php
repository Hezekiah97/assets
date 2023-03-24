<?php

use yii\db\Migration;

/**
 * Handles adding columns to table `{{%owners}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%user}}`
 */
class m220308_092219_add_receive_by_column_to_owners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('{{%owners}}', 'received_by', $this->integer()->notNull());

        // creates index for column `received_by`
        $this->createIndex(
            '{{%idx-owners-received_by}}',
            '{{%owners}}',
            'received_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-owners-received_by}}',
            '{{%owners}}',
            'received_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-owners-received_by}}',
            '{{%owners}}'
        );

        // drops index for column `received_by`
        $this->dropIndex(
            '{{%idx-owners-received_by}}',
            '{{%owners}}'
        );

        $this->dropColumn('{{%owners}}', 'received_by');
    }
}
