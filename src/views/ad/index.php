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
CSS
);
?>

<div class="promo-index-panel">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('+ Добавить', ['create'], ['class' => 'btn btn-primary sz-btn-add']) ?>
    </p>

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
