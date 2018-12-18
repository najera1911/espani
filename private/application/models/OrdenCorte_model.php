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

    function ifExistNumOrden($txtNunOrden){
        $this->db->where('numero_corte',$txtNunOrden);
        $r = $this->db->get('tbl_ordencorte');

        if($r->num_rows()>0){
            return true;
        }else{
            return FALSE;
        }
    }

    function addModeloCorte($data, $dataBultos){
        $this->db->trans_begin();

        $this->db->insert('tbl_ordencorte', $data);
        $insert_id = $this->db->insert_id();

        $dataDetalle= array();
        $longitud = count($dataBultos);

        $sum = 0;

        for($i=0; $i<$longitud; $i++)
        {

            $data2 = array(
                "tbl_ordencorte_id" => $insert_id,
                "num_bulto" => (int) $dataBultos[$i]['num_bulto'],
                "tallas" => (int) $dataBultos[$i]['tallas'],
                "cantidad" => (int) $dataBultos[$i]['cantidad'],
                "resta" => (int) $dataBultos[$i]['resta']
            );

            $this->db->insert('tbl_ordencorte_bultos', $data2);
            $insert_id2 = $this->db->insert_id();

            $sql='INSERT INTO tbl_ordencorte_operaciones (tbl_ordencorte_id, cat_ordencorte_bultos_id, cat_operaciones_id, cantidad, resta)
SELECT ? as tbl_ordencorte_id, ? as cat_ordencorte_bultos_id ,cat_operaciones_id, ? as cantidad, ? as resta 
from tblmodelos_temp';

            $this->db->query($sql, array($insert_id, $insert_id2 ,(int) $dataBultos[$i]['resta'],(int) $dataBultos[$i]['resta']));

//            $array=array();
//            $array['tbl_ordencorte_id'] = $insert_id;
//            $array['num_bulto'] = (int) $dataBultos[$i]['num_bulto'];
//            $array['tallas'] = (int) $dataBultos[$i]['tallas'];
//            $array['cantidad'] = (int) $dataBultos[$i]['cantidad'];
//            $array['resta'] = (int) $dataBultos[$i]['resta'];
//            array_push($dataDetalle ,$array);
//
//            $sum = $sum + (int) $dataBultos[$i]['cantidad'];
        }

        //$this->db->insert_batch('tbl_ordencorte_bultos', $dataDetalle);



        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return true;
        }
    }

    function get_OrdenesCorteView($start,$length){
        if($length>=0){
            $sql='SELECT A.tbl_OrdenCorte_id, A.numero_corte, A.fecha_orden, C.tbl_clientes_id, C.nombre_corto, 
A.modelo, A.colores, COUNT(B.num_bulto) as num_bultos, sum(B.cantidad) as cantidad, 
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 
GROUP by A.tbl_OrdenCorte_id LIMIT ?, ?';
            return $this->db->query($sql, array((int) $start, (int) $length))->result();
        }else{
            $sql='SELECT A.tbl_OrdenCorte_id, A.numero_corte, A.fecha_orden, C.tbl_clientes_id, C.nombre_corto, 
A.modelo, A.colores, COUNT(B.num_bulto) as num_bultos, sum(B.cantidad) as cantidad, 
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 
GROUP by A.tbl_OrdenCorte_id';
            return $this->db->query($sql)->result();
        }
    }

    function get_OrdenesCorteViewSearch($value){
        $sql="SELECT A.tbl_OrdenCorte_id, A.numero_corte, A.fecha_orden, C.tbl_clientes_id, C.nombre_corto, 
A.modelo, A.colores, COUNT(B.num_bulto) as num_bultos, sum(B.cantidad) as cantidad, 
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 and A.numero_corte = ?
GROUP by A.tbl_OrdenCorte_id";
        return $this->db->query($sql, array((int) $value))->result();
    }



}