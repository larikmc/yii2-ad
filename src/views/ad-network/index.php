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
.promo-network-panel .table-responsive {
    width: 100%;
    overflow-x: auto;
}
/* Фиксированный двухпозиционный переключатель [ Вкл | Откл ] */
.promo-toggle-group {
    display: inline-flex;
    align-items: center;
    background: #eef1f4;
    border: 1px solid #dee2e6;
    border-radius: 16px;
    padding: 2px;
    user-select: none;
    vertical-align: middle;
}
.promo-btn {
    display: inline-block;
    padding: 2px 10px;
    font-size: 11.5px;
    font-weight: 600;
    line-height: 1.35;
    border-radius: 14px;
    text-decoration: none !important;
    transition: all 0.15s ease-in-out;
}
/* Левая позиция: Вкл */
.promo-btn--on.is-active {
    background-color: #198754;
    color: #fff;
    cursor: default;
    box-shadow: 0 1px 2px rgba(0,0,0,0.12);
}
.promo-btn--on.is-inactive {
    color: #495057;
    background: transparent;
}
.promo-btn--on.is-inactive:hover {
    color: #198754;
    background: rgba(25, 135, 84, 0.14);
}
/* Правая позиция: Откл */
.promo-btn--off.is-active {
    background-color: #dc3545;
    color: #fff;
    cursor: default;
    box-shadow: 0 1px 2px rgba(0,0,0,0.12);
}
.promo-btn--off.is-inactive {
    color: #495057;
    background: transparent;
}
.promo-btn--off.is-inactive:hover {
    color: #dc3545;
    background: rgba(220, 53, 69, 0.14);
}
CSS
);
?>

<div class="promo-network-panel">

    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1><?= Html::encode($this->title) ?></h1>
        <div>
            <?= Html::a('← К списку баннеров', ['/ad/ad/index'], ['class' => 'btn btn-outline-secondary me-2']) ?>
            <?= Html::a('+ Добавить сеть', ['create'], ['class' => 'btn btn-success sz-btn-add']) ?>
        </div>
    </div>

    <div class="alert alert-light border">
        <strong>💡 Справка:</strong> Скрипты активных сетей из этой таблицы автоматически подключаются в секцию <code>&lt;head&gt;</code> публичных страниц через <code>\larikmc\ad\widgets\AdHeadWidget</code>. Больше не нужно вручную редактировать файлы шаблонов при запуске или отключении рекламных кампаний!
    </div>

    <?php Pjax::begin(); ?>

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'name',
                'format' => 'raw',
                'options' => ['width' => '220'],
                'value' => static function ($model) {
                    $badges = '';
                    if ($model->is_auto) {
                        $badges .= ' <span class="badge bg-info text-dark" title="Авто-встраиваемые форматы: баннеры размещаются скриптом самостоятельно">Авто-блоки</span>';
                    }
                    return '<strong>' . Html::encode($model->name) . '</strong>' . $badges .
                        '<div class="text-muted small">' . Html::encode((string) $model->description) . '</div>';
                },
            ],

            [
                'attribute' => 'code',
                'options' => ['width' => '130'],
                'content' => static fn($model) => Html::tag('code', Html::encode($model->code)),
            ],

            [
                'attribute' => 'head_code',
                'format' => 'raw',
                'value' => static function ($model) {
                    return Html::tag('pre', Html::encode((string) $model->head_code), [
                        'style' => 'margin:0;white-space:pre-wrap;word-break:break-word;overflow-wrap:anywhere;max-width:550px;font-size:11px;',
                    ]);
                },
            ],

            [
                'attribute' => 'status',
                'options' => ['width' => '140'],
                'format' => 'raw',
                'filter' => [
                    1 => 'Вкл в <head>',
                    0 => 'Выкл',
                ],
                'content' => static function ($model) {
                    $html = '<div class="promo-toggle-group">';
                    if ($model->status) {
                        $html .= '<span class="promo-btn promo-btn--on is-active" title="Сейчас включено в <head>">Вкл</span>';
                        $html .= Html::a('Откл', ['toggle', 'id' => $model->id], [
                            'class' => 'promo-btn promo-btn--off is-inactive',
                            'data-method' => 'post',
                            'title' => 'Отключить из <head>',
                        ]);
                    } else {
                        $html .= Html::a('Вкл', ['toggle', 'id' => $model->id], [
                            'class' => 'promo-btn promo-btn--on is-inactive',
                            'data-method' => 'post',
                            'title' => 'Включить в <head>',
                        ]);
                        $html .= '<span class="promo-btn promo-btn--off is-active" title="Сейчас отключено">Откл</span>';
                    }
                    $html .= '</div>';
                    return $html;
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
