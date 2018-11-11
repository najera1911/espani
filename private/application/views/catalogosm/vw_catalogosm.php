<?php
/**
 * Created by REPSS Hidalgo.
 * User: Ulises Darío Martínez Salinas
 * Contact: ulises[dot]salinas[at]gmail[dot]com
 * Date: 16/05/2017
 * Time: 10:58 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Catalogos";
$data['css'] = array(
    'espaniMain.css'
);

$this->load->view("plantilla/encabezado",$data);

?>

    <menu id="menu">
        <div class="container-fluid">
            <div class="row mt-5 mb-3">
                <div class="col text-center text-uppercase">
                    <h2 class="text-espani">Plataforma Integral ESPANI</h2>
                </div>
            </div>
            <div id="ca-menu">
                <div class="row">
                    <div class="col-md-4">
                        <div class="li">
                            <a href="<?php echo base_url()?>puestos/index/puestos">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/puestos.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Puestos</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="li">
                            <a href="<?php echo base_url()?>areas/index/areas">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/dptos.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Departamentos</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="li">
                            <a href="<?php echo base_url()?>operaciones/index/operaciones">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/op.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Operaciones</h2>
                                </div>
                            </a>
                        </div>
                    </div>
               </div>
            </div>
        </div>
    </menu>


    <script>
        $(document).ready(function(){


        });
    </script>

<?php
$data['scripts'] = array(

);
$this->load->view("plantilla/pie",$data);