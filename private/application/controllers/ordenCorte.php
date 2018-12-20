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
                $txtNunOrden = filter_input(INPUT_POST,'txtNunOrdenEspani');
                $txtNunOrdenCliente = filter_input(INPUT_POST,'txtNunOrdenCliente');
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
                    "num_corte_cliente" => $txtNunOrdenCliente
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
            case 'ordenCortePDF':
                $ordenCorte = filter_input(INPUT_GET, 'ordenCorte');


                if (empty($ordenCorte)) {
                    $this->cliError('Faltan datos', '0X001');
                }

                //obtener datos del modelo
                $tadacorte = $this -> ordenCorte_model->getDataCortes($ordenCorte);
                $bultos = $this->ordenCorte_model->getbultos($ordenCorte);
                $operaciones = $this->ordenCorte_model->getOperaciones($ordenCorte);



                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('Muhammad Saqlain Arif');
                $pdf->SetTitle('TCPDF Example 001');
                $pdf->SetSubject('TCPDF Tutorial');
                $pdf->SetKeywords('TCPDF, PDF, example, test, guide');

                // set default header data
                $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE.' 001', PDF_HEADER_STRING, array(0,64,255), array(0,64,128));
                $pdf->setFooterData(array(0,64,0), array(0,64,128));

                // set header and footer fonts
                $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
                $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
                $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
                $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set image scale factor
                $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray($l);
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
                $pdf->setTextShadow(array('enabled'=>true, 'depth_w'=>0.2, 'depth_h'=>0.2, 'color'=>array(196,196,196), 'opacity'=>1, 'blend_mode'=>'Normal'));

                $pdf->SetFont('dejavusans', '', 11);

                $tableDatos = <<<EOD
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="150">Núm. Corte ESPANI</td>
                        <td width="80">{$tadacorte[0]->numero_corte}</td>
                        <td width="80">Cliente</td>
                        <td width="170">{$tadacorte[0]->nombre_corto}</td>
                        <td width="50">Fecha</td>
                        <td width="100">{$tadacorte[0]->fecha_orden}</td>
                    </tr>
                    <tr>
                        <td height="5" colspan="6"></td>
                    </tr>
                    <tr>
                        <td colspan="6" align="center">{$tadacorte[0]->modelo}</td>
                    </tr>
              </table>
EOD;

                $pdf->writeHTML($tableDatos, true, false, true, false, '');

                $pdf->SetFont('dejavusans', '', 9);

                $table = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="background-color:#265170;color:#FFFFFF;">
                        <td align="center" width="100">Núm. Bulto</td>
                        <td align="center" width="100">Talla</td>
                        <td align="center" width="100">Cantidad</td>
                    </tr>
                </thead>
EOD;

                $table2 = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="background-color:#265170;color:#FFFFFF;">
                        <td align="center" width="100">Núm. Bulto</td>
                        <td align="center" width="100">Talla</td>
                        <td align="center" width="100">Cantidad</td>
                    </tr>
                </thead>
EOD;

                $numItems = count($bultos);
                $ni = ceil($numItems/2);
                $total = 0;

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
                            <td width="100">'.$total.'</td></tr>';

                $table .= '</table>';
                $table2 .= '</table>';

                //tabla grande
                $tablefin = <<<EOD
             <table cellspacing="0" cellpadding="2" border="1" style="float:left">
                    <tr>
                        <td align="center" width="320">{$table}</td>
                        <td align="center" width="320">{$table2}</td>
                    </tr>
EOD;


                $pdf->writeHTML($tablefin, true, false, true, false, '');
                //$pdf->writeHTML($table);



                // ---------------------------------------------------------

                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('example_001.pdf', 'I');

            //============================================================+
            // END OF FILE
            //============================================================+

                break;
            default: $this->cliError();
        }
    }


}