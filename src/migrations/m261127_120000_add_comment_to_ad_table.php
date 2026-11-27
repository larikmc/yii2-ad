<?php

declare(strict_types=1);

namespace larikmc\ad\migrations;

use yii\db\Migration;

/**
 * Adds optional admin comment column to {{%ad}} table.
 */
class m261127_120000_add_comment_to_ad_table extends Migration
{
    public function safeUp()
    {
        $schema = $this->db->getTableSchema('{{%ad}}', true);
        if ($schema !== null && $schema->getColumn('comment') === null) {
            $this->addColumn(
                '{{%ad}}',
                'comment',
                $this->string(255)->null()->after('code')
            );
        }
    }

    public function safeDown()
    {
        $schema = $this->db->getTableSchema('{{%ad}}', true);
        if ($schema !== null && $schema->getColumn('comment') !== null) {
            $this->dropColumn('{{%ad}}', 'comment');
        }
    }
}
