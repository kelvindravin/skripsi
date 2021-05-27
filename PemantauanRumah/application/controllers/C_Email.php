<?php

if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class C_Email extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		// The mail sending protocol.
		$config = array(
			'protocol' => 'smtp',
			'smtp_host' => 'smtp.gmail.com',
			'smtp_port' => 465,
			'smtp_crypto' => 'ssl',
			'smtp_user' => '2017730022.monitoring@gmail.com',
			'smtp_pass' => 'homemonitoring',
			'mailtype'  => 'html',
			'charset'   => 'utf-8'
		);
		$this->load->library('email', $config);
		$this->email->set_newline("\r\n"); 
		//must exist, or the email will be failed
		/*READ-ME: 
				Apabila SMTP tidak jalan dan error menunjukan tidak ada file curl-ca-bundle,
				copy file cacert.pem di folder asset/SMTP email, lalu navigate ke folder instalasi XAMPP/apache/bin lalu paste kan file
				cacert.pem lalu di rename jadi curl-ca-bundle.crt
		*/
		$this->load->model('User');
	}

	public function sendWarning()
	{
		$targetEmail = $this->User->getEnabledUserNotification();
		$co = $this->input->post('co');
		$smoke = $this->input->post('smoke');
		$lpg = $this->input->post('lpg');
		
		foreach ($targetEmail as $value) {
			$this->email->from('2017730022.monitoring@gmail.com', 'Home Monitoring System'); //reply-to
			$this->email->to($value->email);
			$this->email->subject('Warning Notification');
			$this->email->message('
			Perhatian,<br>
					Sistem Monitoring telah mendeteksi keberadaan tanda bahaya dengan detail sebagai berikut :
					<br><br>
					Kadar Karbon Monoksida dalam udara : '.$co.' PPM (Batas wajar : 30 PPM)<br>
					Kadar Asap dalam udara : '.$smoke.' PPM (Batas wajar : 100 PPM)<br>
					Kadar LPG dalam udara : '.$lpg.' PPM (Batas wajar : 200 PPM)<br>
					<br>
					Berhati-hatilah, dan harap untuk diperiksa kembali kondisi berikut.
					<br>
					Home Monitoring System - 2017730022
					
			');
			$this->email->send();
		}
	}
}
