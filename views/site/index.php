<?php

/** @var yii\web\View $this */

$this->title = 'Pemilu';

?>

<div class="site-index">
    <div class="container">
        <?php if ($setting != null) : ?>

            <div class="row">
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

            <div class="row mt-4">
                <div id="carouselExampleInterval" class="carousel slide" data-bs-ride="carousel">
                    <div class="carousel-indicators">

                        <?php foreach ($kandidatList as $index => $kandidat) : ?>
                            <button type="button" data-bs-target="#carouselExampleInterval" data-bs-slide-to="<?php echo $index; ?>" class="<?php echo $index == 0 ? 'active' : '' ?>" aria-current="true" aria-label="Slide <?php echo $index++; ?>">
                            </button>
                        <?php endforeach ?>
                    </div>

                    <div class="carousel-inner">
                        <?php foreach ($kandidatList as $index => $kandidat) : ?>
                            <div class="carousel-item <?php echo $index == 0 ? 'active' : '' ?>" data-bs-interval="2000">
                                <div class="d-block w-100" style="height: 400px; background-color: tomato;"></div>
                                <!-- <img src="https://fakeimg.pl/1000x400" class="d-block w-100" alt="..."> -->

                                <div class="carousel-caption d-none d-md-block" style="height: 400px;">
                                    <div class="row justify-content-center align-items-center" style="height: 100%;">
                                        <div class="col-12 col-lg-6">
                                            <?php if ($kandidat["foto"] == null) : ?>
                                                <img style="width: 250px;" src="<?php echo Yii::getAlias("@web/image/avatar.png"); ?>" class="img-fluid d-none d-lg-inline">
                                            <?php else : ?>
                                                <img style="width: 250px;" src="<?php echo Yii::getAlias("@web/image/") . $kandidat['foto']; ?>" class="img-fluid d-none d-lg-inline">
                                            <?php endif ?>
                                        </div>

                                        <div class="col-12 col-lg-6">
                                            <div>
                                                <h5>
                                                    <u><?php echo $kandidat["nama_kandidat"]; ?></u>
                                                </h5>

                                                <p>
                                                    <b>Visi:</b>
                                                </p>

                                                <?php if (count($kandidat["visis"]) > 0) : ?>
                                                    <?php foreach ($kandidat["visis"] as $visi) : ?>
                                                        <p><?php echo $visi["nama_visi"] ?></p>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <p>Tidak ada visi</p>
                                                <?php endif ?>

                                                <p>
                                                    <b>Misi:</b>
                                                </p>

                                                <?php if (count($kandidat["misiList"]) > 0) : ?>
                                                    <?php foreach ($kandidat["misiList"] as $misi) : ?>
                                                        <p><?php echo $misi["nama_misi"] ?></p>
                                                    <?php endforeach; ?>
                                                <?php else : ?>
                                                    <p>Tidak ada misi</p>
                                                <?php endif ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="prev">
                        <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Previous</span>
                    </button>

                    <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleInterval" data-bs-slide="next">
                        <span class="carousel-control-next-icon" aria-hidden="true"></span>
                        <span class="visually-hidden">Next</span>
                    </button>
                </div>
            </div>

            <div class="row g-3 justify-content-center align-items-center mt-3">
                <div class="col d-flex justify-content-center">
                    <form action="" method="POST">
                        <input type="hidden" name="_csrf" value="<?= Yii::$app->request->getCsrfToken() ?>" />

                        <div class="row">
                            <div class="col-auto">
                                <label class="col-form-label">Masukkan Token</label>
                            </div>

                            <div class="col-auto">
                                <input name="token" type="text" class="form-control" placeholder="Masukkan token">
                            </div>

                            <div class="col-auto">
                                <button type="submit" class="btn btn-sm btn-primary">Redeem</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

        <?php else : ?>
            <h4 class="text-center mt-3">Tidak ada pemilhan di periode ini</h4>
        <?php endif ?>
    </div>
</div>