<div class="wrapper">

    <!-- Sidebar -->
    <nav id="sidebar">
        <div class="main_admin_logo text-center mt-2">
            <a href="<?php echo base_url('admin-dashboard') ?>">
                <img src="./assets/images/Logo_LPPK_White_Base.png" width="100" height="100" /><br>
                <h3 class="text text-white mt-2">Administrator</h3>
            </a>
        </div>

        <ul class="list-unstyled">
            <li>
                <a href="<?php echo base_url('admin-dashboard'); ?>">Dashboard</a>
            </li>
        </ul>

        <ul class="list-unstyled components">
            <li>
                <a href="#menuPerusahaanSub" data-toggle="collapse" class="dropdown-toggle" aria-expanded="">Menu Perusahaan
                </a>
                <ul class="collapse list-unstyled pl-2" id="menuPerusahaanSub">
                    <li>
                        <a href="<?php echo base_url('daftar-perusahaan'); ?>" class="">Daftar Perusahaan</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('edit-data') ?>" class="">Edit Data</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('status-benefit') ?>" class="">Status Benefit Perusahaan</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('edit-benefit') ?>" class="">Edit Benefit</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('publikasi') ?>" class="">Detail Benefit Publikasi</a>
                    </li>
                    <li>
                        <a href="<?php echo base_url('benefit-lainnya') ?>" class="">Detail Benefit Lainnya</a>
                    </li>
                </ul>
            </li>
        </ul>

        <ul class="list-unstyled">
            <li>
                <a href="<?php echo base_url('laporan'); ?>">Laporan</a>
            </li>
        </ul>

        <?php if ($this->session->userdata('usertype') == 'superadmin') {
            echo '
                            <ul class="list-unstyled">
                                <li>
                                    <a href="'.base_url('log').'">Log Aktivitas</a>
                                </li>
                            </ul>
                            ';
        } ?>

        <?php if ($this->session->userdata('usertype') == 'superadmin') {
            echo '
                            <ul class="list-unstyled">
                                <li>
                                    <a href="'.base_url('auth').'">Kelola User</a>
                                </li>
                            </ul>
                            ';
        } ?>

        <ul class="list-unstyled">
            <li>
                <a href="<?php echo base_url('logout') ?>" class="btn btn-danger">Logout</a>
            </li>
        </ul>
    </nav>

    <!-- Page Content -->
    <div id="content" class="w-100 mt-1 mr-1">
        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="container-fluid">
                <button type="button" id="sidebarCollapse" class="btn btn-outline-success">
                    <i class="fa fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="nav navbar-nav ml-auto w-100 d-flex justify-content-between">
                        <li class="nav-item mr-5 text-muted">
                            <p class="m-2 text-center" id="time"></p>
                        </li>
                        <li class="nav-item ml-5 text-muted">
                            <p class="m-2 text-center">Welcome
                                <?php
                                if ($this->session->userdata('usertype') == 'superadmin') {
                                ?>
                                    <span class="text-primary">[ Super Admin ] , </span>
                                <?php
                                } else {
                                ?>
                                    <span class="text-danger">[ Admin ] , </span>
                                <?php
                                }
                                ?>
                                <span class="text-success">
                                    <?php
                                    $username = $this->session->userdata('username');
                                    echo $username;
                                    ?>
                                </span>
                            </p>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>


        <!-- Div wrapper dan div content belum ditutup -->

        <!-- For the collapsible button -->
        <script>
            $(document).ready(function() {
                $('#sidebarCollapse').on('click', function() {
                    $('#sidebar').toggleClass('active');
                });
            });

            var timestamp = '<?= date('Y-m-d H:i:s'); ?>';

            function updateTime() {
                $('#time').html('Server Time : ' + Date(timestamp));
                timestamp++;
            }
            $(function() {
                setInterval(updateTime, 1000);
            });
        </script>