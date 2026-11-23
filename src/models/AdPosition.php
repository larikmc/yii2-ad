<?php

declare(strict_types=1);

namespace larikmc\ad\models;

use Yii;
use yii\db\ActiveRecord;
use yii\helpers\ArrayHelper;

/**
 * Model class for table "{{%ad_position}}".
 *
 * @property int $id
 * @property string $name
 * @property int $category_id
 */
class AdPosition extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%ad_position}}';
    }

    /**
     * Override formName to prevent AdBlock filters targeting "AdPosition"
     */
    public function formName(): string
    {
        return 'SlotPosition';
    }

    /**
     * Supports both new SlotPosition and legacy AdPosition payload keys.
     */
    public function load($data, $formName = null): bool
    {
        if ($formName === null) {
            if (isset($data['SlotPosition'])) {
                return parent::load($data, 'SlotPosition');
            }
            if (isset($data['AdPosition'])) {
                return parent::load($data, 'AdPosition');
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
            [['name', 'category_id'], 'required'],
            [['category_id'], 'integer'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'category_id' => 'Раздел',
        ];
    }

    /**
     * Category name
     * @return string|null
     */
    public function getCategory(): ?string
    {
        $dataCat = self::categoryList();
        return $dataCat[$this->category_id] ?? null;
    }

    /**
     * Cached category list
     * @return array<int, string>
     */
    public static function categoryList(): array
    {
        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet('ad_category_list', static function () {
                return self::defaultCategoryList();
            }, 3600);
        }

        return self::defaultCategoryList();
    }

    /**
     * Default category list mapping
     * @return array<int, string>
     */
    public static function defaultCategoryList(): array
    {
        return [
            1 => 'Раскраски',
            2 => 'Загадки',
            3 => 'Раскраски ОНЛАЙН',
            4 => 'Картинки',
            5 => 'Поздравления',
            6 => 'Мультфильмы',
            7 => 'Игры онлайн',
            8 => 'Весь сайт',
        ];
    }

    /**
     * Cached list of positions [id => name]
     * @return array<int, string>
     */
    public static function getListCached(): array
    {
        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet('ad_position_list', static function () {
                return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
            }, 3600);
        }

        return ArrayHelper::map(self::find()->asArray()->all(), 'id', 'name');
    }

    /**
     * Invalidate caches
     */
    public static function invalidateCache(): void
    {
        if (Yii::$app->cache) {
            Yii::$app->cache->delete('ad_position_list');
            Yii::$app->cache->delete('ad_category_list');
            Yii::$app->cache->delete('ad_position_cache');
            Yii::$app->cache->delete('get_all_position');
        }
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        self::invalidateCache();
    }

    /**
     * {@inheritdoc}
     */
    public function afterDelete(): void
    {
        parent::afterDelete();
        self::invalidateCache();
    }
}
