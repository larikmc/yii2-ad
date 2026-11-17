<?php

declare(strict_types=1);

namespace larikmc\ad\migrations;

use yii\db\Migration;

/**
 * Creates table `{{%ad_position}}` and `{{%ad}}` if they do not already exist.
 */
class m240101_000000_create_ad_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            $tableOptions = 'CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE=InnoDB';
        }

        if ($this->db->getTableSchema('{{%ad_position}}', true) === null) {
            $this->createTable('{{%ad_position}}', [
                'id' => $this->primaryKey(),
                'name' => $this->string(255)->notNull(),
                'category_id' => $this->integer()->notNull(),
            ], $tableOptions);

            $this->createIndex('idx_ad_position_category', '{{%ad_position}}', 'category_id');
        }

        if ($this->db->getTableSchema('{{%ad}}', true) === null) {
            $this->createTable('{{%ad}}', [
                'id' => $this->primaryKey(),
                'position_id' => $this->integer()->notNull(),
                'code' => $this->text()->notNull(),
                'ad' => $this->integer()->notNull(),
                'status' => $this->smallInteger()->notNull()->defaultValue(1),
                'config' => $this->text()->null(),
                'theme' => $this->string(255)->null(),
                'mobile' => $this->smallInteger()->notNull()->defaultValue(0),
                'margin_top' => $this->integer()->notNull()->defaultValue(0),
                'wait' => $this->integer()->notNull()->defaultValue(0),
                'frequency' => $this->integer()->notNull()->defaultValue(1),
            ], $tableOptions);

            $this->createIndex('idx_ad_position_mobile_status', '{{%ad}}', ['position_id', 'mobile', 'status']);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ad}}');
        $this->dropTable('{{%ad_position}}');
    }
}
