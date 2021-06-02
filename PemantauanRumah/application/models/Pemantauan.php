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

	public function getTurbidity(){
		$query = $this->db
			->where('sensorPengukur','turbidity')
			->order_by('timestamp','desc')
			->get('sensorReading');
		return $query->result();
	}
	
	public function getSearchData($start,$end,$parameters){
		$parameterFilter = "(";
		
		foreach($parameters as $key => $value){
			$parameterFilter .= "sensorPengukur = '$value'";
			if($key < sizeof($parameters)-1){
				$parameterFilter .= " OR ";
			}
		}
		
		$parameterFilter.= ")";
		
		$query = $this->db
			->where('DATE(timestamp) BETWEEN "'. date('Y-m-d', strtotime($start)). '" and "'. date('Y-m-d', strtotime($end)).'"')
			->where($parameterFilter)
			->get('sensorReading');
		return $query->result();
	}
	
	public function getSensingStatus(){
		$query = $this->db
			->select_max('timestamp')
			->get('sensorReading');
		return $query->result();
	}
}
