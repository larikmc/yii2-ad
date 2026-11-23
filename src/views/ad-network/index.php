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
                'options' => ['width' => '130'],
                'format' => 'raw',
                'filter' => [
                    1 => 'Вкл в <head>',
                    0 => 'Выкл',
                ],
                'content' => static function ($model) {
                    if ($model->status) {
                        return Html::a('<span class="badge text-bg-success">Вкл в &lt;head&gt;</span>', ['toggle', 'id' => $model->id], [
                            'class' => 'text-decoration-none',
                            'title' => 'Нажмите для отключения',
                            'data-method' => 'post',
                        ]);
                    }
                    return Html::a('<span class="badge text-bg-danger">Отключен</span>', ['toggle', 'id' => $model->id], [
                        'class' => 'text-decoration-none',
                        'title' => 'Нажмите для включения',
                        'data-method' => 'post',
                    ]);
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
