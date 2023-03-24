<?php

use yii\db\Migration;

/**
 * Handles the creation of table `{{%assets}}`.
 * Has foreign keys to the tables:
 *
 * - `{{%categories}}`
 * - `{{%user}}`
 * - `{{%user}}`
 * - `{{%user}}`
 */
class m220307_053938_create_assets_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('{{%assets}}', [
            'id' => $this->primaryKey(),
            'category' => $this->integer()->notNull(),
            'asset_code' => $this->string(100),
            'condition' => $this->string(50)->notNull(),
            'status' => $this->boolean()->notNull(),
            'asset_particulars' => $this->text()->notNull(),
            'extra_note' => $this->text(),
        ]);

        // creates index for column `category`
        $this->createIndex(
            '{{%idx-assets-category}}',
            '{{%assets}}',
            'category'
        );

        // add foreign key for table `{{%categories}}`
        $this->addForeignKey(
            '{{%fk-assets-category}}',
            '{{%assets}}',
            'category',
            '{{%categories}}',
            'id',
            'CASCADE'
        );


    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        // drops foreign key for table `{{%categories}}`
        $this->dropForeignKey(
            '{{%fk-assets-category}}',
            '{{%assets}}'
        );

        // drops index for column `category`
        $this->dropIndex(
            '{{%idx-assets-category}}',
            '{{%assets}}'
        );


        $this->dropTable('{{%assets}}');
    }
}
