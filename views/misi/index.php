<?php

use app\models\Misi;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
// use yii\grid\GridView;
use kartik\grid\GridView;

/** @var yii\web\View $this */
/** @var app\models\MisiSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Misi';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="misi-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Misi', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?php if (gettype($dataProvider) == "array" && count((array) $dataProvider) == 0) : ?>
        <h4 class="text-center">Tidak ada misi</h4>
    <?php else : ?>
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'responsive' => true,
            'hover' => true,
            "panel" => [
                "type" => GridView::TYPE_PRIMARY
            ],
            "exportConfig" => [
                GridView::CSV => [],
                GridView::HTML => [],
                GridView::TEXT => [],
                GridView::EXCEL => [],
                GridView::JSON => [],
            ],
            'columns' => [
                ['class' => 'yii\grid\SerialColumn'],

                // 'id_misi',
                [
                    "label" => "Kandidat",
                    "group" => true,
                    "value" => function ($model) {
                        return $model->visi->kandidat->nama_kandidat;
                    }
                ],
                [
                    "attribute" => 'id_visi',
                    "group" => true,
                    "value" => function ($model) {
                        return $model->visi->nama_visi;
                    }
                ],
                'nama_misi:ntext',
                [
                    'class' => ActionColumn::className(),
                    'urlCreator' => function ($action, Misi $model, $key, $index, $column) {
                        return Url::toRoute([$action, 'id_misi' => $model->id_misi]);
                    }
                ],
            ],
        ]); ?>
    <?php endif ?>

</div>