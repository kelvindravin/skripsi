<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Formulir extends CI_Controller
{

	function __construct()
	{
		parent::__construct();
		$this->load->model('Perusahaan');
		$this->load->model('Statusbenefit');
		$this->load->library('session');
	}

	public function index()
	{
		$this->load->view('V_Header');
		$this->load->view('V_Form_Index');
	}

	public function loadHalamanFormulir()
	{
		$this->load->view('V_Header');
		$this->load->view('V_Formulir_Pemilihan_Paket');
	}

	public function loadHalamanIndentitas()
	{
		$this->data['paketPilihan'] = $this->input->get('paket');

		$this->load->view('V_Header');
		$this->load->view('V_Formulir_Identitas', $this->data);
	}

	public function loadHalamanPenutup()
	{
		$this->load->view('V_Header');
		$this->load->view('V_Form_Penutup');
	}

	// Data Management
	public function registerPerusahaan()
	{
		$data = $this->input->post();
		if (sizeof($data) != 0) {
			$fileBaseName = $data['nama'] . "_logo";
			$logoPerusahaan = $this->uploadLogo($fileBaseName);
			$paketPilihan = $data['paket'];
			$namaPerusahaan = $data['nama'];
			$bidangPerusahaan = $data['bidang'];
			$alamatPerusahaan = $data['alamat'];
			$telpPerusahaan = $data['telp'];
			$linkPerusahaan = $data['link'];
			$jumlahKaryawan = $data['jumlahKaryawan'];
			$jumlahLulusanUnpar = $data['jumlahKaryawanUnpar'];
			$namaPic = $data['namaPIC'];
			$emailPic = $data['emailPIC'];
			$kontakPic = $data['kontakPIC'];

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
				'V_noTelpPic' => $kontakPic
			);
			
			//Insert to DB Perusahaan
			$this->Perusahaan->insert('formkerjasama_perusahaan_dt', $dataForUploadtoPerusahaanDB);
			//take value for idPerusahaan (FK)
			$idPerusahaan = $this->Perusahaan->getPerusahaanId($namaPerusahaan);

			// kasih nilai untuk status benefit
			if ($paketPilihan == "basic") {
				$dataForUploadtoStatusBenefitDB = array(
					'idPerusahaan' => $idPerusahaan,
					'V_website' => "1",
					'V_medsos' => "-",
					'V_bem' => "-",
					'V_fakulUnpar' => "-",
					'V_campusHiring' => "-",
					'V_companyBranding' => "-",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			}else if($paketPilihan == "bronze"){
				$dataForUploadtoStatusBenefitDB = array(
					'idPerusahaan' => $idPerusahaan,
					'V_website' => "3",
					'V_medsos' => "3",
					'V_bem' => "-",
					'V_fakulUnpar' => "-",
					'V_campusHiring' => "1",
					'V_companyBranding' => "1",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			}else if($paketPilihan == "silver"){
				$dataForUploadtoStatusBenefitDB = array(
					'idPerusahaan' => $idPerusahaan,
					'V_website' => "6",
					'V_medsos' => "6",
					'V_bem' => "3",
					'V_fakulUnpar' => "3",
					'V_campusHiring' => "2",
					'V_companyBranding' => "2",
					'V_vjf' => "-",
					'V_dataWisuda' => "-"
				);
			}else if($paketPilihan == "gold"){
				$dataForUploadtoStatusBenefitDB = array(
					'idPerusahaan' => $idPerusahaan,
					'V_website' => "10",
					'V_medsos' => "10",
					'V_bem' => "6",
					'V_fakulUnpar' => "6",
					'V_campusHiring' => "3",
					'V_companyBranding' => "3",
					'V_vjf' => "1",
					'V_dataWisuda' => "1"
				);
			}else if($paketPilihan == "platinum"){
				$dataForUploadtoStatusBenefitDB = array(
					'idPerusahaan' => $idPerusahaan,
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
			$this->Perusahaan->insert('formkerjasama_statusbenefit', $dataForUploadtoStatusBenefitDB);

			$this->session->set_flashdata('success', 'Formulir selesai, terimakasih atas waktu anda!');
			redirect(base_url('penutup')); //redirect ke penutup form
		} else {
			$this->session->set_flashdata('error', 'Terdapat kesalahan saat pendaftaran!');
			redirect(base_url()); //redirect ke pembuka form
		}
	}

	function uploadLogo($fileBaseName)
	{
		//Config for logo Upload
		$config['upload_path']          = './assets/uploadedFiles/';
		$config['allowed_types']        = '*';
		$config['overwrite']            = true;
		$config['file_name']            = $fileBaseName;
		$config['max_size']             = 1024;
		//End of Config
		$this->load->library('upload', $config);
		if (!$this->upload->do_upload('logo')) { //'logo' itu name si formnya dari View, ini cek kalau si browse file ada isinya
			$errorMessage = $this->upload->display_errors();
			$this->session->set_flashdata('error', 'Kesalahan pada upload Foto Profil :' . $errorMessage);
			redirect(base_url());
		}
		return $this->upload->data('file_name');
	}
	// End of Data Management
}
