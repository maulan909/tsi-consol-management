<!-- Sidebar -->
<ul class="navbar-nav  sidebar sidebar-dark accordion" style="background-color: #f6921e;" id="accordionSidebar">

    <!-- Sidebar - Brand -->
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="<?= base_url(); ?>">
        <img src="<?= base_url('assets/img/tsi.png') ?>">
        <div class="sidebar-brand-text mx-3">TSI Consolidate Management</div>
    </a>

    <!-- Divider -->
    <hr class="sidebar-divider my-0">

    <?php
    $role_id = $user['role_id'];
    $query = "SELECT user_menu.id, menu FROM user_menu JOIN user_access_menu 
                ON user_menu.id = menu_id WHERE role_id = {$role_id}";
    $menu = $this->db->query($query)->result_array();
    ?>
    <?php foreach ($menu as $m) : ?>
        <!-- Heading -->
        <div class="sidebar-heading">
            <?= $m['menu']; ?>
        </div>
        <?php
        $submenu = $this->db->get_where('user_sub_menu', [
            'menu_id' => $m['id'],
            'is_active' => 1
        ])->result_array();
        ?>
        <?php foreach ($submenu as $sm) : ?>

            <!-- Nav Item - Dashboard -->
            <li class="nav-item <?php if ($sm['title'] == $title) echo 'active'; ?>">
                <a class="nav-link py-2" href="<?= base_url($sm['url']); ?>">
                    <i class="<?= $sm['icon']; ?>"></i>
                    <span><?= $sm['title']; ?></span>
                    <?php
                    $badge = explode('/', $sm['url']);
                    $badge = isset($badge[1]) ? $badge[1] : '';
                    ?>
                    <span class="badge badge-primary badge-counter d-none" id="<?= $badge; ?>">
                        <i class=" fas fa-bell"></i>
                    </span>
                </a>
            </li>

        <?php endforeach; ?>
        <!-- Divider -->
        <hr class="sidebar-divider mb-1">
    <?php endforeach; ?>
    <!-- Nav Item - Dashboard -->
    <li class="nav-item">
        <a class="nav-link" href="#" data-toggle="modal" data-target="#logoutModal">
            <i class="fas fa-fw fa-sign-out-alt"></i>
            <span>Logout</span></a>
    </li>
    <!-- Divider -->
    <hr class="sidebar-divider d-none d-md-block">

    <!-- Sidebar Toggler (Sidebar) -->
    <div class="text-center d-none d-md-inline">
        <button class="rounded-circle border-0" id="sidebarToggle"></button>
    </div>

</ul>
<!-- End of Sidebar -->

<!-- Content Wrapper -->
<div id="content-wrapper" class="d-flex flex-column">

    <!-- Main Content -->
    <div id="content">

        <!-- Topbar -->
        <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">


            <!-- Topbar Navbar -->
            <ul class="navbar-nav ml-auto">

                <!-- Nav Item - User Information -->
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $user['username']; ?></span>
                        <img class="img-profile rounded-circle" src="<?= base_url('assets/img/default.jpg'); ?>">
                    </a>
                    <!-- Dropdown - User Information -->
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                        <a class="dropdown-item" href="<?= base_url('profile/changepassword'); ?>">
                            <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                            Change Password
                        </a>
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>

            </ul>

        </nav>
        <!-- End of Topbar -->