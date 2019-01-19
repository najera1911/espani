<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class OrdenCorte_model extends CI_Model{

    function getClientes(){
        $this->db->select("tbl_clientes_id as id, nombre_corto as nombre,'' as txt")->where('estatus',1);
        return $this->db->get("tbl_clientes")->result();
    }

    function getModelosCorte(){
        $this->db->select("cat_modelos_cortes_id as id, descripcion as nombre,'' as txt")->where('estatus',1);
        $query1 = $this->db->get("cat_modelos_cortes")->result();

        $this->db->select("0 as id, 'Nuevo Modelo' as nombre,'' as txt");
        $query2 = $this->db->get()->result();

        $query = array_merge($query2, $query1);

        return $query;
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
        $this->db->order_by('cat_tipo_corte_id', 'ASC');
        $this->db->get("tblmodelos_temp");
    }

    function datosModelosCortesDetalleEditLimit($start,$length,$tbl_ordencorte_id){
        if($length>=0){
            $this->db->limit($length,$start);
        }

        $this->db->distinct();
        $this->db->select("A.cat_operaciones_id, C.descripcion as filtro_corte, B.operacion as clave, B.descripcion as operacion, '-' as nombre_modelo");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("cat_operaciones B","A.cat_operaciones_id=B.cat_operaciones_id");
        $this->db->join("cat_tipo_corte C","B.cat_tipo_corte_id = C.cat_tipo_corte_id");
        $this->db->where("tbl_ordencorte_id",$tbl_ordencorte_id);
        $this->db->order_by('C.cat_tipo_corte_id, clave');
        return $this->db->get()->result();
    }

    function getOperacionEditSearch($start,$length,$value, $column,$tbl_ordencorte_id){
        $this->db->like('B.operacion', $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->distinct();
        $this->db->select("A.cat_operaciones_id, C.descripcion as filtro_corte, B.operacion as clave, B.descripcion as operacion, '-' as nombre_modelo");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("cat_operaciones B","A.cat_operaciones_id=B.cat_operaciones_id");
        $this->db->join("cat_tipo_corte C","B.cat_tipo_corte_id = C.cat_tipo_corte_id");
        $this->db->where("tbl_ordencorte_id",$tbl_ordencorte_id);
        $this->db->order_by('C.cat_tipo_corte_id, clave');
        return $this->db->get()->result();
    }

    public function datosModelosCortesDetalleLimit($start,$length){
        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->order_by('cat_tipo_corte_id', 'ASC');
        return $this->db->get('tblmodelos_temp')->result();
    }

    function  getOperacionSearch($start, $length, $value, $column){
        $this->db->like($column, $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->order_by('cat_tipo_corte_id', 'ASC');
        return $this->db->get('tblmodelos_temp')->result();
    }

    function deleteOperacion($id){
        $this->db->where('cat_operaciones_id', $id);
        $res= $this->db->delete('tblmodelos_temp');

        return $res;
    }

    function deleteOperacionEdit($data,$tbl_ordencorte_id){
        $this->db->where('tbl_ordencorte_id', $tbl_ordencorte_id)->where('cat_operaciones_id',$data);
        $res= $this->db->delete('tbl_ordencorte_operaciones');

        return $res;
    }

    function validarOrdenCorte($data){
        $data2 = array(
            "validado" => true,
        );

        $this->db->where('tbl_OrdenCorte_id', $data );
        $res= $this->db->update('tbl_ordencorte', $data2);

        return $res;
    }

    function deleteOrdenCorte($data){
        $this->db->trans_begin();

        $this->db->where('tbl_ordencorte_id', $data);
        $this->db->delete('tbl_ordencorte_operaciones');

        $this->db->where('tbl_ordencorte_id', $data);
        $this->db->delete('tbl_ordencorte_bultos');

        $this->db->where('tbl_OrdenCorte_id', $data);
        $this->db->delete('tbl_ordencorte');

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

    function ifExistOper($data){
        $this->db->where('cat_operaciones_id',$data);
        $r = $this->db->get('tblmodelos_temp');

        if($r->num_rows()>0){
            return true;
        }else{
            return FALSE;
        }
    }

    function ifExistOperEdit($data,$tbl_ordencorte_id){
        $this->db->where('cat_operaciones_id',$data)->where('tbl_ordencorte_id',$tbl_ordencorte_id);
        $r = $this->db->get('tbl_ordencorte_operaciones');

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

    function AddOperacionEdit($data,$tbl_ordencorte_id,$idBultos){
        $this->db->trans_begin();
        $longitud = count($idBultos);
        for($i=0; $i<$longitud; $i++){
            $data2 = array(
                "tbl_ordencorte_id" => $tbl_ordencorte_id,
                "cat_ordencorte_bultos_id" => (int) $idBultos[$i]->tbl_OrdenCorte_bultos_id,
                "cat_operaciones_id" => $data,
                "cantidad" => 0,
                "resta" => 0
            );

            $this->db->insert('tbl_ordencorte_operaciones', $data2);
        }

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

        }

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

    function getIdBultos($idOrden){
        $this->db->select("tbl_OrdenCorte_bultos_id");
        $this->db->where("tbl_ordencorte_id",$idOrden);
        return $this->db->get('tbl_ordencorte_bultos')->result();
    }

    function EditModeloCorte($data, $dataBultos, $idOrden, $idBultos){
        if(empty($idOrden)){
            return FALSE;
        }

        $this->db->trans_begin();

        $this->db->where('tbl_OrdenCorte_id', $idOrden);
        $this->db->update('tbl_ordencorte',$data);

        $longitud = count($dataBultos);

        for($i=0; $i<$longitud; $i++)
        {

            $data2 = array(
                "num_bulto" => (int) $dataBultos[$i]['num_bulto'],
                "tallas" => (int) $dataBultos[$i]['tallas'],
                "cantidad" => (int) $dataBultos[$i]['cantidad'],
                "resta" => (int) $dataBultos[$i]['resta']
            );

            $this->db->where('tbl_OrdenCorte_bultos_id', (int) $idBultos[$i]->tbl_OrdenCorte_bultos_id );
            $this->db->update('tbl_ordencorte_bultos', $data2);

            $data3 = array(
                "cantidad" => (int) $dataBultos[$i]['cantidad'],
                "resta" => (int) $dataBultos[$i]['resta']
            );

            $this->db->where('cat_ordencorte_bultos_id', (int) $idBultos[$i]->tbl_OrdenCorte_bultos_id )->where('tbl_ordencorte_id',$idOrden);
            $this->db->update('tbl_ordencorte_operaciones', $data3);

        }

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
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes, A.validado
FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 
GROUP by A.tbl_OrdenCorte_id LIMIT ?, ?';
            return $this->db->query($sql, array((int) $start, (int) $length))->result();
        }else{
            $sql='SELECT A.tbl_OrdenCorte_id, A.numero_corte, A.fecha_orden, C.tbl_clientes_id, C.nombre_corto, 
A.modelo, A.colores, COUNT(B.num_bulto) as num_bultos, sum(B.cantidad) as cantidad, 
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes, A.validado
FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 
GROUP by A.tbl_OrdenCorte_id';
            return $this->db->query($sql)->result();
        }
    }

    function get_OrdenesCorteViewSearch($value){
        $sql="SELECT A.tbl_OrdenCorte_id, A.numero_corte, A.fecha_orden, C.tbl_clientes_id, C.nombre_corto, 
A.modelo, A.colores, COUNT(B.num_bulto) as num_bultos, sum(B.cantidad) as cantidad, 
sum(B.cantidad) - sum(B.resta) as terminado, sum(B.resta) as faltantes, A.validado
FROM tbl_ordencorte A 
INNER JOIN tbl_ordencorte_bultos B on A.tbl_OrdenCorte_id=B.tbl_ordencorte_id 
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id where A.estatus=1 and A.numero_corte = ?
GROUP by A.tbl_OrdenCorte_id";
        return $this->db->query($sql, array((int) $value))->result();
    }

    function getbultos($ordenCorte){
        $this->db->where('tbl_ordencorte_id',$ordenCorte);
        return $this->db->get("tbl_ordencorte_bultos")->result();
    }

    function getDataCortes($ordenCorte){
        $this->db->select("A.*, B.nombre_corto");
        $this->db->from("tbl_ordencorte A")->join("tbl_clientes B","A.cat_clientes_id=b.tbl_clientes_id");
        $this->db->where('tbl_OrdenCorte_id',$ordenCorte);
        return $this->db->get()->result();
    }

    function getOperaciones($ordenCorte){
        $this->db->distinct();
        $this->db->select("A.tbl_ordencorte_id as id, C.cat_tipo_corte_id, C.descripcion as tipo_corte, B.operacion, B.descripcion");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("cat_operaciones B","A.cat_operaciones_id=B.cat_operaciones_id");
        $this->db->join("cat_tipo_corte C","B.cat_tipo_corte_id=C.cat_tipo_corte_id");
        $this->db->where('tbl_ordencorte_id',$ordenCorte);
        $this->db->order_by("cat_tipo_corte_id, operacion", "asc");
        return $this->db->get()->result();
    }

    function validaEdit($data){
        $this->db->where('tbl_ordencorte_id',$data);
        $r = $this->db->get("tbl_reportediario_detalle");

        if($r->num_rows()>0){
            return true;
        }else{
            return FALSE;
        }
    }

    function getOrdenData($idOrden){
        $this->db->where("tbl_OrdenCorte_id",$idOrden);
        return $this->db->get("tbl_ordencorte")->result();
    }

    function getOrdenBultosData($idOrden){
        $this->db->where("tbl_ordencorte_id",$idOrden);
        return $this->db->get("tbl_ordencorte_bultos")->result();
    }


}