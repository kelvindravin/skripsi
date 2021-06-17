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

	public function getLatestReadingTime()
	{
		$query = $this->db
			->select_max('waktu')
			->get('pengukuran');
		return $query->result();	
	}

	public function getReadingOnATimestamp($latestTime)
	{
		$query = $this->db
			->where('waktu',$latestTime)
			->join('pengukuran', 'sensor.idSensor = pengukuran.idSensor')
			->join('nodeSensor', 'sensor.idNode = nodeSensor.idNode')
			->get('sensor');
		return $query->result();
	}
	
	public function getAllSensors(){
		$query = $this->db->distinct()
			->select('identitasSensor')
			->get('sensor');
		return $query->result_array();
	}
	
	public function getSearchData($start,$end,$parameters){
		$parameterFilter = "(";
		
		foreach($parameters as $key => $value){
			$parameterFilter .= "identitasSensor = '$value'";
			if($key < sizeof($parameters)-1){
				$parameterFilter .= " OR ";
			}
		}
		
		$parameterFilter.= ")";
		$query = $this->db
			->join('sensor', 'sensor.idSensor = pengukuran.idSensor')
			->where('DATE(waktu) BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"')
			->where($parameterFilter)
			->get('pengukuran');
		return $query->result();
	}
}
