<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property clsTinyButStrong clsTinyButStrong
 * @property Operaciones_model operaciones_model
 */


class Operaciones extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('operaciones_model');
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
        if (!file_exists(VIEWPATH . 'operaciones/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('operaciones/vw_' . $pagina);
    }
    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'operaciones':
            $res = $this->operaciones_model->obtener_todos();
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
            case 'operacion':
            $txtOperacion = filter_input(INPUT_POST, 'txtOperacion');
            $txtDescripcion = filter_input(INPUT_POST, 'txtDescripcion');
            $txtTarifa_con = filter_input(INPUT_POST, 'txtTarifa_con');
            $txtTarifa_sin = filter_input(INPUT_POST, 'txtTarifa_sin');
            $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);


           /* if(empty($txtOperacion)){
                $this->cliError('Campo operacion no puede estar vacio');
            }
            if(empty($txtDescripcion)){
                    $this->cliError('Campo descripcion esta vacio');
            }
            if(empty($txtTarifa_con)){
                $this->cliError('Tarifa con 7° no puede ser vacio');
            }
            if(empty($txtTarifa_sin)){
                $this->cliError('Tarifa sin 7° no puede ser vacio');
            }*/
            $data = array(
                "descripcion" => $txtDescripcion,
                "operacion" => $txtOperacion,
                "tarifa_con" => $txtTarifa_con,
                "tarifa_sin" => $txtTarifa_sin
            );
            if(!empty($idEmpleado)){
                $res = $this->operaciones_model->updateOperacion($idEmpleado, $data);
            }else{
                $res = $this->operaciones_model->addOperacion($data);
            }
            if ($res){
                exit(json_encode(["status"=>"Ok"]));
            } else{
                $this->cliError("ocurrio un error");
            }

               break;
            case 'deleteCliente':
               $data = filter_input(INPUT_POST,'datos');
               $res = $this->operaciones_model->deleteOperacion($data);
               if ($res) {
                   exit('OK');
               } else {
                   $this->cliError('No se pudo eliminar el departamento');
               }

               break;
               default: $this->cliError();
        }
    }
}
