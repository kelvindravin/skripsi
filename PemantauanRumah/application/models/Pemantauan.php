<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pemantauan extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	public function getAllReading()
	{
		$query = $this->db
			->get('sensorReading');
		return $query->result();
	}
}
