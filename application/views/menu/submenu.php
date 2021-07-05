<!-- Begin Page Content -->
<div class="container-fluid">

    <!-- Page Heading -->
    <?= validation_errors('<div class="alert alert-danger">', '</div>'); ?>
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <a href="#" class="btn btn-primary" data-toggle="modal" data-target="#submenuModal" id="btnTambahSubmenu">Tambah Submenu</a>
    <div class="row">
        <div class="col-lg">
            <div class="card shadow mt-3">
                <div class="card-header py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Submenu</h6>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-bordered" width="100%" cellspacing="0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Menu</th>
                                    <th>Url</th>
                                    <th>Icon</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tfoot>
                                <tr>
                                    <th>#</th>
                                    <th>Title</th>
                                    <th>Menu</th>
                                    <th>Url</th>
                                    <th>Icon</th>
                                    <th>Active</th>
                                    <th>Action</th>
                                </tr>
                            </tfoot>
                            <tbody>
                                <?php
                                $a = 1;
                                foreach ($submenu as $sm) {
                                ?>
                                    <tr>
                                        <td><?= $a; ?></td>
                                        <td><?= $sm['title']; ?></td>
                                        <td><?= $sm['menu'] ?></td>
                                        <td><?= $sm['url']; ?></td>
                                        <td><?= $sm['icon']; ?></td>
                                        <td><?= $sm['is_active'] ?></td>
                                        <td>
                                            <a href="#" class="btn btn-success mb-1 btnEditSubmenu" data-id="<?= $sm['id']; ?>" data-toggle="modal" data-target="#submenuModal"><i class="fas fa-fw fa-edit"></i></a>
                                            <a href="#" class="btn btn-danger mb-1 btnHapusSubmenu" data-id="<?= $sm['id']; ?>" data-toggle="modal" data-target="#submenuHapusModal"><i class="fas fa-fw fa-trash-alt"></i></a>
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
<div class="modal fade" id="submenuModal" tabindex="-1" role="dialog" aria-labelledby="submenuModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="submenuModalLabel">Tambah Submenu</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="<?= base_url('menu/submenu'); ?>" method="post">
                    <input type="hidden" name="id" id="id">
                    <div class="form-group">
                        <label for="title">Submenu Title</label>
                        <input type="text" class="form-control" id="title" name="title" placeholder="Submenu Title" required>
                        <small id="alertSubmenu" class="text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="menu_id">Menu</label>
                        <select class="form-control" id="menu_id" name="menu_id" required>
                            <option value="">-- Choose Menu --</option>
                            <?php foreach ($menu as $m) : ?>
                                <option value="<?= $m['id'] ?>"><?= $m['menu']; ?></option>
                            <?php endforeach; ?>
                        </select>
                        <small id="alertMenuId" class="text text-danger"></small>
                    </div>
                    <label for="basic-url">Url</label>
                    <div class="input-group mb-3">
                        <div class="input-group-prepend">
                            <span class="input-group-text"><?= base_url(); ?></span>
                        </div>
                        <input type="text" class="form-control" id="url" name="url" required>
                        <small id="alertUrl" class="text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="icon">Icon</label>
                        <input type="text" class="form-control" id="icon" name="icon" placeholder="Font Awesome Icon" required>
                        <small id="alertIcon" class="text text-danger"></small>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" value="1" id="is_active" name="is_active" checked>
                        <label class="form-check-label" for="is_active">
                            Active
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
<div class="modal fade" id="submenuHapusModal" tabindex="-1" role="dialog" aria-labelledby="roleHapusModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="roleHapusModalLabel">Yakin Hapus Submenu?</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                Yakin ingin menghapus submenu ini?
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <a href="#" class="btn btn-danger">Hapus</a>
            </div>
        </div>
    </div>
</div>