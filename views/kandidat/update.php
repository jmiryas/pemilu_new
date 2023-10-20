<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kandidat $model */

$this->title = 'Update Kandidat: ' . $model->id_kandidat;
$this->params['breadcrumbs'][] = ['label' => 'Kandidat', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_kandidat, 'url' => ['view', 'id_kandidat' => $model->id_kandidat]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="kandidat-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
