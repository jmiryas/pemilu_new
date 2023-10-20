<?php

/** @var yii\web\View $this */

use yii\helpers\Url;

$this->title = 'Pemilihan';

$js = <<< JS

$(document).ready(function() {
    $('input[type="checkbox"]').click(function() {
        var checkbox = $(this);
        var checkboxId = checkbox.attr('id');
        var label = $('label[for="' + checkboxId + '"]');
        
        if (checkbox.is(':checked')) {
            label.text('Terpilih ✓');
            label.addClass('btn-warning');
        } else {
            label.text('Pilih');
            label.removeClass('btn-warning');
        }
    });
});

JS;

$this->registerJs($js);

?>

<div class="site-index">
    <div class="container">
        <div class="row mt-3">
            <div class="col-6">
                <h4>
                    <?php echo $setting["nama_setting"]; ?>
                </h4>
            </div>

            <div class="col-6 text-end">
                <?php
                $tgl_awal = date("d F", strtotime($setting["tgl_awal"]));
                $tgl_akhir = date("d F Y", strtotime($setting["tgl_akhir"]));
                ?>

                <h4>
                    Periode Pemilihan <?php echo $tgl_awal ?> - <?php echo $tgl_akhir ?>
                </h4>
            </div>
        </div>

        <!-- Card Info Pemilihan -->

        <div class="card border-danger mt-3">
            <h5 class="card-header bg-danger text-white">Informasi Pemilihan</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pemilihan Minimum
                        <span class="badge bg-primary rounded-pill">
                            <?php echo $setting["limit_voting_min"]; ?>
                        </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Pemilihan Maksimum
                        <span class="badge bg-primary rounded-pill">
                            <?php echo $setting["limit_voting_max"]; ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- End Card Info Pemilihan -->

        <!-- Card Kandidat -->

        <form action="<?php echo Url::to(['site/store-pemilihan']); ?>" method="POST" class="mt-4">
            <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

            <input name="id_setting" type="hidden" value="<?php echo $setting['id_setting']; ?>">
            <input name="token" type="hidden" value="<?php echo $token['token']; ?>">

            <div class="row mt-3">
                <?php foreach ($kandidatList as $index => $kandidat) : ?>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-3 mb-4">
                        <div class="card">
                            <!-- <img src="https://via.placeholder.com/1110x650.png" class="card-img-top" style="height: 200px;"> -->
                            <div class="d-flex justify-content-center">
                                <?php if ($kandidat["foto"] == null) : ?>
                                    <img style="width: 150px;" src="<?php echo Yii::getAlias("@web/image/avatar.png"); ?>" class="img-fluid d-none d-lg-inline">
                                <?php else : ?>
                                    <img style="width: 150px;" src="<?php echo Yii::getAlias("@web/image/") . $kandidat['foto']; ?>" class="img-fluid d-none d-lg-inline">
                                <?php endif ?>
                            </div>

                            <div class="card-body">
                                <h5 class="card-title">
                                    <?php if (strlen($kandidat["nama_kandidat"]) > 18) : ?>
                                        <?php echo substr($kandidat["nama_kandidat"], 0, 18) . " ..."; ?>
                                    <?php else : ?>
                                        <?php echo $kandidat["nama_kandidat"]; ?>
                                    <?php endif ?>
                                </h5>

                                <div class="form">
                                    <input name="kandidat[]" value="<?php echo $kandidat['id_kandidat']; ?>" type="checkbox" class="btn-check" id="btn-check-<?php echo $index; ?>" autocomplete="off">
                                    <label class="btn btn-primary btn-sm" for="btn-check-<?php echo $index; ?>">Pilih</label>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endforeach ?>
            </div>

            <div class="row mt-3 justify-content-center">
                <div class="col-2 d-grid">
                    <button onclick="return confirm('Anda yakin?')" type="submit" class="btn btn-sm btn-primary btn-block">Submit</button>
                </div>
            </div>
        </form>

        <!-- END Card Kandidat -->
    </div>
</div>