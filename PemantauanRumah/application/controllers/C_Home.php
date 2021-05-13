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
        // $this->data['ph'] = $this->Pemantauan->getPH();
        // $this->data['humidity'] = $this->Pemantauan->getHumidity();
        // $this->data['temperature'] = $this->Pemantauan->getTemperature();
        // $this->data['lpg'] = $this->Pemantauan->getLPG();
        // $this->data['carbon'] = $this->Pemantauan->getCarbon();
        // $this->data['smoke'] = $this->Pemantauan->getSmoke();
        $this->data['test'] = "testing only";
        
        $this->nav['current_nav'] = "home";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('home',$this->data);
        $this->load->view('footer');
    }

    public function loadHistory(){
        $this->nav['current_nav'] = "history";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('history');
        $this->load->view('footer');
    }

    public function loadAbout(){
        $this->nav['current_nav'] = "about";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('about');
        $this->load->view('footer');
    }
}
