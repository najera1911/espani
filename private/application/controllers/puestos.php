<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property clsTinyButStrong clsTinyButStrong
 * @property Puestos_model puestos_model
 */

 class Puestos extends CI_Controller
 {   
    public function __construct(){
        parent::__construct();
            $this->load->model('puestos_model');
        if( $this->session->userdata('isLoggedIn') ) {
            $this->acl->setUserId($this->session->userdata('idU'));
        }
    }
    function cliError($msg = "Bad Request", $num = "0x0")//
    {
        set_status_header(500);
        exit($msg . trim(" " . $num ));
    }//end funciton error
    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'puestos/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('puestos/vw_' . $pagina);
    }// end function index ---**----
    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'puestos':
            $res = $this->puestos_model->obtenter_todos();
                $res = array('data'=>$res);
                exit(json_encode($res));
               break;
               default: $this->cliError(); 
        }
    }//end function get

     function set($data = '')
     {
         if (!$this->session->userdata('isLoggedIn')) {
             $this->cliError('Default response');
         }
         switch ($data) {
             case 'puestos':
                 $txtDescripcion = filter_input(INPUT_POST, 'txtDescripcion');
                 if (empty($txtDescripcion)) {
                     $this->cliError('Campo vacio');

                 }
                 $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);

                 $data = array(
                     "descripcion" => $txtDescripcion,
                     "estatus" => true
                 );

                 if (!empty($idEmpleado)) {
                     $res = $this->puestos_model->updatePuesto($idEmpleado, $data);
                 } else {
                     $res = $this->puestos_model->addPuesto($data);
                 }
                 if ($res) {
                     exit(json_encode(["status" => "Ok"]));
                 } else {
                     $this->cliError("ocurrio un error");
                 }

                 break;
             case 'deleteArea':
                 $data = filter_input(INPUT_POST, 'datos');
                 $res = $this->puestos_model->deletePuesto($data);
                 if ($res) {
                     exit('OK');
                 } else {
                     $this->cliError('No se pudo eliminar el departamento');
                 }

                 break;
             default:
                 $this->cliError();
         }
     }
 }