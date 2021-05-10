<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Pendaftaran Kerjasama</title>
</head>

<body class="form-main-body">

	<?php if ($this->session->flashdata('error')) { ?>
		<div class="alert alert-danger"> <?= $this->session->flashdata('error') ?> </div>
	<?php } else if ($this->session->flashdata('success')) { ?>
		<div class="alert alert-success"> <?= $this->session->flashdata('success') ?> </div>
	<?php } ?>

	<div class="container middle-content py-5 px-5">
		<div class="row">
			<div class="col-sm-4 d-flex align-items-center justify-content-center">
				<img src="./assets/images/Logo_LPPK.png" width="200" height="200">
			</div>
			<div class="col-sm-8">
				<div class="text-center">
					<h4>Pengisian formulir pendaftaran paket kerjasama telah selesai!</h4>
				</div>
				<div class="text-pembuka-form mt-5">
					<p align="justify">
						Terima kasih atas kesediaan Bapak/Ibu dalam mengisi formulir pendaftaran kerjasama ini. Semoga bentuk kerjasama yang kita sepakati bersama ini, akan bermanfaat baik bagi pihak Perusahaan/Institusi/Lembaga Bapak/Ibu, maupun bagi Universitas Katolik Parahyangan, secara khusus bagi para lulusannya.
					</p>
					<p>
						Salam,
					</p>
					<p>
					Lembaga Pengembangan Pemelajaran dan Karier<br>
					Universitas Katolik Parahyangan
					</p>

				</div>
			</div>
		</div>

	</div>

</body>

</html>