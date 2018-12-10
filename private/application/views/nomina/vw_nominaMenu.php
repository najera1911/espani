<?php
/**
 * Created by REPSS Hidalgo.
 * User: Ulises Darío Martínez Salinas
 * Contact: ulises[dot]salinas[at]gmail[dot]com
 * Date: 16/05/2017
 * Time: 10:58 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Menu Orden Corte";
$data['css'] = array(
    'espaniMain.css'
);

$this->load->view("plantilla/encabezado",$data);

?>

    <style>
        #ca-menu .li:hover .ca-main {
            font-size: 24px !important;
        }
    </style>

    <menu id="menu">
        <div class="container-fluid">
            <div class="row justify-content-center mt-5 mb-5">
                <div class="col text-center text-uppercase">
                    <h2 class="text-espani">Menú Nómina</h2>
                </div>
            </div>
            <div id="ca-menu">
                <div class="row row justify-content-center">
                    <div class="col-md-2">
                        <div class="li">
                            <a href="<?php echo base_url()?>nomina/index/reporteDiario">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/ReportDProd.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Capturar Reporte Diario</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-2">
                        <div class="li">
                            <a href="<?php echo base_url()?>nomina/index/reciboPago">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/recibo.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Recibo de Pago</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </menu>

<?php
$data['scripts'] = array(

);
$this->load->view("plantilla/pie",$data);