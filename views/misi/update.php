<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Misi $model */

$this->title = 'Update Misi: ' . $model->id_misi;
$this->params['breadcrumbs'][] = ['label' => 'Misi', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id_misi, 'url' => ['view', 'id_misi' => $model->id_misi]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="misi-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
