<?php

use app\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var app\models\Token $model */

$this->title = 'Generate Token';
$this->params['breadcrumbs'][] = ['label' => 'Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="token-create">

    <form action="" method="POST">

        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

        <?php

        $data_setting = Setting::find()->asArray()->all();

        echo '<label class="control-label">Pilih Setting</label>';
        echo Select2::widget([
            'name' => 'id_setting',
            'data' => ArrayHelper::map($data_setting, "id_setting", "judul_pemilihan"),
            'options' => [
                'placeholder' => 'Pilih setting ...',
            ],
        ]);

        ?>

        <div class="mt-3 mb-3">
            <label class="form-label">Jumlah Token</label>
            <input name="jumlah_token" type="number" class="form-control" placeholder="Masukkan jumlah token">
        </div>

        <div class="mb-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

</div>