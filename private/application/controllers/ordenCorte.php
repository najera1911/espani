<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property OrdenCorte_model ordenCorte_model
 */


class OrdenCorte extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('ordenCorte_model');
        if( $this->session->userdata('isLoggedIn') ) {
            $this->acl->setUserId($this->session->userdata('idU'));
        }
    }

    function cliError($msg = "Bad Request", $num = "0x0")//
    {
        set_status_header(500);
        exit($msg . trim(" " . $num ));
    }

    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'ordenCorte/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('ordenCorte/vw_' . $pagina);
    }

    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            default: $this->cliError();
        }
    }

    function set($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            default: $this->cliError();
        }
    }


}