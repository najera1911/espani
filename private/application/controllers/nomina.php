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
        $this->load->library("Pdf");
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

    function index3($pagina = '',$id,$id2){
        if (!file_exists(VIEWPATH . 'nomina/vw_' . $pagina . '.php')) {
            show_404();
        }
        $datos = array(
            'id' => $id,
            'id2' =>$id2
        );
        $this->load->view('nomina/vw_' . $pagina,$datos);
    }

    function get($data=''){
        if(!$this->session->userdata('isLoggedIn')){
            $this->cliError('Default response');
        }
        switch($data){
            case 'getEmpleados':
                $idPiso = filter_input(INPUT_GET,'idPiso');
                $res = $this->nomina_model->getEmpleados($idPiso);
                exit(json_encode($res));
                break;
            case 'getPiso':
                $res = $this->nomina_model->getPiso();
                exit(json_encode($res));
                break;
            case 'dataEmpleado':
                $idEmpleado = filter_input(INPUT_POST,'idEmpleado');
                $res = $this->nomina_model->getEmpleadosData($idEmpleado);
                exit(json_encode($res));
                break;
            case 'dataReporteProd':
                $idReporte = filter_input(INPUT_POST,'idReporte');
                $res = $this->nomina_model->getDataReporteProd($idReporte);
                exit(json_encode($res));
                break;
            case 'getCortes':
                $res = $this->nomina_model->getCortes();
                exit(json_encode($res));
                break;
            case 'getBultos':
                $idCorte = filter_input(INPUT_GET,'idCorte');
                $idOper = filter_input(INPUT_GET,'idOper');
                $res = $this->nomina_model->getBultos($idCorte,$idOper);
                exit(json_encode($res));
                break;
            case 'getOperaciones':
                $idCorte = filter_input(INPUT_GET,'idCorte');
                $res = $this->nomina_model->getOperaciones($idCorte);
                exit(json_encode($res));
                break;
            case 'getReporteDiarios':
                $idEmpleado = filter_input(INPUT_POST,'idEmpleado');
                //$ff = filter_input(INPUT_POST,'fecha_f');
                $fi = filter_input(INPUT_POST,'fecha_i');
                $start = $_POST['start']; //valor de inicio para el limit
                $length = $_POST['length'] ;
                if($fi==""){
                    $fecha_i = '';
                }else{
                    $fecha_i = date_format((date_create_from_format('Y/m/d', $fi)), 'Y-m-d');
                }

                // si no hay valor para buscar entonces llama toda la tablas
                $data = $this->nomina_model->get_ReporteDiario($start,$length,$idEmpleado,$fecha_i);
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
            case 'dataRecibo':
                $idReporte = filter_input(INPUT_POST,'datos');
                $res = $this->nomina_model->getDataRecibo($idReporte);
                exit(json_encode($res));
                break;
            case 'horasExtras':
                $id = filter_input(INPUT_POST,'id');
                $res = $this->nomina_model->getHorasExtras($id);
                exit(json_encode($res));
                break;
            case 'getTTBultos':

                $b=0;
                if(isset($_POST['cmbBulto'])){
                    $tbl_ordencorte_bultos_id = $_POST['cmbBulto'];
                    $b=0;
                }else{
                    $tbl_ordencorte_bultos_id[0] = 0;
                    $b = 1;
                }

                if($b==0){
                    $restaO = $this->nomina_model->existenciaOp($tbl_ordencorte_bultos_id);
                    $r2 = (array) $restaO[0];
                    $rn222 = $r2["resta"];
                }else{
                    $rn222 = 0;
                }



                exit($rn222);

                break;
            case 'getFecha':
                $res = $this->nomina_model->getFecha();
                exit(json_encode($res));
                break;
            case 'getPisoF':
                $fecha = filter_input(INPUT_GET,'fecha');
                $res = $this->nomina_model->getPisoF($fecha);
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
            case 'addDatos':
                $cat_rh_empleado_id = filter_input(INPUT_POST,'idEmpleado');
                $fecha_reporte_i = filter_input(INPUT_POST,'txtFchaInicio');
                //$fecha_reporte_f = filter_input(INPUT_POST,'txtFchaFin');
                $usuario_caprura_id = $this->session->userdata('idU');
                $tbl_ordencorte_id = filter_input(INPUT_POST,'cmbCorte');
                if(isset($_POST['cmbBulto'])){
                    $tbl_ordencorte_bultos_id = $_POST['cmbBulto'];
                }else{
                    $tbl_ordencorte_bultos_id[0] = 0;
                }
                //$tbl_ordencorte_bultos_id = filter_input(INPUT_POST,'cmbBulto');
                $tbl_cordencorte_operaciones_id = filter_input(INPUT_POST,'cmbOper');
                $cantidad = filter_input(INPUT_POST,'txtCantidad');
                $id_reporte = filter_input(INPUT_POST,'id_reporte');


                if (empty($fecha_reporte_i)) {
                    $this->cliError('Debe seleccionar fecha inicial');
                }
                if (empty($tbl_ordencorte_id)) {
                    $this->cliError('Debe seleccionar orden de corte');
                }
                if($tbl_cordencorte_operaciones_id>0 and empty($tbl_ordencorte_bultos_id)){
                    $this->cliError('Debe seleccionar núm bulto');
                }

                if (is_null($tbl_cordencorte_operaciones_id)) {
                    $this->cliError('Debe seleccionar operación');
                }

                if (empty($cantidad)) {
                    $this->cliError('Debe ingresar cantidad');
                }

                $nnewResta = 0;
                if($id_reporte==0){

                    $rn222 = 0;
                    $existe = $this->nomina_model->ifExistOper($cat_rh_empleado_id,$fecha_reporte_i);

                    if($existe){
                        $this->cliError('Ya existe un reporte en esa fecha para el Empleado, Verifique');
                    }

                    $data = array(
                        "cat_rh_empleado_id" => $cat_rh_empleado_id,
                        "fecha_reporte_i" => date_format((date_create_from_format('Y/m/d', $fecha_reporte_i)), 'Y-m-d'),
                        "usuario_caprura_id" => $usuario_caprura_id
                    );

                    if((int) $tbl_cordencorte_operaciones_id==0){
                        $existeS01 = $this->nomina_model->ifExistS01($id_reporte);

                        if($existeS01){
                            $this->cliError('Ya existe la orden S01-SABADO  ');
                        }
                    }else{
                        $restaO = $this->nomina_model->existenciaOp($tbl_ordencorte_bultos_id);
                        $r2 = (array) $restaO[0];
                        $rn222 = $r2["resta"];
                    }


                    $data2 = array();
                    $n = count($tbl_ordencorte_bultos_id);

                    if($n>1){
                        if($cantidad>(int) $rn222){
                            $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$r2["resta"].' ');
                        }
                        if($cantidad<(int) $rn222){
                            $this->cliError('La cantidad es menor que la cantidad del total de todos los bultos: '.$r2["resta"].' ');
                        }
                    }else{
                        if((int) $tbl_cordencorte_operaciones_id!=0){
                            if($cantidad>(int) $rn222){
                                $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$rn222.' ');
                            }
                        }
                    }

                    $lastID = $this->nomina_model->AddReporte($data);
                    if ($lastID) {
                        if($n>1){
                            if($cantidad>(int) $rn222){
                                $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$r2["resta"].' ');
                            }
                            if($cantidad<(int) $rn222){
                                $this->cliError('La cantidad es menor que la cantidad del total de todos los bultos: '.$r2["resta"].' ');
                            }

                            for($i=0;$i<$n;$i++){
                                if((int)$tbl_ordencorte_bultos_id[$i]==0){
                                    $cant = $cantidad;
                                }else{
                                    $cantidadB = $this->nomina_model->existenciaBulto($tbl_ordencorte_bultos_id[$i]);
                                    $r22 = (array) $cantidadB[0];
                                    $cant = (int) $r22["resta"];
                                }
                                $data22 = array(
                                    "tbl_reportediario_id" => $lastID,
                                    "tbl_ordencorte_id" => $tbl_ordencorte_id,
                                    "tbl_ordencorte_bultos_id" => 0,
                                    "tbl_cordencorte_operaciones_id" => $tbl_ordencorte_bultos_id[$i],
                                    "cantidad" => $cant
                                );
                                array_push($data2,$data22);
                            }

                        }else{
                            if((int) $tbl_cordencorte_operaciones_id!=0){
                                if($cantidad>(int) $rn222){
                                    $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$rn222.' ');
                                }
                            }

                            $nnewResta = $rn222 - $cantidad;

                            for($i=0;$i<$n;$i++){
                                $cant = $cantidad;
                                $data22 = array(
                                    "tbl_reportediario_id" => $lastID,
                                    "tbl_ordencorte_id" => $tbl_ordencorte_id,
                                    "tbl_ordencorte_bultos_id" => 0,
                                    "tbl_cordencorte_operaciones_id" => $tbl_ordencorte_bultos_id[$i],
                                    "cantidad" => $cant
                                );
                                array_push($data2,$data22);
                            }

                        }
                        $res2 = $this->nomina_model->AddReporte2($lastID,$data2,$n,$tbl_ordencorte_bultos_id,$nnewResta);

                        echo $lastID;
                        exit($lastID);

                    } else {
                        $this->cliError('error');
                    }
                }else{

                    $r222 = 0;
                    $newResta = 0;

                    if((int) $tbl_cordencorte_operaciones_id==0){
                        $existeS01 = $this->nomina_model->ifExistS01($id_reporte);

                        if($existeS01){
                            $this->cliError('Ya existe la orden S01-SABADO  ');
                        }
                    }else{
                        $restaO = $this->nomina_model->existenciaOp($tbl_ordencorte_bultos_id);
                        $r2 = (array) $restaO[0];
                        $r222 = $r2["resta"];
                    }

                    $data2 = array();
                    $n = count($tbl_ordencorte_bultos_id);
                    if($n>1){
                        if($cantidad>(int) $r222){
                            $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$r222.' ');
                        }
                        if($cantidad<(int) $r222){
                            $this->cliError('La cantidad es menor que la cantidad del total de todos los bultos: '.$r222.' ');
                        }

                        for($i=0;$i<$n;$i++){
                            if((int)$tbl_ordencorte_bultos_id[$i]==0){
                                $cant = $cantidad;
                            }else{
                                $cantidadB = $this->nomina_model->existenciaBulto($tbl_ordencorte_bultos_id[$i]);
                                $r22 = (array) $cantidadB[0];
                                $cant = (int) $r22["resta"];
                            }
                            $data22 = array(
                                "tbl_reportediario_id" => $id_reporte,
                                "tbl_ordencorte_id" => $tbl_ordencorte_id,
                                "tbl_ordencorte_bultos_id" => 0,
                                "tbl_cordencorte_operaciones_id" => $tbl_ordencorte_bultos_id[$i],
                                "cantidad" => $cant
                            );
                            array_push($data2,$data22);
                        }

                    }else{

                        if((int) $tbl_cordencorte_operaciones_id!=0){
                            if($cantidad>(int) $r222){
                                $this->cliError('La cantidad es mayor que la cantidad del total de todos los bultos: '.$r222.' ');
                            }
                        }

                        $newResta = $r222 - $cantidad;

                        for($i=0;$i<$n;$i++){
                            $cant = $cantidad;
                            $data22 = array(
                                "tbl_reportediario_id" => $id_reporte,
                                "tbl_ordencorte_id" => $tbl_ordencorte_id,
                                "tbl_ordencorte_bultos_id" => 0,
                                "tbl_cordencorte_operaciones_id" => $tbl_ordencorte_bultos_id[$i],
                                "cantidad" => $cant
                            );
                            array_push($data2,$data22);
                        }

                    }

                    $res = $this->nomina_model->AddReporte2($id_reporte,$data2,$n,$tbl_ordencorte_bultos_id,$newResta);
                    if ($res) {
                        exit($id_reporte);
                    } else {
                        $this->cliError('No se pudo eliminar el usuario');
                    }
                }

                break;
            case 'deleteOperacion':
                $data = $_POST['datos']; //obtiene el nombre de las columnas
                $idReporteDetalle = $data["tbl_reportediario_detalle_id"];
                $cantidad = $data["cantidad"];
                $idOperacion = $data["tbl_cordencorte_operaciones_id"];
                $idBulto = $data["tbl_ordencorte_bultos_id"];


                if($idOperacion>0){
                    $restaO = $this->nomina_model->existenciaOp($idOperacion);
                    $r2 = (array) $restaO[0];
                }else{
                    $r2["resta"] = 0;
                }


                $sum = $cantidad + $r2["resta"];

                $res = $this->nomina_model->deleteOperacion($idReporteDetalle,$idOperacion,$sum);
                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar el usuario');
                }

                break;
            case 'deleteOperacionesGroup':
                if(isset($_POST['data'])){
                    $data = $_POST['data'];
                }else{
                    $this->cliError('Debe de seleccionar una operación ');
                }

                $n = count($data);

                for($i=0;$i<$n;$i++){
                    $idReporteDetalle = $data[$i]["tbl_reportediario_detalle_id"];
                    $cantidad = $data[$i]["cantidad"];
                    $idOperacion = $data[$i]["tbl_cordencorte_operaciones_id"];


                    if($idOperacion>0){
                        $restaO = $this->nomina_model->existenciaOp($idOperacion);
                        $r2 = (array) $restaO[0];
                    }else{
                        $r2["resta"] = 0;
                    }


                    $sum = $cantidad + $r2["resta"];

                    $res = $this->nomina_model->deleteOperacion($idReporteDetalle,$idOperacion,$sum);
                }

                if ($res) {
                    exit('OK');
                } else {
                    $this->cliError('No se pudo eliminar');
                }

                break;
            case 'horasExtras':
                $txtHE = filter_input(INPUT_POST,'txtHE');
                $tbl_reporteDiario_id = filter_input(INPUT_POST,'tbl_reporteDiario_id');


                if(empty($tbl_reporteDiario_id) or $tbl_reporteDiario_id ==0 ){
                    $this->cliError('Debe Seleccionar un reporte');
                }

                $data = array(
                    "he" => $txtHE
                );

                $res = $this->nomina_model->addHorasExtras($data,$tbl_reporteDiario_id);

                if ($res) {
                    exit(json_encode(["status" => "Ok"]));
                } else {
                    $this->cliError("ocurrio un error");
                }
                break;
            case 'reporteDiarioPDF':
                $idReporte = filter_input(INPUT_GET, 'idReporte');
                if (empty($idReporte)) {
                    $this->cliError('Faltan datos', '0X001');
                }

                //obtener datos del modelo
                $data = $this -> nomina_model->getDataReporte($idReporte);
                $detalle = $this->nomina_model->getDetalleR($idReporte);
                //$operaciones = $this->ordenCorte_model->getOperaciones($ordenCorte);

                setlocale(LC_TIME, 'spanish');
                //$inicio = strftime("%d de %B del %Y", strtotime($tadacorte[0]->fecha_orden));

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
                        <td width="150" class="bold">Fecha Reporte:</td>
                        <td width="200">{$data[0]->fecha_reporte_i}</td>                        
                    </tr>
                    <tr>
                        <td width="70" class="bold">PISO:</td>
                        <td width="200">{$data[0]->departamento}</td>
                        <td width="100" class="bold">NOMBRE:</td>
                        <td width="230">{$data[0]->NombreC}</td>
                    </tr>

              </table>
EOD;
                $pdf->writeHTML($tableDatos, true, false, true, false, '');

                $table = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="50">CORTE</td>
                        <td align="center" width="120">CLIENTE</td>
                        <td align="center" width="50">BULTO</td>
                        <td align="center" width="50">OPERACIÓN</td>
                        <td align="center" width="50">CANTIDAD</td>
                    </tr>
                </thead>
EOD;

                $table2 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="1">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="50">CORTE</td>
                        <td align="center" width="120">CLIENTE</td>
                        <td align="center" width="50">BULTO</td>
                        <td align="center" width="50">OPERACIÓN</td>
                        <td align="center" width="50">CANTIDAD</td>
                    </tr>
                </thead>
EOD;

                $numItems = count($detalle);
                $ni = ceil($numItems/2);

                for($i=0;$i<$ni;$i++){
                    $table .= '
                        <tr>
                            <td width="50" align="center">'.$detalle[$i]->numero_corte.'</td>
                            <td width="120" align="center">'.$detalle[$i]->nombre_corto.'</td>
                            <td width="50" align="center">'.$detalle[$i]->num_bulto.'</td>
                            <td width="50" align="center">'.$detalle[$i]->operacion.'</td>
                            <td width="50" align="center">'.$detalle[$i]->cantidad .'</td>
                        </tr>
                    ';
                }

                for($i=$ni;$i<$numItems;$i++){
                    $table2 .= '
                        <tr>
                            <td width="50" align="center">'.$detalle[$i]->numero_corte.'</td>
                            <td width="120" align="center">'.$detalle[$i]->nombre_corto.'</td>
                            <td width="50" align="center">'.$detalle[$i]->num_bulto.'</td>
                            <td width="50" align="center">'.$detalle[$i]->operacion.'</td>
                            <td width="50" align="center">'.$detalle[$i]->cantidad .'</td>
                        </tr>
                    ';
                }


                $table .= '</table>';
                $table2 .= '</table>';

                //tabla grande
                $tablefin = <<<EOD
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td align="center" width="325">{$table}</td>
                        <td align="center" width="322">{$table2}</td>
                    </tr>
             </table>
EOD;

                $pdf->SetFont('dejavusans', '', 9);

                $pdf->writeHTML($tablefin, true, false, true, false, '');


                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('OrdenCorte_Num'.$idReporte.'.pdf', 'I');

                //============================================================+
                // END OF FILE
                //============================================================+
                break;
            case 'reciboPDF':
                $idReporte = filter_input(INPUT_GET, 'idReporte');
                if (empty($idReporte)) {
                    $this->cliError('Faltan datos', '0X001');
                }

                $sum = 0;
                $s=0;

                //obtener datos del modelo
                $data = $this -> nomina_model->getDataReporte($idReporte);
                $detalle = $this->nomina_model->getDataRecibo($idReporte);

                setlocale(LC_TIME, 'spanish');
                //$inicio = strftime("%d de %B del %Y", strtotime($tadacorte[0]->fecha_orden));

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

                $he = $data[0]->he;

                $tableDatos = <<<EOD
                <style>
                td.bold{
    font-weight: bold;
    }
</style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="130" class="bold">Fecha Reporte:</td>
                        <td width="150">{$data[0]->fecha_reporte_i}</td> 
                        <td width="100" class="bold">NOMBRE:</td>
                        <td width="200">{$data[0]->NombreC}</td> 
                        <td width="100" class="bold">{$data[0]->departamento}</td>                
                    </tr>
              </table>
EOD;
                $pdf->writeHTML($tableDatos, true, false, true, false, '');

                $table = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="100">OPERACIÓN</td>
                        <td align="center" width="100">CANTIDAD</td>
                        <td align="center" width="100">TARIFA</td>
                        <td align="center" width="100">TOTAL</td>
                    </tr>
                </thead>
EOD;

                $tableSB = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
EOD;

                $numItems = count($detalle);

                for($i=0;$i<$numItems;$i++){

                    if($detalle[$i]->operacion <> 'S01'){
                        //var_dump($detalle[$i]->operacion);
                        $total = floatval($detalle[$i]->cantidad) * floatval($detalle[$i]->tarifa_con);
                        $tarifa = sprintf("%1\$.5f",floatval($detalle[$i]->tarifa_con));
                        $total = round($total, 2);
                        $sum = $sum + $total;
                        $table .= '
                        <tr>
                            <td width="100" align="center">'.$detalle[$i]->operacion.'</td>
                            <td width="100" align="center">'.$detalle[$i]->cantidad.'</td>
                            <td width="100" align="center">$ '.$tarifa.'</td>
                            <td width="100" align="right">$ '.sprintf("%1\$.2f",$total).'</td>
                        </tr>
                    ';
                    }else{
                        $totalS = floatval($detalle[$i]->cantidad) * floatval($detalle[$i]->tarifa_con);
                        $tarifaS = sprintf("%1\$.2f",floatval($detalle[$i]->tarifa_con));
                        $s = floatval($detalle[$i]->tarifa_con);

                        $tableSB .= '
                        <tr>
                            <td COLSPAN="3" width="300" align="right">SABADO</td>
                            <td width="100" align="right">$ '.sprintf("%1\$.2f",$totalS).'</td>
                        </tr>
                    ';

                    }

                }

                $sumT = sprintf("%1\$.2f",$sum);

                $table2 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="300" align="right">IMPORTE</th>
                        <th width="100" align="right">$ {$sumT}</th>
                    </tr>
                </thead>
            </table>
EOD;

                $totalHE = (($sum / 7)/9)*$he;
                $totalHE = $totalHE * 2;

                $totalR = $sum + $totalHE + $s;
                $totalR = sprintf("%1\$.2f",$totalR);

                $tableSB .= '
                        <tr>
                            <td width="100" align="center">H.E.</td>
                            <td width="100" align="center">'.$he.'</td>
                            <td width="100" align="center">H.E.</td>
                            <td width="100" align="right">$ '.sprintf("%1\$.2f",$totalHE).'</td>
                        </tr>
                    ';

                $table .= '</table>';
                $tableSB .= '</table>';

                $table3 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="300" align="right">TOTAL</th>
                        <th width="100" align="right">$ {$totalR}</th>
                    </tr>
                </thead>
            </table>
EOD;

                $pdf->writeHTML($table, true, false, true, false, '');
                $pdf->writeHTML($table2, true, false, true, false, '');
                $pdf->writeHTML($tableSB, true, false, true, false, '');
                $pdf->writeHTML($table3, true, false, true, false, '');


                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('Recibo'.$idReporte.'.pdf', 'I');

                //============================================================+
                // END OF FILE
                //============================================================+

                break;
            case 'ReciboPisoPDF':
                $idPiso = filter_input(INPUT_GET, 'idPiso');
                $fecha = filter_input(INPUT_GET, 'fecha');
                if (empty($idPiso)) {
                    $this->cliError('Faltan datos', '0X001');
                }

                //obtener datos del modelo

                $data = $this -> nomina_model->getDataReportePiso($idPiso,$fecha);

                //$data = $this -> nomina_model->getDataReporte($idReporte);
                //$detalle = $this->nomina_model->getDataRecibo($idReporte);

                setlocale(LC_TIME, 'spanish');
                //$inicio = strftime("%d de %B del %Y", strtotime($tadacorte[0]->fecha_orden));

                $PDF_HEADER_TITLE="Titulo del PDF";

                // create new PDF document
                $pdf = new TCPDF(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

                // set document information
                $pdf->SetCreator(PDF_CREATOR);
                $pdf->SetAuthor('ESPANI S.A de C.V');

                $PDF_HEADER_STRING="";


                // set default monospaced font
                $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

                // set margins
                $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);


                // set auto page breaks
                $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

                // set some language-dependent strings (optional)
                if (@file_exists(dirname(__FILE__).'/lang/eng.php')) {
                    require_once(dirname(__FILE__).'/lang/eng.php');
                    $pdf->setLanguageArray();
                }

                // ---------------------------------------------------------

                // set default font subsetting mode
                $pdf->setFontSubsetting(true);

                $numItems = count($data);
                $j=0;
                $jj=0;
                $fn=0;

                for ($i=0; $i < $numItems; $i+=2)
                {
                    $fn+=2;


                    if($fn<$numItems){
                        $fin = $fn;
                    }else{
                        $fin = $numItems;
                    }

                    for($k=$j;$k<$fin;$k+=2){
                        $pdf->AddPage('L', 'A4');
                        $pdf->SetFont('dejavusans', '', 10);
                        $sum = 0;
                        $s=0;
                        $he = $data[$k]->he;
                        $idReporte1= $data[$k]->tbl_reporteDiario_id;
                        $detalle1 = $this->nomina_model->getDataRecibo($idReporte1);

                        $tableDatos = <<<EOD
                <style>
                td.bold{
    font-weight: bold;
    }
</style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="130" class="bold">Fecha Reporte:</td>
                        <td width="100">{$data[$k]->fecha_reporte_i}</td>                
                    </tr>
                    <tr>
                        <td width="70" class="bold">NOMBRE:</td>
                        <td width="180">{$data[$k]->NombreC}</td> 
                        <td width="80" class="bold">{$data[$k]->departamento}</td>                
                    </tr>
              </table>
EOD;

                        $table = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="100">OPERACIÓN</td>
                        <td align="center" width="80">CANTIDAD</td>
                        <td align="center" width="80">TARIFA</td>
                        <td align="center" width="80">TOTAL</td>
                    </tr>
                </thead>
EOD;

                        $tableSB = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
EOD;

                        $numItems2 = count($detalle1);

                        for($i=0;$i<$numItems2;$i++){

                            if($detalle1[$i]->operacion <> 'S01'){
                                //var_dump($detalle[$i]->operacion);
                                $total = floatval($detalle1[$i]->cantidad) * floatval($detalle1[$i]->tarifa_con);
                                $tarifa = sprintf("%1\$.5f",floatval($detalle1[$i]->tarifa_con));
                                $total = round($total, 2);
                                $sum = $sum + $total;
                                $table .= '
                        <tr>
                            <td width="100" align="center">'.$detalle1[$i]->operacion.'</td>
                            <td width="80" align="center">'.$detalle1[$i]->cantidad.'</td>
                            <td width="80" align="center">$ '.$tarifa.'</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$total).'</td>
                        </tr>
                    ';
                            }else{
                                $totalS = floatval($detalle1[$i]->cantidad) * floatval($detalle1[$i]->tarifa_con);
                                $tarifaS = sprintf("%1\$.2f",floatval($detalle1[$i]->tarifa_con));
                                $s = floatval($detalle1[$i]->tarifa_con);

                                $tableSB .= '
                        <tr>
                            <td COLSPAN="3" width="260" align="right">SABADO</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$totalS).'</td>
                        </tr>
                    ';

                            }

                        }

                        $sumT = sprintf("%1\$.2f",$sum);

                        $table2 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="260" align="right">IMPORTE</th>
                        <th width="80" align="right">$ {$sumT}</th>
                    </tr>
                </thead>
            </table>
EOD;

                        $totalHE = (($sum / 7)/9)*$he;
                        $totalHE = $totalHE * 2;

                        $totalR = $sum + $totalHE + $s;
                        $totalR = sprintf("%1\$.2f",$totalR);

                        $tableSB .= '
                        <tr>
                            <td width="100" align="center">H.E.</td>
                            <td width="80" align="center">'.$he.'</td>
                            <td width="80" align="center">H.E.</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$totalHE).'</td>
                        </tr>
                    ';

                        $table .= '</table>';
                        $tableSB .= '</table>';

                        $table3 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="260" align="right">TOTAL</th>
                        <th width="80" align="right">$ {$totalR}</th>
                    </tr>
                </thead>
            </table>
EOD;


                        if($k+1<$numItems){
                            $sum2 = 0;
                            $s2=0;
                            $he2 = $data[$k+1]->he;
                            $idReporte2= $data[$k+1]->tbl_reporteDiario_id;
                            $detalle2 = $this->nomina_model->getDataRecibo($idReporte2);
                            $tableDatos2 = <<<EOD
                <style>
                td.bold{
    font-weight: bold;
    }
</style>
             <table cellspacing="0" cellpadding="2" border="0">
                    <tr>
                        <td width="130" class="bold">Fecha Reporte:</td>
                        <td width="100">{$data[$k+1]->fecha_reporte_i}</td>                
                    </tr>
                    <tr>
                        <td width="70" class="bold">NOMBRE:</td>
                        <td width="180">{$data[$k+1]->NombreC}</td> 
                        <td width="80" class="bold">{$data[$k+1]->departamento}</td>                
                    </tr>
              </table>
EOD;


                            $table111 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <td align="center" width="100">OPERACIÓN</td>
                        <td align="center" width="80">CANTIDAD</td>
                        <td align="center" width="80">TARIFA</td>
                        <td align="center" width="80">TOTAL</td>
                    </tr>
                </thead>
EOD;

                            $tableSB2 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
EOD;

                            $numItems3 = count($detalle2);

                            for($i=0;$i<$numItems3;$i++){

                                if($detalle2[$i]->operacion <> 'S01'){
                                    //var_dump($detalle[$i]->operacion);
                                    $total2 = floatval($detalle2[$i]->cantidad) * floatval($detalle2[$i]->tarifa_con);
                                    $tarifa2 = sprintf("%1\$.5f",floatval($detalle2[$i]->tarifa_con));
                                    $total2 = round($total2, 2);
                                    $sum2 = $sum2 + $total2;
                                    $table111 .= '
                        <tr>
                            <td width="100" align="center">'.$detalle2[$i]->operacion.'</td>
                            <td width="80" align="center">'.$detalle2[$i]->cantidad.'</td>
                            <td width="80" align="center">$ '.$tarifa2.'</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$total2).'</td>
                        </tr>
                    ';
                                }else{
                                    $totalS2 = floatval($detalle2[$i]->cantidad) * floatval($detalle2[$i]->tarifa_con);
                                    $tarifaS2 = sprintf("%1\$.2f",floatval($detalle2[$i]->tarifa_con));
                                    $s2 = floatval($detalle2[$i]->tarifa_con);

                                    $tableSB2 .= '
                        <tr>
                            <td COLSPAN="3" width="260" align="right">SABADO</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$totalS2).'</td>
                        </tr>
                    ';

                                }

                            }

                            $sumT2 = sprintf("%1\$.2f",$sum2);

                            $table222 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="260" align="right">IMPORTE</th>
                        <th width="80" align="right">$ {$sumT2}</th>
                    </tr>
                </thead>
            </table>
EOD;

                            $totalHE2 = (($sum2 / 7)/9)*$he2;
                            $totalHE2 = $totalHE2 * 2;

                            $totalR2 = $sum2 + $totalHE2 + $s2;
                            $totalR2 = sprintf("%1\$.2f",$totalR2);

                            $tableSB2 .= '
                        <tr>
                            <td width="100" align="center">H.E.</td>
                            <td width="80" align="center">'.$he2.'</td>
                            <td width="80" align="center">H.E.</td>
                            <td width="80" align="right">$ '.sprintf("%1\$.2f",$totalHE2).'</td>
                        </tr>
                    ';

                            $table111 .= '</table>';
                            $tableSB2 .= '</table>';

                            $table333 = <<<EOD
                                <style>                
  

                </style>
             <table cellspacing="0" cellpadding="2" border="0">
                <thead>
                    <tr style="font-weight: bold">
                        <th COLSPAN="3" width="260" align="right">TOTAL</th>
                        <th width="80" align="right">$ {$totalR2}</th>
                    </tr>
                </thead>
            </table>
EOD;

                        }else{
                            $tableDatos2 = <<<EOD
                <style>
                td.bold{
    font-weight: bold;
    }
</style>
             <table cellspacing="0" cellpadding="2" border="0">
              </table>
EOD;
                        }



                        $tablefin = <<<EOD
                        <style>
                td.br{
    border-right: 1px solid #000000 ;
    }
</style>
             <table cellspacing="1" cellpadding="8" border="0">
                    <tr>
                        <td class="br" align="center" width="380">{$tableDatos}</td>
                        <td align="center" width="380">{$tableDatos2}</td>
                    </tr>
                    <tr>
                        <td class="br" align="center" width="380">{$table}</td>
                        <td align="center" width="380">{$table111}</td>
                    </tr>
                    <tr>
                        <td class="br" align="center" width="380">{$table2}</td>
                        <td align="center" width="380">{$table222}</td>
                    </tr>
                    <tr>
                        <td class="br" align="center" width="380">{$tableSB}</td>
                        <td align="center" width="380">{$tableSB2}</td>
                    </tr>
                    <tr>
                        <td class="br" align="center" width="380">{$table3}</td>
                        <td align="center" width="380">{$table333}</td>
                    </tr>
             </table>
EOD;


                        $pdf->SetFont('dejavusans', '', 9);

                        $pdf->writeHTML($tablefin, true, false, true, false, '');

                        }



                    $j=$fn;
                }






                // Close and output PDF document
                // This method has several options, check the source code documentation for more information.
                $pdf->Output('Recibo'.$idPiso.'.pdf', 'I');

                //============================================================+
                // END OF FILE
                //============================================================+

                break;
            default: $this->cliError();
        }
    }

}