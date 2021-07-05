<div class="container-fluid">
    <?= $this->session->flashdata('messages'); ?>
    <h1 class="h3 mb-4 text-gray-800"><?= $title; ?></h1>
    <div class="row">
        <div class="col-lg-6">
            <form action="<?= base_url('profile/changepassword'); ?>" method="post">
                <div class="form-group">
                    <label for="old_password">Old Password</label>
                    <input type="password" class="form-control" id="old_password" name="old_password" placeholder="Old Password">
                    <?= form_error('old_password', '<small class="text text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="password1">New Password</label>
                    <input type="password" class="form-control" id="password1" name="password1" placeholder="New Password">
                    <?= form_error('password1', '<small class="text text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <label for="password2">Repeat Password</label>
                    <input type="password" class="form-control" id="password2" name="password2" placeholder="Repeat Password">
                    <?= form_error('password2', '<small class="text text-danger">', '</small>'); ?>
                </div>
                <div class="form-group">
                    <button type="submit" class="btn btn-primary">Change Password</button>
                </div>
            </form>
        </div>
    </div>
</div>