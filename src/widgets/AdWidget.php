<?php

declare(strict_types=1);

namespace larikmc\ad\widgets;

use larikmc\ad\models\Ad;
use larikmc\ad\models\AdPosition;
use Yii;
use yii\base\Widget;

/**
 * AdWidget renders targeted advertising banners with optional delayed loading,
 * device detection, and debug previews.
 *
 * Example usage:
 * ```php
 * echo \larikmc\ad\widgets\AdWidget::widget(['position_id' => 1]);
 * ```
 */
class AdWidget extends Widget
{
    /**
     * @var int Advertising position ID (from ad_position table)
     */
    public int $position_id;

    /**
     * @var bool|null Force mobile (true) or desktop (false). Null = auto-detect.
     */
    public ?bool $isMobile = null;

    /**
     * @var bool|null Show debug badge instead of real banner.
     * Null = auto (true in dev environment on local IPs).
     */
    public ?bool $showDebug = null;

    /**
     * @var int Cache TTL in seconds.
     */
    public int $cacheDuration = 3600;

    /**
     * {@inheritdoc}
     */
    public function getViewPath(): string
    {
        return __DIR__ . DIRECTORY_SEPARATOR . 'views';
    }

    /**
     * {@inheritdoc}
     */
    public function run(): string
    {
        if (empty($this->position_id)) {
            return '';
        }

        $mobile = $this->detectMobile() ? Ad::MOBILE_MOBILE : Ad::MOBILE_PC;
        $ad = static::getAd($this->position_id, $mobile, $this->cacheDuration);

        if (!$ad) {
            return '';
        }

        $isDebug = $this->resolveDebugState();

        if ($isDebug) {
            $positions = static::getAllPositions($this->cacheDuration);
            $positionName = $positions[$this->position_id]['name'] ?? ('Позиция #' . $this->position_id);

            return $this->render('debug', [
                'ad' => $ad,
                'positionName' => $positionName,
                'positionId' => $this->position_id,
                'mobile' => $mobile,
            ]);
        }

        return $this->render('ad', [
            'ad' => $ad,
            'positionId' => $this->position_id,
        ]);
    }

    /**
     * Detects whether the current request is from a mobile device
     * @return bool
     */
    protected function detectMobile(): bool
    {
        if ($this->isMobile !== null) {
            return $this->isMobile;
        }

        if (class_exists('\\frontend\\controllers\\AppController') && method_exists('\\frontend\\controllers\\AppController', 'isMobile')) {
            try {
                return (bool)\frontend\controllers\AppController::isMobile();
            } catch (\Throwable $e) {
                // fallback
            }
        }

        if (isset(Yii::$app->params['isMobile'])) {
            return (bool)Yii::$app->params['isMobile'];
        }

        $userAgent = Yii::$app->request->headers->get('User-Agent', '');
        return (bool)preg_match('/Mobile|Android|Silk\/|Kindle|BlackBerry|Opera Mini|Opera Mobi|iPhone|iPod/i', $userAgent);
    }

    /**
     * Resolves whether debug mode should be shown
     * @return bool
     */
    protected function resolveDebugState(): bool
    {
        if ($this->showDebug !== null) {
            return $this->showDebug;
        }

        $userIp = Yii::$app->request->userIP;
        $isLocalIp = in_array($userIp, ['127.0.0.1', '::1', 'localhost'], true);
        $urlOverride = Yii::$app->request->get('ad_debug');

        if ($urlOverride !== null) {
            return (bool)$urlOverride;
        }

        return (defined('YII_ENV') && YII_ENV === 'dev') && $isLocalIp;
    }

    /**
     * Fetches cached active ad by position and device format
     *
     * @param int $positionId
     * @param int $mobile
     * @param int $cacheDuration
     * @return array|null
     */
    public static function getAd(int $positionId, int $mobile, int $cacheDuration = 3600): ?array
    {
        $cacheKey = 'ads' . $positionId . '-' . $mobile;
        $duration = Yii::$app->params['cash_time'] ?? $cacheDuration;

        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet($cacheKey, static function () use ($positionId, $mobile) {
                return Ad::find()
                    ->where(['position_id' => $positionId, 'status' => 1])
                    ->andWhere(['in', 'mobile', [$mobile, Ad::MOBILE_ALL]])
                    ->asArray()
                    ->one();
            }, $duration);
        }

        return Ad::find()
            ->where(['position_id' => $positionId, 'status' => 1])
            ->andWhere(['in', 'mobile', [$mobile, Ad::MOBILE_ALL]])
            ->asArray()
            ->one();
    }

    /**
     * Fetches all cached positions indexed by id
     *
     * @param int $cacheDuration
     * @return array
     */
    public static function getAllPositions(int $cacheDuration = 3600): array
    {
        $duration = Yii::$app->params['cash_time'] ?? $cacheDuration;

        if (Yii::$app->cache) {
            return Yii::$app->cache->getOrSet('get_all_position', static function () {
                return AdPosition::find()->indexBy('id')->asArray()->all();
            }, $duration);
        }

        return AdPosition::find()->indexBy('id')->asArray()->all();
    }
}
