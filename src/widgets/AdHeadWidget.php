<?php

declare(strict_types=1);

namespace larikmc\ad\widgets;

use larikmc\ad\models\AdNetwork;
use Yii;
use yii\base\Widget;

/**
 * AdHeadWidget renders active advertising network libraries and head scripts.
 *
 * Example usage in views/layouts/_head.php:
 * ```php
 * <?= \larikmc\ad\widgets\AdHeadWidget::widget() ?>
 * ```
 */
class AdHeadWidget extends Widget
{
    /**
     * @var bool Skip injection on local dev IPs (127.0.0.1, ::1, localhost).
     */
    public bool $ignoreLocalIps = true;

    /**
     * @var array List of local IPs to bypass
     */
    public array $localIps = ['127.0.0.1', '::1', 'localhost'];

    /**
     * @var int Cache duration in seconds for active networks query
     */
    public int $cacheDuration = 3600;

    /**
     * {@inheritdoc}
     */
    public function run(): string
    {
        if ($this->ignoreLocalIps) {
            $userIp = Yii::$app->request->userIP;
            if (in_array($userIp, $this->localIps, true)) {
                return "<!-- AdHeadWidget: bypassed for local IP {$userIp} -->\n";
            }
        }

        try {
            $networks = AdNetwork::getActiveNetworks($this->cacheDuration);
        } catch (\Throwable $e) {
            Yii::error("AdHeadWidget failed to load networks: " . $e->getMessage(), __METHOD__);
            return "<!-- AdHeadWidget: error loading networks -->\n";
        }

        if (empty($networks)) {
            return "<!-- AdHeadWidget: no active networks -->\n";
        }

        $output = ["<!-- AdHeadWidget: start active advertising networks -->"];
        foreach ($networks as $network) {
            $code = trim((string) $network->head_code);
            if ($code !== '') {
                $output[] = "<!-- Network: " . htmlspecialchars($network->name, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8') . " -->";
                $output[] = $code;
            }
        }
        $output[] = "<!-- AdHeadWidget: end active advertising networks -->\n";

        return implode("\n", $output);
    }
}
