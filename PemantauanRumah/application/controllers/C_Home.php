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

    public function loadHero()
    {
        //to show heroes (decoded)
        $hero = file_get_contents('https://api.opendota.com/api/heroes');
        $this->data['hero'] = json_decode($hero);
        $this->data['current_nav'] = "heroes";

        $this->load->view('header');
        $this->load->view('navbar',$this->data);
        $this->load->view('heroes',$this->data);
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