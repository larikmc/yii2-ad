<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\AdNetwork */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="promo-network-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'placeholder' => 'Например: Digital Caramel']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'code')->textInput(['maxlength' => true, 'placeholder' => 'Например: caramel']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'is_auto')->dropDownList([
                0 => 'Обычная (баннеры по позициям)',
                1 => 'Авто-встраивание (только head)',
            ], ['class' => 'form-select']) ?>
        </div>
        <div class="col-md-2">
            <?= $form->field($model, 'status')->dropDownList([
                1 => 'Включен в <head>',
                0 => 'Выключен',
            ], ['class' => 'form-select']) ?>
        </div>
    </div>

    <div class="row g-3 mb-3">
        <div class="col-md-9">
            <?= $form->field($model, 'description')->textInput(['maxlength' => true, 'placeholder' => 'Пояснение для администратора']) ?>
        </div>
        <div class="col-md-3">
            <?= $form->field($model, 'sort_order')->textInput(['type' => 'number']) ?>
        </div>
    </div>

    <?= $form->field($model, 'head_code')->textarea([
        'rows' => 6,
        'class' => 'form-control',
        'style' => 'font-family: monospace; font-size: 13px;',
        'placeholder' => '<script async src="..."></script>',
    ])->hint('HTML/JS теги, которые будут подключены в секцию &lt;head&gt; публичных страниц.') ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success sz-btn-save']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
