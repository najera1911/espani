<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Date: 16/05/2017
 * Time: 10:57 AM
 */
?><!DOCTYPE html>
<html lang="es_MX">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="<?php echo base_url('assets/img/')?>icon.png">

    <title>ESPANI <?php echo (isset($title)?$title:"."); ?></title>



    <script src="<?php echo base_url('assets/js/')?>jquery-3.2.1.min.js?v=3.2.1"></script>
    <script src="<?php echo base_url('assets/js/')?>jquery.validate.min.js"></script>



    <link href="<?php echo base_url('assets/css/')?>datepicker.min.css?v=1" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/')?>bootstrap.css?v=4.1.3" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/')?>bootstrap.min.css?v=4.1.3" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/')?>navbar.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/')?>all.css" rel="stylesheet">
    <link href="<?php echo base_url('assets/css/')?>sweetalert.css" rel="stylesheet">

    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.css"/>

    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4-4.1.1/jq-3.3.1/jszip-2.5.0/dt-1.10.18/af-2.3.2/b-1.5.4/b-colvis-1.5.4/b-flash-1.5.4/b-html5-1.5.4/b-print-1.5.4/fc-3.2.5/fh-3.1.4/r-2.2.2/sl-1.2.6/datatables.min.js"></script>


    <?php
    if(isset($css)){
        for($i=0; $i<count($css);$i++){
            echo '<link href="'.  base_url("assets/css/".$css[$i]) .'?v=1" rel="stylesheet">';
        }
    }
    ?>


</head>
<body>





<?php
if( $this->session->userdata('isLoggedIn') ) {
    $this->load->view("plantilla/menu");
}
?>
