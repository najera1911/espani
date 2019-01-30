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
            case 'clientes':
            $datasearch = $_POST['search']; //obtiene el valor para buscar
            $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
            $start = $_POST['start']; //valor de inicio para el limit
            $length = $_POST['length'] ;
        // si no hay valor para buscar entonces llama toda la tablas
            if (empty($datasearch["value"])){
                $data = $this->clientes_model->get_clientes($start,$length,array('estatus'=>1));
            }else{  //de lo contrario hace una busqueda tipo like
                $data = $this->clientes_model->getClienteSearch($start,$length,$datasearch["value"],$nameColumn[0]["data"]);
            }
                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
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
            case 'clientes':
                $txtName = filter_input(INPUT_POST, 'txtName');
                $txtAPaterno = filter_input(INPUT_POST, 'txtAPaterno');
                $txtAMaterno = filter_input(INPUT_POST, 'txtAMaterno');
                $txtNombreCorto = filter_input(INPUT_POST, 'txtNombreCorto');
                $rfc = filter_input(INPUT_POST,'txtRFC');
                $txtemail           = filter_input(INPUT_POST, 'txtEmail');
                $txtTelefono1       = filter_input(INPUT_POST, 'txtFon');
                $txtCalle           = filter_input(INPUT_POST, 'txtCalleNum');
                $txtColonia         = filter_input(INPUT_POST, 'txtColonia');
                $cmbEntidad              = filter_input(INPUT_POST, 'cmbEntidad');
                $cmbMunicipio       = filter_input(INPUT_POST, 'cmbMunicipio');
                $cmbLocalidad       = filter_input(INPUT_POST, 'cmbLocalidad');

                $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);

                if(empty($txtName)){
                    $this->cliError('Campo nombre vacio');
                }
                if(empty($txtNombreCorto)){
                    $this->cliError('Campo nombre corto vacio');
                }

                $data = array(
                    'apellido_p' => $txtAPaterno,
                    'apellido_m' => $txtAMaterno,
                    'nombre' => $txtName,
                    'nombre_corto' => $txtNombreCorto,
                    'rfc' => $rfc,
                    'calle_num' => $txtCalle,
                    'colonia' =>$txtColonia,
                    'cat_entidad_id' => $cmbEntidad,
                    "cat_municipio_id" => $cmbMunicipio,
                    "cat_localidad_id" => $cmbLocalidad,
                    "email" => $txtemail,
                    "telefono" => $txtTelefono1,
                    'estatus' => true,
                    "cat_usuario_id" => $this->session->userdata('idU')
                );

                if(!empty($idEmpleado)){
                    $res = $this->clientes_model->updateClient($idEmpleado, $data);
                }else{
                    $res = $this->clientes_model->addClient($data);
                }

                if($res){
                    exit(json_encode(["status" => "Ok" ]));
                }else{
                    $this->cliError("Ocurrio un error");
                }

                break;
            case 'deleteCliente':
                $data = filter_input(INPUT_POST,'datos');
                $res = $this->clientes_model->deleteCliente($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }

                break;
            default : $this->cliError();
        }
    }

}