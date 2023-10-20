<?php

use app\models\Kandidat;
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\Visi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="visi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_visi')->textarea(['rows' => 6]) ?>

    <?php 
    $data_kandidat = Kandidat::find()->asArray()->all();

    echo $form->field($model, "id_kandidat")->widget(Select2::classname(), [
        'data' => ArrayHelper::map($data_kandidat, "id_kandidat", "nama_kandidat"),
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Pilih kandidat ...'],
        'pluginOptions' => [
        ],
    ])->label("Pilih Kandidat");
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
