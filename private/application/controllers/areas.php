<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property clsTinyButStrong clsTinyButStrong
 * @property Areas_model areas_model
 */

class Areas extends CI_Controller
{
    public function __construct(){
        parent::__construct();
        $this->load->model('areas_model');

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
        if (!file_exists(VIEWPATH . 'areas/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('areas/vw_' . $pagina);
    }
    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'areas':
            $res = $this->areas_model->obtenter_todos();
                $res = array('data'=>$res);
                exit(json_encode($res));
               break;
               default: $this->cliError(); 
        }
    }
    function set($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'areas':
                
               break;
               default: $this->cliError(); 
        }
    }

}