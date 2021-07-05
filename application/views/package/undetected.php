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
                    <div class="table-responsive">
                        <table class="table table-bordered" id="offlineList" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($lists as $list) {
                                    $koli = $this->package->getTotalKoli($list);
                                ?>
                                    <tr>
                                        <td><?= $list; ?></td>
                                        <td><?= $this->package->getLocation($list); ?></td>
                                        <td><?= $koli['dry']; ?> Koli Dry/Fresh & <?= $koli['frozen']; ?> Koli Frozen/Chiller</td>
                                        <td align="center"><a href="#" data-id="<?= $list; ?>" class="btn btn-primary moveConsUnd"><i class="fas fa-dolly"></i> Move to Delivery Zone</a></td>
                                    </tr>
                                <?php

                                }
                                ?>

                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->