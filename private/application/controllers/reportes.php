<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property Reportes_model reportes_model
 */


class Reportes extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('reportes_model');
        if( $this->session->userdata('isLoggedIn') ) {
            $this->acl->setUserId($this->session->userdata('idU'));
        }
        $this->load->library("Pdf");
    }

    function cliError($msg = "Bad Request", $num = "0x0")//
    {
        set_status_header(500);
        exit($msg . trim(" " . $num ));
    }

    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'reportes/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('reportes/vw_' . $pagina);
    }

    function index2($pagina = '',$id){
        if (!file_exists(VIEWPATH . 'reportes/vw_' . $pagina . '.php')) {
            show_404();
        }
        $datos = array(
            'id' => $id,
        );
        $this->load->view('reportes/vw_' . $pagina,$datos);
    }

    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'reporteOC':
                $idCorte = filter_input(INPUT_POST,'idCorte');
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;

                if (empty($datasearch["value"])){
                    $data = $this->reportes_model->ReporteOC($idCorte,$start,$length);
                }else{  //de lo contrario hace una busqueda tipo like
                    $data = $this->reportes_model->ReporteOCSearch($idCorte,$start,$length,$datasearch["value"],$nameColumn[5]["data"]);
                }

                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            case 'reporteOperacion':
                $idCorte = filter_input(INPUT_POST,'idCorte');
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;

                if (empty($datasearch["value"])){
                    $data = $this->reportes_model->ReporteOperacion($idCorte,$start,$length);
                }else{  //de lo contrario hace una busqueda tipo like
                    $data = $this->reportes_model->ReporteOperacionSearch($idCorte,$start,$length,$datasearch["value"],$nameColumn[4]["data"]);
                }

                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            default: $this->cliError();
        }
    }


}