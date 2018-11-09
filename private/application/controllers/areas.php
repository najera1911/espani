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
    function get($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }

        switch($what){
            case 'areas':
                $data = $this->areas_model->get_areas(array('estatus'=>1));
                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            default : $this->cliError();
        }
    }
    function set($what=''){
        if(!$this->session->userdata('isLoggedIn') ){
            $this->cliError('Default response');
        }
        switch($what){
            case 'areas':
                $txtDescripcion = filter_input(INPUT_POST, 'txtDescripcion');
                $txtEstatus = filter_input(INPUT_POST, 'txtEstatus');

                if(empty($txtDescripcion)){
                    $this->cliError('Campo Descripcion Vacio');
                }
                if(empty($txtEstatus)){
                    $this->cliError('Campo Estatus vacio');
                }
                $data = array(
                'desacripcion' => $txtDescripcion,
                'estatus' => $txtEstatus,                    
                );
                
        }
    }
}