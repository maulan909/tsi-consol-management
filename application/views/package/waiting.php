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
                        <table class="table table-bordered" id="waitList" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Kekurangan Picklist</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Kekurangan Picklist</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($orders as $order) {
                                    $picklist = $this->package->getTotalPicklist($order['ca_no']);
                                    if ($picklist['consol'] != $picklist['total']) {
                                        $koli = $this->package->getTotalKoli($order['ca_no']);
                                ?>
                                        <tr>
                                            <td><?= $order['ca_no']; ?></td>
                                            <td><?= $picklist['total']; ?> Picklist</td>
                                            <td><?= $picklist['total'] - $picklist['consol']; ?> Picklist</td>
                                            <td><?= $this->package->getLocation($order['ca_no']); ?></td>
                                            <td><?= $koli['dry']; ?> Koli Dry/Fresh & <?= $koli['frozen']; ?> Frozen/Chiller</td>
                                        </tr>
                                <?php
                                    }
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