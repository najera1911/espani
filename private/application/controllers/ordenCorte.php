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
        $this->load->library("Pdf");
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

    function index2($pagina = '',$id){
        if (!file_exists(VIEWPATH . 'ordenCorte/vw_' . $pagina . '.php')) {
            show_404();
        }
        $datos = array(
            'id' => $id,
        );
        $this->load->view('ordenCorte/vw_' . $pagina,$datos);
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
            case 'getModelosEdit':
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                $tbl_ordencorte_id = filter_input(INPUT_POST, 'tbl_ordencorte_id');

                if (empty($datasearch["value"])){
                    $res = $this->ordenCorte_model->datosModelosCortesDetalleEditLimit($start,$length,$tbl_ordencorte_id);
                }else{  //de lo contrario hace una busqueda tipo like
                    $res = $this->ordenCorte_model->getOperacionEditSearch($start,$length,$datasearch["value"],$nameColumn[2]["data"],$tbl_ordencorte_id);
                }

                $res = array('data'=>$res);
                exit(json_encode($res));

                break;
            case 'ordenesCorteView':
                $datasearch = $_POST['search']; //obtiene el valor para buscar
                $nameColumn = $_POST['columns']; //obtiene el nombre de las columnas
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                // si no hay valor para buscar entonces llama toda la tablas
                if (empty($datasearch["value"])){
                    $data = $this->ordenCorte_model->get_OrdenesCorteView($start,$length);
                }else{  //de lo contrario hace una busqueda tipo like
                    $data = $this->ordenCorte_model->get_OrdenesCorteViewSearch($datasearch["value"]);
                }

                $data = array('data'=>$data);
                exit(json_encode($data));
                break;
            case 'validaEdit':
                $data = filter_input(INPUT_POST,'id');
                $res = $this->ordenCorte_model->validaEdit($data);
                if ($res) {
                    exit('OK');
                } else {
                    exit('notOK');
                }
                break;
            case 'dataOrden':
                $idOrden = filter_input(INPUT_POST,'idOrden');
                $res = $this->ordenCorte_model->getOrdenData($idOrden);
                exit(json_encode($res));
                break;
            case 'dataOrdenBultos':
                $idOrden = filter_input(INPUT_POST,'idOrden');
                $res = $this->ordenCorte_model->getOrdenBultosData($idOrden);
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
            case 'deleteOrden':
                $data = filter_input(INPUT_POST,'datos');
                $res = $this->ordenCorte_model->deleteOperacion($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }
                break;
            case 'deleteOrdenOperacionEdit':
                $data = filter_input(INPUT_POST,'datos');
                $tbl_ordencorte_id = filter_input(INPUT_POST,'tbl_ordencorte_id');
                $res = $this->ordenCorte_model->deleteOperacionEdit($data,$tbl_ordencorte_id);
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
            case 'addOperacionEdit':
                $data = filter_input(INPUT_POST,'data');
                $tbl_ordencorte_id = filter_input(INPUT_POST,'tbl_ordencorte_id');
                $idBultos = $this->ordenCorte_model->getIdBultos($tbl_ordencorte_id);

                //var_dump($idBultos[0]->tbl_OrdenCorte_bultos_id);

                if(empty($data)){
                    $this->cliError('Elije una operación');
                }

                $existe = $this->ordenCorte_model->ifExistOperEdit($data,$tbl_ordencorte_id);

                if($existe){
                    $this->cliError('La operación ya existe en el modelo');
                }

                $res = $this->ordenCorte_model->AddOperacionEdit($data,$tbl_ordencorte_id,$idBultos);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('Error');
                }

                break;
            case 'ordencorte':
                $cmbCliente = filter_input(INPUT_POST,'cmbCliente');
                $txtFch = filter_input(INPUT_POST,'txtFch');
                $txtNombreModelo = filter_input(INPUT_POST,'txtNombreModelo');
                $txtTela = filter_input(INPUT_POST,'txtTela');
                $txtNunO = filter_input(INPUT_POST,'txtNunOrdenEspani');
                $txtNunOrdenC = filter_input(INPUT_POST,'txtNunOrdenCliente');
                $txtNunOrden = trim($txtNunO);
                $txtNunOrdenCliente = trim($txtNunOrdenC);
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
                    $this->cliError('Debe de Ingresar un número de orden de ESPANI');
                }
                if(empty($txtNunOrdenCliente)){
                    $this->cliError('Debe de Ingresar un número de orden del CLiente');
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
                $txtTaqueda = filter_input(INPUT_POST,'txtTaqueda');
                $txtPase = filter_input(INPUT_POST,'txtPase');
                $txtLargo = filter_input(INPUT_POST,'txtLargo');
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
                    "estatus" => true,
                    "num_corte_cliente" => $txtNunOrdenCliente,
                    "taqueda" => $txtTaqueda,
                    "pase" => $txtPase,
                    "largo" => $txtLargo,
                    "validado" => false
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
            case 'ordencorteEdit':
                $idOrden = filter_input(INPUT_POST,'idOrden');
                $cmbCliente = filter_input(INPUT_POST,'cmbCliente');
                $txtFch = filter_input(INPUT_POST,'txtFch');
                $txtNombreModelo = filter_input(INPUT_POST,'txtNombreModelo');
                $txtTela = filter_input(INPUT_POST,'txtTela');
                $txtNunO = filter_input(INPUT_POST,'txtNunOrdenEspani');
                $txtNunOrdenC = filter_input(INPUT_POST,'txtNunOrdenCliente');
                $txtNunOrden = trim($txtNunO);
                $txtNunOrdenCliente = trim($txtNunOrdenC);
                $txtMetrosTela = filter_input(INPUT_POST,'txtMetrosTela');
                $txtColores = filter_input(INPUT_POST,'txtColores');
                $txtNumBultos = filter_input(INPUT_POST,'txtNumBultos');

                if(empty($idOrden)){
                    $this->cliError('Debe de selecionar una orden de corte');
                }

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
                    $this->cliError('Debe de Ingresar un número de orden de ESPANI');
                }
                if(empty($txtNunOrdenCliente)){
                    $this->cliError('Debe de Ingresar un número de orden del CLiente');
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
                $txtTaqueda = filter_input(INPUT_POST,'txtTaqueda');
                $txtPase = filter_input(INPUT_POST,'txtPase');
                $txtLargo = filter_input(INPUT_POST,'txtLargo');
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
                    "estatus" => true,
                    "num_corte_cliente" => $txtNunOrdenCliente,
                    "taqueda" => $txtTaqueda,
                    "pase" => $txtPase,
                    "largo" => $txtLargo,
                    "validado" => false
                );

                $idBultos = $this->ordenCorte_model->getIdBultos($idOrden);

                $n = count($idBultos);

                $dataBultos = array();
                for ($i=0;$i<$n;$i++){
                    $nb = filter_input(INPUT_POST,'nb'.$i);
                    $tall = filter_input(INPUT_POST,'tall'.$i);
                    $cant = filter_input(INPUT_POST,'cant'.$i);
                    array_push($dataBultos,
                        array("num_bulto"=>$nb,"tallas"=>$tall, "cantidad"=>$cant, "resta"=>$cant)
                    );
                }

                $res = $this->ordenCorte_model->EditModeloCorte($data, $dataBultos, $idOrden, $idBultos);

                if ($res) {
                    exit('ok');
                } else {
                    $this->cliError("ocurrio un error");
                }

                break;
            case 'validarOrdenCorte':
                $data = filter_input(INPUT_POST,'datos');
                $res = $this->ordenCorte_model->validarOrdenCorte($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }
                break;
            case 'deleteOrdenCorte':
                $data = filter_input(INPUT_POST,'datos');

                $res = $this->ordenCorte_model->validaEdit($data);
                if ($res) {
                    $this->cliError('No se pudo eliminar la orden de corte, ya tiene generados pagos');
                }

                $res = $this->ordenCorte_model->deleteOrdenCorte($data);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }

                break;
            case 'ordenCortePDF':
                $ordenCorte = filter_input(INPUT_GET, 'ordenCorte');


                if (empty($ordenCorte)) {
                    $this->cliError('Faltan datos', '0X001');
                }

                //obtener datos del modelo
                $tadacorte = $this -> ordenCorte_model->getDataCortes($ordenCorte);
                $bultos = $this->ordenCorte_model->getbultos($ordenCorte);
                $operaciones = $this->ordenCorte_model->getOperaciones($ordenCorte);

                setlocale(LC_TIME, 'spanish');
                $inicio = strftime("%d de %B del %Y", strtotime($tadacorte[0]->fecha_orden));

                $PDF_HEADER_TITLE="Titulo del PDF";



                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('ESPANI S.A de C.V');
                $pdf->SetTitle('MAQUILADORA ESPANI S.A. DE C.V.');

                $PDF_HEADER_STRING="";



                // set default header data
                $pdf->SetHeaderData(PDF_HEADER_LOGO, 10, 'MAQUILADORA ESPANI S.A. DE C.V.', $PDF_HEADER_STRING, array(0,0,0), array(0,0,0));
                $pdf->setFooterData(array(0,0,0), array(0,0,0));

                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(5);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray();
                }

                // ---------------------------------------------------------

                // set default font subsetting mode
                $pdf->setFontSubsetting(true);

                // Set font
                // dejavusans is a UTF-8 Unicode font, if you only need to
                // print standard ASCII chars, you can use core fonts like
                // helvetica or times to reduce file size.
                $pdf->SetFont('dejavusans', '', 14, '', true);

                // Add a page
                // This method has several options, check the source code documentation for more information.
                $pdf->AddPage();

                // set text shadow effect
                $pdf->SetFont('dejavusans', '', 10);

                $tableDatos = <<<EOD
                <style>
                td.bold{
    font-weight: bold;
    }
</style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="100" class="bold">Núm. Corte</td>
                        <td width="70">{$tadacorte[0]->numero_corte}</td>
                        <td width="70" class="bold">Cliente</td>
                        <td width="150">{$tadacorte[0]->nombre_corto}</td>
                        <td width="50" class="bold">Fecha</td>
                        <td width="200">{$inicio}</td>
                    </tr>
                    <tr>
                        <td height="5" colspan="6"></td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center" class="bold">{$tadacorte[0]->modelo}</td>
                    </tr>
              </table>
EOD;

                $pdf->writeHTML($tableDatos, true, false, true, false, '');

                $pdf->SetFont('dejavusans', '', 9);

                $numItems = count($bultos);

                $total = 0;

                if($numItems>=25){
                    $ni = ceil($numItems/3);
                    $ni2 = $ni + $ni;

                    $table = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="66">Núm. Bulto</td>
                        <td align="center" width="66">Talla</td>
                        <td align="center" width="66">Cantidad</td>
                    </tr>
                </thead>
EOD;

                    $table2 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="66">Núm. Bulto</td>
                        <td align="center" width="66">Talla</td>
                        <td align="center" width="66">Cantidad</td>
                    </tr>
                </thead>
EOD;

                    $table3 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="66">Núm. Bulto</td>
                        <td align="center" width="66">Talla</td>
                        <td align="center" width="66">Cantidad</td>
                    </tr>
                </thead>
EOD;

                    for($i=0;$i<$ni;$i++){
                        $table .= '
                        <tr>
                            <td width="66" align="center">'.$bultos[$i]->num_bulto.'</td>
                            <td width="66" align="center">'.$bultos[$i]->tallas.'</td>
                            <td width="66" align="center">'.$bultos[$i]->cantidad.'</td>
                        </tr>
                    ';
                        $total = $total + $bultos[$i]->cantidad;
                    }

                    for($j=$ni;$j<$ni2;$j++){
                        $table2 .= '
                        <tr>
                            <td width="66" align="center">'.$bultos[$j]->num_bulto.'</td>
                            <td width="66" align="center">'.$bultos[$j]->tallas.'</td>
                            <td width="66" align="center">'.$bultos[$j]->cantidad.'</td>
                        </tr>
                    ';
                        $total = $total + $bultos[$j]->cantidad;
                    }

                    for($k=$ni2;$k<$numItems;$k++){
                        $table3 .= '
                        <tr>
                            <td width="66" align="center">'.$bultos[$k]->num_bulto.'</td>
                            <td width="66" align="center">'.$bultos[$k]->tallas.'</td>
                            <td width="66" align="center">'.$bultos[$k]->cantidad.'</td>
                        </tr>
                    ';
                        $total = $total + $bultos[$k]->cantidad;
                    }

                    $table3 .= '<tr style="background-color:#d5d0d1;color:#000000;"><td  width="132" align="right">TOTAL:</td>
                            <td width="66" style="font-weight: bold">'.$total.'</td></tr>';

                    $table .= '</table>';
                    $table2 .= '</table>';
                    $table3 .= '</table>';

                    //tabla grande
                    $tablefin = <<<EOD
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td align="center" width="213">{$table}</td>
                        <td align="center" width="213">{$table2}</td>
                        <td align="center" width="213">{$table3}</td>
                    </tr>
             </table>
EOD;

                    //imprime numero de bultos
                    $pdf->writeHTML($tablefin, true, false, true, false, '');


                }else{
                    $ni = ceil($numItems/2);

                    $table = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="100">Núm. Bulto</td>
                        <td align="center" width="100">Talla</td>
                        <td align="center" width="100">Cantidad</td>
                    </tr>
                </thead>
EOD;

                    $table2 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="100">Núm. Bulto</td>
                        <td align="center" width="100">Talla</td>
                        <td align="center" width="100">Cantidad</td>
                    </tr>
                </thead>
EOD;

                    for($i=0;$i<$ni;$i++){
                        $table .= '
                        <tr>
                            <td width="100" align="center">'.$bultos[$i]->num_bulto.'</td>
                            <td width="100" align="center">'.$bultos[$i]->tallas.'</td>
                            <td width="100" align="center">'.$bultos[$i]->cantidad.'</td>
                        </tr>
                    ';
                        $total = $total + $bultos[$i]->cantidad;
                    }

                    for($j=$ni;$j<$numItems;$j++){
                        $table2 .= '
                        <tr>
                            <td width="100" align="center">'.$bultos[$j]->num_bulto.'</td>
                            <td width="100" align="center">'.$bultos[$j]->tallas.'</td>
                            <td width="100" align="center">'.$bultos[$j]->cantidad.'</td>
                        </tr>
                    ';
                        $total = $total + $bultos[$j]->cantidad;
                    }

                    $table2 .= '<tr style="background-color:#d5d0d1;color:#000000;"><td  width="200" align="right">TOTAL:</td>
                            <td width="100" style="font-weight: bold">'.$total.'</td></tr>';

                    $table .= '</table>';
                    $table2 .= '</table>';

                    //tabla grande
                    $tablefin = <<<EOD
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td align="center" width="320">{$table}</td>
                        <td align="center" width="320">{$table2}</td>
                    </tr>
             </table>
EOD;

                    //imprime numero de bultos
                    $pdf->writeHTML($tablefin, true, false, true, false, '');

                } // end else


                //$pdf->writeHTML($table);

            //gereneral las tablas de operaciones

                $tableOp1 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
EOD;

                $tableOp2 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
EOD;

                $numItemsOp = count($operaciones);
                $ant=0; $new=0;

                for($x=0;$x<$numItemsOp;$x++){
                    $new = (int)$operaciones[$x]->cat_tipo_corte_id;

                    if((int)$operaciones[$x]->cat_tipo_corte_id <= 3 || (int)$operaciones[$x]->cat_tipo_corte_id==6){
                        if($new!=$ant ){
                            $tableOp1 .= '
                        <tr>
                            <td style="font-weight: bold" width="310" align="center" colspan="2">'.$operaciones[$x]->tipo_corte.'</td>
                        </tr>
                    ';
                            $ant=$new;
                        }

                        $tableOp1 .= '
                        <tr>
                            <td width="50" align="center">'.$operaciones[$x]->operacion.'</td>
                            <td width="260" align="left">'.$operaciones[$x]->descripcion.'</td>
                        </tr>
                    ';
                    }else{

                        if($new!=$ant ){
                            $tableOp2 .= '
                        <tr>
                            <td style="font-weight: bold" width="310" align="center" colspan="2">'.$operaciones[$x]->tipo_corte.'</td>
                        </tr>
                    ';
                            $ant=$new;
                        }

                        $tableOp2 .= '
                        <tr>
                            <td width="50" align="center">'.$operaciones[$x]->operacion.'</td>
                            <td width="260" align="left">'.$operaciones[$x]->descripcion.'</td>
                        </tr>
                    ';
                    }

                }

                $tableOp1 .= '</table>';
                $tableOp2 .= '</table>';

                //tabla grande
                $tableOperaciones = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1" style="float:left">
                    <tr>
                        <td align="center" width="320">{$tableOp1}</td>
                        <td align="center" width="320">{$tableOp2}</td>
                    </tr>
EOD;

                $pdf->writeHTML($tableOperaciones, true, false, true, false, '');

                // Se agrega la pagina numero dos Todos los datos de la orden de corte
                $pdf->AddPage();
                //var_dump($tadacorte);

                $pdf->SetFont('dejavusans', '', 9);

                $tableDatos2 = <<<EOD
                <style>                
    td {
        height: 30px;
    }
    
    td.bold{
    font-weight: bold;
    }
                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="150" class="bold">NOMBRE DEL CLIENTE:</td>
                        <td width="250">{$tadacorte[0]->nombre_corto}</td>
                        <td width="80" class="bold">FECHA:</td>
                        <td width="150">{$inicio}</td>
                    </tr>
                    <tr>
                        <td width="100" class="bold">MODELO:</td>
                        <td width="215">{$tadacorte[0]->modelo}</td>
                        <td width="100" class="bold">TELA:</td>
                        <td width="215">{$tadacorte[0]->tela}</td>
                    </tr>
                    <tr>
                        <td width="200" class="bold">ORDEN DE CORTE CLIENTE:</td>
                        <td width="115">{$tadacorte[0]->num_corte_cliente}</td>
                        <td width="200" class="bold">METROS DE TELA CORTADA:</td>
                        <td width="115">{$tadacorte[0]->mtros_tela_cortada}</td>
                    </tr>
              </table>
EOD;

                $pdf->writeHTML($tableDatos2, true, false, true, false, '');
                $pdf->Ln(5);
                //imprime numero de bultos
                $pdf->writeHTML($tablefin, true, false, true, false, '');

                $tableDatos3 = <<<EOD
                <style>                
    td {
        height: 30px;
    }
    
    td.two{
    height: 50px;
    }
    
    td.bold{
    font-weight: bold;
    }
                </style>
             <table cellspacing="0" cellpadding="2" border="1">
                    <tr>
                        <td width="315" class="bold" align="center">COLORES:</td>
                        <td width="315" class="bold" align="center">OBSERVACIONES:</td>
                    </tr>
                    <tr>
                        <td width="315" class="two">{$tadacorte[0]->colores}</td>
                        <td width="315" class="two">{$tadacorte[0]->observaciones}</td>
                    </tr>
              </table>
EOD;

                $pdf->writeHTML($tableDatos3, true, false, true, false, '');

                // ---------------------------------------------------------

                $tableDatos4 = <<<EOD
                <style>                
    td {
        height: 20px;
        border-bottom: 1px solid #494949;
        text-align: center;
    }
    
    td.bold{
    font-weight: bold;
    border-bottom: none;
    text-align: left;
    }
                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="150" class="bold" >PINZAS DELANTERAS:</td>
                        <td width="480">{$tadacorte[0]->pinzas_delanteras}</td>
                    </tr>
                    <tr>
                        <td width="150" class="bold" >PINZAS TRASERAS:</td>
                        <td width="480">{$tadacorte[0]->pinzas_traseras}</td>                        
                    </tr>
                    <tr>
                        <td width="150" class="bold" >BOLSAS DELANTERAS:</td>
                        <td width="480">{$tadacorte[0]->bolsas_detanteras}</td>
                    </tr>
                    <tr>
                        <td width="150" class="bold" >BOLSAS TRASERAS:</td>
                        <td width="480">{$tadacorte[0]->bolsas_traseras}</td>                        
                    </tr>
                    <tr>
                        <td width="80" class="bold" >TRABAS:</td>
                        <td width="235">{$tadacorte[0]->trabas}</td>  
                        <td width="82" class="bold" >PRETINA:</td>
                        <td width="235">{$tadacorte[0]->pretina}</td>                       
                    </tr>
                    <tr>
                        <td width="80" class="bold" >CARTERAS:</td>
                        <td width="235">{$tadacorte[0]->carteras}</td>  
                        <td width="80" class="bold" >SECRETA:</td>
                        <td width="235">{$tadacorte[0]->secreta}</td>                       
                    </tr>
                    <tr>
                        <td width="80" class="bold" >TAQUEDA:</td>
                        <td width="235">{$tadacorte[0]->taqueda}</td>  
                        <td width="80" class="bold" >PASE:</td>
                        <td width="235">{$tadacorte[0]->pase}</td>                       
                    </tr>
                    <tr>
                        <td width="80" class="bold" >LARGO:</td>
                        <td width="235">{$tadacorte[0]->largo}</td>                        
                    </tr>
              </table>
EOD;

                $pdf->writeHTML($tableDatos4, true, false, true, false, '');

                $tableDatos5 = <<<EOD
                <style>   
                table{
                border: 1px solid #000000;
                }    
                         
    td {
        height: 50px;
        border-right: 1px solid #000000;
        text-align: center;
    }
    
    td.bold{
    height: 30px;
    font-weight: bold;
    border-bottom: none;
    text-align: center;
    }
                </style>
             <table cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="210" class="bold" >TELA:</td>
                        <td width="210" class="bold" >BOTÓN:</td>
                        <td width="210" class="bold" >CIERRE:</td>
                    </tr>
                    <tr>
                        <td width="210">{$tadacorte[0]->tela}</td>
                        <td width="210">{$tadacorte[0]->boton}</td> 
                        <td width="210">{$tadacorte[0]->cierre}</td>                       
                    </tr>                   
              </table>
<br><br>
<table cellspacing="0" cellpadding="2">
                    <tr>
                        <td width="210" class="bold" >HILO:</td>
                        <td width="210" class="bold" >ETIQUETA:</td>
                        <td width="210" class="bold" >NÚMERO DE CORTE:</td>
                    </tr>
                    <tr>
                        <td width="210">{$tadacorte[0]->hilo}</td>
                        <td width="210">{$tadacorte[0]->etiqueta}</td> 
                        <td width="210" style="font-weight: bold;font-size: 20px">{$tadacorte[0]->numero_corte}</td>                       
                    </tr>                   
              </table>

EOD;

                $pdf->writeHTML($tableDatos5, true, false, true, false, '');

                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('OrdenCorte_Num'.$ordenCorte.'.pdf', 'I');

            //============================================================+
            // END OF FILE
            //============================================================+

                break;
            default: $this->cliError();
        }
    }


}