<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('consol/add'); ?>" class="btn btn-primary my-3">Tambah</a>
    <div class="text text-danger">Note: Refresh halaman untuk update tabel</div>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External Order No</th>
                                    <th>No Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Remarks</th>
                                    <th>Tanggal Input</th>
                                    <th>Option</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>External Order No</th>
                                    <th>No Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Remarks</th>
                                    <th>Tanggal Input</th>
                                    <th>Option</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($consol as $cons) {
                                    if ($cons['remarks'] == 1) {
                                        $cons['remarks'] = 'Frozen & Chiller';
                                    } else {
                                        $cons['remarks'] = '';
                                    }
                                ?>
                                    <tr>
                                        <td><?= $cons['ca_no']; ?></td>
                                        <td><?= $cons['palet_no'] ?></td>
                                        <td><?= $cons['koli'] ?> Koli</td>
                                        <td><?= $cons['remarks'] ?></td>
                                        <td><?= $cons['tgl']; ?></td>
                                        <td align="center">
                                            <a href="<?= base_url('consol/edit/' . $cons['id_pack_consol']) ?>" class="btn btn-success mt-1"><i class="fa fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger mt-1 delCons" data-id="<?= $cons['id_pack_consol']; ?>"><i class="fa fa-trash-alt"></i></a>
                                        </td>
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