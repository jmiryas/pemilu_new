<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Visi $model */

$this->title = $model->id_visi;
$this->params['breadcrumbs'][] = ['label' => 'Visi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="visi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_visi' => $model->id_visi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_visi' => $model->id_visi], [
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
            'id_visi',
            'nama_visi:ntext',
            [
                "attribute" => "id_kandidat",
                "value" => function($model) {
                    return $model->kandidat->nama_kandidat;
                }
            ]
        ],
    ]) ?>

</div>
