<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Statusbenefit extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('localdb', TRUE);
	}

	//Untuk Insert data ke database
	public function insert($table, $data)
	{
		$this->db->insert($table, $data);
	}

	public function getAllBenefitData()
	{
		$query = $this->db
			->select('V_logoPerusahaan,V_namaPerusahaan, V_paket,V_website, V_medsos, V_bem, V_fakulUnpar, V_campusHiring, V_companyBranding, V_vjf, V_dataWisuda')
			->join('formkerjasama_perusahaan_dt', 'formkerjasama_perusahaan_dt.idPerusahaan = formkerjasama_statusBenefit.idPerusahaan')
			->where('N_status', 0)
			->where('V_masaSelesai >=', date("Y-m-d"))
			->get('formkerjasama_statusBenefit');
		return $query->result();
	}

	public function getBenefitDataById($idPerusahaan)
	{
		$query = $this->db
			->from('formkerjasama_statusbenefit')
			->where('idPerusahaan', $idPerusahaan)
			->get();
		return $query->result();
	}

	public function updateBenefitPerusahaanById($idPerusahaan,$data){
		$this->db->where('idPerusahaan', $idPerusahaan);
        $affected = $this->db->update('formkerjasama_statusbenefit', $data);
        if ($affected != 0) {
            return true;
        } else {
            return false;
        }
	}
	
}
