<?php

declare(strict_types=1);

namespace larikmc\ad\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * Model class for table "{{%ad}}".
 *
 * @property int $id
 * @property int $position_id
 * @property string $code
 * @property int $ad
 * @property int $status
 * @property string|null $config
 * @property string|null $theme
 * @property int $mobile 0=PC, 1=Mobile, 2=PC & Mobile
 * @property int $margin_top
 * @property int $wait
 * @property int $frequency
 */
class Ad extends ActiveRecord
{
    public const PARTNER_YANDEX = 1;
    public const PARTNER_GOOGLE = 2;
    public const PARTNER_VK = 3;
    public const PARTNER_MY = 4;
    public const PARTNER_MARKET = 5;
    public const PARTNER_POZDRAVLENIYA = 6;
    public const PARTNER_CARAMEL = 7;
    public const PARTNER_ADFINITY = 8;

    public const MOBILE_PC = 0;
    public const MOBILE_MOBILE = 1;
    public const MOBILE_ALL = 2;

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ad}}';
    }

    /**
     * Override formName to prevent AdBlock filters targeting "Ad" and "field-ad-*"
     */
    public function formName(): string
    {
        return 'PromoItem';
    }

    /**
     * Supports both new PromoItem and legacy Ad payload keys.
     */
    public function load($data, $formName = null): bool
    {
        if ($formName === null) {
            if (isset($data['PromoItem'])) {
                return parent::load($data, 'PromoItem');
            }
            if (isset($data['Ad'])) {
                return parent::load($data, 'Ad');
            }
        }

        return parent::load($data, $formName);
    }

    /**
     * {@inheritdoc}
     */
    public function init(): void
    {
        parent::init();
        if ($this->config === null) {
            $this->config = '1';
        }
        if ($this->theme === null) {
            $this->theme = '1';
        }
        if ($this->frequency === null) {
            $this->frequency = 1;
        }
        if ($this->wait === null) {
            $this->wait = 0;
        }
        if ($this->margin_top === null) {
            $this->margin_top = 0;
        }
        if ($this->status === null) {
            $this->status = 1;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['position_id', 'code', 'ad', 'status', 'mobile'], 'required'],
            [['position_id', 'ad', 'status', 'mobile', 'margin_top', 'wait', 'frequency'], 'integer'],
            [['code', 'config'], 'string'],
            [['theme'], 'string', 'max' => 255],
            [['margin_top', 'wait'], 'default', 'value' => 0],
            [['frequency'], 'default', 'value' => 1],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'position_id' => 'Позиция',
            'code' => 'Код',
            'ad' => 'Реклама',
            'status' => 'Статус',
            'config' => 'Config',
            'theme' => 'Шаблон',
            'mobile' => 'Формат',
            'margin_top' => 'Отступ сверху',
            'wait' => 'Задержка',
            'frequency' => 'Показывать с задержкой',
        ];
    }

    /**
     * @return string
     */
    public function getPosition(): string
    {
        $pos = $this->getPositionFromCache();
        return $pos[$this->position_id]['name'] ?? '—';
    }

    /**
     * Cached list of positions
     * @return array
     */
    public function getPositionFromCache(): array
    {
        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet('ad_position_cache', static function () {
                return AdPosition::find()->indexBy('id')->asArray()->all();
            }, 3600);
        }

        return AdPosition::find()->indexBy('id')->asArray()->all();
    }

    /**
     * Partner choices
     * @return array<int, string>
     */
    public static function partnerList(): array
    {
        return [
            self::PARTNER_YANDEX => 'Яндекс',
            self::PARTNER_GOOGLE => 'Google',
            self::PARTNER_VK => 'VK',
            self::PARTNER_MY => 'Моя',
            self::PARTNER_MARKET => 'Market',
            self::PARTNER_POZDRAVLENIYA => 'Поздравления',
            self::PARTNER_CARAMEL => 'Caramel',
        ];
    }

    /**
     * Format choices
     * @return array<int, string>
     */
    public static function mobileList(): array
    {
        return [
            self::MOBILE_PC => 'PC',
            self::MOBILE_MOBILE => 'Mobile',
            self::MOBILE_ALL => 'PC & Mobile',
        ];
    }

    /**
     * Partner name
     * @return string
     */
    public function getAdPartnerName(): string
    {
        if ($this->ad === self::PARTNER_ADFINITY) {
            return 'Adfinity (авто-встраивание)';
        }
        $list = self::partnerList();
        return $list[$this->ad] ?? 'Неизвестно';
    }

    /**
     * Partner badge markup
     * @return string
     */
    public function getAdPartnerBadge(): string
    {
        switch ($this->ad) {
            case self::PARTNER_YANDEX:
                return '<img width="40px" style="border-radius:4px" src="/admin/img/ads-logo/yandex.jpg" alt="Yandex" onerror="this.outerHTML=\'<span class=\\\'badge bg-danger\\\'>Яндекс</span>\'">';
            case self::PARTNER_GOOGLE:
                return '<img width="40px" style="border-radius:4px" src="/admin/img/ads-logo/google.jpg" alt="Google" onerror="this.outerHTML=\'<span class=\\\'badge bg-primary\\\'>Google</span>\'">';
            case self::PARTNER_VK:
                return '<img width="40px" style="border-radius:4px" src="/admin/img/ads-logo/vk.svg" alt="VK" onerror="this.outerHTML=\'<span class=\\\'badge bg-info text-dark\\\'>VK</span>\'">';
            case self::PARTNER_MY:
                return '<span class="badge text-bg-warning">Моя</span>';
            case self::PARTNER_MARKET:
                return '<span class="badge text-bg-primary">Market</span>';
            case self::PARTNER_POZDRAVLENIYA:
                return '<span class="badge text-bg-warning">Поздравления</span>';
            case self::PARTNER_CARAMEL:
                return '<span class="badge text-bg-warning">Caramel</span>';
            case self::PARTNER_ADFINITY:
                return '<span class="badge text-bg-warning">Adfinity</span>';
            default:
                return '<span class="badge bg-secondary">' . (int)$this->ad . '</span>';
        }
    }

    /**
     * Invalidate ad cache entries
     */
    public function invalidateAdCache(): void
    {
        $caches = [];
        if (Yii::$app->cache) {
            $caches[] = Yii::$app->cache;
        }
        if (Yii::$app->has('frontendCache')) {
            $caches[] = Yii::$app->get('frontendCache');
        }

        foreach ($caches as $cache) {
            $cache->delete('ads' . $this->position_id . '-0');
            $cache->delete('ads' . $this->position_id . '-1');
            $cache->delete('ad_position_cache');
            $cache->delete('get_all_position');
        }

        if (class_exists('\\backend\\helpers\\AppCacheHelper')) {
            try {
                \backend\helpers\AppCacheHelper::clearAll();
            } catch (\Throwable $e) {
                // Ignore if in different environment
            }
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        $this->invalidateAdCache();
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete(): void
    {
        parent::afterDelete();
        $this->invalidateAdCache();
    }
}
