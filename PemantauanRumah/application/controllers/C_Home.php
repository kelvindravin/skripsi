<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
    }

    public function loadHome()
    {
        $this->data['current_nav'] = "home";
        $this->load->view('header');
        $this->load->view('navbar',$this->data);
        $this->load->view('home',$this->data);
        $this->load->view('footer');
    }

    public function loadAbout(){
        $this->data['current_nav'] = "about";
        $this->load->view('header');
        $this->load->view('navbar',$this->data);
        $this->load->view('about');
        $this->load->view('footer');
    }
}
