<h2>Tambah Setting</h2>

<form action="" method="POST">
    <input type="hidden" name="_csrf" value="<?=Yii::$app->request->getCsrfToken()?>" />

    <div class="mb-3">
        <label class="form-label">Nama Setting</label>
        <input name="nama_setting" type="text" class="form-control" placeholder="Masukkan nama setting">
    </div>

    <div class="mb-3">
        <label class="form-label">Judul Pemilihan</label>
        <input name="judul_pemilihan" type="text" class="form-control" placeholder="Masukkan judul pemilihan">
    </div>

    <div class="mb-3">
        <label class="form-label">Voting Min</label>
        <input name="limit_voting_min" type="number" class="form-control" placeholder="Masukkan voting min">
    </div>

    <div class="mb-3">
        <label class="form-label">Voting Max</label>
        <input name="limit_voting_max" type="number" class="form-control" placeholder="Masukkan voting max">
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Awal</label>
        <input name="tgl_awal" type="date" class="form-control" placeholder="Pilih tanggal awal">
    </div>

    <div class="mb-3">
        <label class="form-label">Tanggal Akhir</label>
        <input name="tgl_akhir" type="date" class="form-control" placeholder="Pilih tanggal akhir">
    </div>

    <div class="form-check mb-3">
        <input name="is_aktif" id="status-aktif" class="form-check-input" type="checkbox" value="1" checked>
        <label class="form-check-label" for="status-aktif">
            Status Aktif
        </label>
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>