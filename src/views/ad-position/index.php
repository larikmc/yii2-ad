<?php

use larikmc\ad\helpers\ViewHelper;
use yii\grid\GridView;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\Pjax;

/* @var $this yii\web\View */
/* @var $searchModel larikmc\ad\models\AdPositionSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */
/* @var $data array */

$this->title = 'Позиции блоков';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slot-position-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <div class="alert alert-info d-flex align-items-center mb-3" role="alert">
        <div>
            <strong>Пример вызова в шаблоне:</strong>
            <code>\larikmc\ad\widgets\AdWidget::widget(['position_id' => 1]);</code>
            <br>
            <span class="text-muted small">или через алиас:</span>
            <code>\frontend\widgets\AdWidget::widget(['position_id' => 1]);</code>
        </div>
    </div>

    <p>
        <?= Html::a('+ Добавить', ['create'], ['class' => 'btn btn-primary sz-btn-add']) ?>
    </p>

    <?php Pjax::begin(); ?>

    <div class="table-responsive">
    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            [
                'attribute' => 'id',
                'options' => ['width' => '70'],
            ],
            'name',
            [
                'attribute' => 'category_id',
                'value' => 'category',
                'options' => ['width' => '250'],
                'filter' => class_exists('\\kartik\\select2\\Select2')
                    ? \kartik\select2\Select2::widget([
                        'name' => 'AdPositionSearch[category_id]',
                        'value' => $searchModel->category_id,
                        'data' => $data['category'],
                        'options' => ['placeholder' => 'Выбрать раздел ...'],
                        'pluginOptions' => [
                            'allowClear' => true,
                            'selectOnClose' => true,
                        ],
                    ])
                    : Html::activeDropDownList($searchModel, 'category_id', $data['category'], ['prompt' => 'Все разделы', 'class' => 'form-select']),
            ],
            ViewHelper::actionColumn([
                'urlCreator' => static fn($action, $model) => Url::toRoute([$action, 'id' => $model->id]),
            ]),
        ],
    ]); ?>
    </div>

    <?php Pjax::end(); ?>

</div>
