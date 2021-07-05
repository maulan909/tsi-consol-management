<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
        <a href="<?= base_url('package/readyexport'); ?>" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm"><i class="fas fa-download fa-sm text-white-50"></i> Export xls</a>
    </div>
    <div class="d-sm-flex justify-content-end">
        <form id="labelForm" action="https://eretail.tanihub.com/eRetailWeb/printShippingLabelForMultipleFormats" method="GET">
            <div class="input-group mb-3">
                <input type="hidden" name="printRemainingDocFlag" value="false">
                <input type="hidden" name="flag" value="OutboundLabel">
                <input type="hidden" name="fileNameSufiX" value="">
                <input type="hidden" name="attchment" value="false">
                <input type="text" class="form-control" placeholder="Enter Delivery No." id="delNOS" name="delNOS" autocomplete="off">
                <div class="input-group-append">
                    <button type="submit" class="btn btn-primary" id="btnSubmit">Open Label</button>
                </div>
            </div>
        </form>
    </div>
    <div class="text text-danger">Note: Refresh halaman untuk update tabel</div>

    <div class="row">
        <div class="col-lg">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="readyList" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Kekurangan Picklist</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Total Picklist</th>
                                    <th>Kekurangan Picklist</th>
                                    <th>Lokasi Palet</th>
                                    <th>Jumlah Koli</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($orders as $order) {
                                    $picklist = $this->package->getTotalPicklist($order);
                                    if ($picklist['consol'] == $picklist['total']) {
                                        $koli = $this->package->getTotalKoli($order);
                                ?>
                                        <tr>
                                            <td><?= $order; ?></td>
                                            <td><?= $picklist['total'] ?> Picklist</td>
                                            <td><?= $picklist['total'] - $picklist['consol']; ?> Picklist</td>
                                            <td><?= $this->package->getLocation($order); ?></td>
                                            <td><?= $koli['dry']; ?> Koli Dry/Fresh & <?= $koli['frozen']; ?> Koli Frozen/Chiller</td>
                                            <td align="center">
                                                <a href="#" data-id="<?= $order; ?>" class="btn btn-primary moveCons"><i class="fas fa-dolly"></i> Move to Delivery Zone</a>
                                            </td>
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