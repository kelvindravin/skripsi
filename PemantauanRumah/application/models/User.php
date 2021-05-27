<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User extends CI_Model
{
	public function __construct()
	{
		parent::__construct();
		$this->db = $this->load->database('default',TRUE);
	}

	public function getAllUser()
	{
		$query = $this->db
			->get('user');
		return $query->result();
	}
	
	public function getUserByLogin($email,$password){
		$query = $this->db
			->where('email',$email)
			->where('password',$password)
			->get('user');
		if(sizeof($query->result()) != 0){
			return true;
		}else{
			return false;
		}
	}
	
	public function getEnabledUserNotification(){
		$query = $this->db
			->where('notifikasi',1)
			->get('user');
		return $query->result();
	}
}
