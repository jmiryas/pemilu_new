<?php

use app\models\Setting;
use app\models\Token;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\ActionColumn;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;

/** @var yii\web\View $this */
/** @var app\models\TokenSearch $searchModel */
/** @var yii\data\ActiveDataProvider $dataProvider */

$this->title = 'Tokens';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="token-index">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Generate Token', ['token/generate'], ['class' => 'btn btn-primary']) ?>
    </p>

    <?php // echo $this->render('_search', ['model' => $searchModel]); 
    ?>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => [
            ['class' => 'yii\grid\SerialColumn'],

            'token',
            [
                "attribute" => 'id_setting',
                "value" => function ($model) {
                    return $model->setting->judul_pemilihan;
                },
                'filter' => ArrayHelper::map(Setting::find()->asArray()->all(), 'id_setting', 'judul_pemilihan'),
            ],
            [
                "attribute" => 'is_pakai',
                "format" => "raw",
                "value" => function ($model) {
                    if ($model->is_pakai) {
                        return Html::tag("b", "SUDAH DIPAKAI", ["class" => "text-success text-decoration-none"]);
                    } else {
                        return Html::tag("b", "BELUM DIPAKAI", ["class" => "text-primary text-decoration-none"]);
                    }
                }
            ],
            [
                'class' => ActionColumn::className(),
                "template" => "{view} {delete}",
                'urlCreator' => function ($action, Token $model, $key, $index, $column) {
                    return Url::toRoute([$action, 'token' => $model->token]);
                }
            ],
        ],
    ]); ?>


</div>