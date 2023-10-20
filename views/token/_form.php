<?php

use app\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Token $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="token-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'token')->textInput(['maxlength' => true]) ?>

    <?php 
    
    $data_setting = Setting::find()->asArray()->all();

    echo $form->field($model, "id_setting")->widget(Select2::classname(), [
        'data' => ArrayHelper::map($data_setting, "id_setting", "nama_setting"),
        'maintainOrder' => true,
        'options' => ['placeholder' => 'Pilih setting ...'],
        'pluginOptions' => [
        ],
    ])->label("Pilih Setting");
    
    ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
