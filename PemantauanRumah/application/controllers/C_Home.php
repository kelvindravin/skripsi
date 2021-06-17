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
        $waktu = $this->Pemantauan->getLatestReadingTime();

        $this->data['readings'] = $this->Pemantauan->getReadingOnATimestamp($waktu[0]->waktu);
        
        
        $this->nav['current_nav'] = "home";
        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('home',$this->data);
        $this->load->view('footer');
    }

    public function loadHistorySearch(){
        $this->nav['current_nav'] = "history";
        $this->data['listSensors'] = $this->Pemantauan->getAllSensors();

        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('historySearch',$this->data);
        $this->load->view('footer');
    }
    
    public function filterSearch(){
        $this->nav['current_nav'] = "history";
        $searchInput = $this->input->post();
        
        if(empty($searchInput['parameter'])){
                $rawData = $this->Pemantauan->getAllSensors();
                $searchInput['parameter'] = array_column($rawData,'identitasSensor');
                
        }
        
        $this->data['dataHistory'] = $this->Pemantauan->getSearchData($searchInput['tanggalMulai'], $searchInput['tanggalSelesai'], $searchInput['parameter']);

        $this->load->view('header');
        $this->load->view('navbar',$this->nav);
        $this->load->view('historyView',$this->data);
        $this->load->view('footer');
    }

        public function getRealtimeUpdate(){
        $waktu = $this->Pemantauan->getLatestReadingTime();

        $readings = $this->Pemantauan->getReadingOnATimestamp($waktu[0]->waktu);
        
        echo json_encode($readings);
	}
        
        public function getSensingStatus(){
        $result['sensingStatus'] = $this->Pemantauan->getSensingStatus()[0]->timestamp;
        
        echo json_encode($result);
        }
}
