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
