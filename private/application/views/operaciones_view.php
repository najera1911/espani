<?php


defined('BASEPATH') OR exit('No direct script access allowed');

$data['title'] = ":: Operaciones";
$data['css'] = array(
    'espaniMain.css'
);

$this->load->view("plantilla/encabezado",$data);
?>










    <script>
        $(document).ready(function(){


        });
    </script>

<?php
$data['scripts'] = array(

);
$this->load->view("plantilla/pie",$data);