<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Jurusanlist extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('localdb', TRUE);
	}

	public function getAllJurusan()
	{
		$query = $this->db
			->from('formkerjasama_jurusan')
			->get();
		return $query->result();
	}
}
