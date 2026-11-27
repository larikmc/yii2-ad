<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\Ad */

$this->title = 'Реклама #' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="promo-view-panel">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Удалить', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Вы уверены, что хотите удалить эту рекламу?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id',
            [
                'attribute' => 'position_id',
                'value' => $model->getPosition(),
            ],
            [
                'attribute' => 'ad',
                'format' => 'raw',
                'value' => $model->getAdPartnerBadge() . ' ' . Html::encode($model->getAdPartnerName()),
            ],
            [
                'attribute' => 'mobile',
                'value' => [0 => 'PC', 1 => 'Mobile', 2 => 'PC & Mobile'][$model->mobile] ?? '-',
            ],
            'margin_top',
            'wait',
            'frequency',
            [
                'attribute' => 'status',
                'value' => $model->status ? 'Включен' : 'Выключен',
            ],
            'comment',
            [
                'attribute' => 'code',
                'format' => 'raw',
                'value' => Html::tag('pre', Html::encode($model->code), [
                    'style' => 'white-space:pre-wrap; word-break:break-all; background:#f8f9fa; padding:10px; border-radius:4px;',
                ]),
            ],
        ],
    ]) ?>

</div>
