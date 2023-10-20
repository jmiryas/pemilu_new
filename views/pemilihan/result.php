<?php

use app\models\Pemilihan;
use yii\helpers\Html;
use dosamigos\chartjs\ChartJs;

$this->title = 'Hasil Pemilihan';
$this->params['breadcrumbs'][] = $this->title;

?>

<div class="pemilihan-index">
    <?php if (count($voting_result) > 0) : ?>
        <h5>
            <?php
            $tgl_awal = date("d F", strtotime($current_setting["tgl_awal"]));
            $tgl_akhir = date("d F Y", strtotime($current_setting["tgl_akhir"]));
            ?>

            <?php
            echo $this->title . " '" . $current_setting["nama_setting"] . "' | " .
                $tgl_awal . " - " . $tgl_akhir;
            ?>
        </h5>

        <!-- Card Info Pemilihan -->

        <div class="card border-danger mt-3">
            <h5 class="card-header bg-danger text-white">Informasi Pemilihan</h5>
            <div class="card-body">
                <ul class="list-group list-group-flush">
                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Pemilih
                        <span class="badge bg-primary rounded-pill px-3">
                            <?php echo $total_voters; ?>
                        </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Sudah Memilih
                        <span class="badge bg-info rounded-pill px-3">
                            <?php echo $total_has_voted; ?>
                        </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Belum Memilih
                        <span class="badge bg-secondary rounded-pill px-3">
                            <?php echo $total_not_voted; ?>
                        </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Suara Sah
                        <span class="badge bg-success rounded-pill px-3">
                            <?php echo $total_suara_sah; ?>
                        </span>
                    </li>

                    <li class="list-group-item d-flex justify-content-between align-items-center">
                        Total Golput
                        <span class="badge bg-danger rounded-pill px-3">
                            <?php echo $total_suara_golput; ?>
                        </span>
                    </li>
                </ul>
            </div>
        </div>

        <!-- End Card Info Pemilihan -->

        <table class="table table-bordered table-hover mt-4">
            <thead>
                <tr>
                    <th scope="col" class="bg-black text-white">No.</th>
                    <th scope="col" class="bg-black text-white">Foto Kandidat</th>
                    <th scope="col" class="bg-black text-white">Nama Kandidat</th>
                    <th scope="col" class="bg-black text-white">Total Suara</th>
                    <th scope="col" class="bg-black text-white">Status</th>
                </tr>
            </thead>
            <tbody>
                <?php
                foreach ($voting_result as $index => $voting) :
                ?>
                    <tr>
                        <th class="<?php echo $index == 0 && $voting["total_suara"] > 0 ? 'bg-success text-white' : '' ?>"><?php echo $index + 1; ?></th>

                        <td class="<?php echo $index == 0 && $voting["total_suara"] > 0 ? 'bg-success text-white' : '' ?>">
                            <?php if ($voting["foto"] == null) : ?>
                                <img style="width: 50px;" src="<?php echo Yii::getAlias("@web/image/avatar.png"); ?>" class="img-fluid d-none d-lg-inline">
                            <?php else : ?>
                                <img style="width: 50px;" src="<?php echo Yii::getAlias("@web/image/") . $voting["foto"]; ?>" class="img-fluid d-none d-lg-inline">
                            <?php endif ?>
                        </td>

                        <td class="<?php echo $index == 0 && $voting["total_suara"] > 0 ? 'bg-success text-white' : '' ?>"><?php echo $voting["nama_kandidat"]; ?></td>

                        <td class="<?php echo $index == 0 && $voting["total_suara"] > 0 ? 'bg-success text-white' : '' ?>">
                            <?php echo number_format($voting["total_suara_persen"], 2, ",", ""); ?>%
                        </td>

                        <td class="<?php echo $index == 0 && $voting["total_suara"] > 0 ? 'bg-success text-white' : '' ?>">
                            <?php if ($index == 0 && $voting["total_suara"] > 0) : ?>
                                <p>Kandidat Terpilih</p>
                            <?php else : ?>
                                <p>-</p>
                            <?php endif ?>
                        </td>
                    </tr>
                <?php
                endforeach;
                ?>
            </tbody>
        </table>
    <?php else : ?>
        <h5 class="text-center">Hasil pemilihan tidak ada</h5>
    <?php endif ?>
</div>