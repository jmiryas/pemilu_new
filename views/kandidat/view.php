<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Kandidat $model */

$this->title = $model->id_kandidat;
$this->params['breadcrumbs'][] = ['label' => 'Kandidat', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="kandidat-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Update', ['update', 'id_kandidat' => $model->id_kandidat], ['class' => 'btn btn-primary']) ?>
        <?= Html::a('Delete', ['delete', 'id_kandidat' => $model->id_kandidat], [
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
            'id_kandidat',
            'nama_kandidat',
            [
                "attribute" => 'id_setting',
                "value" => function ($model) {
                    return $model->setting->nama_setting;
                }
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
            ]
        ],
    ]) ?>

</div>