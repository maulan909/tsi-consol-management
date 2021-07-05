<div class="container-fluid">
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-3 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-body">
                    <form action="<?= base_url('additional'); ?>" method="post">
                        <div class="form-group row">
                            <label for="total_palet" class="col-sm-3 col-form-label">Total Palet Consol</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="total_palet" name="total_palet" placeholder="Total Palet Consol" value="<?= $settings['total_palet']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="max_koli" class="col-sm-3 col-form-label">Maksimal Koli Per Palet</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="max_koli" name="max_koli" placeholder="Maksimal Koli Per Palet" value="<?= $settings['max_koli']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="jadwal_backup" class="col-sm-3 col-form-label">Jadwal Backup Per Hari</label>
                            <div class="col-sm-9">
                                <input type="number" class="form-control" id="jadwal_backup" name="jadwal_backup" placeholder="Jadwal Backup" value="<?= $settings['jadwal_backup']; ?>" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-sm-9 offset-sm-3">
                                <button type="submit" class="btn btn-primary">Save Changes</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>