<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Pemilihan $model */

$this->title = $model->id_pemilihan;
$this->params['breadcrumbs'][] = ['label' => 'Pemilihan', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="pemilihan-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_pemilihan' => $model->id_pemilihan], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_pemilihan' => $model->id_pemilihan], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'id_pemilihan',
            [
                "attribute" => 'tgl',
                "format" => "date"
            ],
            [
                "attribute" => 'id_setting',
                "value" => function ($model) {
                    return $model->setting->nama_setting;
                }
            ],
        ],
    ]) ?>

    <table class="table table-hover">
        <thead class="table-dark">
            <tr>
                <th scope="col">No.</th>
                <th scope="col">Nama Kandidat</th>
            </tr>
        </thead>
        <tbody>
            <?php
            $index = 1;
            foreach ($pemilihan_detail_list as $pemilihan_detail) :
            ?>
                <tr>
                    <th><?php echo $index++; ?></th>
                    <td><?php echo $pemilihan_detail["kandidat"]["nama_kandidat"]; ?></td>
                </tr>
            <?php
            endforeach;
            ?>
        </tbody>
    </table>

</div>