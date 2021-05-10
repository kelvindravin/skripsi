<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Admin extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Authority');
		$this->load->model('Perusahaan');
		$this->load->model('Statusbenefit');
		$this->load->model('Publikasi');
		$this->load->model('Jurusanlist');
		$this->load->model('Benefit Lainnya/Campushiring');
		$this->load->model('Benefit Lainnya/Companybranding');
		$this->load->model('Benefit Lainnya/Vjf');
		$this->load->model('Benefit Lainnya/Datawisuda');
		$this->load->model('Adminlog');
		$this->load->library('session');
	}

	public function addLog($text)
	{
		$name = $this->session->userdata('username');
		$role = $this->session->userdata('usertype');

		$log = $name . ' (' . $role . ') ' . $text;

		$this->Adminlog->insert($log);
	}

	public function loadHalamanAdmin()
	{
		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Index_Login');
	}

	public function loginSSO()
	{
		if (!$this->cas->is_authenticated()) {
			$this->cas->force_auth();
		} else {
			if ($this->cas->user()) {
				// print_r(sizeof($this->Authority->getAdminRole($this->cas->user())));exit();
				if (sizeof($this->Authority->getAdminRole($this->cas->user())) != 0) {
					$tmpRole = $this->Authority->getAdminRole($this->cas->user());
					$role = null;
					if ($tmpRole[0]->N_statusAdmin == 0) {
						$role = 'superadmin';
					} else {
						$role = 'admin';
					}
					$this->session->set_userdata('usertype', $role);
					$this->session->set_userdata('username', $this->cas->user());
					redirect(base_url('admin-dashboard'));
				} else {
					$this->session->set_flashdata('error', 'Anda tidak terdaftar sebagai Administrator!');
					$this->cas->logout();
					redirect(site_url('admin'));
				}
			} else {
				$this->session->set_flashdata('error', 'Anda tidak terdaftar sebagai Administrator!');
				redirect(site_url('admin'));
			}
		}
	}

	public function loadMainPage()
	{
		$this->data['daftarBenefitPerusahaan'] = $this->Statusbenefit->getAllBenefitData();
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/V_Admin_Dashboard', $this->data);
	}

	// Menu Perusahaan
	public function loadHalamanDaftarPerusahaan()
	{
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllValidPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Daftar_Perusahaan', $this->data);
	}
	public function loadHalamanEditData()
	{
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Edit_Perusahaan', $this->data);
	}

	// Edit Data Modules
	public function loadEditData()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);
		// print_r($this->data['dataPerusahaan']);exit();

		$result = $this->load->view('Admin/Menu Perusahaan/Edit Perusahaan Action/V_Edit_Perusahaan', $this->data, TRUE);
		echo $result;
	}

	//dataUpdateFunction
	public function updateDataPerusahaan()
	{
		$updatedData = $this->input->post();
		$idPerusahaan = $updatedData['idPerusahaan'];

		//input yang bakal di proses
		if (sizeof($updatedData) != 0) {
			$fileBaseName = $updatedData['nama'];
			$logoPerusahaan = $updatedData['tempLogoPerusahaan'];
			if ($_FILES['logo']['size'] != 0) {
				$logoPerusahaan = $this->updateLogo($fileBaseName . "_logo");
			}
			$paketPilihan = $updatedData['paket'];
			$namaPerusahaan = $updatedData['nama'];
			$bidangPerusahaan = $updatedData['bidang'];
			$alamatPerusahaan = $updatedData['alamat'];
			$telpPerusahaan = $updatedData['telp'];
			$linkPerusahaan = $updatedData['link'];
			$jumlahKaryawan = $updatedData['jumlahKaryawan'];
			$jumlahLulusanUnpar = $updatedData['jumlahKaryawanUnpar'];
			$namaPic = $updatedData['namaPIC'];
			$emailPic = $updatedData['emailPIC'];
			$kontakPic = $updatedData['kontakPIC'];
			$masaMulai = $updatedData['tglMulai'];
			$masaSelesai = $updatedData['tglSelesai'];
			$buktiBayar = $updatedData['tempBuktiPembayaran'];
			if ($_FILES['buktiPembayaran']['size'] != 0) {
				$buktiBayar = $this->uploadBuktiBayar($fileBaseName . "_Bukti Pembayaran");
			}
			$mouNumber = $updatedData['noMOU'];

			// perusahaan DB
			$dataForUploadtoPerusahaanDB = array(
				'V_namaPerusahaan' => $namaPerusahaan,
				'V_logoPerusahaan' => $logoPerusahaan,
				'V_paket' => $paketPilihan,
				'V_bidangUsaha' => $bidangPerusahaan,
				'V_alamatPerusahaan' => $alamatPerusahaan,
				'V_kontakPerusahaan' => $telpPerusahaan,
				'V_websitePerusahaan' => $linkPerusahaan,
				'V_jumlahKaryawan' => $jumlahKaryawan,
				'V_jumlahLulusanUnpar' => $jumlahLulusanUnpar,
				'V_namaPic' => $namaPic,
				'V_emailPic' => $emailPic,
				'V_noTelpPic' => $kontakPic,
				'V_masaBerlaku' => $masaMulai,
				'V_masaSelesai' => $masaSelesai,
				'V_buktiPembayaran' => $buktiBayar,
				'V_mouNo' => $mouNumber
			);

			// print_r($dataForUploadtoPerusahaanDB);exit();
			//Update to DB Perusahaan
			$this->Perusahaan->updateDataPerusahaanById($idPerusahaan, $dataForUploadtoPerusahaanDB);

			$dataForUploadtoStatusBenefitDB = "";
			// kasih nilai untuk status benefit
			if ($paketPilihan == "basic") {
				$dataForUploadtoStatusBenefitDB = array(
					'V_website' => "1",
					'V_medsos' => "-",
					'V_bem' => "-",
					'V_fakulUnpar' => "-",
					'V_campusHiring' => "-",
					'V_companyBranding' => "-",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			} else if ($paketPilihan == "bronze") {
				$dataForUploadtoStatusBenefitDB = array(
					'V_website' => "3",
					'V_medsos' => "3",
					'V_bem' => "-",
					'V_fakulUnpar' => "-",
					'V_campusHiring' => "1",
					'V_companyBranding' => "1",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			} else if ($paketPilihan == "silver") {
				$dataForUploadtoStatusBenefitDB = array(
					'V_website' => "6",
					'V_medsos' => "6",
					'V_bem' => "3",
					'V_fakulUnpar' => "3",
					'V_campusHiring' => "2",
					'V_companyBranding' => "2",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			} else if ($paketPilihan == "gold") {
				$dataForUploadtoStatusBenefitDB = array(
					'V_website' => "10",
					'V_medsos' => "10",
					'V_bem' => "6",
					'V_fakulUnpar' => "6",
					'V_campusHiring' => "3",
					'V_companyBranding' => "3",
					'V_vjf' => "1",
					'V_dataWisuda' => "1"
				);
			} else if ($paketPilihan == "platinum") {
				$dataForUploadtoStatusBenefitDB = array(
					'V_website' => "Unlimited",
					'V_medsos' => "Unlimited",
					'V_bem' => "Unlimited",
					'V_fakulUnpar' => "Unlimited",
					'V_campusHiring' => "4",
					'V_companyBranding' => "4",
					'V_vjf' => "2",
					'V_dataWisuda' => "2"
				);
			}
			//Insert to DB Statusbenefit
			$this->Statusbenefit->updateBenefitPerusahaanById($idPerusahaan, $dataForUploadtoStatusBenefitDB);
			$this->addLog('Mengupdate data perusahaan dengan nama ' . $updatedData['nama']);

			$this->session->set_flashdata('success', 'Selesai mengganti!');
			redirect(base_url('edit-data')); //redirect ke halaman edit data perusahaan
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan pada update!');
			redirect(base_url('edit-data')); //redirect ke halaman edit data perusahaan
		}
	}

	public function updateLogo($FileBaseName)
	{
		//Config for Logo Update
		$config['upload_path']          = './assets/uploadedFiles/';
		$config['allowed_types']        = '*';
		$config['overwrite']            = true;
		$config['file_name']            = $FileBaseName;
		$config['max_size']             = 1024;
		//End of Config
		//if upload library already loaded
		if ($this->load->library('upload')) {
			$this->upload->initialize($config);
		} else {
			$this->load->library('upload', $config);
		}
		if (!$this->upload->do_upload('logo')) {
			$errorMessage = $this->upload->display_errors();
			$this->session->set_flashdata('error', 'Kesalahan pada upload Foto Profil :' . $errorMessage);
			redirect(base_url('edit-data'));
		}
		return $this->upload->data('file_name');
	}

	function uploadMou($fileBaseName)
	{
		//Config for MOU Upload
		$config['upload_path']          = './assets/uploadedFiles/MOU';
		$config['allowed_types']        = '*';
		$config['overwrite']            = true;
		$config['file_name']            = $fileBaseName;
		$config['max_size']             = 1024;
		//End of Config
		//if upload library already loaded
		if ($this->load->library('upload')) {
			$this->upload->initialize($config);
		} else {
			$this->load->library('upload', $config);
		}
		if (!$this->upload->do_upload('mou')) { //untuk ambil file mou nya
			$errorMessage = $this->upload->display_errors();
			$this->session->set_flashdata('error', 'Kesalahan pada upload MOU :' . $errorMessage);
			redirect(base_url('edit-data'));
		}
		return $this->upload->data('file_name');
	}

	function uploadBuktiBayar($fileBaseName)
	{
		//Config for buktiPembayaran Upload
		$config['upload_path']          = './assets/uploadedFiles/Bukti Pembayaran';
		$config['allowed_types']        = '*';
		$config['overwrite']            = true;
		$config['file_name']            = $fileBaseName;
		$config['max_size']             = 1024;
		//End of Config
		//if upload library already loaded
		if ($this->load->library('upload')) {
			$this->upload->initialize($config);
		} else {
			$this->load->library('upload', $config);
		}
		if (!$this->upload->do_upload('buktiPembayaran')) { //untuk ambil file buktiPembayaran nya
			$errorMessage = $this->upload->display_errors();
			$this->session->set_flashdata('error', 'Kesalahan pada upload Bukti Pembayaran :' . $errorMessage);
			redirect(base_url('edit-data'));
		}
		$this->addLog('Mengupload bukti pembayaran perusahaan dengan nama ' . $fileBaseName);
		return $this->upload->data('file_name');
	}

	function deletePerusahaan($id)
	{
		$id = $this->input->get('id');
		$data = $this->Perusahaan->getPerusahaanDataById($id);
		$namaPerusahaan = $data[0]->V_namaPerusahaan;
		$data = array(
			'N_status' => 1
		);
		$this->Perusahaan->updatePerusahaanStatus($id, $data);
		$this->addLog('Menghapus perusahaan dengan nama ' . $namaPerusahaan);
		$this->session->set_flashdata('success', 'Sukses menghapus perusahaan');
		redirect(base_url('edit-data'));
	}
	// End of Edit Data Modules

	public function loadHalamanStatusBenefit()
	{
		$this->data['daftarBenefitPerusahaan'] = $this->Statusbenefit->getAllBenefitData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Status_Benefit', $this->data);
	}

	public function loadHalamanEditBenefit()
	{
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Edit_Benefit', $this->data);
	}

	// Edit Benefit Modules
	public function loadEditBenefit()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);
		$this->data['dataBenefit'] = $this->Statusbenefit->getBenefitDataById($id);

		$result = $this->load->view('Admin/Menu Perusahaan/Edit Perusahaan Action/V_Edit_Benefit', $this->data, TRUE);
		echo $result;
	}

	public function updateBenefit()
	{
		$updatedData = $this->input->post();
		if (sizeof($updatedData) != 0) {
			$idPerusahaan = $updatedData['idPerusahaan'];

			$dataForUploadtoStatusBenefitDB = array(
				'V_website' => $updatedData['website'],
				'V_medsos' => $updatedData['medsos'],
				'V_bem' => $updatedData['medsosBem'],
				'V_fakulUnpar' => $updatedData['fakulUnpar'],
				'V_campusHiring' => $updatedData['campHiring'],
				'V_companyBranding' => $updatedData['compBranding'],
				'V_vjf' => $updatedData['vjf'],
				'V_dataWisuda' => $updatedData['dataWisuda']
			);

			// print_r($dataForUploadtoStatusBenefitDB);exit();
			//Insert to DB Statusbenefit
			$this->Statusbenefit->updateBenefitPerusahaanById($idPerusahaan, $dataForUploadtoStatusBenefitDB);
			$data = $this->Perusahaan->getPerusahaanDataById($updatedData['idPerusahaan']);
			$namaPerusahaan = $data[0]->V_namaPerusahaan;
			$this->addLog('Merubah benefit perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Selesai mengganti!');
			redirect(base_url('edit-benefit'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan pada update!');
			redirect(base_url('edit-benefit'));
		}
	}
	// End of Edit Benefit Modules

	public function loadHalamanPublikasi()
	{
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Publikasi_Loker', $this->data);
	}

	// Publikasi Modules
	public function loadAddPublikasi()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->load->view('Admin/Menu Perusahaan/Edit Perusahaan Action/V_Add_Publikasi', $this->data);
	}

	public function insertPublikasi()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataPublikasi = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_judul' => $data['judulLowongan'],
				'V_tglMulai' => $data['tglPermohonan'],
				'V_tglSelesai' => $data['tglBatas'],
				'V_arsipMateri' => $data['arsipMateri'],
				'N_website' => $data['website'],
				'N_medsos' => $data['medsos'],
				'N_bem' => $data['bem'],
				'N_fakulUnpar' => $data['fakulUnpar']
			);

			//Insert to DB Publikasi
			$this->Publikasi->insert('formkerjasama_publikasi', $dataPublikasi);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$judulPublikasi = $data['judulLowongan'];
			$this->addLog('Menambahkan publikasi perusahaan dengan nama' . $namaPerusahaan . ' dengan judul ' . $judulPublikasi);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('publikasi'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('publikasi'));
		}
	}

	public function loadHistoryPublikasi()
	{
		$id = $this->input->get('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->data['dataWebsite'] = $this->Publikasi->getPublikasiWebsiteDataById($id);
		$this->data['dataMedsos'] = $this->Publikasi->getPublikasiMedsosDataById($id);
		$this->data['dataBem'] = $this->Publikasi->getPublikasiBEMDataById($id);
		$this->data['dataFakulUnpar'] = $this->Publikasi->getPublikasifakulUnparDataById($id);

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/Edit Perusahaan Action/V_History_Publikasi', $this->data);
	}

	public function loadEditPublikasi()
	{
		$idPublikasi = $this->input->post('idPublikasi');
		$idPerusahaan = $this->input->post('idPerusahaan');

		$this->data['dataPublikasi'] = $this->Publikasi->getPublikasiDataById($idPublikasi);
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($idPerusahaan);

		$result = $this->load->view('Admin/Menu Perusahaan/Edit Perusahaan Action/V_Edit_Publikasi', $this->data, TRUE);
		echo $result;
	}

	public function editPublikasi()
	{
		$data = $this->input->post();
		if (sizeof($data) != 0) {
			$idPublikasi = $data['idPublikasi'];

			$dataForUploadtoPublikasiDB = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_judul' => $data['judulLowongan'],
				'V_tglMulai' => $data['tglPermohonan'],
				'V_tglSelesai' => $data['tglBatas'],
				'V_arsipMateri' => $data['arsipMateri'],
				'N_website' => $data['website'],
				'N_medsos' => $data['medsos'],
				'N_bem' => $data['bem'],
				'N_fakulUnpar' => $data['fakulUnpar']
			);

			//Insert to DB Publikasi
			$validator = $this->Publikasi->updatePublikasiPerusahaanById($idPublikasi, $dataForUploadtoPublikasiDB);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$judulPublikasi = $data['judulLowongan'];
			$this->addLog('Mengedit publikasi perusahaan dengan nama' . $namaPerusahaan . ' dengan judul ' . $judulPublikasi);
			if ($validator) {
				$this->session->set_flashdata('success', 'Selesai mengganti!');
				redirect(base_url('publikasi'));
			} else {
				$this->session->set_flashdata('error', 'Terdapat kesalahan pada update!');
				redirect(base_url('publikasi'));
			}
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan pada update!');
			redirect(base_url('publikasi'));
		}
	}
	// End of Publikasi Modules

	// Publikasi untuk benefit lainnya
	public function loadHalamanBenefitLainnya()
	{
		$this->data['daftarPerusahaan'] = $this->Perusahaan->getAllPerusahaanData();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/V_Benefit_Lainnya', $this->data);
	}

	// Publikasi Modules
	//untuk campus hiring
	public function loadAddBenefitCH()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Add_Benefit_CH', $this->data);
	}

	public function addBenefitCH()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCH = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_linkMateri' => $data['materiPublikasi'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Campushiring->insert('formkerjasama_benefit_campushiring', $dataCH);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menambah benefit Campus Hiring pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('benefit-lainnya'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('benefit-lainnya'));
		}
	}

	public function loadEditBenefitCH()
	{
		$idBenefit = $this->input->post('idBenefit');
		$idPerusahaan = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['benefit'] = $this->Campushiring->getBenefitById($idBenefit);
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($idPerusahaan);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Edit_Benefit_CH', $this->data);
	}

	public function editBenefitCH()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCH = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_linkMateri' => $data['materiPublikasi'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Campushiring->updateBenefitByBenefitId($data['idBenefit'], $dataCH);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Mengedit benefit Campus Hiring pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Perubahan berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}
	
	public function deleteBenefitCH()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCH = array(
				'N_status' => 1
			);

			//Insert to DB Benefit Lainnya
			$this->Campushiring->updateBenefitByBenefitId($data['id'], $dataCH);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menghapus benefit Campus Hiring pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Menghapus benefit berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	//untuk company branding
	public function loadAddBenefitCB()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Add_Benefit_CB', $this->data);
	}

	public function addBenefitCB()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCB = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_linkMateri' => $data['materiPublikasi'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Companybranding->insert('formkerjasama_benefit_companybranding', $dataCB);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menambah benefit Company Branding pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('benefit-lainnya'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('benefit-lainnya'));
		}
	}

	public function loadEditBenefitCB()
	{
		$idBenefit = $this->input->post('idBenefit');
		$idPerusahaan = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['benefit'] = $this->Companybranding->getBenefitById($idBenefit);
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($idPerusahaan);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Edit_Benefit_CB', $this->data);
	}

	public function editBenefitCB()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCB = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_linkMateri' => $data['materiPublikasi'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Companybranding->updateBenefitByBenefitId($data['idBenefit'], $dataCB);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Mengedit benefit Company Branding pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Perubahan berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	public function deleteBenefitCB()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataCB = array(
				'N_status' => 1
			);

			//Insert to DB Benefit Lainnya
			$this->Companybranding->updateBenefitByBenefitId($data['id'], $dataCB);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menghapus benefit Company Branding pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Menghapus benefit berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	//untuk VJF
	public function loadAddBenefitVJF()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Add_Benefit_VJF', $this->data);
	}

	public function addBenefitVJF()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataVjf = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Vjf->insert('formkerjasama_benefit_vjf', $dataVjf);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menambah benefit VJF pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('benefit-lainnya'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('benefit-lainnya'));
		}
	}

	public function loadEditBenefitVJF()
	{
		$idBenefit = $this->input->post('idBenefit');
		$idPerusahaan = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['benefit'] = $this->Companybranding->getBenefitById($idBenefit);
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($idPerusahaan);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Edit_Benefit_VJF', $this->data);
	}

	public function editBenefitVJF()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataVjf = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_tglPelaksaan' => $data['tglKegiatan']
			);

			//Insert to DB Benefit Lainnya
			$this->Vjf->updateBenefitByBenefitId($data['idBenefit'], $dataVjf);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Mengedit benefit VJF pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Perubahan berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	public function deleteBenefitVJF()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataVJF = array(
				'N_status' => 1
			);

			//Insert to DB Benefit Lainnya
			$this->Vjf->updateBenefitByBenefitId($data['id'], $dataVJF);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menghapus benefit VJF pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Menghapus benefit berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	//untuk DW
	public function loadAddBenefitDW()
	{
		$id = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Add_Benefit_DW', $this->data);
	}

	public function addBenefitDW()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataDW = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_tglPelaksaan' => $data['tglPermintaan']
			);

			//Insert to DB Benefit Lainnya
			$this->Datawisuda->insert('formkerjasama_benefit_datawisuda', $dataDW);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menambah benefit Data Wisuda pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('benefit-lainnya'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('benefit-lainnya'));
		}
	}

	public function loadEditBenefitDW()
	{
		$idBenefit = $this->input->post('idBenefit');
		$idPerusahaan = $this->input->post('idPerusahaan');
		$this->data['listJurusan'] = $this->Jurusanlist->getAllJurusan();
		$this->data['benefit'] = $this->Companybranding->getBenefitById($idBenefit);
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($idPerusahaan);

		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_Edit_Benefit_DW', $this->data);
	}

	public function editBenefitDW()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataDW = array(
				'idPerusahaan' => $data['idPerusahaan'],
				'V_jurusanTerlibat' => implode(", ", $data['jurusan']),
				'V_tglPelaksaan' => $data['tglPermintaan']
			);

			//Insert to DB Benefit Lainnya
			$this->Datawisuda->updateBenefitByBenefitId($data['idBenefit'], $dataDW);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Mengedit benefit Data Wisuda pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Perubahan berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	public function deleteBenefitDW()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$dataDW = array(
				'N_status' => 1
			);

			//Insert to DB Benefit Lainnya
			$this->Datawisuda->updateBenefitByBenefitId($data['id'], $dataDW);
			$dataPerusahaan = $this->Perusahaan->getPerusahaanDataById($data['idPerusahaan']);
			$namaPerusahaan = $dataPerusahaan[0]->V_namaPerusahaan;
			$this->addLog('Menghapus benefit Data Wisuda pada perusahaan dengan nama' . $namaPerusahaan);

			$this->session->set_flashdata('success', 'Menghapus benefit berhasil!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('history-benefit-lainnya?idPerusahaan=' . $data['idPerusahaan']));
		}
	}

	public function loadHistoryBenefitLainnya()
	{
		$id = $this->input->get('idPerusahaan');
		$this->data['dataPerusahaan'] = $this->Perusahaan->getPerusahaanDataById($id);

		$this->data['dataCampHiring'] = $this->Campushiring->getBenefitByPerusahaan($id);
		$this->data['dataCompBranding'] = $this->Companybranding->getBenefitByPerusahaan($id);
		$this->data['dataVjf'] = $this->Vjf->getBenefitByPerusahaan($id);
		$this->data['dataWisuda'] = $this->Datawisuda->getBenefitByPerusahaan($id);

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Menu Perusahaan/Benefit Lainnya/V_History_Benefit_Lainnya', $this->data);
	}
	// End of Publikasi untuk benefit lainnya

	public function loadLaporan()
	{
		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/V_Admin_Laporan');
	}

	public function cariLaporan()
	{
		$tahun = $this->input->post('tahun');
		$triwulan = $this->input->post('triwulan');

		$this->getLaporan($tahun, $triwulan);
	}

	public function getLaporan($tahun, $triwulan)
	{
		$this->data['dataLaporan'] = $this->Perusahaan->getAllLaporanByTahunTriwulan($tahun, $triwulan);
		$this->data['tahunLaporan'] = $tahun;
		if ($triwulan == 5) {
			$this->data['triwulanLaporan'] = "All";
		} else {
			$this->data['triwulanLaporan'] = $triwulan;
		}

		$this->load->view('Admin/V_Header_Laporan');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/Hasil Laporan/V_Hasil_Laporan', $this->data);
	}

	public function loadLog()
	{
		$this->data['log'] = $this->Adminlog->getAllLog();

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/V_Admin_Log', $this->data);
	}

	public function loadAuth()
	{
		$email = $this->session->userdata('username');
		$this->data['daftarAdmin'] = $this->Authority->getAllAdminData($email);

		$this->load->view('Admin/V_Header_Admin');
		$this->load->view('Admin/V_Admin_Navbar');
		$this->load->view('Admin/V_Admin_Kelola_User', $this->data);
	}

	public function changeAuth()
	{
		$data = $this->input->post();
		$role = $data['currentRole'];
		$roleChange = 0;

		if ($role == 0) {
			$roleChange = 1;
		} else {
			$roleChange = 0;
		}

		if (sizeof($data) != 0) {
			$dataAdmin = array(
				'N_statusAdmin' => $roleChange
			);

			//Insert to DB Publikasi
			$this->Authority->updateStatusAdmin($data['id'], $dataAdmin);

			$this->session->set_flashdata('success', 'Perubahan berhasil!');
			redirect(base_url('auth'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat perubahan data!');
			redirect(base_url('auth'));
		}
	}

	public function insertNewAuth()
	{
		$data = $this->input->post();

		if (sizeof($data) != 0) {
			$data = array(
				'V_email' => $data['email'],
				'N_statusAdmin' => $data['roleAdmin']
			);

			//Insert to authority DB
			$this->Publikasi->insert('formkerjasama_authority', $data);

			$this->session->set_flashdata('success', 'Penambahan berhasil!');
			redirect(base_url('auth'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penambahan data!');
			redirect(base_url('auth'));
		}
	}

	function deleteAuth()
	{
		$id = $this->input->post('id');
		// print_r($id);exit();

		if (sizeof($id) != 0) {
			$dataAdminDelete = array(
				'idAdmin' => $id
			);

			//Delete data from db authority
			$this->Authority->deleteAdmin('formkerjasama_authority', $dataAdminDelete);

			$this->session->set_flashdata('success', 'Penghapusan berhasil!');
			redirect(base_url('auth'));
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat penghapusan data!');
			redirect(base_url('auth'));
		}
	}

	public function logout()
	{
		$this->cas->logout();
	}

	// End of Menu Perusahaan
}
