<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\AdPosition */
/* @var $form yii\widgets\ActiveForm */
/* @var $data array */
?>

<div class="slot-position-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="mb-3">
        <?= $form->field($model, 'name')->textInput(['maxlength' => true, 'class' => 'form-control', 'placeholder' => 'Например: Раскраски - Верхний баннер']) ?>
    </div>

    <div class="mb-3">
        <?php if (class_exists('\\kartik\\select2\\Select2')): ?>
            <?= $form->field($model, 'category_id')->widget(\kartik\select2\Select2::class, [
                'data' => $data['category'],
                'options' => ['placeholder' => 'Выбрать раздел', 'multiple' => false, 'autocomplete' => 'off'],
                'maintainOrder' => true,
                'pluginOptions' => [
                    'allowClear' => true,
                ],
            ]) ?>
        <?php else: ?>
            <?= $form->field($model, 'category_id')->dropDownList($data['category'], ['prompt' => 'Выбрать раздел', 'class' => 'form-select']) ?>
        <?php endif; ?>
    </div>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
