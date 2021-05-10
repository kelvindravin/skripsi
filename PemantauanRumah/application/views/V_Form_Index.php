<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Formulir Pendaftaran Kerjasama</title>
</head>

<body class="form-main-body">

	<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
	<?php } else if ($this->session->flashdata('success')) { ?>
		<div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
	<?php } ?>

	<div class="container middle-content py-5 px-5 transparent-background">
		<div class="row">
			<div class="col-sm-4 d-flex align-items-center justify-content-center">
				<img src="./assets/images/Logo_LPPK.png" width="200" height="200">
			</div>
			<div class="col-sm-8">
				<div class="text-center">
					<h3>Formulir Pendaftaran Kerjasama</h3>
				</div>
				<div class="text-pembuka-form mt-5">
					<p align="justify">
						Selamat datang Bapak/Ibu Perwakilan Perusahaan/Institusi/Lembaga, di Laman Formulir Pendaftaran Paket Kerjasama Lembaga Pengembangan Pemelajaran dan Karier (LPPK) Universitas Katolik Parahyangan.
					</p>
					<p align="justify">
						Sebelum Bapak/Ibu memulai kerjasama dengan kami, Bapak/Ibu diperkenankan untuk mengisi dengan lengkap formulir pendaftaran ini serta mengunggah dokumen yang kami butuhkan untuk keperluan kelengkapan administratif.
					</p>
					<p align="justify">
						Atas perhatiannya, kami ucapkan terima kasih.
					</p>
				</div>
				<div class="text-center mt-5">
					<a href="<?php echo site_url('PengisianForm') ?>" class="btn btn-success">Selanjutnya</a>
				</div>
			</div>
		</div>

	</div>

</body>

</html>