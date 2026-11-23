<?php

declare(strict_types=1);

namespace larikmc\ad\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model class for table "{{%ad_network}}".
 *
 * @property int $id
 * @property string $code
 * @property string $name
 * @property int|null $partner_id
 * @property int $is_auto
 * @property string $head_code
 * @property string|null $description
 * @property int $status
 * @property int $sort_order
 * @property int|null $updated_at
 */
class AdNetwork extends ActiveRecord
{
    public const CACHE_KEY_ACTIVE = 'ad_active_networks';

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ad_network}}';
    }

    /**
     * Prevent AdBlock rules targeting form names
     */
    public function formName(): string
    {
        return 'PromoNetwork';
    }

    /**
     * Support both PromoNetwork and AdNetwork payload keys
     */
    public function load($data, $formName = null): bool
    {
        if ($formName === null) {
            if (isset($data['PromoNetwork'])) {
                return parent::load($data, 'PromoNetwork');
            }
            if (isset($data['AdNetwork'])) {
                return parent::load($data, 'AdNetwork');
            }
        }

        return parent::load($data, $formName);
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['code', 'name', 'head_code'], 'required'],
            [['partner_id', 'is_auto', 'status', 'sort_order', 'updated_at'], 'integer'],
            [['head_code'], 'string'],
            [['code'], 'string', 'max' => 50],
            [['name'], 'string', 'max' => 100],
            [['description'], 'string', 'max' => 255],
            [['code'], 'unique'],
            [['status'], 'default', 'value' => 1],
            [['sort_order', 'is_auto'], 'default', 'value' => 0],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'code' => 'Ключ сети',
            'name' => 'Название сети',
            'partner_id' => 'Партнёр баннеров',
            'is_auto' => 'Авто-встраивание',
            'head_code' => 'Код для <head>',
            'description' => 'Описание',
            'status' => 'Статус в <head>',
            'sort_order' => 'Порядок',
            'updated_at' => 'Обновлено',
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function beforeSave($insert): bool
    {
        if (parent::beforeSave($insert)) {
            $this->updated_at = time();
            return true;
        }
        return false;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        static::invalidateCache();
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete(): void
    {
        parent::afterDelete();
        static::invalidateCache();
    }

    /**
     * Invalidate network cache
     */
    public static function invalidateCache(): void
    {
        if (Yii::$app->cache) {
            Yii::$app->cache->delete(self::CACHE_KEY_ACTIVE);
        }
    }

    /**
     * Get active networks for head script injection (cached)
     *
     * @param int $duration
     * @return static[]
     */
    public static function getActiveNetworks(int $duration = 3600): array
    {
        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet(self::CACHE_KEY_ACTIVE, static function () {
                return static::find()
                    ->where(['status' => 1])
                    ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
                    ->all();
            }, $duration);
        }

        return static::find()
            ->where(['status' => 1])
            ->orderBy(['sort_order' => SORT_ASC, 'id' => SORT_ASC])
            ->all();
    }

    /**
     * Toggles network status
     *
     * @return bool New status
     */
    public function toggleStatus(): bool
    {
        $this->status = $this->status ? 0 : 1;
        $this->save(false, ['status', 'updated_at']);
        return (bool) $this->status;
    }

    /**
     * Check if a specific network partner is currently active in head
     *
     * @param int $partnerId
     * @return bool
     */
    public static function isPartnerActiveInHead(int $partnerId): bool
    {
        $actives = static::getActiveNetworks();
        foreach ($actives as $network) {
            if ($network->partner_id === $partnerId) {
                return true;
            }
        }
        return false;
    }
}
