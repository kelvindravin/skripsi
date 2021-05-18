<!-- Navigation -->
<html>

<body>
    <nav class="navbar sticky-top navbar-expand-lg home-navbar">
        <img src="./assets/images/UNPAR logo.ico" width="70px" height="70px" class="mr-1">
        <h3 class="text-center text-white pr-5">
            Pemantauan Rumah
        </h3>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "home") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('home') ?>">Beranda</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "history") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('history') ?>">Histori</a>
                </li>
                <!-- <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "about") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('about') ?>">Tentang</a>
                </li> -->
            </ul>
        </div>
    </nav>
</body>

</html>