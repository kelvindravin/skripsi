<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Pemantauan Rumah - Viewing</title>
</head>

<body class="d-flex flex-column min-vh-100">

    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>

    <header>
        <h1 class="text-center mt-5 text-white" style=" color: white; text-shadow: -1px -1px 0 #000, 1px -1px 0 #000, -1px 1px 0 #000, 1px 1px 0 #000;">
            Welcome to Pemantauan Rumah
        </h1>
    </header>

    <content>
        <div class="container">
            <div class="row">
                <div class="col-sm-3">
                    Temperature!
                </div>
                <div class="col-sm-3">
                    Humidity!
                </div>
                <div class="col-sm-3">
                    pH!
                </div>
            </div>
            <div class="row">
                <div class="col-sm-3">
                    LPG!
                </div>
                <div class="col-sm-3">
                    Carbon!
                </div>
                <div class="col-sm-3">
                    Smoke!
                </div>
            </div>
        </div>
    </content>
</body>

</html>