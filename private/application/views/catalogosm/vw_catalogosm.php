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
                            <a href="<?php echo base_url()?>catpuesto/index/catpuesto">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/emp.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Operaciones</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="li">
                            <a href="<?php echo base_url()?>clientes/index/clientes">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/client.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">Perfiles</h2>
                                </div>
                            </a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="li">
                            <a href="<?php echo base_url()?>pacientes/index/pacientes">
                                <div class="ca-imagen">
                                    <img class="object move-right" src="<?php echo base_url()?>assets/img/catalogos.png">
                                </div>
                                <div class="ca-content">
                                    <h2 class="ca-main">No me acuerdo</h2>
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