<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	date_default_timezone_set('Asia/Jakarta');

class Adminlog extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('localdb', TRUE);
	}

	//Untuk Insert data ke database
	public function insert($logText)
	{
		$now = date('Y-m-d H:i:s');
        $data = array(
            'V_log' => $logText , 
            'T_waktu' => $now
        );

		$this->db->insert('formkerjasama_log', $data);
	}

	public function getAllLog()
	{
		$query = $this->db
			->from('formkerjasama_log')
			->get();
		return $query->result();
	}
}
