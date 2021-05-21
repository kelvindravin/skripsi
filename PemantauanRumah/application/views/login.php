<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
    <title>Pemantauan Rumah - Login</title>
</head>


<body>
    <?php if ($this->session->flashdata('error')) { ?>
        <div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
    <?php } ?>

    <div class="container h-100 d-flex align-items-center justify-content-center">
        <div class="text-center" id="login_container">
            <div class="row">
                <div class="col-sm-12 col-xl-12">
                <img class="mb-3" src="./assets/images/UNPAR logo.ico" height="200" width="200" />
                    <h2 class="text-center">Aplikasi Informatif</h2>
                    <h2 class="text-cetnter">Sistem Pemantauan Rumah</h2>
                </div>
            </div>
            <div class="row justify-content-center align-items-center">
                <form action='login-process' method="post">
			<div class="row card-body">

				<div class="container">

					<div class="row form-group">
						<label for="label_email" class="col-sm-5 col-form-label">E-mail</label>

						<div class="col-sm-7">
							<input type="text" class="form-control" id="email" name="email">
						</div>
					</div>

					<div class="row form-group">
						<label for="label_password" class="col-sm-5 col-form-label">Password</label>

						<div class="col-sm-7">
							<input type="password" class="form-control" id="password" name="password">
						</div>
					</div>
					<div class="row">
						<div class="col-sm-12 text-center mt-3">
							<button type="submit" class="btn btn-success ml-1">Login</button>
						</div>
					</div>
				</div>
			</div>
		</form>
            </div>
        </div>
    </div>
</body>

</html>
