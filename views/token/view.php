<?php

use yii\helpers\Html;
use yii\widgets\DetailView;

/** @var yii\web\View $this */
/** @var app\models\Token $model */

$this->title = $model->token;
$this->params['breadcrumbs'][] = ['label' => 'Tokens', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="token-view">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?php 
        // echo Html::a('Update', ['update', 'token' => $model->token], ['class' => 'btn btn-primary']) 
        ?>

        <?php 
        echo Html::a('Delete', ['delete', 'token' => $model->token], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]); 
        ?>
    </p>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'token',
            [
                "attribute" => 'id_setting',
                "value" => function($model) {
                    return $model->setting->nama_setting;
                }
            ],
            [
                "attribute" => 'is_pakai',
                "format" => "raw",
                "value" => function($model) {
                    if ($model->is_pakai) {
                        return Html::tag("b", "SUDAH DIPAKAI", ["class" => "text-success text-decoration-none"]);
                    } else {
                        return Html::tag("b", "BELUM DIPAKAI", ["class" => "text-primary text-decoration-none"]);
                    }
                }
            ],
        ],
    ]) ?>

</div>
