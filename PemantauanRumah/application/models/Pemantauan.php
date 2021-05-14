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
	
	public function getTemperature(){
		$query = $this->db
			->where('sensorPengukur','temperature')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getHumidity(){
		$query = $this->db
			->where('sensorPengukur','humidity')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getLPG(){
		$query = $this->db
			->where('sensorPengukur','LPG')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getCarbon(){
		$query = $this->db
			->where('sensorPengukur','Carbon')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getSmoke(){
		$query = $this->db
			->where('sensorPengukur','Smoke')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getPH(){
		$query = $this->db
			->where('sensorPengukur','pH')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
}
