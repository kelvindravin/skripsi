<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Perusahaan extends CI_Model
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

	//seluruh perusahaan, sampai yg udh kadaluarsa / di delete
	public function getAllPerusahaanData()
	{
		$query = $this->db
			->get('formkerjasama_perusahaan_dt');
		return $query->result();
	}

	//ambil data perusahaan yg masih aktif aja
	public function getAllValidPerusahaanData()
	{
		$query = $this->db
			->where('N_Status', 0)
			->where('V_masaSelesai >=', date("Y-m-d"))
			->get('formkerjasama_perusahaan_dt');
		return $query->result();
	}

	public function getPerusahaanDataById($idPerusahaan)
	{
		$query = $this->db
			->from('formkerjasama_perusahaan_dt')
			->where('idPerusahaan', $idPerusahaan)
			->get();
		return $query->result();
	}

	public function getPerusahaanId($namaPerusahaan)
	{
		$query = $this->db
			->select('idPerusahaan')
			->from('formkerjasama_perusahaan_dt')
			->where('V_namaPerusahaan', $namaPerusahaan)
			->get();
		return $query->result()[0]->idPerusahaan;
	}

	public function updateDataPerusahaanById($idPerusahaan, $data)
	{
		$this->db->where('idPerusahaan', $idPerusahaan);
		$affected = $this->db->update('formkerjasama_perusahaan_dt', $data);
		if ($affected != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function updatePerusahaanStatus($id, $data)
	{
		$this->db->where('idPerusahaan', $id);
		$affected = $this->db->update('formkerjasama_perusahaan_dt', $data);
		if ($affected != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function getAllLaporanByTahunTriwulan($tahun, $triwulan)
	{
		$batasAtasTriwulan = 0;
		$batasTengahTriwulan = 0;
		$batasBawahTriwulan = 0;

		if ($triwulan == 1) {
			$batasAtasTriwulan = 1;
			$batasTengahTriwulan = 2;
			$batasBawahTriwulan = 3;
		} else if ($triwulan == 2) {
			$batasAtasTriwulan = 4;
			$batasTengahTriwulan = 5;
			$batasBawahTriwulan = 6;
		} else if ($triwulan == 3) {
			$batasAtasTriwulan = 7;
			$batasTengahTriwulan = 8;
			$batasBawahTriwulan = 9;
		} else if ($triwulan == 4) {
			$batasAtasTriwulan = 10;
			$batasTengahTriwulan = 11;
			$batasBawahTriwulan = 12;
		}

		if ($triwulan == 5) {
			$query = $this->db
				// ->select('V_logoPerusahaan,V_namaPerusahaan,V_paket,V_masaBerlaku,V_masaSelesai,V_mouNo')
				->join('formkerjasama_statusbenefit', 'formkerjasama_perusahaan_dt.idPerusahaan = formkerjasama_statusbenefit.idPerusahaan')
				->where('N_Status', 0)
				->get('formkerjasama_perusahaan_dt');
				// print_r($query->result());exit();
			return $query->result();
		}else{
			$query = $this->db
				// ->select('V_logoPerusahaan,V_namaPerusahaan,V_paket,V_masaBerlaku,V_masaSelesai,V_mouNo')
				->join('formkerjasama_statusbenefit', 'formkerjasama_perusahaan_dt.idPerusahaan = formkerjasama_statusbenefit.idPerusahaan')
				->where('N_Status', 0)
				->where('MONTH(V_masaBerlaku)', $batasAtasTriwulan)
				->or_where('MONTH(V_masaBerlaku)', $batasTengahTriwulan)
				->or_where('MONTH(V_masaBerlaku)', $batasBawahTriwulan)
				->where('YEAR(V_MasaBerlaku)', $tahun)
				->get('formkerjasama_perusahaan_dt');
			return $query->result();
		}
	}
}
