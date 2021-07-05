<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-0 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary"><?= $title; ?> List</h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-4 offset-lg-8">
                            <form action="<?= base_url('additional/log'); ?>" method="post">
                                <div class="input-group mb-3">
                                    <input type="text" class="form-control" name="keyword" placeholder="Search..." aria-describedby="submit" autocomplete="off">
                                    <div class="input-group-append">
                                        <input type="submit" class="btn btn-primary" name="submit" id="submit" value="Search">
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>External Order No</th>
                                    <th width="20%">Log</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>External Order No</th>
                                    <th>Log</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                foreach ($logs as $log) {
                                    $id = $this->Log_model->getLogDetail($log['ext_no'])->row_array();
                                ?>
                                    <tr>
                                        <td><?= $log['ext_no']; ?></td>
                                        <td align="right"><a href="<?= base_url('additional/detail/' . $id['id']); ?>" class="btn btn-primary"><i class="fas fa-file-signature"></i> See Log</a></td>
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