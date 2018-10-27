<?php defined('BASEPATH') OR exit('No direct script access allowed');

$this->acl->setUserId($this->session->userdata('idU'));//EXTRAE SOLO UNA PARTE DEL ARRAY DE INICIO DE SESION
?>

<style>


</style>

<nav id="header" class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="#">
            <img src="<?php echo base_url('assets/img/')?>icon2.png" alt="maquiladora logo">
            <span>MAQUILADORA ESPANI S.A DE C.V. </span>
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
                aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav ml-auto">
                <li class="nav-item itemfirst">
                    <a class="nav-link" href="<?php echo base_url()?>inicio/index/inicio"><span class="fas fa-home fa-fw"></span> Inicio</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url()?>empleados/index/empleados"><span class="fas fa-users"></span> Empleados</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo base_url()?>clientes/index/clientes"><span class="fas fa-user-tie"></span> Clientes </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-clipboard-list"></span> Catalogos</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href=""><span class="fas fa-cogs"></span> Operaciones</a>
                        <a class="dropdown-item" href=""><span class="fas fa-gift"></span> two</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href=""><span class="fas fa-dolly-flatbed"></span> Orden de Corte </a>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#" role="button" aria-haspopup="true" aria-expanded="false">
                        <span class="fas fa-cogs"></span> Admin</a>
                    <div class="dropdown-menu dropdown-menu-right">
                        <a class="dropdown-item" href="<?php echo base_url()?>administrador/index/usuarios"><span class="fas fa-users-cog"></span> Usuarios </a>
                        <a class="dropdown-item" href=""><span class="fas fa-user-tie"></span>Perfiles</a>
                    </div>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="<?php echo  site_url(("inicio/cerrar_sesion"));?>"><span class="fas fa-sign-out-alt"></span>Salir</a>
                </li>
                <!--                <li class="nav-item">-->
                <!--                    <a class="nav-link text-platzi" href="#" data-target="#modalCompra" data-toggle="modal">Comprar tickets</a>-->
                <!--                </li>-->
            </ul>
        </div>
    </div>
</nav>

<div class="container-fluid">

