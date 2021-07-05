<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="text text-danger">Note: Refresh halaman untuk update tabel</div>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
                </div>
                <div class="card-body">
                    <div class="row justify-content-end">
                        <form action="<?= base_url('package/history'); ?>" method="POST">
                            <div class="form-group mx-sm-1 mb-2 d-inline-block">
                                <input type="text" class="form-control form-control-sm" id="keyword" name="keyword" placeholder="Search..." autocomplete="off">
                            </div>
                            <input type="submit" name="submit" value="Search" name="submit" class="btn btn-sm btn-primary mr-3 mb-2 mt-1 d-inline-block">
                        </form>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>Order No</th>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Palet Location</th>
                                    <th>Total Koli</th>
                                    <th>Consol Date</th>
                                    <th>Move Date</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>Order No</th>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Palet Location</th>
                                    <th>Total Koli</th>
                                    <th>Consol Date</th>
                                    <th>Move Date</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($histories as $history) {
                                ?>
                                    <tr>
                                        <td><?= $history['order_no']; ?></td>
                                        <td><?= $history['external_order']; ?></td>
                                        <td><?= $history['total_picklist']; ?></td>
                                        <td><?= $history['palet_no']; ?></td>
                                        <td><?= $history['total_koli']; ?></td>
                                        <td><?= ($history['consol_date'] !== '') ? date('d-m-Y H:m:s', $history['consol_date']) : ''; ?></td>
                                        <td><?= ($history['move_date'] !== '') ? date('d-m-Y H:m:s', $history['move_date']) : ''; ?></td>
                                    </tr>
                                <?php
                                }
                                ?>
                            </tbody>
                        </table>
                    </div>
                    <?= $this->pagination->create_links(); ?>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->