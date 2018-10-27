<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property clsTinyButStrong clsTinyButStrong
 * @property Clientes_model clientes_model
 */

class Clientes extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('clientes_model');

        if( $this->session->userdata('isLoggedIn') ) {
            $this->acl->setUserId($this->session->userdata('idU'));
        }
    }

    function cliError($msg = "Bad Request", $num = "0x0")
    {
        set_status_header(500);
        exit($msg . trim(" " . $num ));
    }

    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'clientes/vw_' . $pagina . '.php')) {
            show_404();
        }

        $this->load->view('clientes/vw_' . $pagina);
    }

    function get($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
//        if (!$this->acl->hasPermission('admin_access')){
//            $this->cliError('Default response.');
//        }

        switch($what){
            default : $this->cliError();
        }
    }

    function set($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
//        if (!$this->acl->hasPermission('admin_access')){
//            $this->cliError('Default response.');
//        }

        switch($what){
            default : $this->cliError();
        }
    }

}