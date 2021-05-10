<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class Pemantauan extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('localdb', TRUE);
	}

	//get All Pemantauan Data
	public function getAllPerusahaanData()
	{
		$query = $this->db
			->get('sensorReading');
		return $query->result();
	}