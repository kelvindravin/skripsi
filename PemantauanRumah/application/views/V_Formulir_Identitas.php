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
			<h1>Formulir Identitas Perusahaan</h1>
		</div>
	</div>

	<form action="submitForm" method="post" enctype="multipart/form-data">

		<div class="container middle-content-form mt-3 py-3 px-3">
			<!-- Data Diri Perusahaan -->
			<div class="text-center">
				<h3>Data Diri Perusahaan</h3>
				<div class="medium-info-black">
					<div class="mt-2 text-center">Paket yang anda pilih adalah : </div>
					<div class="d-flex align-items-center justify-content-center">
						<select class="mt-2 mr-2 selectpicker form-control border rounded text text-info" id="inputPaket" name="paket" data-live-search="true" data-size="5" data-style="btn-transparant" style="width: auto;" required>
							<option hidden selected value="<?php echo $paketPilihan; ?>"><?php echo $paketPilihan;?></option>
							<option data-tokens='basic' value='basic'>Basic</option>
							<option data-tokens='bronze' value='bronze'>Bronze</option>
							<option data-tokens='silver' value='silver'>Silver</option>
							<option data-tokens='gold' value='gold'>Gold</option>
							<option data-tokens='platinum' value='platinum'>Platinum</option>
						</select>
						<button type="button" class="btn btn-info mt-2" data-toggle="modal" data-target="#modalInformasiPaket">Informasi Paket</button>
					</div>
				</div>
			</div>
			<hr>
			<div class="row">
				<!-- Logo Perusahaan -->
				<div class="col-sm-5">
					<div class="row form-group ">
						<div class="col-sm-12">
							<div class="text-center">
								<img id="output" src="./assets/images/buildings.png" width="200">
							</div>
							<div class="input-group">

								<div class="custom-file mt-4">
									<input type="file" class="text-center custom-file-input" id="logo" accept="image/*" name='logo' onchange="document.getElementById('output').src = window.URL.createObjectURL(this.files[0])" required>
									<label class="custom-file-label" for="logo" aria-describedby="logo">Unggah Logo Perusahaan*</label>
								</div><br>

							</div><br>
							<label for="warningInputLogo" class="text-center text-danger text-bold font-weight-bold">*Maximum Logo Size of 1 MB (JPG/JPEG/PNG)</label>
						</div>
					</div>

				</div>

				<!-- Identitas Perusahaan -->
				<div class="col-sm-7">

					<div class="row form-group">
						<label for="inputNama" class="col-sm-4 col-form-label">Nama Perusahaan</label>

						<div class="col-sm-8">
							<input type="text" placeholder="Nama Perusahaan" class="form-control border" id="inputNama" name="nama" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputBidang" class="col-sm-4 col-form-label">Bidang Usaha</label>

						<div class="col-sm-8">
							<select class="selectpicker form-control border rounded" id="inputBidang" name="bidang" data-live-search="true" data-size="5" data-style="btn-transparant" required>
								<option disabled hidden selected value="">Pilih Bidang...</option>
								<option data-tokens='Pertanian; perikanan; dan kehutanan' value='Pertanian; perikanan; dan kehutanan'>Pertanian; perikanan; dan kehutanan</option>
								<option data-tokens='Pertambangan dan penggalian,Industri pengolahan' value='Pertambangan dan penggalian,Industri pengolahan'>Pertambangan dan penggalian,Industri pengolahan</option>
								<option data-tokens='Pengadaan listrik; gas; uap/air panas; dan udara dingin' value='Pengadaan listrik; gas; uap/air panas; dan udara dingin'>Pengadaan listrik; gas; uap/air panas; dan udara dingin</option>
								<option data-tokens='Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah' value='Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah'>Pengadaan air;pengelolaan sampah dan daur ulang; pembuangan dan pembersihan limbah dan sampah</option>
								<option data-tokens='Konstruksi dan pembangunan' value='Konstruksi dan pembangunan'>Konstruksi dan pembangunan</option>
								<option data-tokens='Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor' value='Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor'>Perdagangan besar dan eceran; reparasi dan perawatan mobil dan sepeda motor</option>
								<option data-tokens='Transportasi dan pergudangan' value='Transportasi dan pergudangan'>Transportasi dan pergudangan</option>
								<option data-tokens='Penyediaan akomodasi dan penyediaan makanan dan minuman' value='Penyediaan akomodasi dan penyediaan makanan dan minuman'>Penyediaan akomodasi dan penyediaan makanan dan minuman</option>
								<option data-tokens='Informasi dan komunikasi' value='Informasi dan komunikasi'>Informasi dan komunikasi</option>
								<option data-tokens='Jasa keuangan dan asuransi' value='Jasa keuangan dan asuransi'>Jasa keuangan dan asuransi</option>
								<option data-tokens='Real estate; developer; dan property,Jasa professional; ilmiah dan teknis' value='Real estate; developer; dan property,Jasa professional; ilmiah dan teknis'>Real estate; developer; dan property,Jasa professional; ilmiah dan teknis</option>
								<option data-tokens='Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya' value='Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya'>Jasa persewaan dan sewa guna usaha tanpa hak opsi; ketenagakerjaan; agen perjalanan dan penunjang usaha lainnya</option>
								<option data-tokens='Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial' value='Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial'>Administrasi pemerintahan; pertahanan; dan jaminan wajib sosial</option>
								<option data-tokens='Jasa pendidikan' value='Jasa pendidikan'>Jasa pendidikan</option>
								<option data-tokens='Kesenian; hiburan dan rekreasi' value='Kesenian; hiburan dan rekreasi'>Kesenian; hiburan dan rekreasi</option>
								<option data-tokens='Kegiatan jasa lainnya' value='Kegiatan jasa lainnya'>Kegiatan jasa lainnya</option>
								<option data-tokens='Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga' value='Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga'>Jasa perorangan yang melayani rumah tangga; kegiatan yang menghasilkan barang dan jasa oleh rumah tangga</option>
								<option data-tokens='Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya' value='Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya'>Kegiatan badan internasional dan kegiatan badan internasional ekstra lainnya</option>
								<option data-tokens='Kerohanian' value='Kerohanian'>Kerohanian</option>

							</select>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputAlamat" class="col-sm-4 col-form-label">Alamat Perusahaan</label>

						<div class="col-sm-8">
							<input type="text" placeholder="Alamat Perusahaan" class="form-control border" id="inputAlamat" name="alamat" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputTelp" class="col-sm-4 col-form-label">Kontak Perusahaan</label>

						<div class="col-sm-8">
							<input type="text" placeholder="Nomor Kontak Perusahaan" class="form-control border" id="inputTelp" name="telp" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputLink" class="col-sm-4 col-form-label">Website Perusahaan</label>

						<div class="col-sm-8">
							<input type="text" placeholder="Link Website Perusahaan" class="form-control border" id="inputLink" name="link" required>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Data Karyawan Perusahaan -->
		<div class="container middle-content-form mt-3 py-3 px-3">
			<div class="text-center">
				<h3>Data Karyawan Perusahaan</h3>
			</div>
			<hr>
			<div class="d-flex align-items-center justify-content-center">
				<div class="w-75">
					<div class="row form-group">
						<label for="inputJumlahKaryawan" class="col-sm-6 col-form-label">Jumlah Karyawan</label>

						<div class="col-sm-6">
							<input type="text" placeholder="Jumlah Karyawan" class="form-control border" id="inputJumlahKaryawan" name="jumlahKaryawan" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputKaryawanUnpar" class="col-sm-6 col-form-label">Jumlah Lulusan UNPAR yang Bekerja Dalam Perusahaan</label>

						<div class="col-sm-6">
							<select class="selectpicker form-control border rounded" id="inputKaryawanUnpar" name="jumlahKaryawanUnpar" data-live-search="true" data-size="5" data-style="btn-transparant" required>
								<option disabled hidden selected value="">Pilih Jumlah...</option>
								<option data-tokens='1-25' value='1-25'>1 - 25 Orang</option>
								<option data-tokens='26-50' value='26-50'>26 - 50 Orang</option>
								<option data-tokens='51-75' value='51-75'>51 - 75 Orang</option>
								<option data-tokens='> 75 orang' value='> 75 orang'> > 75 Orang</option>
							</select>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Data PIC Perusahaan -->
		<div class="container middle-content-form mt-3 py-3 px-3">
			<div class="text-center">
				<h3>Data PIC Perusahaan</h3>
			</div>
			<hr>
			<div class="d-flex align-items-center justify-content-center">
				<div class="w-75">
					<div class="row form-group">
						<label for="inputNamaPIC" class="col-sm-6 col-form-label">Nama PIC</label>

						<div class="col-sm-6">
							<input type="text" placeholder="Nama" class="form-control border" id="inputNamaPIC" name="namaPIC" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputEmailPIC" class="col-sm-6 col-form-label">Email PIC</label>

						<div class="col-sm-6">
							<input type="email" placeholder="Email" class="form-control border" id="inputEmailPIC" name="emailPIC" required>
						</div>
					</div>

					<div class="row form-group">
						<label for="inputKontakPIC" class="col-sm-6 col-form-label">No Telp/WA PIC</label>

						<div class="col-sm-6">
							<input type="tel" placeholder="Telephone / WA" class="form-control border" id="inputKontakPIC" name="kontakPIC" required>
						</div>
					</div>
				</div>
			</div>


		</div>

		<div class="container middle-content-form mt-3 py-3 px-3">
			<div class="text-center my-2">
				<a href="<?php echo base_url('PengisianForm') ?>" class="btn btn-danger mx-2" id="btn-kembali">Kembali</a>
				<button type="submit" class="btn btn-success mx-2">Selesai</button>
			</div>
		</div>
	</form>

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

</body>

</html>

<script>
	// For Changing Custom File Name (On Upload)
	$(".custom-file-input").on("change", function() {
		var fileName = $(this).val().split("\\").pop();
		$(this).siblings(".custom-file-label").addClass("selected").html(fileName);
	});
</script>