<?php

declare(strict_types=1);

namespace larikmc\ad\migrations;

use yii\db\Migration;

/**
 * Creates table `{{%ad_network}}` for head scripts and auto-ad networks management.
 */
class m261123_120000_create_ad_network_table extends Migration
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

        if ($this->db->getTableSchema('{{%ad_network}}', true) === null) {
            $this->createTable('{{%ad_network}}', [
                'id' => $this->primaryKey(),
                'code' => $this->string(50)->notNull()->unique(),
                'name' => $this->string(100)->notNull(),
                'partner_id' => $this->integer()->null(),
                'is_auto' => $this->smallInteger()->notNull()->defaultValue(0),
                'head_code' => $this->text()->notNull(),
                'description' => $this->string(255)->null(),
                'status' => $this->smallInteger()->notNull()->defaultValue(1),
                'sort_order' => $this->integer()->notNull()->defaultValue(0),
                'updated_at' => $this->integer()->null(),
            ], $tableOptions);

            $this->createIndex('idx_ad_network_status_sort', '{{%ad_network}}', ['status', 'sort_order']);
            $this->createIndex('idx_ad_network_partner', '{{%ad_network}}', 'partner_id');

            $time = time();
            $this->batchInsert('{{%ad_network}}', [
                'code', 'name', 'partner_id', 'is_auto', 'head_code', 'description', 'status', 'sort_order', 'updated_at'
            ], [
                [
                    'yandex',
                    'Яндекс РТБ',
                    1,
                    0,
                    "<script>window.yaContextCb = window.yaContextCb || [];</script>\n<script src=\"https://yandex.ru/ads/system/context.js\" async></script>",
                    'Библиотека контекстной рекламы Яндекс (context.js). Необходима для работы баннеров Яндекса.',
                    1,
                    10,
                    $time,
                ],
                [
                    'caramel',
                    'Digital Caramel',
                    7,
                    0,
                    "<script async src=\"https://cdn.digitalcaramel.com/caramel.js\"></script>",
                    'Библиотека Digital Caramel (caramel.js). Необходима для работы баннеров Caramel.',
                    1,
                    20,
                    $time,
                ],
                [
                    'adfinity',
                    'Adfinity (авто-встраивание)',
                    8,
                    1,
                    "<script src=\"https://cdn.adfinity.pro/code/2karandasha.ru/adfinity.js\" charset=\"utf-8\" async></script>",
                    'Авто-встраиваемые форматы Adfinity. Скрипт сам размещает рекламу в контенте, баннеры в позициях не требуются.',
                    1,
                    30,
                    $time,
                ],
                [
                    'mps',
                    'MPS / Mediascope',
                    null,
                    1,
                    "<script src=\"https://statika.mpsuadv.ru/scripts/7390.js\" async></script>",
                    'Внешний рекламный загрузчик MPS / Mediascope.',
                    1,
                    40,
                    $time,
                ],
            ]);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        $this->dropTable('{{%ad_network}}');
    }
}
