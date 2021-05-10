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
        $this->data['reading'] = $this->Pemantauan->getAllReading();
        
        $this->nav['current_nav'] = "home";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('home',$this->data);
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
