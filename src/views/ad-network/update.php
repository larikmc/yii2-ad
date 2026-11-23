<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\AdNetwork */

$this->title = 'Редактирование сети: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['/ad/ad/index']];
$this->params['breadcrumbs'][] = ['label' => 'Сети (<head>)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->name;
?>

<div class="promo-network-update">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
