<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%records}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%assets}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m220307_054252_create_records_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%records}}', [
            'id' => $this->primaryKey(),
            'asset_id' => $this->integer()->notNull(),
            'returned_by' => $this->integer()->notNull(),
            'received_by' => $this->integer()->notNull(),
            'returned_date' => $this->integer()->notNull(),
        ]);

        // creates index for column `asset_id`
        $this->createIndex(
            '{{%idx-records-asset_id}}',
            '{{%records}}',
            'asset_id'
        );

        // add foreign key for table `{{%assets}}`
        $this->addForeignKey(
            '{{%fk-records-asset_id}}',
            '{{%records}}',
            'asset_id',
            '{{%assets}}',
            'id',
            'CASCADE'
        );

        // creates index for column `returned_by`
        $this->createIndex(
            '{{%idx-records-returned_by}}',
            '{{%records}}',
            'returned_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-records-returned_by}}',
            '{{%records}}',
            'returned_by',
            '{{%user}}',
            'id',
            'CASCADE'
        );

        // creates index for column `received_by`
        $this->createIndex(
            '{{%idx-records-received_by}}',
            '{{%records}}',
            'received_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-records-received_by}}',
            '{{%records}}',
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
        // drops foreign key for table `{{%assets}}`
        $this->dropForeignKey(
            '{{%fk-records-asset_id}}',
            '{{%records}}'
        );

        // drops index for column `asset_id`
        $this->dropIndex(
            '{{%idx-records-asset_id}}',
            '{{%records}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-records-returned_by}}',
            '{{%records}}'
        );

        // drops index for column `returned_by`
        $this->dropIndex(
            '{{%idx-records-returned_by}}',
            '{{%records}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-records-received_by}}',
            '{{%records}}'
        );

        // drops index for column `received_by`
        $this->dropIndex(
            '{{%idx-records-received_by}}',
            '{{%records}}'
        );

        $this->dropTable('{{%records}}');
    }
}
