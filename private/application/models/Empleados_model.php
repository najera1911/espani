<?php

class Empleados_model extends CI_Model{

    function get_empleados($start, $length, $where=null, $select=null, $table = 'empleados_view' ){
        if(!empty($where))
            if(! is_array($where)){
                return FALSE;
            }
        if(!empty($select))
            $this->db->select($select);

        if(!empty($where))
            $this->db->where($where);

        if($length>=0){
            $this->db->limit($length,$start);
        }
        return $this->db->get($table)->result();
    }

    function  getEmpleadoSearch($start, $length, $value, $column){
        $this->db->like($column, $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        return $this->db->get('empleados_view')->result();
    }

    function getEntidad(){
        $this->db->select("cat_entidad_id as id, nombre,'' as txt");
        return $this->db->get("cat_entidad")->result();
    }

    function getMunicipio($cat_estado_id){
        $this->db->select("cat_municipio_id as id, descripcion as nombre, '' as txt")->where('cat_estado_id',$cat_estado_id);
        return $this->db->get("cat_municipio")->result();
    }

    function  getLocalidad($cat_estado_id,$clave_municipio){
        $this->db->select("cat_localidad_id as id, descripcion as nombre, '' as txt")->where('cat_entidad_id',$cat_estado_id)->where('cat_municipio_id',$clave_municipio);
        return $this->db->get("cat_localidad")->result();
    }

    function getDepartamento(){
        $this->db->select("cat_rh_departamento_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("cat_rh_departamento")->result();
    }

    function getPuesto(){
        $this->db->select("cat_rh_puesto_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("cat_rh_puesto")->result();
    }

    function addEmpleado($empleado){
        if(!$empleado instanceof clsPersonal){
            return FALSE;
        }
        $res = $this->db->insert('cat_rh_empleados',$empleado);
        $lastId = $res?$this->db->insert_id():$res;
        return $lastId;
    }

    function updateEmpleado($id, $empleado){
        if(empty($id)){
            return FALSE;
        }

        if(!$empleado instanceof clsPersonal){
            return FALSE;
        }
        $array =  (array) $empleado;
        $rtn = [];

        foreach ($array as $index => $var) {
            if(!is_empty($var,TRUE)){
                $rtn[$index] = $var;
                if($var===-1){
                    $rtn[$index] = NULL;
                }
            }
        }

        $this->db->where('cat_rh_empleado_id', $id);
        $res = $this->db->update('cat_rh_empleados',$rtn);

        return $res;
    }

    function updateTblEmpleado($set = NULL, $where  = NULL,  $tableName = 'cat_rh_empleados'){
        if(empty($set) || empty($where)){
            return FALSE;
        }
        if(!is_array($set) || !is_array($where)){
            return FALSE;
        }

        return $this->db->update($tableName, $set, $where);
    }

    function updateFoto($idEmpleado, $foto, $tipo, $len){
        $this->db->where("cat_rh_empleados_id", $idEmpleado);
        $this->db->delete("cat_rh_empleados_fotos");


        $array = array("cat_rh_empleados_id" => $idEmpleado,
            "vbfoto" => $foto,
            "ifotoLen" => $len,
            "vfotoType" => "'" . $tipo  . "'");
        $this->db->insert('cat_rh_empleados_fotos', $array, FALSE);
    }

    function getFoto($idEmpleado){
        $this->db->select('vbfoto as foto, ifotoLen as len, vfotoType as tipo')->where('cat_rh_empleados_id', $idEmpleado);
        $res = $this->db->get("cat_rh_empleados_fotos")->result();
        if(count($res)<=0){
            $res = "";
        }else{
            $res = $res[0];
        }

        return $res;
    }

    function deleteEmpleado($idEmpleado,$txtFhBjaja){
        $data = array(
            'estatus' => false,
            'fcha_baja' => $txtFhBjaja
        );
        $this->db->where('cat_rh_empleado_id', $idEmpleado);
        $res = $this->db->update('cat_rh_empleados', $data);

        return $res;
    }

}