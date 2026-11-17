<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\Ad */
/* @var $data array */

$this->title = 'Редактировать рекламу: #' . $model->id . ' (' . $model->getPosition() . ')';
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => '#' . $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Редактировать';
?>
<div class="ad-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
