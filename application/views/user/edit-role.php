<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="<?= base_url('user/role'); ?>" class="btn btn-primary">Kembali</a>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Role : <?= $role['role']; ?></h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Menu</th>
                                    <th width="20%">Access</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Menu</th>
                                    <th>Access</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $a = 1;
                                foreach ($menu as $m) {
                                ?>
                                    <tr>
                                        <td><?= $a; ?></td>
                                        <td><?= $m['menu'] ?></td>
                                        <td>
                                            <div class="form-check">
                                                <input class="form-check-input" type="checkbox" data-role="<?= $role['id']; ?>" data-menu="<?= $m['id'] ?>" <?= check_access($role['id'], $m['id']); ?>>
                                            </div>
                                        </td>
                                    </tr>
                                <?php
                                    $a++;
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