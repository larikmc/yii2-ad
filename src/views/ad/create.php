<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\Ad */
/* @var $data array */

$this->title = 'Добавить рекламу';
$this->params['breadcrumbs'][] = ['label' => 'Реклама', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="ad-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
