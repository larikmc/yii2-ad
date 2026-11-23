<?php

use larikmc\ad\helpers\ViewHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel larikmc\ad\models\AdNetworkSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Рекламные сети (<head>)';
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['/ad/ad/index']];
$this->params['breadcrumbs'][] = $this->title;

$this->registerCss(<<<'CSS'
.promo-network-container {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

/* 1. Шапка */
.promo-net-header-card {
    background: var(--sz-surface, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: var(--sz-radius-md, 20px);
    padding: 18px 24px;
    box-shadow: var(--sz-shadow, 0 10px 30px rgba(0, 0, 0, 0.03));
}
html.dark .promo-net-header-card,
body.dark .promo-net-header-card {
    background: #17243c;
    border-color: #2c3f5d;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

.promo-net-header-main {
    display: flex;
    align-items: center;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 16px;
}
.promo-net-header-left {
    display: flex;
    align-items: center;
    gap: 14px;
}
.promo-net-header-icon {
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
html.dark .promo-net-header-icon,
body.dark .promo-net-header-icon {
    background: rgba(49, 137, 247, 0.22);
    color: #5ea4ff;
}
.promo-net-header-title {
    font-size: 24px;
    font-weight: 700;
    color: var(--sz-text, #14294d);
    letter-spacing: -0.02em;
    line-height: 1.2;
    margin: 0;
}
.promo-net-header-subtitle {
    font-size: 13px;
    color: var(--sz-muted, #7b93be);
    margin-top: 3px;
}
.promo-net-header-actions {
    display: flex;
    align-items: center;
    gap: 10px;
}

/* 2. Инфо-карточка */
.promo-net-callout {
    display: flex;
    align-items: flex-start;
    gap: 14px;
    background: linear-gradient(135deg, rgba(49, 137, 247, 0.05) 0%, rgba(40, 101, 190, 0.08) 100%);
    border: 1px solid rgba(49, 137, 247, 0.22);
    border-left: 4px solid var(--sz-primary, #3189f7);
    border-radius: var(--sz-radius-md, 20px);
    padding: 16px 20px;
}
html.dark .promo-net-callout,
body.dark .promo-net-callout {
    background: linear-gradient(135deg, rgba(49, 137, 247, 0.12) 0%, rgba(18, 29, 50, 0.75) 100%);
    border-color: rgba(49, 137, 247, 0.32);
    border-left-color: #3189f7;
}

.promo-net-callout-icon {
    width: 38px;
    height: 38px;
    border-radius: 10px;
    background: rgba(49, 137, 247, 0.15);
    color: var(--sz-primary, #3189f7);
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 22px;
    flex-shrink: 0;
}
html.dark .promo-net-callout-icon,
body.dark .promo-net-callout-icon {
    background: rgba(49, 137, 247, 0.24);
    color: #6bb0ff;
}
.promo-net-callout-text {
    font-size: 13.5px;
    line-height: 1.55;
    color: var(--sz-text, #14294d);
    margin: 0;
}
html.dark .promo-net-callout-text,
body.dark .promo-net-callout-text {
    color: #dce8ff;
}

/* 3. Таблица */
.promo-net-table-panel {
    background: var(--sz-surface, #ffffff);
    border: 1px solid var(--sz-line, rgba(40, 52, 82, 0.12));
    border-radius: var(--sz-radius-md, 20px);
    padding: 20px;
    box-shadow: var(--sz-shadow, 0 10px 30px rgba(0, 0, 0, 0.03));
}
html.dark .promo-net-table-panel,
body.dark .promo-net-table-panel {
    background: #17243c;
    border-color: #2c3f5d;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.25);
}

/* Переключатели [ Вкл | Откл ] */
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

.ui-kit-seg-btn--on.is-active {
    background: #079b70;
    color: #ffffff !important;
    font-weight: 750;
    cursor: default;
    box-shadow: 0 2px 6px rgba(7, 155, 112, 0.35);
}
.ui-kit-seg-btn--off.is-active {
    background: #e24e6c;
    color: #ffffff !important;
    font-weight: 750;
    cursor: default;
    box-shadow: 0 2px 6px rgba(226, 78, 108, 0.35);
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
CSS
);
?>

<div class="promo-network-container promo-network-panel">

    <!-- 1. ШАПКА -->
    <div class="promo-net-header-card">
        <div class="promo-net-header-main">
            <div class="promo-net-header-left">
                <div class="promo-net-header-icon">
                    <span class="material-symbols-rounded">hub</span>
                </div>
                <div>
                    <h1 class="promo-net-header-title"><?= Html::encode($this->title) ?></h1>
                    <div class="promo-net-header-subtitle">
                        Управление загрузчиками рекламных сетей, подключаемыми в секции <span class="promo-code-badge">&lt;head&gt;</span>
                    </div>
                </div>
            </div>
            <div class="promo-net-header-actions">
                <?= Html::a(
                    '<span class="material-symbols-rounded" style="font-size:18px;">arrow_back</span> <span>К списку баннеров</span>',
                    ['/ad/ad/index'],
                    ['class' => 'promo-btn-hub', 'encode' => false]
                ) ?>
                <?= Html::a(
                    '<span class="material-symbols-rounded" style="font-size:19px;">add</span> <span>Добавить сеть</span>',
                    ['create'],
                    ['class' => 'promo-btn-add', 'encode' => false]
                ) ?>
            </div>
        </div>
    </div>

    <!-- 2. ИНФОРМАЦИЯ -->
    <div class="promo-net-callout">
        <div class="promo-net-callout-icon">
            <span class="material-symbols-rounded">info</span>
        </div>
        <p class="promo-net-callout-text">
            Скрипты активных сетей из этой таблицы автоматически подключаются в секцию <code class="promo-code-badge">&lt;head&gt;</code> публичных страниц через виджет <code>\larikmc\ad\widgets\AdHeadWidget</code>. Переключение статуса сети моментально добавляет или убирает её код без правки файлов и без риска оставить неактивные скрипты.
        </p>
    </div>

    <!-- 3. ТАБЛИЦА СЕТЕЙ -->
    <div class="promo-net-table-panel">
        <?php Pjax::begin(['id' => 'ad-network-grid-pjax']); ?>

        <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'tableOptions' => ['class' => 'table table-hover align-middle mb-0'],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                [
                    'attribute' => 'sort_order',
                    'options' => ['width' => '90'],
                    'headerOptions' => ['style' => 'text-align:center;'],
                    'contentOptions' => ['style' => 'text-align:center;'],
                ],
                [
                    'attribute' => 'name',
                    'format' => 'raw',
                    'value' => static fn($model) => '<strong style="color:var(--sz-text);">' . Html::encode($model->name) . '</strong>',
                ],
                [
                    'attribute' => 'code',
                    'format' => 'raw',
                    'options' => ['width' => '130'],
                    'value' => static fn($model) => '<code class="promo-code-badge">' . Html::encode($model->code) . '</code>',
                ],
                [
                    'attribute' => 'partner_id',
                    'options' => ['width' => '160'],
                    'value' => static fn($model) => $model->partner_id ? ('Партнер ID #' . $model->partner_id) : '— (Глобальная)',
                ],
                [
                    'attribute' => 'status',
                    'options' => ['width' => '140'],
                    'format' => 'raw',
                    'filter' => [
                        0 => 'Откл',
                        1 => 'Вкл',
                    ],
                    'content' => static function ($model) {
                        return '<div class="ui-kit-segmented-control" role="group">'
                            . ($model->status
                                ? '<span class="ui-kit-seg-btn ui-kit-seg-btn--on is-active" title="Включено">Вкл</span>'
                                . Html::a('Откл', ['toggle', 'id' => $model->id], [
                                    'class' => 'ui-kit-seg-btn ui-kit-seg-btn--off',
                                    'data-method' => 'post',
                                    'title' => 'Отключить',
                                ])
                                : Html::a('Вкл', ['toggle', 'id' => $model->id], [
                                    'class' => 'ui-kit-seg-btn ui-kit-seg-btn--on',
                                    'data-method' => 'post',
                                    'title' => 'Включить',
                                ])
                                . '<span class="ui-kit-seg-btn ui-kit-seg-btn--off is-active" title="Отключено">Откл</span>'
                            )
                            . '</div>';
                    },
                ],
                [
                    'attribute' => 'updated_at',
                    'options' => ['width' => '170'],
                    'format' => ['date', 'php:d.m.Y H:i'],
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
