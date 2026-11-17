<?php

use larikmc\ad\models\Ad;

/**
 * Ad debug preview template for local development
 *
 * @var array $ad
 * @var string $positionName
 * @var int $positionId
 * @var int $mobile
 */

$marginTop = (int)($ad['margin_top'] ?? 0);
$wait = (int)($ad['wait'] ?? 0);
$frequency = max(1, (int)($ad['frequency'] ?? 1));

$partnerId = (int)($ad['ad'] ?? 0);
$badge = '';

switch ($partnerId) {
    case Ad::PARTNER_YANDEX:
        $badge = '<img style="border-radius:6px;width:32px;height:32px;object-fit:cover;" src="/admin/img/ads-logo/yandex.jpg" alt="Yandex" onerror="this.outerHTML=\'<span class=\\\'badge bg-danger\\\'>Яндекс</span>\'">';
        break;
    case Ad::PARTNER_GOOGLE:
        $badge = '<img style="border-radius:6px;width:32px;height:32px;object-fit:cover;" src="/admin/img/ads-logo/google.jpg" alt="Google" onerror="this.outerHTML=\'<span class=\\\'badge bg-primary\\\'>Google</span>\'">';
        break;
    case Ad::PARTNER_VK:
        $badge = '<img style="border-radius:6px;width:32px;height:32px;object-fit:cover;" src="/admin/img/ads-logo/vk.svg" alt="VK" onerror="this.outerHTML=\'<span class=\\\'badge bg-info text-dark\\\'>VK</span>\'">';
        break;
    case Ad::PARTNER_MY:
        $badge = '<span class="badge bg-warning text-dark">Моя</span>';
        break;
    case Ad::PARTNER_MARKET:
        $badge = '<span class="badge bg-primary">Market</span>';
        break;
    case Ad::PARTNER_POZDRAVLENIYA:
        $badge = '<span class="badge bg-warning text-dark">Поздравления</span>';
        break;
    case Ad::PARTNER_CARAMEL:
        $badge = '<span class="badge bg-warning text-dark">Caramel</span>';
        break;
    case Ad::PARTNER_ADFINITY:
        $badge = '<span class="badge bg-warning text-dark">Adfinity</span>';
        break;
    default:
        $badge = '<span class="badge bg-secondary">Сеть #' . $partnerId . '</span>';
        break;
}

$formatLabel = ($mobile === 1) ? 'Mobile' : 'PC';
$style = $marginTop > 0 ? "margin-top: {$marginTop}px;" : '';
?>

<div class="ad-debug-card" style="<?= $style ?>background:#ffffff; border:1px dashed #cbd5e1; border-radius:12px; padding:12px 16px; margin-bottom:16px; box-shadow:0 2px 8px rgba(0,0,0,0.04); display:flex; gap:12px; align-items:center; font-family:system-ui,-apple-system,sans-serif; font-size:13px; color:#1e293b;">
    <div style="flex-shrink:0;">
        <?= $badge ?>
    </div>
    <div style="flex-grow:1; line-height:1.4;">
        <div style="font-weight:600; font-size:13px; color:#0f172a;">
            <?= htmlspecialchars($positionName, ENT_QUOTES, 'UTF-8') ?>
            <span style="font-size:11px; font-weight:normal; color:#64748b;">(#<?= (int)$positionId ?>)</span>
            <span style="display:inline-block; margin-left:6px; padding:2px 6px; font-size:11px; border-radius:4px; background:<?= $mobile === 1 ? '#fef3c7;color:#92400e;' : '#e0e7ff;color:#3730a3;' ?>">
                <?= $formatLabel ?>
            </span>
        </div>
        <div style="font-size:11px; color:#64748b; margin-top:2px;">
            <?php if ($wait > 0): ?>
                Задержка: <?= ($wait / 1000) ?>с (<?= $frequency > 1 ? 'каждому ' . $frequency : '100%' ?>)
            <?php else: ?>
                Без задержки
            <?php endif; ?>
            <?php if ($marginTop > 0): ?>
                &bull; Отступ: <?= $marginTop ?>px
            <?php endif; ?>
        </div>
    </div>
    <div style="flex-shrink:0;">
        <a href="?ad_debug=0" style="font-size:11px; color:#2563eb; text-decoration:underline;" title="Показать реальный баннер">Тест live</a>
    </div>
</div>
