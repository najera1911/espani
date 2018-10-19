<?php

class clsPersonal
{
    var
        $cat_area_id,
        $apellido_paterno,
        $apellido_materno,
        $nombre,
        $fh_nacimiento,
        $sexo,
        $rfc,
        $curp,
        $profesion,
        $profesion_cedula,
        $especialidad,
        $especialidad_cedula,
        $telefono1,
        $telefono2,
        $email,
        $fh_baja,
        $usuario,
        $clave,
        $cat_perfil_id,
        $cambia_clave,
        $calle,
        $colonia,
        $cp,
        $cat_localidad_id,
        $cat_municipio_id,
        $cat_estado_id
    ;


    function __construct()
    {
        $this->profesion_cedula= "";
        $this->especialidad_cedula = "";
        $this->cat_area_id  = FALSE;
    }
}