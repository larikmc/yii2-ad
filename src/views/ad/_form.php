<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model larikmc\ad\models\Ad */
/* @var $form yii\widgets\ActiveForm */
/* @var $data array */
?>

<div class="ad-form">

    <?php $form = ActiveForm::begin(); ?>

    <div class="row g-3 mb-3">
        <div class="col-md-4">
            <?php if (class_exists('\\kartik\\select2\\Select2')): ?>
                <?= $form->field($model, 'ad')->widget(\kartik\select2\Select2::class, [
                    'data' => $data['partner'],
                    'options' => ['placeholder' => 'Выбрать рекламную сеть', 'autocomplete' => 'off'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>
            <?php else: ?>
                <?= $form->field($model, 'ad')->dropDownList($data['partner'], ['prompt' => 'Выбрать рекламную сеть', 'class' => 'form-select']) ?>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <?php if (class_exists('\\kartik\\select2\\Select2')): ?>
                <?= $form->field($model, 'position_id')->widget(\kartik\select2\Select2::class, [
                    'data' => $data['position'],
                    'options' => ['placeholder' => 'Выбрать позицию', 'autocomplete' => 'off'],
                    'pluginOptions' => ['allowClear' => true],
                ]) ?>
            <?php else: ?>
                <?= $form->field($model, 'position_id')->dropDownList($data['position'], ['prompt' => 'Выбрать позицию', 'class' => 'form-select']) ?>
            <?php endif; ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'mobile')->dropDownList([
                0 => 'PC',
                1 => 'Mobile',
                2 => 'PC & Mobile',
            ], ['class' => 'form-select']) ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'margin_top')->dropDownList([
                0 => 'нет',
                10 => '10px',
                15 => '15px',
                20 => '20px',
                30 => '30px',
                40 => '40px',
            ], ['class' => 'form-select'])->label('Отступ сверху') ?>
        </div>

        <div class="col-md-4">
            <?= $form->field($model, 'wait')->dropDownList([
                0 => 'нет',
                500 => '0,5 секунды',
                1000 => '1 секунда',
                1500 => '1,5 секунды',
                2000 => '2 секунды',
                2500 => '2,5 секунды',
                3000 => '3 секунды',
            ], ['class' => 'form-select', 'id' => 'ad-wait-select']) ?>
        </div>

        <div class="col-md-4" id="ad-frequency-container" style="<?= (int)$model->wait === 0 ? 'display:none;' : '' ?>">
            <?= $form->field($model, 'frequency')->dropDownList([
                1 => 'всем (100%)',
                2 => 'каждому 2 (50%)',
                3 => 'каждому 3 (33%)',
                4 => 'каждому 4 (25%)',
                5 => 'каждому 5 (20%)',
                6 => 'каждому 6',
                7 => 'каждому 7',
                8 => 'каждому 8',
                9 => 'каждому 9',
                10 => 'каждому 10',
            ], ['class' => 'form-select']) ?>
        </div>
    </div>

    <?= $form->field($model, 'code')->textarea([
        'rows' => 10,
        'class' => 'form-control',
        'style' => 'width: 100%; font-family: monospace; font-size: 13px;',
        'placeholder' => 'Вставьте HTML / JavaScript код баннера',
    ]) ?>

    <?= $form->field($model, 'status')->dropDownList([
        1 => 'Включен',
        0 => 'Выключен',
    ], ['class' => 'form-select']) ?>

    <div class="form-group mt-3">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success']) ?>
        <?= Html::a('Отмена', ['index'], ['class' => 'btn btn-secondary ms-2']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>

<?php
$js = <<<'JS'
(function() {
    var select = document.getElementById('ad-wait-select');
    var container = document.getElementById('ad-frequency-container');
    if (select && container) {
        select.addEventListener('change', function() {
            container.style.display = (parseInt(this.value, 10) > 0) ? '' : 'none';
        });
    }
})();
JS;
$this->registerJs($js, \yii\web\View::POS_END);
?>
