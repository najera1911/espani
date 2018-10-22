<?php

class Empleados_model extends CI_Model{

    function get_empleados($where=null, $select=null, $table = 'empleados_view'){
        if(!empty($where))
            if(! is_array($where)){
                return FALSE;
            }
        if(!empty($select))
            $this->db->select($select);

        if(!empty($where))
            $this->db->where($where);

        return $this->db->get($table)->result();
    }

    function getEntidad(){
        $this->db->select("cat_entidad_id as id, nombre,'' as txt");
        return $this->db->get("cat_entidad")->result();
    }

    function getDepartamento(){
        $this->db->select("cat_rh_departamento_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("cat_rh_departamento")->result();
    }

    function getPuesto(){
        $this->db->select("cat_rh_puesto_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("cat_rh_puesto")->result();
    }

}