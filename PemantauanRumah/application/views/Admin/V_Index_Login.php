<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Admin | Formulir Kerjasama Perusahaan</title>
</head>


<body>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>

    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="text-center" id="login_container">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                <img src="./assets/images/Logo_LPPK.png" height="150" width="150" />
                    <h2 class="text-center">Administrasi Formulir Kerjasama Perusahaan</h2>
                </div>
            </div>
            <div class="row">
                <div class="col">
                    <div class="row">
                        <div class="col-sm-12 text-center mt-3">
                            <!-- Untuk check login -->
                            <a href="<?= base_url('admin-login') ?>" type="button" class="btn btn-success ml-1"> Login</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>