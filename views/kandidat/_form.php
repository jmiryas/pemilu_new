<?php

use kartik\file\FileInput;
use app\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Kandidat $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="kandidat-form">

    <?php $form = ActiveForm::begin(["options" => ["enctype" => "multipart/form-data"]]); ?>

    <?= $form->field($model, 'nama_kandidat')->textInput(['maxlength' => true]) ?>

    <?php

    $data_setting = Setting::find()->asArray()->all();

    echo $form->field($model, "id_setting")->widget(Select2::classname(), [
        'data' => ArrayHelper::map($data_setting, "id_setting", "judul_pemilihan"),
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Pilih setting ...'],
        'pluginOptions' => [],
    ])->label("Pilih Setting");

    ?>

    <?php
    echo $form->field($model, 'image_file')->widget(FileInput::classname(), [
        'options' => ['accept' => 'image/*'],
    ]);
    ?>

    <?php
    if ($model->foto != null) {
        echo Html::img(Yii::getAlias("@web/image/")
            . $model->foto, ["height" => "200px"]);
    }
    ?>

    <?= $form->field($model, 'foto')->hiddenInput()->label("") ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>