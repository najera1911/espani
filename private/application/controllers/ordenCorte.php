<?php
defined('BASEPATH') OR exit('No direct script access allowed');


/**
 * @property  CI_Session session
 * @property Acl acl
 * @property CI_Loader load
 * @property OrdenCorte_model ordenCorte_model
 */


class OrdenCorte extends CI_Controller{

    public function __construct(){
        parent::__construct();
        $this->load->model('ordenCorte_model');
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
        if (!file_exists(VIEWPATH . 'ordenCorte/vw_' . $pagina . '.php')) {
            show_404();
        }
        $this->load->view('ordenCorte/vw_' . $pagina);
    }

    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'clientes':
                $res = $this->ordenCorte_model->getClientes();
                exit(json_encode($res));
                break;
            case 'modeloCorte':
                $res = $this->ordenCorte_model->getModelosCorte();
                exit(json_encode($res));
                break;
            case 'filtroCorte':
                $res = $this->ordenCorte_model->getFiltroCorte();
                exit(json_encode($res));
                break;
            case 'operac':
                $id = filter_input(INPUT_GET, 'id', FILTER_VALIDATE_INT);
                if(empty($id)){
                    $this->cliError("Seleccione un filtro de corte");
                }
                $res = $this->ordenCorte_model->getOpera($id);
                exit(json_encode($res));
                break;
            case 'getModelos':
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                $idModel = filter_input(INPUT_POST, 'idModel');
                $deleteRow = filter_input(INPUT_POST, 'deleteRow');

                if($deleteRow==0){
                    $this->ordenCorte_model->datosModelosCortesDetalle($idModel);
                    if (empty($datasearch["value"])){
                        $res = $this->ordenCorte_model->datosModelosCortesDetalleLimit($start,$length);
                    }else{  //de lo contrario hace una busqueda tipo like
                        $res = $this->ordenCorte_model->getOperacionSearch($start,$length,$datasearch["value"],$nameColumn[2]["data"]);
                    }

                    $res = array('data'=>$res);
                    exit(json_encode($res));
                }else{
                    if (empty($datasearch["value"])){
                        $res = $this->ordenCorte_model->datosModelosCortesDetalleLimit($start,$length);
                    }else{  //de lo contrario hace una busqueda tipo like
                        $res = $this->ordenCorte_model->getOperacionSearch($start,$length,$datasearch["value"],$nameColumn[2]["data"]);
                    }

                    $res = array('data'=>$res);
                    exit(json_encode($res));
                }


                break;
            default: $this->cliError();
        }
    }

    function set($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'deleteOrden':
                $data = filter_input(INPUT_POST,'datos');
                $res = $this->ordenCorte_model->deleteOperacion($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }
                break;
            case 'addOperacion':
                $data = filter_input(INPUT_POST,'data');
                $cat_modelos_cortes_id = filter_input(INPUT_POST,'cat_modelos_cortes_id');
                $model = filter_input(INPUT_POST,'model');

                if(empty($data)){
                    $this->cliError('Elije una operación');
                }

                $existe = $this->ordenCorte_model->ifExistOper($data);

                if($existe){
                    $this->cliError('La operación ya existe en el modelo');
                }

                $res = $this->ordenCorte_model->AddOperacion($data,$cat_modelos_cortes_id,$model);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }

                break;
            case 'ordencorte':
                $cmbCliente = filter_input(INPUT_POST,'cmbCliente');
                $txtFch = filter_input(INPUT_POST,'txtFch');
                $txtNombreModelo = filter_input(INPUT_POST,'txtNombreModelo');
                $txtTela = filter_input(INPUT_POST,'txtTela');
                $txtNunOrden = filter_input(INPUT_POST,'txtNunOrden');
                $txtMetrosTela = filter_input(INPUT_POST,'txtMetrosTela');
                $txtColores = filter_input(INPUT_POST,'txtColores');
                $txtNumBultos = filter_input(INPUT_POST,'txtNumBultos');

                if(empty($cmbCliente)){
                    $this->cliError('Debe de Seleccionar un Cliente');
                }
                if(empty($txtFch)){
                    $this->cliError('Debe de Seleccionar una Fecha');
                }
                if(empty($txtNombreModelo)){
                    $this->cliError('Debe de Ingresar un nombre de modelo');
                }
                if(empty($txtNunOrden)){
                    $this->cliError('Debe de Ingresar un número de orden');
                }

                $existe = $this->ordenCorte_model->ifExistNumOrden($txtNunOrden);

                if($existe){
                    $this->cliError('El número de corte ya existe, favor de Verificar');
                }

                if(empty($txtNumBultos)){
                    $this->cliError('Debe de ingresar numero de bulto');
                }

                $txtObserv = filter_input(INPUT_POST,'txtObserv');
                $txtPinzasD = filter_input(INPUT_POST,'txtPinzasD');
                $txtPinzasT = filter_input(INPUT_POST,'txtPinzasT');
                $txtBolsasD = filter_input(INPUT_POST,'txtBolsasD');
                $txtBolsasT = filter_input(INPUT_POST,'txtBolsasT');
                $txtTrabas = filter_input(INPUT_POST,'txtTrabas');
                $txtPretina = filter_input(INPUT_POST,'txtPretina');
                $txtCartera = filter_input(INPUT_POST,'txtCartera');
                $txtSecreta = filter_input(INPUT_POST,'txtSecreta');
                $txtBoton = filter_input(INPUT_POST,'txtBoton');
                $txtCierre = filter_input(INPUT_POST,'txtCierre');
                $txtHilo = filter_input(INPUT_POST,'txtHilo');
                $txtEtiqueta = filter_input(INPUT_POST,'txtEtiqueta');
                $cat_usuario_captuta = $this->session->userdata('idU');


                $data = array(
                    "numero_corte" => $txtNunOrden,
                    "cat_clientes_id" => $cmbCliente,
                    "fecha_orden" => date_format((date_create_from_format('d/m/Y', $txtFch)), 'Y-m-d'),
                    "modelo" => $txtNombreModelo,
                    "tela" => $txtTela,
                    "mtros_tela_cortada" => $txtMetrosTela,
                    "colores" => $txtColores,
                    "observaciones" => $txtObserv,
                    "pinzas_delanteras" => $txtPinzasD,
                    "pinzas_traseras" => $txtPinzasT,
                    "bolsas_detanteras" => $txtBolsasD,
                    "bolsas_traseras" => $txtBolsasT,
                    "trabas" => $txtTrabas,
                    "pretina" => $txtPretina,
                    "carteras" => $txtCartera,
                    "secreta" => $txtSecreta,
                    "boton" => $txtBoton,
                    "cierre" => $txtCierre,
                    "hilo" => $txtHilo,
                    "etiqueta" => $txtEtiqueta,
                    "cat_usuario_captura" => $cat_usuario_captuta,
                    "estatus" => true
                );

                $dataBultos = array();
                for ($i=0;$i<$txtNumBultos;$i++){
                    $nb = filter_input(INPUT_POST,'nb'.$i);
                    $tall = filter_input(INPUT_POST,'tall'.$i);
                    $cant = filter_input(INPUT_POST,'cant'.$i);
                    array_push($dataBultos,
                        array("num_bulto"=>$nb,"tallas"=>$tall, "cantidad"=>$cant, "resta"=>$cant)
                    );
                }

                $res = $this->ordenCorte_model->addModeloCorte($data, $dataBultos);

                if ($res) {
                    exit('ok');
                } else {
                    $this->cliError("ocurrio un error");
                }

                break;
            default: $this->cliError();
        }
    }


}