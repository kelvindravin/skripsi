<?php
defined('BASEPATH') or exit('No direct script access allowed');

class C_Home extends CI_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Pemantauan');
        $this->load->model('User');
    }
    
    public function loadLogin(){
        $this->load->view('header');
        $this->load->view('login');
    }
    
    public function loginProcess(){
        $email = $this->input->post('email');
        $password = $this->input->post('password');
        $loginAuthenticator = $this->User->getUserByLogin($email, $password);
        if ($loginAuthenticator == true) {
            $this->session->set_userdata('email', $email);
            redirect(base_url('home'));
        } else {
            $this->session->set_flashdata('error', 'Akun tidak terdaftar / data akun tidak sesuai!');
            redirect(base_url('login'));
        }
    }
    
    public function logout(){
        $this->session->sess_destroy();
        redirect(base_url('login'));
    }

    public function loadHome()
    {
        //list of data
        $this->data['ph'] = $this->Pemantauan->getPH();
        $this->data['ph'] = $this->Pemantauan->getTurbidity();
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

    public function loadHistorySearch(){
        $this->nav['current_nav'] = "history";

        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('historySearch');
        $this->load->view('footer');
    }
    
    public function filterSearch(){
        $this->nav['current_nav'] = "history";
        $searchInput = $this->input->post();
        
        if(empty($searchInput['parameter'])){
                $searchInput['parameter'] = array('temperature','humidity','ph','lpg','carbon','smoke','turbidity');
        }
        
        $this->data['dataHistory'] = $this->Pemantauan->getSearchData($searchInput['tanggalMulai'], $searchInput['tanggalSelesai'], $searchInput['parameter']);

        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('historyView',$this->data);
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
        $result['newTemperatureLoc'] = $this->Pemantauan->getTemperature()[0]->lokasi;
        $result['timestampTemperature'] = $this->Pemantauan->getTemperature()[0]->timestamp;
        
        $result['newHumidity'] = $this->Pemantauan->getHumidity()[0]->pengukuran;
        $result['newHumidityLoc'] = $this->Pemantauan->getHumidity()[0]->lokasi;
        $result['timestampHumidity'] = $this->Pemantauan->getHumidity()[0]->timestamp;
        
        $result['newPh'] = $this->Pemantauan->getPH()[0]->pengukuran;
        $result['newPhLoc'] = $this->Pemantauan->getPH()[0]->lokasi;
        $result['timestampPh'] = $this->Pemantauan->getPH()[0]->timestamp;

        $result['newTurbidity'] = $this->Pemantauan->getTurbidity()[0]->pengukuran;
        $result['newTurbidityLoc'] = $this->Pemantauan->getTurbidity()[0]->lokasi;
        $result['timestampTurbidity'] = $this->Pemantauan->getTurbidity()[0]->timestamp;
        
        $result['newLPG'] = $this->Pemantauan->getLPG()[0]->pengukuran;
        $result['newLPGLoc'] = $this->Pemantauan->getLPG()[0]->lokasi;
        $result['timestampLPG'] = $this->Pemantauan->getLPG()[0]->timestamp;
        
        $result['newCO'] = $this->Pemantauan->getCarbon()[0]->pengukuran;
        $result['newCOLoc'] = $this->Pemantauan->getCarbon()[0]->lokasi;
        $result['timestampCO'] = $this->Pemantauan->getCarbon()[0]->timestamp;
        
        $result['newSmoke'] = $this->Pemantauan->getSmoke()[0]->pengukuran;
        $result['newSmokeLoc'] = $this->Pemantauan->getSmoke()[0]->lokasi;
        $result['timestampSmoke'] = $this->Pemantauan->getSmoke()[0]->timestamp;
        
        $result['updatedTimestamp'] = $this->Pemantauan->getSensingStatus()[0]->timestamp;
        
        echo json_encode($result);
	}
        
        public function getSensingStatus(){
        $result['sensingStatus'] = $this->Pemantauan->getSensingStatus()[0]->timestamp;
        
        echo json_encode($result);
        }
}
