<div class="container-fluid">

    <!-- Page Heading -->
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <div class="row mt-3">
        <div class="col-lg-6">
            <form action="<?= base_url('consol/edit/' . $detail['id_pack_consol']); ?>" method="post">
                <input type="hidden" id="id" name="id" value="<?= $detail['id_pack_consol']; ?>">
                <div class="form-group">
                    <label for="ca_no">External Order No</label>
                    <input type="text" class="form-control" id="ca_no" name="ca_no" placeholder="External Order No" value="<?= $detail['ca_no']; ?>" autocomplete="off" readonly required>
                    <?= form_error('ca_no', '<small class="text text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="palet_no">Lokasi Palet Consol</label>
                    <input type="number" class="form-control" id="palet_no" name="palet_no" placeholder="Lokasi Palet Consol" value="<?= $detail['palet_no']; ?>" autocomplete="off" readonly required>
                    <?= form_error('palet_no', '<small class="text text-danger">', '</small>'); ?>
                    <small class="d-none" id="suggested"></small>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="checkbox" value="1" id="remarks" name="remarks" <?php if ($detail['remarks'] == 1) echo 'checked'; ?>>
                    <label class="form-check-label" for="remarks">
                        Frozen / Chiller
                    </label>
                </div>
                <div class="form-group mt-2">
                    <label for="koli">Jumlah Koli</label>
                    <input type="number" class="form-control" id="koli" name="koli" placeholder="Jumlah Koli" value="<?= $detail['koli']; ?>" autocomplete="off" required>
                    <?= form_error('koli', '<small class="text text-danger">', '</small>'); ?>
                </div>
                <div class="d-none" id="jmlPicklist"></div>
                <div class="d-none" id="jmlKoli"></div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Edit</button>
                </div>
            </form>
        </div>
    </div>
</div>