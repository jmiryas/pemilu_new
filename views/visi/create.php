<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Visi $model */

$this->title = 'Create Visi';
$this->params['breadcrumbs'][] = ['label' => 'Visi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visi-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
