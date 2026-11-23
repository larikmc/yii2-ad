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
.promo-index-panel .table-responsive {
    width: 100%;
    overflow-x: auto;
    -webkit-overflow-scrolling: touch;
}
.promo-index-panel .grid-view table {
    min-width: 1100px;
}
.promo-head-status-card {
    background: #f8f9fa;
    border: 1px solid #e9ecef;
    border-radius: 8px;
    padding: 12px 16px;
}
.promo-net-pill {
    display: inline-flex;
    align-items: center;
    background: #fff;
    border: 1px solid #dee2e6;
    border-radius: 20px;
    padding: 4px 12px;
    margin-right: 8px;
    margin-bottom: 6px;
    font-size: 13px;
}
.promo-net-pill .status-indicator {
    width: 9px;
    height: 9px;
    border-radius: 50%;
    margin-right: 6px;
    display: inline-block;
}
.status-indicator.on { background-color: #198754; box-shadow: 0 0 0 2px rgba(25, 135, 84, 0.2); }
.status-indicator.off { background-color: #dc3545; }
CSS
);

$networks = $data['networks'] ?? [];
$headSyncWarnings = $data['headSyncWarnings'] ?? [];
?>

<div class="promo-index-panel">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0"><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('⚙️ Сети (<head>)', ['/ad/ad-network/index'], ['class' => 'btn btn-outline-secondary me-2']) ?>
            <?= Html::a('+ Добавить', ['create'], ['class' => 'btn btn-success sz-btn-add']) ?>
        </div>
    </div>

    <!-- 1. Панель мониторинга скриптов в <head> -->
    <?php if (!empty($networks)): ?>
        <div class="promo-head-status-card mb-3">
            <div class="d-flex justify-content-between align-items-center mb-2">
                <span class="fw-bold" style="font-size: 13.5px;">
                    🌐 Статус загрузчиков в <code>&lt;head&gt;</code>:
                </span>
                <span class="text-muted small">
                    <?= Html::a('Управление всеми сетями →', ['/ad/ad-network/index'], ['class' => 'text-decoration-none']) ?>
                </span>
            </div>
            <div class="d-flex flex-wrap align-items-center">
                <?php foreach ($networks as $net): ?>
                    <div class="promo-net-pill">
                        <span class="status-indicator <?= $net->status ? 'on' : 'off' ?>"></span>
                        <span class="me-2 fw-semibold"><?= Html::encode($net->name) ?></span>
                        <?php if ($net->status): ?>
                            <span class="badge bg-success-subtle text-success me-2" style="font-size: 11px;">Вкл</span>
                            <?= Html::a('Откл', ['/ad/ad-network/toggle', 'id' => $net->id], [
                                'class' => 'btn btn-sm btn-link text-danger p-0 text-decoration-none',
                                'style' => 'font-size: 11.5px;',
                                'data-method' => 'post',
                                'title' => 'Отключить загрузку библиотеки из <head>',
                            ]) ?>
                        <?php else: ?>
                            <span class="badge bg-secondary-subtle text-secondary me-2" style="font-size: 11px;">Выкл</span>
                            <?= Html::a('Вкл', ['/ad/ad-network/toggle', 'id' => $net->id], [
                                'class' => 'btn btn-sm btn-link text-success p-0 text-decoration-none fw-bold',
                                'style' => 'font-size: 11.5px;',
                                'data-method' => 'post',
                                'title' => 'Включить загрузку библиотеки в <head>',
                            ]) ?>
                        <?php endif; ?>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endif; ?>

    <!-- 2. Предупреждения о рассинхронизации (баннеры включены, но head отключен) -->
    <?php if (!empty($headSyncWarnings)): ?>
        <?php foreach ($headSyncWarnings as $warn): ?>
            <div class="alert alert-warning border-start border-4 border-warning d-flex align-items-center justify-content-between mb-3 py-2 px-3">
                <div>
                    <strong>⚠️ Внимание:</strong> В таблице включены баннеры сети <strong><?= Html::encode($warn['partner']) ?></strong> (<?= (int)$warn['count'] ?> шт.), однако скрипт сети в <code>&lt;head&gt;</code> сейчас <strong>ОТКЛЮЧЁН</strong>! Баннеры не смогут отобразиться посетителям.
                </div>
                <?php if ($warn['network_id']): ?>
                    <div>
                        <?= Html::a('Включить ' . Html::encode($warn['partner']) . ' в <head>', ['/ad/ad-network/toggle', 'id' => $warn['network_id']], [
                            'class' => 'btn btn-sm btn-warning fw-bold text-nowrap ms-3',
                            'data-method' => 'post',
                        ]) ?>
                    </div>
                <?php endif; ?>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <!-- 3. Справка по Adfinity (авто-встраивание) -->
    <div class="alert alert-info border-start border-4 border-info d-flex align-items-start mb-3 py-2 px-3">
        <div class="me-3 fs-4" style="line-height: 1.2;">💡</div>
        <div class="flex-grow-1" style="font-size: 13.5px;">
            <div class="fw-bold mb-1">Рекламная сеть Adfinity (авто-встраиваемые форматы)</div>
            <div class="text-muted">
                У сети <strong>Adfinity</strong> блоки являются авто-встраиваемыми. Их <strong>не нужно</strong> создавать в этом списке и вручную привязывать к позициям сайта. Скрипт подключается только в <code>&lt;head&gt;</code>, после чего сам находит места на страницах и размещает рекламу.
            </div>
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
                <div class="mt-2">
                    Статус Adfinity в &lt;head&gt;:
                    <?php if ($adfinityNet->status): ?>
                        <span class="badge bg-success">Подключён в &lt;head&gt;</span>
                        <?= Html::a('Отключить', ['/ad/ad-network/toggle', 'id' => $adfinityNet->id], [
                            'class' => 'btn btn-xs btn-outline-danger btn-sm py-0 px-2 ms-2',
                            'data-method' => 'post',
                        ]) ?>
                    <?php else: ?>
                        <span class="badge bg-secondary">Отключён</span>
                        <?= Html::a('Включить', ['/ad/ad-network/toggle', 'id' => $adfinityNet->id], [
                            'class' => 'btn btn-xs btn-outline-success btn-sm py-0 px-2 ms-2',
                            'data-method' => 'post',
                        ]) ?>
                    <?php endif; ?>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <?php Pjax::begin(); ?>

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'ad',
                'filter' => $data['partner'],
                'format' => 'raw',
                'options' => ['width' => '90'],
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
                        'style' => 'margin:0;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere;max-width:640px;font-size:12px;',
                    ]);
                },
            ],
            [
                'attribute' => 'mobile',
                'options' => ['width' => '110'],
                'format' => 'raw',
                'filter' => [
                    0 => 'PC',
                    1 => 'Mobile',
                    2 => 'PC & Mobile',
                ],
                'content' => static function ($model) {
                    $badges = [
                        0 => '<span class="badge bg-primary">PC</span>',
                        1 => '<span class="badge bg-warning text-dark">Mobile</span>',
                        2 => '<span class="badge bg-info text-dark">PC & Mobile</span>',
                    ];
                    return $badges[$model->mobile] ?? '-';
                },
            ],

            [
                'attribute' => 'wait',
                'options' => ['width' => '90'],
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
                        return $label . '/' . ($model->frequency > 1 ? ('кажд. ' . $model->frequency) : 'всем');
                    }

                    return '-';
                },
            ],

            [
                'attribute' => 'margin_top',
                'options' => ['width' => '80'],
                'content' => static fn($model) => $model->margin_top > 0 ? ($model->margin_top . 'px') : '-',
            ],

            [
                'attribute' => 'status',
                'options' => ['width' => '80'],
                'format' => 'raw',
                'filter' => [
                    0 => 'Выкл',
                    1 => 'Вкл',
                ],
                'content' => static function ($model) {
                    return $model->status
                        ? '<span class="badge text-bg-success">Вкл</span>'
                        : '<span class="badge text-bg-danger">Выкл</span>';
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
