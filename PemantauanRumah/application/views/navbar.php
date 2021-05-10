<!-- Navigation -->
<html>

<body>
    <nav class="navbar sticky-top navbar-expand-lg home-navbar">
        <img src="./assets/images/Dota 2 Icon.png" width="70px" height="70px" class="mr-5">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNavDropdown" aria-controls="navbarNavDropdown" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNavDropdown">
            <ul class="navbar-nav">
                <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "home") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('home') ?>">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "heroes") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('heroes') ?>">Heroes</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link <?php if ($current_nav == "about") {
                                            echo " active";
                                        } ?>" href="<?php echo site_url('about') ?>">About</a>
                </li>
            </ul>
        </div>
    </nav>
</body>

</html>