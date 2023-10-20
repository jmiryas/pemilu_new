<?php

use app\models\Visi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\VisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Visi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="visi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Visi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'nama_visi:ntext',
            [
                "attribute" => "id_kandidat",
                "value" => function($model) {
                    return $model->kandidat->nama_kandidat;
                }
            ],
            [
                'class' => ActionColumn::className(),
                'urlCreator' => function ($action, Visi $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_visi' => $model->id_visi]);
                 }
            ],
        ],
    ]); ?>


</div>
