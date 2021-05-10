<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Publikasi extends CI_Model
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

	public function getAllPublikasiData()
	{
		$query = $this->db
			->join('formkerjasama_perusahaan_dt', 'formkerjasama_perusahaan_dt.idPerusahaan = formkerjasama_publikasi.idPerusahaan')
			->where('N_status', 0)
			->get('formkerjasama_publikasi');
		return $query->result();
	}

	public function getPublikasiDataById($idPublikasi)
	{
		$query = $this->db
			->from('formkerjasama_publikasi')
			->where('idPublikasi', $idPublikasi)
			->get();
		return $query->result();
	}

	//get Publikasi Data by type

	public function getPublikasiWebsiteDataById($idPublikasi)
	{
		$query = $this->db
			->select('idPublikasi,idPerusahaan,V_judul,V_tglMulai,V_tglSelesai,V_arsipMateri')
			->from('formkerjasama_publikasi')
			->where('idPerusahaan', $idPublikasi)
			->where('N_website', 1)
			->get();
		return $query->result();
	}

	public function getPublikasiMedsosDataById($idPublikasi)
	{
		$query = $this->db
			->select('idPublikasi,idPerusahaan,V_judul,V_tglMulai,V_tglSelesai,V_arsipMateri')
			->from('formkerjasama_publikasi')
			->where('idPerusahaan', $idPublikasi)
			->where('N_medsos', 1)
			->get();
		return $query->result();
	}

	public function getPublikasiBEMDataById($idPublikasi)
	{
		$query = $this->db
			->select('idPublikasi,idPerusahaan,V_judul,V_tglMulai,V_tglSelesai,V_arsipMateri')
			->from('formkerjasama_publikasi')
			->where('idPerusahaan', $idPublikasi)
			->where('N_bem', 1)
			->get();
		return $query->result();
	}

	public function getPublikasifakulUnparDataById($idPublikasi)
	{
		$query = $this->db
			->select('idPublikasi,idPerusahaan,V_judul,V_tglMulai,V_tglSelesai,V_arsipMateri')
			->from('formkerjasama_publikasi')
			->where('idPerusahaan', $idPublikasi)
			->where('N_fakulUnpar', 1)
			->get();
		return $query->result();
	}
	//end of get Publikasi Data by type

	public function updatePublikasiPerusahaanById($idPublikasi,$data){
		$this->db->where('idPublikasi', $idPublikasi);
        $affected = $this->db->update('formkerjasama_publikasi', $data);
        if ($affected != 0) {
            return true;
        } else {
            return false;
        }
	}
	
}
