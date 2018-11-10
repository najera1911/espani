<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('areas_model');

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
        if (!file_exists(VIEWPATH . 'areas/vw_' . $pagina . '.php')) {
            show_404();
        }

        $this->load->view('areas/vw_' . $pagina);
    }
}