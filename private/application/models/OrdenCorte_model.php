<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenCorte_model extends CI_Model{

    function getClientes(){
        $this->db->select("tbl_clientes_id as id, nombre_corto as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("tbl_clientes")->result();
    }

    function getModelosCorte(){
        $this->db->select("cat_modelos_cortes_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("cat_modelos_cortes")->result();
    }

    function getFiltroCorte(){
        $this->db->select("cat_tipo_corte_id as id, descripcion as nombre,'' as txt")->where('estatus',true);
        return $this->db->get("cat_tipo_corte")->result();
    }

    function getOpera($id){
        $this->db->select("cat_operaciones_id as id, CONCAT(operacion,' - ', descripcion) as nombre,'' as txt")->where('estatus',true);
        $this->db->where('cat_tipo_corte_id',$id);
        return $this->db->get("cat_operaciones")->result();
    }

    public function datosModelosCortesDetalle($idModel){

        if(empty($idModel)){
            $idModel=0;
        }

        $this->db->query("DROP TABLE IF EXISTS tblmodelos_temp");
        $sql='CREATE TABLE tblmodelos_temp SELECT * FROM modelos_cortes_view where estatus=1 and cat_modelos_cortes_id=?';
        $this->db->query($sql, array($idModel));
        $this->db->get("tblmodelos_temp");
    }

    public function datosModelosCortesDetalleLimit($start,$length){
        $this->db->limit($length,$start);
        return $this->db->get('tblmodelos_temp')->result();
    }

    function  getOperacionSearch($start, $length, $value, $column){
        $this->db->like($column, $value);
        $this->db->limit($length,$start);
        return $this->db->get('tblmodelos_temp')->result();
    }

    function deleteOperacion($id){
        $this->db->where('cat_operaciones_id', $id);
        $res= $this->db->delete('tblmodelos_temp');

        return $res;
    }

    function ifExistOper($data){
        $this->db->where('cat_operaciones_id',$data);
        $r = $this->db->get('tblmodelos_temp');

        if($r->num_rows()>0){
            return true;
        }else{
            return FALSE;
        }
    }

    function AddOperacion($data,$cat_modelos_cortes_id,$model){

        $sql='INSERT INTO tblmodelos_temp (cat_modelos_cortes_id, modeloCorte, estatus, cat_operaciones_id, cat_tipo_corte_id, tipoCorte, operacion, nombreOperacion,tarifa_con,tarifa_sin)
SELECT ? as cat_modelos_cortes_id, ? as modeloCorte, estatus, cat_operaciones_id, cat_tipo_corte_id, tipoCorte, operacion, descripcion as nombreOperacion, tarifa_con, tarifa_sin from cat_operacion_view
where cat_operaciones_id=?';
        $res = $this->db->query($sql, array($cat_modelos_cortes_id,$model,$data));

        return $res;
    }

}