<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\AdNetwork */

$this->title = 'Добавить рекламную сеть (<head>)';
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['/ad/ad/index']];
$this->params['breadcrumbs'][] = ['label' => 'Сети (<head>)', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="promo-network-create">
    <h1><?= Html::encode($this->title) ?></h1>
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
