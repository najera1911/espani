<?php
/**
 * Created by REPSS Hidalgo.
 * User: Ulises Darío Martínez Salinas
 * Contact: ulises[dot]salinas[at]gmail[dot]com
 * Date: 16/05/2017
 * Time: 10:58 AM
 */

defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Inicio";
$data['css'] = array(
    'style6.css'
);

$this->load->view("plantilla/encabezado",$data);

?>

<menu id="menu">
    <div class="container-fluid">
        <div class="row mt-5 mb-5">
            <div class="col text-center text-uppercase">
                <h2>Plataforma Integral ESPANI</h2>
            </div>
        </div>
        <div class="row mb-5">
            <ul class="ca-menu">
                <li>
                    <a href="#">
                        <span class="ca-icon">F</span>
                        <div class="ca-content">
                            <h2 class="ca-main">Empleados</h2>
                        </div>
                    </a>
                </li>
                <li class="ml-2">
                    <a href="#">
                        <span class="ca-icon">H</span>
                        <div class="ca-content">
                            <h2 class="ca-main">Clientes</h2>
                        </div>
                    </a>
                </li>
                <li class="ml-2">
                    <a href="#">
                        <span class="ca-icon">N</span>
                        <div class="ca-content">
                            <h2 class="ca-main">Orden de Corte</h2>
                        </div>
                    </a>
                </li>
                <li class="ml-2">
                    <a href="#">
                        <span class="ca-icon">K</span>
                        <div class="ca-content">
                            <h2 class="ca-main">Catalogos</h2>
                        </div>
                    </a>
                </li>
                <li class="ml-2">
                    <a href="#">
                        <span class="ca-icon">L</span>
                        <div class="ca-content">
                            <h2 class="ca-main">Pagos</h2>
                        </div>
                    </a>
                </li>
            </ul>
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