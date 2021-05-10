<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Authority extends CI_Model
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

	public function getAdminRole($emailAdmin)
	{
		$query = $this->db
			->select('N_statusAdmin')
			->from('formkerjasama_authority')
			->where('V_email', $emailAdmin)
			->get();
		return $query->result();
	}

	public function getAllAdminData($email)
	{
		$query = $this->db
			->from('formkerjasama_authority')
			->where_not_in('V_email',$email)
			->get();
		return $query->result();
	}

	public function updateStatusAdmin($id,$data){
		$this->db->where('idAdmin', $id);
		$affected = $this->db->update('formkerjasama_authority', $data);
		if ($affected != 0) {
			return true;
		} else {
			return false;
		}
	}

	public function deleteAdmin($table, $data){
		$this->db->delete($table, $data);
	}
}
