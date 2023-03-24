<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%owners}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%assets}}`
 * - `{{%user}}`
 */
class m220308_085141_create_owners_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%owners}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(100)->notNull(),
            'asset_id' => $this->integer()->notNull(),
            'issued_by' => $this->integer()->notNull(),
            'issued_date' => $this->integer(50)->notNull(),
            'returned_status' => $this->boolean(),
            'returned_date' => $this->integer(50),
        ]);

        // creates index for column `asset_id`
        $this->createIndex(
            '{{%idx-owners-asset_id}}',
            '{{%owners}}',
            'asset_id'
        );

        // add foreign key for table `{{%assets}}`
        $this->addForeignKey(
            '{{%fk-owners-asset_id}}',
            '{{%owners}}',
            'asset_id',
            '{{%assets}}',
            'id',
            'CASCADE'
        );

        // creates index for column `issued_by`
        $this->createIndex(
            '{{%idx-owners-issued_by}}',
            '{{%owners}}',
            'issued_by'
        );

        // add foreign key for table `{{%user}}`
        $this->addForeignKey(
            '{{%fk-owners-issued_by}}',
            '{{%owners}}',
            'issued_by',
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
            '{{%fk-owners-asset_id}}',
            '{{%owners}}'
        );

        // drops index for column `asset_id`
        $this->dropIndex(
            '{{%idx-owners-asset_id}}',
            '{{%owners}}'
        );

        // drops foreign key for table `{{%user}}`
        $this->dropForeignKey(
            '{{%fk-owners-issued_by}}',
            '{{%owners}}'
        );

        // drops index for column `issued_by`
        $this->dropIndex(
            '{{%idx-owners-issued_by}}',
            '{{%owners}}'
        );

        $this->dropTable('{{%owners}}');
    }
}
