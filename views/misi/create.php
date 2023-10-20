<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Misi $model */

$this->title = 'Create Misi';
$this->params['breadcrumbs'][] = ['label' => 'Misi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="misi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
