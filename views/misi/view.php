<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Misi $model */

$this->title = $model->id_misi;
$this->params['breadcrumbs'][] = ['label' => 'Misi', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="misi-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_misi' => $model->id_misi], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_misi' => $model->id_misi], [
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
            // 'id_misi',
            [
                "label" => "Kandidat",
                "value" => function($model) {
                    return $model->visi->kandidat->nama_kandidat;
                }
            ],
            [
                "attribute" => 'id_visi',
                "value" => function($model) {
                    return $model->visi->nama_visi;
                }
            ],
            'nama_misi:ntext',
        ],
    ]) ?>

</div>
