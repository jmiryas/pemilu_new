<?php

use app\models\Pemilihan;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\PemilihanSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Pemilihan';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="pemilihan-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            // 'id_pemilihan',
            "tgl:date",
            "setting.nama_setting",
            [
                'class' => ActionColumn::className(),
                "template" => "{view}",
                'urlCreator' => function ($action, Pemilihan $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'id_pemilihan' => $model->id_pemilihan]);
                }
            ],
        ],
    ]); ?>


</div>