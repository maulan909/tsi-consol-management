<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#roleModal" id="btnTambahRole">Tambah Role</a>
    <div class="row">
        <div class="col-md-8">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User Role</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Role</th>
                                    <th width="20%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Role</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $a = 1;
                                foreach ($user_role as $ur) {
                                ?>
                                    <tr>
                                        <td><?= $a; ?></td>
                                        <td><?= $ur['role'] ?></td>
                                        <td>
                                            <a href="<?= base_url('user/roleaccess/' . $ur['id']) ?>" class="btn btn-warning mb-1"><i class="fas fa-fw fa-user-tag"></i></a>
                                            <a href="#" class="btn btn-success mb-1 btnEditRole" data-id="<?= $ur['id']; ?>" data-toggle="modal" data-target="#roleModal"><i class="fas fa-fw fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger mb-1 btnHapusRole" data-id="<?= $ur['id']; ?>" data-toggle="modal" data-target="#roleHapusModal"><i class="fas fa-fw fa-trash-alt"></i></a>
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

<!-- Role Modal -->
<div class="modal fade" id="roleModal" tabindex="-1" role="dialog" aria-labelledby="roleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleModalLabel">Tambah Role</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('user/role'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="rolename">Role</label>
                        <input type="text" class="form-control" id="rolename" name="role" placeholder="Role Name">
                        <small id="alertRoleName" class="text text-danger"></small>
                    </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Tambah</button>
            </div>
            </form>
        </div>
    </div>
</div>
<!-- Hapus Modal -->
<div class="modal fade" id="roleHapusModal" tabindex="-1" role="dialog" aria-labelledby="roleHapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleHapusModalLabel">Yakin Hapus Role?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus role ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>