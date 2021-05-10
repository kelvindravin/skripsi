<?php
defined('BASEPATH') or exit('No direct script access allowed');
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<title>Pengisian Formulir</title>
</head>

<body class="form-main-body mb-3">
	<div class="container middle-content-form mt-5 py-3 px-3">
		<div class="text-center">
			<h1>Pemilihan Paket Kerjasama*</h1>
			<div class="small-info-red">
				<div class="mt-2">*Informasi mengenai detail dari setiap paket kerjasama dapat dilihat dengan menekan tombol informasi paket dibawah ini</div>
			</div>
			<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#modalInformasiPaket">Informasi Paket</button>
		</div>
		<div class="text-center">
			<div class="info-black">
				<div class="mt-2">Pembayaran dapat dilakukan kepada rekening berikut :</div>
				<div class="mt-2 text-danger">Bank OCBC NISP</div>
				<div class="mt-2">No Rekening : 017 - 130 - 004491</div>
				<div class="mt-2">Atas Nama : Yayasan Unpar</div>
			</div>
		</div>
	</div>

	<div class="container middle-content-form mt-3 py-3 px-3">
		<div class="text-center">
			<!-- Modal Informasi Paket -->
			<div class="modal fade bd-example-modal-lg" id="modalInformasiPaket" tabindex="-1" aria-labelledby="InformasiPaket" aria-hidden="true">
				<div class="modal-dialog modal-lg modal-dialog-centered" role="document">
					<div class="modal-content">
						<div class="modal-header">
							<h5 class="modal-title" id="InformasiPaket">Detail Paket Kerjasama</h5>
							<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
							</button>
						</div>
						<div class="modal-body">
							<object data="./assets/images/Paket Kerjasama.pdf" type="application/pdf" width="100%" height="800">
								<p>It appears you don't have a PDF plugin for this browser.
									<a href="./assets/images/Paket Kerjasama.pdf" download>click here to download the PDF file.</a>
								</p>
							</object>
						</div>
						<div class="modal-footer">
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
						</div>
					</div>
				</div>
			</div>
			<!-- End of Modal Informasi Paket -->

			<div>Silahkan pilih paket kerjasama yang akan diambil :</div>

			<div class="row mt-3">
				<div class="col-sm-4">
					<div class="">
						<div class="py-2" id="menu-paket-cap-basic">
							<b>Paket Basic</b>
						</div>
						<div class="menu-paket-body pt-4">
							<p>Harga Paket</p>
							<p>Gratis</p>
						</div>
						<div class="menu-paket-footer pb-3 pt-2">
							<a href="<?php echo base_url('FormIdentitas?paket=basic') ?>" class="btn btn-success" id="btn-pilih-paket">Pilih Paket</a>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="">
						<div class="py-2" id="menu-paket-cap-bronze">
							<b>Paket Bronze</b>
						</div>
						<div class="menu-paket-body pt-4">
							<p>Harga Paket</p>
							<p>Rp. 2.500.000,- / Tahun</p>
						</div>
						<div class="menu-paket-footer pb-3 pt-2">
							<a href="<?php echo base_url('FormIdentitas?paket=bronze') ?>" class="btn btn-success" id="btn-pilih-paket">Pilih Paket</a>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="">
						<div class="py-2" id="menu-paket-cap-silver">
							<b>Paket Silver</b>
						</div>
						<div class="menu-paket-body pt-4">
							<p>Harga Paket</p>
							<p>Rp. 6.000.000,- / Tahun</p>
						</div>
						<div class="menu-paket-footer pb-3 pt-2">
							<a href="<?php echo base_url('FormIdentitas?paket=silver') ?>" class="btn btn-success" id="btn-pilih-paket">Pilih Paket</a>
						</div>
					</div>
				</div>
			</div>

			<div class="row mt-3 d-flex align-items-center justify-content-center">
				<div class="col-sm-4">
					<div class="">
						<div class="py-2" id="menu-paket-cap-gold">
							<b>Paket Gold</b>
						</div>
						<div class="menu-paket-body pt-4">
							<p>Harga Paket</p>
							<p>Rp. 14.000.000,- / Tahun</p>
						</div>
						<div class="menu-paket-footer pb-3 pt-2">
							<a href="<?php echo base_url('FormIdentitas?paket=gold') ?>" class="btn btn-success" id="btn-pilih-paket">Pilih Paket</a>
						</div>
					</div>
				</div>

				<div class="col-sm-4">
					<div class="">
						<div class="py-2" id="menu-paket-cap-platinum">
							<b>Paket Platinum</b>
						</div>
						<div class="menu-paket-body pt-4">
							<p>Harga Paket</p>
							<p>Rp. 28.000.000,- / Tahun</p>
						</div>
						<div class="menu-paket-footer pb-3 pt-2">
							<a href="<?php echo base_url('FormIdentitas?paket=platinum') ?>" class="btn btn-success" id="btn-pilih-paket">Pilih Paket</a>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</body>

</html>