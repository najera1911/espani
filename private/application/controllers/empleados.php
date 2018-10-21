<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

/**
* @property  CI_Session session
* @property Acl acl
* @property CI_Loader load
* @property clsTinyButStrong clsTinyButStrong
* @property Empleados_model empleados_model
* @property  pdf_master_fichaempleado pdf_master_fichaempleado
*/

class Empleados extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('empleados_model');
        $this->load->library('clsPersonal');

        if( $this->session->userdata('isLoggedIn') ) {
            $this->acl->setUserId($this->session->userdata('idU'));
        }
    }

    function cliError($msg = "Bad Request", $num = "0x0")
    {
        set_status_header(500);
        exit($msg . trim(" " . $num ));
    }

    function index($pagina = 'empleados', $data=null){

        if (!file_exists(VIEWPATH . 'empleados/vw_' . $pagina . '.php')) {
            show_404();
        }

        if (!$this->session->userdata('isLoggedIn')) {
            $pagina = 'login';
        }

        $this->load->view('empleados/vw_' . $pagina, $data);

    }

    //funcion para obtener datos
    function get($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
        if (!$this->acl->hasPermission('admin_access')){
            $this->cliError('Default response.');
        }

        switch($what){
            case 'ejemploContrato':
                break;
            default : $this->cliError();
        }
    }

    //funcion para enviar datos
    function set($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
        if (!$this->acl->hasPermission('admin_access')){
            $this->cliError('Default response.');
        }

        switch($what){
            case 'ejemploContrato':
                break;
            default : $this->cliError();
        }
    }

} //end class Empleados