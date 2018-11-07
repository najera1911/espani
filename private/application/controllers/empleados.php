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

    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'empleados/vw_' . $pagina . '.php')) {
            show_404();
        }

        $this->load->view('empleados/vw_' . $pagina);
    }

    //funcion para obtener datos
    function get($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
//        if (!$this->acl->hasPermission('admin_access')){
//            $this->cliError('Default response.');
//        }

        switch($what){
            case 'empleados':
                $data = $this->empleados_model->get_empleados(array('estatus'=>1));
                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            case 'catEntidad':
                $res = $this->empleados_model->getEntidad();
                exit(json_encode($res));
                break;
            case 'catMunicipio':
                $cat_estado_id = filter_input(INPUT_GET, 'cat_estado_id', FILTER_VALIDATE_INT);
                if(empty($cat_estado_id)){
                    $this->cliError("Seleccione un estado");
                }
                $res = $this->empleados_model->getMunicipio($cat_estado_id);
                exit(json_encode($res));
                break;
            case 'catLocalidad':
                $cat_estado_id = filter_input(INPUT_GET, 'cat_estado_id', FILTER_VALIDATE_INT);
                $clave_municipio = filter_input(INPUT_GET, 'cat_municipio', FILTER_VALIDATE_INT);
                if(empty($cat_estado_id) || empty($clave_municipio)){
                    $this->cliError("Seleccione un estado y municipio");
                }
                $res = $this->empleados_model->getLocalidad($cat_estado_id,$clave_municipio);
                exit(json_encode($res));
                break;
            case 'catDepartamento':
                $res = $this->empleados_model->getDepartamento();
                exit(json_encode($res));
                break;
            case 'catPuesto':
                $res = $this->empleados_model->getPuesto();
                exit(json_encode($res));
                break;
            case 'foto':
                $id = filter_input(INPUT_GET, 'csid', FILTER_VALIDATE_INT);

                if(empty($id)){
                    show_404();
                    exit();
                }


                $res = $this->empleados_model->getFoto($id);
                if(!empty($res)){
                    header('content-type: '. $res->tipo);
                    echo $res->foto;
                }else{
                    $img = (APPPATH .'libraries/empty.jpg');
                    header('content-type: '. 'image/jpeg');
                    header('content-disposition: inline; filename="empty.jpg";');
                    readfile($img);
                }
                break;
            default : $this->cliError();
        }
    }

    //funcion para enviar datos
    function set($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
//        if (!$this->acl->hasPermission('admin_access')){
//            $this->cliError('Default response.');
//        }

        switch($what){
            case 'empleado':
                $rfc = filter_input(INPUT_POST,'txtRFC');
                if(empty($rfc)){
                    $this->cliError('Faltan Datos','0x01');
                }


                $txtAPaterno = filter_input(INPUT_POST, 'txtAPaterno');
                $txtAMaterno = filter_input(INPUT_POST, 'txtAMaterno');
                $txtName          = filter_input(INPUT_POST, 'txtName');
                $cmbSexo            = filter_input(INPUT_POST, 'cmbSexo');
                $txtCURP            = filter_input(INPUT_POST, 'txtCURP');
                $txtFchaNac    = filter_input(INPUT_POST, 'txtFchaNac');
                $txtemail           = filter_input(INPUT_POST, 'txtEmail');
                $txtTelefono1       = filter_input(INPUT_POST, 'txtFon');
                $txtNSS            = filter_input(INPUT_POST, 'txtNSS');
                $txtCalle           = filter_input(INPUT_POST, 'txtCalleNum');
                $txtColonia         = filter_input(INPUT_POST, 'txtColonia');
                $cmbEntidad              = filter_input(INPUT_POST, 'cmbEntidad');
                $cmbMunicipio       = filter_input(INPUT_POST, 'cmbMunicipio');
                $cmbLocalidad       = filter_input(INPUT_POST, 'cmbLocalidad');
                $cmbDep          = filter_input(INPUT_POST, 'cmbDep');
                $cmbPuesto          = filter_input(INPUT_POST, 'cmbPuesto');
                $cmbFchaIngreso      = filter_input(INPUT_POST, 'txtFchaIngreso');



                $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);



                //Registra en la tabla principal
                $empleado = new clsPersonal();

                $empleado->cat_rh_departamento             = strtoupper($cmbDep);
                $empleado->cat_rh_puesto            = ($cmbPuesto);
                $empleado->apellido_p           = ($txtAPaterno);
                $empleado->apellido_m           = ($txtAMaterno);
                $empleado->nombre                     = ($txtName);
                $empleado->fcha_nac              = date_create_from_format('d/m/Y', $txtFchaNac);
                $empleado->sexo                       = ($cmbSexo);
                $empleado->rfc                        = strtoupper($rfc);
                $empleado->curp = strtoupper($txtCURP);
                $empleado->nss                       = strtoupper($txtNSS);
                $empleado->telefono                   = strtoupper($txtTelefono1);
                $empleado->email                       = strtoupper($txtemail);
                $empleado->calle_num                      = ($txtCalle);
                $empleado->colonia                    = ($txtColonia);
                $empleado->cat_entidad                  = ($cmbEntidad);
                $empleado->cat_localidad              = ($cmbLocalidad);
                $empleado->cat_municipio                 = ($cmbMunicipio);
                $empleado->fcha_ingreso                 = date_create_from_format('d/m/Y', $cmbFchaIngreso);
                $empleado->estatus              = (true);
                $empleado->cat_usuario_alta_id = $this->session->userdata('idU');



                $foto = NULL;
                $fotoLen = NULL;
                $fotoType = NULL;



                if(isset($_FILES) AND (count($_FILES) == 1) ){
                    if((preg_match('/image*/',$_FILES['txtImagenUsuario']['type'])) == 1) {
                        $file     = $_FILES['txtImagenUsuario'];
                        $data     = file_get_contents($file['tmp_name']);
                        $fotoLen  = $file['size'];
                        $fotoType = $file['type'];
                        $fotoHex  = unpack("H*hex", $data);
                        $foto     = "0x" . $fotoHex['hex'];
//                        $foto     = "'". 'data:' . $fotoType . ';base64,' . base64_encode($data) . "'";
                    }
                }

                // comprobar que las fechas sean validas, sueldo sea positivo y valido, y cp sean numeros

                if(empty($empleado->fcha_nac) || empty($empleado->fcha_ingreso)){

                    $this->cliError('Error al validar las fechas');
                }


                if(empty($empleado->apellido_p) || empty($empleado->apellido_m) || empty($empleado->nombre)){
                    $this->cliError('Error al validar el nombre y apellidos, vacio');
                }

                if(empty($empleado->cat_rh_departamento) || empty($empleado->cat_rh_puesto)){
                    $this->cliError('Error al validar el departamento o puesto, vacio');
                }


                //convertir fechas

                $empleado->fcha_nac = $empleado->fcha_nac->format('Y-m-d');
                $empleado->fcha_ingreso = $empleado->fcha_ingreso->format('Y-m-d');

                if(!empty($idEmpleado)){
                    $res = $this->empleados_model->updateEmpleado($idEmpleado, $empleado);
                }else{
                    $res = $this->empleados_model->addEmpleado($empleado);
                    // actualizar el empleado asignarle vusuario y vclave
                    if($res){
                        $usuario = 'EM' . sprintf("%'04d", $res);
                        $this->empleados_model->updateTblEmpleado(
                            array('numEmpleado' => $usuario ),
                            array('cat_rh_empleado_id' => $res)
                        );
                    }
                }

                if(!empty($foto)){
                    $this->empleados_model->updateFoto( ((empty($idEmpleado) AND $res)? $res: $idEmpleado ), $foto, $fotoType, $fotoLen);
                }


                if($res){
                    $idEmpleado = (empty($idEmpleado)?$res:$idEmpleado);
                    exit(json_encode(["status" => "Ok", "numEmpleado" => 'SP'.sprintf("%'04d", $idEmpleado)]));

                }else{

                    $this->cliError("Ocurrio un error");
                }
                // primero comprobamos si existe el RFC, si ya existe entonces acutaliza los datos, de lo contrario es un empleado nuevo

                break;
            case 'deleteUsuario':
                $data = filter_input(INPUT_POST,'datos');
                $txtFhBjaja = filter_input(INPUT_POST,'txtFhBjaja');
//                $fcBaja = date_create_from_format('Y/m/d', $txtFhBjaja);
//                $fcBaja = $fcBaja->format('Y-m-d');


                    $res = $this->empleados_model->deleteEmpleado($data,$txtFhBjaja);
                    if ($res) {
                        exit('OK');
                    } else {
                        $this->cliError('No se pudo eliminar el Empleado');
                    }

                break;
            default : $this->cliError();
        }
    }

} //end class Empleados