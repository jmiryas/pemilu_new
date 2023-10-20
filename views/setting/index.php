<h2><?php

    use yii\helpers\Html;

    $this->title = 'Setting';

    $this->params['breadcrumbs'][] = $this->title;

    echo $title; ?></h2>

<?php echo Html::a("Entri", ["setting/entri"], ["class" => "btn btn-primary"]); ?>

<table class="table table-hover">
  <thead>
    <tr>
      <th scope="col">No.</th>
      <th scope="col">Nama Setting</th>
      <th scope="col">Judul</th>
      <th scope="col">Voting Min</th>
      <th scope="col">Voting Max</th>
      <th scope="col">Tanggal Awal</th>
      <th scope="col">Tanggal Akhir</th>
      <th scope="col">Status Aktif</th>
      <th scope="col">Aksi</th>
    </tr>
  </thead>
  <tbody>
    <?php
    $index = 1;
    foreach ($settings as $setting) :
    ?>
      <tr>
        <th><?php echo $index++; ?></th>
        <td><?php echo $setting["nama_setting"]; ?></td>
        <td><?php echo $setting["judul_pemilihan"]; ?></td>
        <td><?php echo $setting["limit_voting_min"]; ?></td>
        <td><?php echo $setting["limit_voting_max"]; ?></td>
        <td><?php echo $setting["tgl_awal"]; ?></td>
        <td><?php echo $setting["tgl_akhir"]; ?></td>
        <td><?php echo $setting["is_aktif"]; ?></td>
        <td class="row gap-2">
          <?php echo Html::a("Update", ["setting/update", "id_setting" => $setting["id_setting"]], ["class" => "btn btn-sm btn-warning"]); ?>
          <?php echo Html::a("Hapus", ["setting/destroy", "id_setting" => $setting["id_setting"]], ["class" => "btn btn-sm btn-danger", "onclick" => "return confirm('Hapus setting?')"]); ?>
        </td>
      </tr>
    <?php
    endforeach;
    ?>
  </tbody>
</table>