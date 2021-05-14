<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Pemantauan');
    }

    public function loadHome()
    {
        //list of data
        $this->data['ph'] = $this->Pemantauan->getPH();
        $this->data['humidity'] = $this->Pemantauan->getHumidity();
        $this->data['temperature'] = $this->Pemantauan->getTemperature();
        $this->data['lpg'] = $this->Pemantauan->getLPG();
        $this->data['carbon'] = $this->Pemantauan->getCarbon();
        $this->data['smoke'] = $this->Pemantauan->getSmoke();
        
        $this->nav['current_nav'] = "home";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('home',$this->data);
        $this->load->view('footer');
    }

    public function loadHistory(){
        $this->nav['current_nav'] = "history";
        $this->data['dataPengukuran'] = $this->Pemantauan->getAllReading();

        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('history',$this->data);
        $this->load->view('footer');
    }

    public function loadAbout(){
        $this->nav['current_nav'] = "about";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('about');
        $this->load->view('footer');
    }

	public function getRealtimeUpdate(){
		$result['newTemperature'] = $this->Pemantauan->getTemperature()[0]->pengukuran;
        $result['newHumidity'] = $this->Pemantauan->getHumidity()[0]->pengukuran;
        $result['newPh'] = $this->Pemantauan->getPH()[0]->pengukuran;
        $result['newLPG'] = $this->Pemantauan->getLPG()[0]->pengukuran;
        $result['newCO'] = $this->Pemantauan->getCarbon()[0]->pengukuran;
        $result['newSmoke'] = $this->Pemantauan->getSmoke()[0]->pengukuran;

        echo json_encode($result);
	}
}
