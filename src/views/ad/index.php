<?php

use larikmc\ad\helpers\ViewHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel larikmc\ad\models\AdSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data array */

$this->title = 'Реклама';
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<'CSS'
/* =========================================================================
   AD PROMO MODULE — MODERN DESIGN SYSTEM (LIGHT & DARK THEMES)
   Compatible with /admin/ui-kit specification
   ========================================================================= */

.promo-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* 1. Шапка страницы */
.promo-header-card {
    background: var(--sz-surface, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: var(--sz-radius-md, 20px);
    padding: 18px 24px;
    box-shadow: var(--sz-shadow, 0 10px 30px rgba(0, 0, 0, 0.03));
}
html.dark .promo-header-card,
body.dark .promo-header-card {
    background: #17243c;
    border-color: #2c3f5d;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.promo-header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}
.promo-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.promo-header-icon {
    width: 48px;
    height: 48px;
    border-radius: 14px;
    background: var(--sz-primary-soft, rgba(49, 137, 247, 0.12));
    color: var(--sz-primary, #3189f7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 26px;
    flex-shrink: 0;
}
html.dark .promo-header-icon,
body.dark .promo-header-icon {
    background: rgba(49, 137, 247, 0.22);
    color: #5ea4ff;
}
.promo-header-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--sz-text, #14294d);
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0;
}
.promo-header-subtitle {
    font-size: 13px;
    color: var(--sz-muted, #7b93be);
    margin-top: 3px;
}
.promo-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* Кнопки в стиле UI-Kit */
.promo-btn-hub {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 16px;
    font-size: 13.5px;
    font-weight: 600;
    border-radius: 12px;
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.18));
    background: var(--sz-surface-strong, #ffffff);
    color: var(--sz-text, #14294d);
    text-decoration: none !important;
    transition: all 0.18s ease;
}
.promo-btn-hub:hover {
    background: var(--sz-primary-soft, rgba(49, 137, 247, 0.1));
    border-color: var(--sz-primary, #3189f7);
    color: var(--sz-primary, #3189f7);
}
html.dark .promo-btn-hub,
body.dark .promo-btn-hub {
    background: #1d2c46;
    border-color: #384f73;
    color: #dce8ff;
}
html.dark .promo-btn-hub:hover,
body.dark .promo-btn-hub:hover {
    background: rgba(49, 137, 247, 0.2);
    border-color: #5ea4ff;
    color: #87bbff;
}

.promo-btn-add {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    font-size: 13.5px;
    font-weight: 600;
    border-radius: 12px;
    border: 0;
    background: linear-gradient(135deg, #079b70 0%, #05825e 100%);
    color: #ffffff !important;
    text-decoration: none !important;
    box-shadow: 0 4px 14px rgba(7, 155, 112, 0.3);
    transition: all 0.18s ease;
}
.promo-btn-add:hover {
    background: linear-gradient(135deg, #08ad7e 0%, #06966c 100%);
    box-shadow: 0 6px 18px rgba(7, 155, 112, 0.42);
    transform: translateY(-1px);
}

/* 2. Карточка загрузчиков в <head> */
.promo-head-card {
    background: var(--sz-surface, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: var(--sz-radius-md, 20px);
    padding: 16px 20px;
    box-shadow: var(--sz-shadow, 0 10px 30px rgba(0, 0, 0, 0.03));
}
html.dark .promo-head-card,
body.dark .promo-head-card {
    background: #17243c;
    border-color: #2c3f5d;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.promo-head-card__header {
    display: flex;
    justify-content: space-between;
    align-items: center;
    margin-bottom: 12px;
    flex-wrap: wrap;
    gap: 8px;
}
.promo-head-card__title {
    display: inline-flex;
    align-items: center;
    gap: 8px;
    font-size: 13.5px;
    font-weight: 700;
    color: var(--sz-text, #14294d);
}
.promo-code-badge {
    font-family: 'JetBrains Mono', Consolas, Monaco, monospace;
    font-size: 12px;
    font-weight: 600;
    padding: 2px 7px;
    border-radius: 6px;
    background: rgba(49, 137, 247, 0.12);
    color: var(--sz-primary, #3189f7);
    border: 1px solid rgba(49, 137, 247, 0.2);
}
html.dark .promo-code-badge,
body.dark .promo-code-badge {
    background: rgba(49, 137, 247, 0.22);
    color: #87bbff;
    border-color: rgba(49, 137, 247, 0.35);
}

.promo-head-card__link {
    font-size: 12.5px;
    font-weight: 600;
    color: var(--sz-primary, #3189f7);
    text-decoration: none !important;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    transition: all 0.15s ease;
}
.promo-head-card__link:hover {
    color: var(--sz-primary-hover, #2178e6);
    transform: translateX(2px);
}
html.dark .promo-head-card__link,
body.dark .promo-head-card__link {
    color: #87bbff;
}

/* Сетка переключателей загрузчиков (совместимо с .ui-kit-toggle-item) */
.promo-toggles-grid {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    align-items: center;
}

.ui-kit-toggle-item {
    display: inline-flex;
    align-items: center;
    justify-content: space-between;
    gap: 10px;
    padding: 6px 6px 6px 14px;
    background: var(--sz-surface-strong, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: 999px;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.04);
    transition: all 0.18s ease;
}
.ui-kit-toggle-item:hover {
    border-color: var(--sz-line-strong, rgba(40, 52, 82, 0.22));
    box-shadow: 0 3px 8px rgba(0, 0, 0, 0.06);
}
html.dark .ui-kit-toggle-item,
body.dark .ui-kit-toggle-item {
    background: #111a2c;
    border-color: #2b3d56;
    box-shadow: 0 2px 6px rgba(0, 0, 0, 0.22);
}
html.dark .ui-kit-toggle-item:hover,
body.dark .ui-kit-toggle-item:hover {
    border-color: #3f5678;
    box-shadow: 0 4px 12px rgba(0, 0, 0, 0.35);
}

.ui-kit-toggle-label {
    display: inline-flex;
    align-items: center;
    font-size: 13px;
    font-weight: 600;
    color: var(--sz-text, #14294d);
    letter-spacing: -0.01em;
    user-select: none;
}
html.dark .ui-kit-toggle-label,
body.dark .ui-kit-toggle-label {
    color: #dce8ff;
}

/* Пульсирующая точка статуса */
.ui-kit-status-dot {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    margin-right: 9px;
    background: #e24e6c;
    box-shadow: 0 0 0 2px rgba(226, 78, 108, 0.2);
    display: inline-block;
    flex-shrink: 0;
    transition: all 0.2s ease;
}
.ui-kit-status-dot.is-active {
    background: #079b70;
    box-shadow: 0 0 0 2.5px rgba(7, 155, 112, 0.25);
    animation: szDotPulse 2.4s infinite ease-in-out;
}
@keyframes szDotPulse {
    0% { box-shadow: 0 0 0 2px rgba(7, 155, 112, 0.25); }
    50% { box-shadow: 0 0 0 5px rgba(7, 155, 112, 0.08); }
    100% { box-shadow: 0 0 0 2px rgba(7, 155, 112, 0.25); }
}

/* Фиксированный двухпозиционный переключатель [ Вкл | Откл ] */
.ui-kit-segmented-control {
    display: inline-flex;
    align-items: center;
    padding: 2px;
    background: rgba(113, 157, 235, 0.12);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: 999px;
    user-select: none;
    flex-shrink: 0;
}
html.dark .ui-kit-segmented-control,
body.dark .ui-kit-segmented-control {
    background: #0d1524;
    border-color: #203148;
}

.ui-kit-seg-btn {
    border: 0;
    background: transparent;
    padding: 2px 11px;
    border-radius: 999px;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1.35;
    color: var(--sz-muted, #7b93be);
    cursor: pointer;
    text-decoration: none !important;
    display: inline-block;
    transition: all 0.15s ease-in-out;
}
.ui-kit-seg-btn:hover {
    color: var(--sz-text, #14294d);
}
html.dark .ui-kit-seg-btn:hover,
body.dark .ui-kit-seg-btn:hover {
    color: #ffffff;
}

/* Левая позиция: Вкл */
.ui-kit-seg-btn--on.is-active {
    background: #079b70;
    color: #ffffff !important;
    font-weight: 750;
    cursor: default;
    box-shadow: 0 2px 6px rgba(7, 155, 112, 0.35);
}
/* Правая позиция: Откл */
.ui-kit-seg-btn--off.is-active {
    background: #e24e6c;
    color: #ffffff !important;
    font-weight: 750;
    cursor: default;
    box-shadow: 0 2px 6px rgba(226, 78, 108, 0.35);
}

/* 3. Карточка Adfinity (авто-встраиваемые форматы) */
.promo-callout-card {
    display: flex;
    align-items: flex-start;
    gap: 16px;
    background: linear-gradient(135deg, rgba(49, 137, 247, 0.05) 0%, rgba(40, 101, 190, 0.08) 100%);
    border: 1px solid rgba(49, 137, 247, 0.22);
    border-left: 4px solid var(--sz-primary, #3189f7);
    border-radius: var(--sz-radius-md, 20px);
    padding: 16px 22px;
    box-shadow: var(--sz-shadow, 0 8px 24px rgba(0, 0, 0, 0.02));
    transition: all 0.18s ease;
}
html.dark .promo-callout-card,
body.dark .promo-callout-card {
    background: linear-gradient(135deg, rgba(49, 137, 247, 0.12) 0%, rgba(18, 29, 50, 0.75) 100%);
    border-color: rgba(49, 137, 247, 0.32);
    border-left-color: #3189f7;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.promo-callout-icon {
    width: 44px;
    height: 44px;
    border-radius: 12px;
    background: rgba(49, 137, 247, 0.15);
    color: var(--sz-primary, #3189f7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 24px;
    flex-shrink: 0;
}
html.dark .promo-callout-icon,
body.dark .promo-callout-icon {
    background: rgba(49, 137, 247, 0.24);
    color: #6bb0ff;
}

.promo-callout-body {
    flex: 1;
}
.promo-callout-title {
    display: flex;
    align-items: center;
    gap: 8px;
    font-size: 14.5px;
    font-weight: 700;
    color: var(--sz-text, #14294d);
    margin-bottom: 6px;
}
html.dark .promo-callout-title,
body.dark .promo-callout-title {
    color: #eef4ff;
}
.promo-callout-desc {
    font-size: 13.5px;
    line-height: 1.55;
    color: var(--sz-text, #14294d);
    opacity: 0.92;
    margin: 0;
}
html.dark .promo-callout-desc,
body.dark .promo-callout-desc {
    color: #c9dbfa;
    opacity: 1;
}

.promo-callout-footer {
    display: flex;
    align-items: center;
    gap: 12px;
    margin-top: 12px;
    padding-top: 10px;
    border-top: 1px dashed var(--sz-line, rgba(40, 52, 82, 0.14));
    flex-wrap: wrap;
}
html.dark .promo-callout-footer,
body.dark .promo-callout-footer {
    border-top-color: #2b3d56;
}

/* 4. Предупреждение о рассинхронизации (Alert) */
.promo-warning-card {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 16px;
    background: rgba(238, 166, 60, 0.08);
    border: 1px solid rgba(238, 166, 60, 0.28);
    border-left: 4px solid #eea63c;
    border-radius: 16px;
    padding: 14px 20px;
}
html.dark .promo-warning-card,
body.dark .promo-warning-card {
    background: rgba(238, 166, 60, 0.14);
    border-color: rgba(238, 166, 60, 0.38);
    border-left-color: #eea63c;
}
.promo-warning-body {
    display: flex;
    align-items: center;
    gap: 12px;
    font-size: 13.5px;
    color: var(--sz-text, #14294d);
}
html.dark .promo-warning-body,
body.dark .promo-warning-body {
    color: #ffeed3;
}
.promo-warning-icon {
    font-size: 24px;
    color: #eea63c;
    flex-shrink: 0;
}

/* 5. Таблица баннеров */
.promo-table-panel {
    background: var(--sz-surface, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: var(--sz-radius-md, 20px);
    padding: 20px;
    box-shadow: var(--sz-shadow, 0 10px 30px rgba(0, 0, 0, 0.03));
}
html.dark .promo-table-panel,
body.dark .promo-table-panel {
    background: #17243c;
    border-color: #2c3f5d;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.promo-table-panel .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.promo-table-panel .grid-view table {
    min-width: 1100px;
    margin-bottom: 0;
}

/* Пастельные бейджи Soft Badges из UI-Kit */
.badge-soft-success { background: rgba(7, 155, 112, 0.12) !important; color: #079b70 !important; font-weight: 600; font-size: 12px; }
.badge-soft-warning { background: rgba(238, 166, 60, 0.14) !important; color: #c48016 !important; font-weight: 600; font-size: 12px; }
.badge-soft-danger  { background: rgba(226, 78, 108, 0.12) !important; color: #e24e6c !important; font-weight: 600; font-size: 12px; }
.badge-soft-primary { background: rgba(49, 137, 247, 0.12) !important; color: #3189f7 !important; font-weight: 600; font-size: 12px; }
.badge-soft-info    { background: rgba(40, 101, 190, 0.12) !important; color: #2865be !important; font-weight: 600; font-size: 12px; }

html.dark .badge-soft-success, body.dark .badge-soft-success { background: rgba(7, 155, 112, 0.22) !important; color: #4ae0b1 !important; }
html.dark .badge-soft-warning, body.dark .badge-soft-warning { background: rgba(238, 166, 60, 0.22) !important; color: #ffc46a !important; }
html.dark .badge-soft-danger, body.dark .badge-soft-danger  { background: rgba(226, 78, 108, 0.22) !important; color: #ff849d !important; }
html.dark .badge-soft-primary, body.dark .badge-soft-primary { background: rgba(49, 137, 247, 0.22) !important; color: #87bbff !important; }
html.dark .badge-soft-info, body.dark .badge-soft-info    { background: rgba(40, 101, 190, 0.22) !important; color: #8cb8f8 !important; }

/* Код баннера */
.promo-code-block {
    margin: 0;
    white-space: pre-wrap;
    word-break: break-word;
    overflow-wrap: anywhere;
    max-width: 620px;
    font-size: 12px;
    font-family: 'JetBrains Mono', Consolas, Monaco, monospace;
    background: #f8fafc;
    border: 1px solid #e2e8f0;
    border-radius: 8px;
    padding: 6px 10px;
    color: #0f172a;
    line-height: 1.45;
}
html.dark .promo-code-block,
body.dark .promo-code-block {
    background: #0f172a;
    border-color: #1e293b;
    color: #94a3b8;
}
CSS
);

$networks = $data['networks'] ?? [];
$headSyncWarnings = $data['headSyncWarnings'] ?? [];
?>

<div class="promo-container promo-index-panel">

    <!-- 1. ШАПКА РАЗДЕЛА -->
    <div class="promo-header-card">
        <div class="promo-header-main">
            <div class="promo-header-left">
                <div class="promo-header-icon">
                    <span class="material-symbols-rounded">campaign</span>
                </div>
                <div>
                    <h1 class="promo-header-title"><?= Html::encode($this->title) ?></h1>
                    <div class="promo-header-subtitle">
                        Управление рекламными позициями сайта и скриптами сетей в <span class="promo-code-badge">&lt;head&gt;</span>
                    </div>
                </div>
            </div>
            <div class="promo-header-actions">
                <?= Html::a(
                    '<span class="material-symbols-rounded" style="font-size:18px;">hub</span> <span>Сети (&lt;head&gt;)</span>',
                    ['/ad/ad-network/index'],
                    ['class' => 'promo-btn-hub', 'encode' => false]
                ) ?>
                <?= Html::a(
                    '<span class="material-symbols-rounded" style="font-size:19px;">add</span> <span>Добавить баннер</span>',
                    ['create'],
                    ['class' => 'promo-btn-add', 'encode' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- 2. МОНИТОРИНГ И ПЕРЕКЛЮЧАТЕЛИ ЗАГРУЗЧИКОВ В <head> -->
    <?php if (!empty($networks)): ?>
        <div class="promo-head-card">
            <div class="promo-head-card__header">
                <div class="promo-head-card__title">
                    <span class="material-symbols-rounded text-primary" style="font-size:20px;">dns</span>
                    <span>Статус загрузчиков в <code class="promo-code-badge">&lt;head&gt;</code>:</span>
                </div>
                <?= Html::a(
                    '<span>Управление всеми сетями</span> <span class="material-symbols-rounded" style="font-size:16px;">arrow_forward</span>',
                    ['/ad/ad-network/index'],
                    ['class' => 'promo-head-card__link', 'encode' => false]
                ) ?>
            </div>

            <div class="promo-toggles-grid">
                <?php foreach ($networks as $net): ?>
                    <div class="ui-kit-toggle-item">
                        <div class="ui-kit-toggle-label">
                            <span class="ui-kit-status-dot <?= $net->status ? 'is-active' : '' ?>"></span>
                            <span><?= Html::encode($net->name) ?></span>
                        </div>
                        <div class="ui-kit-segmented-control" role="group" aria-label="Переключатель статуса <?= Html::encode($net->name) ?>">
                            <!-- Слева ВСЕГДА Вкл -->
                            <?php if ($net->status): ?>
                                <span class="ui-kit-seg-btn ui-kit-seg-btn--on is-active" title="Сейчас включено в <head>">Вкл</span>
                                <?= Html::a('Откл', ['/ad/ad-network/toggle', 'id' => $net->id], [
                                    'class' => 'ui-kit-seg-btn ui-kit-seg-btn--off',
                                    'data-method' => 'post',
                                    'title' => 'Отключить скрипт из <head>',
                                ]) ?>
                            <?php else: ?>
                                <?= Html::a('Вкл', ['/ad/ad-network/toggle', 'id' => $net->id], [
                                    'class' => 'ui-kit-seg-btn ui-kit-seg-btn--on',
                                    'data-method' => 'post',
                                    'title' => 'Включить скрипт в <head>',
                                ]) ?>
                                <span class="ui-kit-seg-btn ui-kit-seg-btn--off is-active" title="Сейчас отключено">Откл</span>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 3. ПРЕДУПРЕЖДЕНИЯ О РАССИНХРОНИЗАЦИИ (БАННЕРЫ ВКЛ, HEAD ОТКЛ) -->
    <?php if (!empty($headSyncWarnings)): ?>
        <?php foreach ($headSyncWarnings as $warn): ?>
            <div class="promo-warning-card">
                <div class="promo-warning-body">
                    <span class="material-symbols-rounded promo-warning-icon">warning</span>
                    <div>
                        <strong>Внимание:</strong> В таблице включены баннеры сети <strong><?= Html::encode($warn['partner']) ?></strong> (<?= (int)$warn['count'] ?> шт.), однако скрипт сети в <code>&lt;head&gt;</code> сейчас <strong>ОТКЛЮЧЁН</strong>! Баннеры не отображаются посетителям.
                    </div>
                </div>
                <?php if ($warn['network_id']): ?>
                    <div>
                        <?= Html::a(
                            '<span class="material-symbols-rounded" style="font-size:16px;">power_settings_new</span> <span>Включить в &lt;head&gt;</span>',
                            ['/ad/ad-network/toggle', 'id' => $warn['network_id']],
                            [
                                'class' => 'btn btn-sm btn-warning sz-btn-icon text-nowrap fw-bold',
                                'data-method' => 'post',
                                'encode' => false,
                            ]
                        ) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- 4. СПРАВКА ПО ADFINITY (АВТО-ВСТРАИВАНИЕ) -->
    <div class="promo-callout-card">
        <div class="promo-callout-icon">
            <span class="material-symbols-rounded">auto_awesome</span>
        </div>
        <div class="promo-callout-body">
            <div class="promo-callout-title">
                <span>Рекламная сеть Adfinity</span>
                <span class="badge badge-soft-primary">Авто-встраивание</span>
            </div>
            <p class="promo-callout-desc">
                У сети <strong>Adfinity</strong> рекламные блоки являются авто-встраиваемыми. Их <strong>не требуется</strong> создавать вручную в таблице ниже и привязывать к позициям сайта. Скрипт подключается в секции <code class="promo-code-badge">&lt;head&gt;</code>, после чего алгоритм Adfinity сам находит оптимальные места на страницах и размещает рекламу.
            </p>
            <?php
            $adfinityNet = null;
            foreach ($networks as $n) {
                if ($n->code === 'adfinity' || $n->partner_id === 8) {
                    $adfinityNet = $n;
                    break;
                }
            }
            ?>
            <?php if ($adfinityNet): ?>
                <div class="promo-callout-footer">
                    <span class="fw-semibold" style="font-size:13px;color:var(--sz-text);">Статус Adfinity в &lt;head&gt;:</span>
                    <div class="ui-kit-segmented-control" role="group">
                        <?php if ($adfinityNet->status): ?>
                            <span class="ui-kit-seg-btn ui-kit-seg-btn--on is-active" title="Сейчас включено в <head>">Вкл</span>
                            <?= Html::a('Откл', ['/ad/ad-network/toggle', 'id' => $adfinityNet->id], [
                                'class' => 'ui-kit-seg-btn ui-kit-seg-btn--off',
                                'data-method' => 'post',
                                'title' => 'Отключить из <head>',
                            ]) ?>
                        <?php else: ?>
                            <?= Html::a('Вкл', ['/ad/ad-network/toggle', 'id' => $adfinityNet->id], [
                                'class' => 'ui-kit-seg-btn ui-kit-seg-btn--on',
                                'data-method' => 'post',
                                'title' => 'Включить в <head>',
                            ]) ?>
                            <span class="ui-kit-seg-btn ui-kit-seg-btn--off is-active" title="Сейчас отключено">Откл</span>
                        <?php endif; ?>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <!-- 5. ТАБЛИЦА БАННЕРОВ (GRIDVIEW) -->
    <div class="promo-table-panel">
        <?php Pjax::begin(['id' => 'ad-grid-pjax']); ?>

        <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'ad',
                    'filter' => $data['partner'],
                    'format' => 'raw',
                    'options' => ['width' => '110'],
                    'content' => static fn($model) => $model->getAdPartnerBadge(),
                ],
                [
                    'attribute' => 'position_id',
                    'options' => ['width' => '280'],
                    'value' => 'position',
                    'filter' => class_exists('\\kartik\\select2\\Select2')
                        ? \kartik\select2\Select2::widget([
                            'name' => 'AdSearch[position_id]',
                            'value' => $searchModel->position_id,
                            'data' => $data['position'],
                            'options' => ['placeholder' => 'Выбрать ...'],
                            'pluginOptions' => [
                                'allowClear' => true,
                                'selectOnClose' => true,
                            ],
                        ])
                        : Html::activeDropDownList($searchModel, 'position_id', $data['position'], ['prompt' => 'Все позиции', 'class' => 'form-select']),
                ],
                [
                    'attribute' => 'code',
                    'format' => 'raw',
                    'value' => static function ($model) {
                        return Html::tag('pre', Html::encode((string) $model->code), [
                            'class' => 'promo-code-block',
                        ]);
                    },
                ],
                [
                    'attribute' => 'mobile',
                    'options' => ['width' => '120'],
                    'format' => 'raw',
                    'filter' => [
                        0 => 'PC',
                        1 => 'Mobile',
                        2 => 'PC & Mobile',
                    ],
                    'content' => static function ($model) {
                        $badges = [
                            0 => '<span class="badge badge-soft-primary">PC</span>',
                            1 => '<span class="badge badge-soft-warning">Mobile</span>',
                            2 => '<span class="badge badge-soft-info">PC & Mobile</span>',
                        ];
                        return $badges[$model->mobile] ?? '-';
                    },
                ],

                [
                    'attribute' => 'wait',
                    'options' => ['width' => '110'],
                    'content' => static function ($model) {
                        $labels = [
                            0 => 'нет',
                            500 => '0,5 сек',
                            1000 => '1 сек',
                            1500 => '1,5 сек',
                            2000 => '2 сек',
                            2500 => '2,5 сек',
                            3000 => '3 сек',
                        ];

                        if ($model->wait > 0) {
                            $label = $labels[$model->wait] ?? (($model->wait / 1000) . ' сек');
                            return '<span class="badge badge-soft-secondary" style="font-size:11.5px;">'
                                . Html::encode($label . '/' . ($model->frequency > 1 ? ('кажд. ' . $model->frequency) : 'всем'))
                                . '</span>';
                        }

                        return '<span class="text-muted">—</span>';
                    },
                ],

                [
                    'attribute' => 'margin_top',
                    'options' => ['width' => '90'],
                    'content' => static fn($model) => $model->margin_top > 0
                        ? ('<span class="badge badge-soft-secondary" style="font-size:11.5px;">' . $model->margin_top . 'px</span>')
                        : '<span class="text-muted">—</span>',
                ],

                [
                    'attribute' => 'status',
                    'options' => ['width' => '90'],
                    'format' => 'raw',
                    'filter' => [
                        0 => 'Выкл',
                        1 => 'Вкл',
                    ],
                    'content' => static function ($model) {
                        return $model->status
                            ? '<span class="badge badge-soft-success">● Вкл</span>'
                            : '<span class="badge badge-soft-danger">● Выкл</span>';
                    },
                ],

                ViewHelper::actionColumn([
                    'urlCreator' => static fn($action, $model) => Url::toRoute([$action, 'id' => $model->id]),
                ]),
            ],
        ]); ?>
        </div>

        <?php Pjax::end(); ?>
    </div>

</div>
