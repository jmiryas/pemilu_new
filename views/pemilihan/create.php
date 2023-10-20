<?php

use app\models\Setting;
use kartik\select2\Select2;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pemilihan $model */

$this->title = 'Create Pemilihan';
$this->params['breadcrumbs'][] = ['label' => 'Pemilihans', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pemilihan-create">

    <h2>Tambah Pemilihan</h2>

    <form action="" method="POST">
        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

        <div class="mb-3">
            <label class="form-label">Tanggal</label>
            <input name="tgl" type="date" class="form-control" placeholder="Pilih tanggal">
        </div>

        <?php

        $data_setting = Setting::find()->asArray()->all();

        echo '<label class="control-label">Pilih Setting</label>';
        echo Select2::widget([
            'name' => 'id_setting',
            'data' => ArrayHelper::map($data_setting, "id_setting", "nama_setting"),
            'options' => [
                'placeholder' => 'Pilih setting ...',
            ],
        ]);

        ?>

        <div class="mt-3">
            <button type="submit" class="btn btn-primary">Submit</button>
        </div>
    </form>

</div>