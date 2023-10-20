<?php

use app\models\Kandidat;
use app\models\Setting;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\KandidatSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Kandidat';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="kandidat-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Create Kandidat', ['create'], ['class' => 'btn btn-success']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'id_kandidat',
            'nama_kandidat',
            [
                "attribute" => 'id_setting',
                "value" => function ($model) {
                    return $model->setting->nama_setting;
                },
                'filter' => ArrayHelper::map(Setting::find()->asArray()->all(), 'id_setting', 'nama_setting'),
            ],
            // 'foto',
            [
                "attribute" => "foto",
                "format" => "raw",
                "value" => function ($model) {
                    if ($model->foto == null) {
                        return Html::img(
                            Yii::getAlias("@web/image/avatar.png"),
                            ["height" => "50px"]
                        );
                    } else {
                        return Html::img(Yii::getAlias("@web/image/")
                            . $model->foto, ["height" => "50px"]);
                    }
                }
            ],
            [
                'class' => ActionColumn::className(),
                "template" => "{view} {update} {delete}",
                "buttons" => [
                    "view" => function ($url, $model) {
                        return Html::a("Detail", ["kandidat/view", "id_kandidat" => $model["id_kandidat"]], ["class" => "btn btn-sm btn-primary"]);
                    },
                    "update" => function ($url, $model) {
                        return Html::a("Edit", ["kandidat/update", "id_kandidat" => $model["id_kandidat"]], ["class" => "btn btn-sm btn-warning"]);
                    },
                    "delete" => function ($url, $model) {
                        return Html::a("Hapus", ["kandidat/delete", "id_kandidat" => $model["id_kandidat"]], ["class" => "btn btn-sm btn-danger", "data" => [
                            "confirm" => "Hapus kandidat?",
                            "method" => "POST"
                        ]]);
                    }
                ]
                // 'urlCreator' => function ($action, Kandidat $model, $key, $index, $column) {
                //     return Url::toRoute([$action, 'id_kandidat' => $model->id_kandidat]);
                //  }
            ],
        ],
    ]); ?>


</div>