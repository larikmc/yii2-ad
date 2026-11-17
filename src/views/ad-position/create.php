<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\AdPosition */
/* @var $data array */

$this->title = 'Создать позицию блоков';
$this->params['breadcrumbs'][] = ['label' => 'Позиции блоков', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="slot-position-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'data' => $data,
    ]) ?>

</div>
