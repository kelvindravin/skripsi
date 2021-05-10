<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/

$route['default_controller'] = 'C_Formulir';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;

$route['PengisianForm'] = 'C_Formulir/loadHalamanFormulir';
$route['FormIdentitas'] = 'C_Formulir/loadHalamanIndentitas';
$route['penutup'] = 'C_Formulir/loadHalamanPenutup';

// Pengolahan Data Form
$route['submitForm'] = 'C_Formulir/registerPerusahaan';

// Admin
$route['admin'] = 'C_Admin/loadHalamanAdmin';
$route['admin-login'] = 'C_Admin/loginSSO';
$route['admin-dashboard'] = 'C_Admin/loadMainPage';

    //  Admin-Menu Perusahaan
    $route['daftar-perusahaan'] = 'C_Admin/loadHalamanDaftarPerusahaan';
    $route['edit-data'] = 'C_Admin/loadHalamanEditData';
        // Child of edit-data
        $route['edit-perusahaan'] = 'C_Admin/loadEditData';
        $route['updateDataPerusahaan'] = 'C_Admin/updateDataPerusahaan';
        $route['delete-perusahaan'] = 'C_Admin/deletePerusahaan';
    $route['status-benefit'] = 'C_Admin/loadHalamanStatusBenefit';
    $route['edit-benefit'] = 'C_Admin/loadHalamanEditBenefit';
        // Child of edit-benefit
        $route['status-benefit/edit-benefit'] = 'C_Admin/loadEditBenefit';
        $route['edit-benefit-perusahaan'] = 'C_Admin/updateBenefit';
    $route['publikasi'] = 'C_Admin/loadHalamanPublikasi';
        // Child of publikasi
        $route['add-publikasi'] = 'C_Admin/loadAddPublikasi';
        $route['edit-publikasi'] = 'C_Admin/loadEditPublikasi';
        $route['history-publikasi'] = 'C_Admin/loadHistoryPublikasi';
        $route['addPublikasi'] = 'C_Admin/insertPublikasi';
        $route['editPublikasi'] = 'C_Admin/editPublikasi';
    $route['benefit-lainnya'] = 'C_Admin/loadHalamanBenefitLainnya';
        // Child of benefit lainnya
        $route['add-benefit-lainnya-ch'] = 'C_Admin/loadAddBenefitCH';
            $route['addBenefitCH'] = 'C_Admin/addBenefitCH';
            $route['editBenefitCH'] = 'C_Admin/loadEditBenefitCH';
            $route['edit-BenefitCH'] = 'C_Admin/editBenefitCH';
            $route['delete-benefit-ch'] = 'C_Admin/deleteBenefitCH';
        $route['add-benefit-lainnya-cb'] = 'C_Admin/loadAddBenefitCB';
            $route['addBenefitCB'] = 'C_Admin/addBenefitCB';
            $route['editBenefitCB'] = 'C_Admin/loadEditBenefitCB';
            $route['edit-BenefitCB'] = 'C_Admin/editBenefitCB';
            $route['delete-benefit-cb'] = 'C_Admin/deleteBenefitCB';
        $route['add-benefit-lainnya-vjf'] = 'C_Admin/loadAddBenefitVJF';
            $route['addBenefitVJF'] = 'C_Admin/addBenefitVJF';
            $route['editBenefitVJF'] = 'C_Admin/loadEditBenefitVJF';
            $route['edit-BenefitVJF'] = 'C_Admin/editBenefitVJF';
            $route['delete-benefit-vjf'] = 'C_Admin/deleteBenefitVJF';
        $route['add-benefit-lainnya-dw'] = 'C_Admin/loadAddBenefitDW';
            $route['addBenefitDW'] = 'C_Admin/addBenefitDW';
            $route['editBenefitDW'] = 'C_Admin/loadEditBenefitDW';
            $route['edit-BenefitDW'] = 'C_Admin/editBenefitDW';
            $route['delete-benefit-dw'] = 'C_Admin/deleteBenefitDW';
        $route['history-benefit-lainnya'] = 'C_Admin/loadHistoryBenefitLainnya';

$route['laporan'] = 'C_Admin/loadLaporan';
$route['cariLaporan'] = 'C_Admin/cariLaporan';
$route['log'] = 'C_Admin/loadLog';
$route['auth'] = 'C_Admin/loadAuth';
    $route['change-authority'] = 'C_Admin/changeAuth';
    $route['add-authority'] = 'C_Admin/insertNewAuth';
    $route['delete-authority'] = 'C_Admin/deleteAuth';
$route['logout'] = 'C_Admin/logout';