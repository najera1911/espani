<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property clsTinyButStrong clsTinyButStrong
 * @property Administrador_model administrador_model
 */

class Administrador extends CI_Controller {

    public function __construct(){
        parent::__construct();
        $this->load->model('administrador_model');

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
        if (!file_exists(VIEWPATH . 'administrador/vw_' . $pagina . '.php')) {
            show_404();
        }

        $this->load->view('administrador/vw_' . $pagina);
    }

    function get($what=''){
        if( !$this->session->userdata('isLoggedIn') ) {
            $this->cliError('Default response');
        }
//        if (!$this->acl->hasPermission('admin_access')){
//            $this->cliError('Default response.');
//        }

        switch($what){
            case 'catPerfil':
                $res = $this->administrador_model->catPerfil();
                exit(json_encode($res));
                break;
            case 'user':
                $data = $this->administrador_model->get_user(array('estatus'=>1,'cat_usuario_id >'=>1));
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
            case 'usuario':
                $txtName = filter_input(INPUT_POST, 'txtName');
                $txtAPaterno = filter_input(INPUT_POST, 'txtAPaterno');
                $txtAMaterno = filter_input(INPUT_POST, 'txtAMaterno');
                $cmbSexo = filter_input(INPUT_POST, 'cmbSexo');
                $txtUser = filter_input(INPUT_POST, 'txtUser');
                $txtPass = filter_input(INPUT_POST, 'txtPass');
                $cmbPerfil = filter_input(INPUT_POST, 'cmbPerfil');

                $idEmpleado = filter_input(INPUT_POST, '_id_', FILTER_VALIDATE_INT);

                if(empty($txtName)){
                    $this->cliError('Campo nombre vacio');
                }
                if(empty($txtAPaterno)){
                    $this->cliError('Campo apellido paterno vacio');
                }
                if(empty($cmbSexo)){
                    $this->cliError('Selecciones sexo');
                }
                if(empty($txtUser)){
                    $this->cliError('Debe de introducir un usuario');
                }
                if(empty($txtPass)){
                    $this->cliError('Debe de introducir una contraseña');
                }
                if(empty($cmbPerfil)){
                    $this->cliError('Selecciones un perfil');
                }

                $data = array(
                    'apellido_p' => $txtAPaterno,
                    'apellido_m' => $txtAMaterno,
                    'nombre' => $txtName,
                    'sexo' => $cmbSexo,
                    'usuario' => $txtUser,
                    'clave' => password_hash($txtPass, PASSWORD_BCRYPT, ['cost' => 11]),
                    'cat_perfil_id' =>$cmbPerfil,
                    'cambia_clave' => 1,
                    'estatus' => true
                );

                if(!empty($idEmpleado)){
                    $res = $this->administrador_model->updateUser($idEmpleado, $data);
                }else{
                    $res = $this->administrador_model->addUser($data);
                }

                if($res){
                    $idEmpleado = (empty($idEmpleado)?$res:$idEmpleado);
                    exit(json_encode(["status" => "Ok", "numEmpleado" => 'SP'.sprintf("%'04d", $idEmpleado)]));

                }else{

                    $this->cliError("Ocurrio un error");
                }

                break;
            case 'deleteUsuario':
                $data = filter_input(INPUT_POST,'datos');
                $res = $this->administrador_model->deleteUser($data);
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