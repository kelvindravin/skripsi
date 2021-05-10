<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Datawisuda extends CI_Model
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

	public function getBenefitByPerusahaan($id)
	{
		$query = $this->db
			->from('formkerjasama_benefit_datawisuda')
			->where('idPerusahaan', $id)
			->where('N_status', 0)
			->get();
		return $query->result();
	}

	public function getBenefitById($id)
	{
		$query = $this->db
			->from('formkerjasama_benefit_datawisuda')
			->where('idBenefit', $id)
			->get();
		return $query->result();
	}

	public function updateBenefitByBenefitId($id, $data)
	{
		$this->db->where('idBenefit', $id);
		$affected = $this->db->update('formkerjasama_benefit_datawisuda', $data);
		if ($affected != 0) {
			return true;
		} else {
			return false;
		}
	}
}
