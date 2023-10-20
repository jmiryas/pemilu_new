<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Visi $model */

$this->title = 'Update Visi: ' . $model->id_visi;
$this->params['breadcrumbs'][] = ['label' => 'Visi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_visi, 'url' => ['view', 'id_visi' => $model->id_visi]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="visi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
