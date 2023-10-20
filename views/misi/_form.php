<?php

use app\models\Visi;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Misi $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="misi-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'nama_misi')->textarea(['rows' => 6]) ?>

    <?php 
    $data_visi = Visi::find()->with(["kandidat"])->asArray()->all();

    foreach($data_visi as $index => $visi) {
        $data_visi[$index]["visi_dan_nama"] = strtoupper($visi["kandidat"]["nama_kandidat"]) .
             " - " . 
             $visi["nama_visi"];
    }

    // var_dump($data_visi);
    // die;    

    echo $form->field($model, "id_visi")->widget(Select2::classname(), [
        'data' => ArrayHelper::map($data_visi, "id_visi", "visi_dan_nama"),
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Pilih visi ...'],
        'pluginOptions' => [
        ],
    ])->label("Pilih Visi");
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
