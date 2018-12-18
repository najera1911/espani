<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property Nomina_model nomina_model
 */


class Nomina extends CI_Controller{
    public function __construct(){
        parent::__construct();
        $this->load->model('nomina_model');
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
        if (!file_exists(VIEWPATH . 'nomina/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('nomina/vw_' . $pagina);
    }

    function index2($pagina = '',$id){
        if (!file_exists(VIEWPATH . 'nomina/vw_' . $pagina . '.php')) {
            show_404();
        }
        $datos = array(
            'id' => $id,
        );
        $this->load->view('nomina/vw_' . $pagina,$datos);
    }

    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'getEmpleados':
                $res = $this->nomina_model->getEmpleados();
                exit(json_encode($res));
                break;
            case 'dataEmpleado':
                $idEmpleado = filter_input(INPUT_POST,'idEmpleado');
                $res = $this->nomina_model->getEmpleadosData($idEmpleado);
                exit(json_encode($res));
                break;
            case 'getCortes':
                $res = $this->nomina_model->getCortes();
                exit(json_encode($res));
                break;
            case 'getBultos':
                $idCorte = filter_input(INPUT_GET,'idCorte');
                $res = $this->nomina_model->getBultos($idCorte);
                exit(json_encode($res));
                break;
            case 'getOperaciones':
                $idCorte = filter_input(INPUT_GET,'idCorte');
                $idBulto = filter_input(INPUT_GET,'idBulto');
                $res = $this->nomina_model->getOperaciones($idCorte,$idBulto);
                exit(json_encode($res));
                break;
            case 'getReporteDiarios':
                $idEmpleado = filter_input(INPUT_POST,'idEmpleado');
                $ff = filter_input(INPUT_POST,'fecha_f');
                $fi = filter_input(INPUT_POST,'fecha_i');
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                if($fi == ''){
                    $fecha_i = '2018-01-01';
                }else{
                    $fecha_i = date_format((date_create_from_format('Y/m/d', $fi)), 'Y-m-d');
                }
                if($ff == ''){
                    $fecha_f = '2018-01-01';
                }else{
                    $fecha_f = date_format((date_create_from_format('Y/m/d', $ff)), 'Y-m-d');
                }
                // si no hay valor para buscar entonces llama toda la tablas
                $data = $this->nomina_model->get_ReporteDiario($start,$length,$idEmpleado,$fecha_i,$fecha_f);
                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            case 'getReporte':
                $tbl_reportediario_id = filter_input(INPUT_POST,'tbl_reportediario_id');
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                $data = $this->nomina_model->getReporte($tbl_reportediario_id,$start,$length);
                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            default: $this->cliError();
        }
    }

    function set($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'addDatos':
                $cat_rh_empleado_id = filter_input(INPUT_POST,'idEmpleado');
                $fecha_reporte_i = filter_input(INPUT_POST,'txtFchaInicio');
                $fecha_reporte_f = filter_input(INPUT_POST,'txtFchaFin');
                $usuario_caprura_id = $this->session->userdata('idU');
                $tbl_ordencorte_id = filter_input(INPUT_POST,'cmbCorte');
                $tbl_ordencorte_bultos_id = filter_input(INPUT_POST,'cmbBulto');
                $tbl_cordencorte_operaciones_id = filter_input(INPUT_POST,'cmbOper');
                $cantidad = filter_input(INPUT_POST,'txtCantidad');
                $id_reporte = filter_input(INPUT_POST,'id_reporte');

                if($id_reporte==0){
                    $existe = $this->nomina_model->ifExistOper($cat_rh_empleado_id,$fecha_reporte_i,$fecha_reporte_f);

                    if($existe){
                        $this->cliError('Ya existe un reporte entre esas fechas para el Empleado, Verifique');
                    }

                    $data = array(
                        "cat_rh_empleado_id" => $cat_rh_empleado_id,
                        "fecha_reporte_i" => date_format((date_create_from_format('Y/m/d', $fecha_reporte_i)), 'Y-m-d'),
                        "fecha_reporte_f" => date_format((date_create_from_format('Y/m/d', $fecha_reporte_f)), 'Y-m-d'),
                        "usuario_caprura_id" => $usuario_caprura_id,
                    );

                    if($tbl_cordencorte_operaciones_id==99){
                        $r2["resta"] = 0;
                    }else{
                        $restaO = $this->nomina_model->existenciaOp($tbl_cordencorte_operaciones_id);
                        $r2 = (array) $restaO[0];

                        if($cantidad>(int) $r2["resta"]){
                            $this->cliError('La cantidad es mayor que la cantidad del número del Operaciones');
                        }
                    }

                    $res = $this->nomina_model->AddReporte($data,$tbl_ordencorte_id,$tbl_ordencorte_bultos_id,$tbl_cordencorte_operaciones_id,$cantidad,$r2["resta"]);
                    if ($res) {
                        exit(json_encode($res));
                    } else {
                        $this->cliError('No se pudo eliminar el usuario');
                    }
                }else{

                    if($tbl_cordencorte_operaciones_id==99){
                        $r2["resta"] = 0;
                    }else{
                        $restaO = $this->nomina_model->existenciaOp($tbl_cordencorte_operaciones_id);
                        $r2 = (array) $restaO[0];

                        if($cantidad>(int) $r2["resta"]){
                            $this->cliError('La cantidad es mayor que la cantidad del número del Operaciones');
                        }
                    }

                    $res = $this->nomina_model->AddReporte2($id_reporte,$tbl_ordencorte_id,$tbl_ordencorte_bultos_id,$tbl_cordencorte_operaciones_id,$cantidad,$r2["resta"]);
                    if ($res) {
                        exit($id_reporte);
                    } else {
                        $this->cliError('No se pudo eliminar el usuario');
                    }
                }

                break;
            default: $this->cliError();
        }
    }
}