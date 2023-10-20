<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Pemilihan $model */

$this->title = 'Update Pemilihan: ' . $model->id_pemilihan;
$this->params['breadcrumbs'][] = ['label' => 'Pemilihans', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_pemilihan, 'url' => ['view', 'id_pemilihan' => $model->id_pemilihan]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="pemilihan-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
