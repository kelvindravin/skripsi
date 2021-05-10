<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['cas_server_url'] = 'https://sso.unpar.ac.id';
//ganti nama_aplikasi menjadi nama folder projek. pastikan file php_cas ada di dalamnya.
$config['phpcas_path'] = 'application/third_party/phpcas/'; 
$config['cas_disable_server_validation'] = TRUE;