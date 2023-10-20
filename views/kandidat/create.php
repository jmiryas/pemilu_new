<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var app\models\Kandidat $model */

$this->title = 'Create Kandidat';
$this->params['breadcrumbs'][] = ['label' => 'Kandidat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kandidat-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
