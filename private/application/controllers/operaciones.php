<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
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
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                // si no hay valor para buscar entonces llama toda la tablas
                if (empty($datasearch["value"])){
                    $res = $this->operaciones_model->obtener_todos($start,$length);
                }else{  //de lo contrario hace una busqueda tipo like
                    $res = $this->operaciones_model->obtener_todosSearch($start,$length,$datasearch["value"],$nameColumn[1]["data"]);
                }

                $res = array('data'=>$res);
                exit(json_encode($res));
               break;
            case 'operaciones2':
                $start = -1;
                $length = -1;
                $res = $this->operaciones_model->obtener_todos($start,$length);
                $res = array('data'=>$res);
                exit(json_encode($res));
                break;
            case 'tipoCorte':
                $res = $this->operaciones_model->obtener_tipoCorte();
                $res = array('data'=>$res);
                exit(json_encode($res));
                break;
            case 'catTipoCorte':
                $res = $this->operaciones_model->catTipoCorte();
                exit(json_encode($res));
                break;
            case 'datosModelosCortes':
                $res = $this->operaciones_model->getModelosCorte();
                $res = array('data'=>$res);
                exit(json_encode($res));
                break;
            case 'datosModelosCortesDetalle':
                $idModel = filter_input(INPUT_POST, 'idModel');
                $res = $this->operaciones_model->datosModelosCortesDetalle($idModel);
                $res = array('data'=>$res);
                exit(json_encode($res));
                break;
            default: $this->cliError();
        }
    }

    function set($data = '')
    {
        if (!$this->session->userdata('isLoggedIn')) {
            $this->cliError('Default response');
        }
        switch ($data) {
            case 'operacion':
                $cmbTipoCorte = filter_input(INPUT_POST, 'cmbTipoCorte');
                $txtOperacion2 = filter_input(INPUT_POST, 'txtOperacion');
                $txtOperacion = trim($txtOperacion2);
                $txtDescripcion = filter_input(INPUT_POST, 'txtDescripcion');
                $txtTarifa_sin = filter_input(INPUT_POST, 'txtTarifa_sin');
                $txtTarifa_con = filter_input(INPUT_POST, 'txtTarifa_con');
                $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);

                if(empty($cmbTipoCorte)){
                    $this->cliError('seleccione un tipo de corte');
                }
                 if(empty($txtOperacion)){
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
                 }

                $existe = $this->operaciones_model->ifExistOperacion($txtOperacion);

                if($existe){
                    $this->cliError('La clave de operación ya existe');
                }

                $data = array(
                    "cat_tipo_corte_id" => $cmbTipoCorte,
                    "operacion" => strtoupper($txtOperacion),
                    "descripcion" => strtoupper($txtDescripcion),
                    "tarifa_con" => $txtTarifa_con,
                    "tarifa_sin" => $txtTarifa_sin,
                    "estatus" => true
                );

                if (!empty($idEmpleado)) {
                    $res = $this->operaciones_model->updateOperacion($idEmpleado, $data);
                } else {
                    $res = $this->operaciones_model->addOperacion($data);
                }
                if ($res) {
                    exit(json_encode(["status" => "Ok"]));
                } else {
                    $this->cliError("ocurrio un error");
                }

                break;
            case 'deleteCliente':
                $data = filter_input(INPUT_POST, 'datos');
                $res = $this->operaciones_model->deleteOperacion($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el departamento');
                }

                break;
            case 'tipoCorte':
                $txtDescripcion = filter_input(INPUT_POST, 'txtDescripcion');
                if (empty($txtDescripcion)) {
                    $this->cliError('Campo vacio');

                }
                $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);

                $data = array(
                    "descripcion" => strtoupper($txtDescripcion),
                    "estatus" => true
                );

                if (!empty($idEmpleado)) {
                    $res = $this->operaciones_model->updateTipoCorte($idEmpleado, $data);
                } else {
                    $res = $this->operaciones_model->addTipoCorte($data);
                }
                if ($res) {
                    exit(json_encode(["status" => "Ok"]));
                } else {
                    $this->cliError("ocurrio un error");
                }
                break;
            case 'deleteTipoCorte':
                $data = filter_input(INPUT_POST, 'datos');
                $res = $this->operaciones_model->deleteTipoCorte($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el tipo de corte');
                }
                break;
            case 'modelosCortes':
                $descripcion = filter_input(INPUT_POST, 'name');
                $id = filter_input(INPUT_POST, '_id_');

                if(isset($_REQUEST['arr'])){
                    $myArray = $_REQUEST['arr'];
                }else{
                    $myArray = [];
                }

                if(empty($descripcion)){
                    $this->cliError('Debe de Ingresar un nombre');
                }
                if(empty($myArray)){
                    $this->cliError('Debe seleccionar al menos una operación');
                }

                $data = array(
                    "descripcion" => $descripcion,
                    "estatus" => true
                );

                if ($id==0) {
                    $existe = $this->operaciones_model->existeNombre($descripcion);

                    if($existe){
                        $this->cliError('El nombre del modelo ya esiste');
                    }

                    $res = $this->operaciones_model->addModeloCorte($data, $myArray);
                } else {
                    $res = $this->operaciones_model->UpdateModeloCorte($id,$data, $myArray);
                    //$res = $this->operaciones_model->updateTipoCorte($id, $data);
                }

                if ($res) {
                    exit(json_encode(["status" => "Ok"]));
                } else {
                    $this->cliError("ocurrio un error");
                }

                break;
            default:
                $this->cliError();
        }
    }
}
