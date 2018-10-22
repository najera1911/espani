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

}