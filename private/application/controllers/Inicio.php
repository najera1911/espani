<?php
    defined('BASEPATH') OR exit('No direct script access allowed');

    /**
     * @property CI_Session session
     * @property Acl acl
     * @property Usuario_model usuario_model
     */
    class Inicio extends CI_Controller
    {

        public function __construct()
        {
            parent::__construct();

            if ($this->session->userdata('isLoggedIn')) {
                $this->acl->setUserId($this->session->userdata('idEmpleado'));
            }
            $this->load->model('usuario_model');
        }


        function cliError($msg = "Bad Request", $num = "0x0")
        {
            set_status_header(500);
            exit($msg . trim(" " . $num ));
        }


        function index($pagina = 'inicio', $data=null){

            if (!file_exists(VIEWPATH . 'inicio/vw_' . $pagina . '.php')) {
                show_404();
            }

            if (!$this->session->userdata('isLoggedIn')) {
                $pagina = 'login';
            }

            $this->load->view('inicio/vw_' . $pagina, $data);

        }

        function iniciar_sesion(){
            if ($this->session->userdata('isLoggedIn')) {
                $this->index('inicio');
                return;
            }

            $usuario = filter_input(INPUT_POST, 'txtUsuario');
            $clave = filter_input(INPUT_POST, 'txtClave');

            if(empty($usuario) || empty($clave)){
                $this->index('login',['error'=>true]);
            }else{

                if($this->usuario_model->validar_usuario($usuario, $clave)){
                    redirect('/');
                }else{
                    $this->index('login',['error'=>true]);
                }

            }

        }

        function cerrar_sesion(){
            $this->session->unset_userdata('isLoggedIn');
            $this->session->sess_destroy();
            redirect('/');
        }

    }
