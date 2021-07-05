<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#userModal" id="btnTambahUser">Tambah User</a>
    <div class="row">
        <div class="col-xl-10">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">User</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" id="userTable" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th width="5%">#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Active</th>
                                    <th width="10%">Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Username</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php $i = 1; ?>
                                <?php foreach ($user_list as $us) : ?>
                                    <tr>
                                        <td><?= $i; ?></td>
                                        <td><?= $us['username']; ?></td>
                                        <td><?= $us['email']; ?></td>
                                        <td><?= $us['role']; ?></td>
                                        <td><?= $us['is_active']; ?></td>
                                        <td>
                                            <?php if ($us['role_id'] != 1) : ?>
                                                <a href="" class="btn btn-success mt-1 btnEditUser" data-id="<?= $us['id'] ?>" data-toggle="modal" data-target="#userModal"><i class="fas fa-fw fa-edit"></i></a>
                                                <a href="" class="btn btn-danger mt-1 btnHapusUser" data-id="<?= $us['id'] ?>" data-toggle="modal" data-target="#userHapusModal"><i class="fas fa-fw fa-trash-alt"></i></a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php $i++; ?>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
<!-- /.container-fluid -->

<!-- User Modal -->
<div class="modal fade" id="userModal" tabindex="-1" role="dialog" aria-labelledby="userModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userModalLabel">Tambah User</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('user'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" placeholder="username" required>
                        <small class="text text-danger" id="alertUsername"></small>
                    </div>
                    <div class="form-group">
                        <label for="email">Email (Optional)</label>
                        <input type="email" class="form-control" id="email" name="email" placeholder="Email Address">
                        <small class="text text-danger" id="alertEmail"></small>
                    </div>
                    <div class="form-group">
                        <label for="role_id">Role</label>
                        <select class="custom-select" name="role_id" id="role_id" required>
                            <option value="">-- Pilih Role --</option>
                            <?php foreach ($user_role as $ur) : ?>
                                <option value="<?= $ur['id']; ?>"><?= $ur['role']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group row">
                        <div class="col-sm-9">
                            <input type="text" class="form-control" id="password" name="password" placeholder="Password" autocomplete="off" required>
                        </div>
                        <div class="col-sm-3">
                            <a href="#" class="btn btn-secondary" id="btnGenerate">Generate</a>
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" name="is_active" id="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            active
                        </label>
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
<div class="modal fade" id="userHapusModal" tabindex="-1" role="dialog" aria-labelledby="userHapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="userHapusModalLabel">Yakin Hapus User?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus user ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>