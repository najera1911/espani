<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nomina_model extends CI_Model{

    function getEmpleados($idPiso){
        $this->db->select("cat_rh_empleado_id AS id, CONCAT(departamento,' -',NombreC) as nombre,'' as txt");
        $this->db->where("estatus",1)->where("cat_rh_departamento",$idPiso);
        return $this->db->get("empleados_view")->result();
    }

    function getPiso(){
        $this->db->select("cat_rh_departamento_id AS id, descripcion as nombre,'' as txt");
        $this->db->where("estatus",1);
        return $this->db->get("cat_rh_departamento")->result();
    }

    function getEmpleadosData($idEmpleado){
        $this->db->select("cat_rh_empleado_id, departamento, puesto, NombreC, cat_rh_departamento");
        $this->db->where("estatus",1)->where("cat_rh_empleado_id",$idEmpleado);
        return $this->db->get("empleados_view")->result();
    }

    function getDataReporteProd($idReporte){
        $this->db->select("A.*, B.NombreC, B.departamento, B.puesto, B.cat_rh_departamento");
        $this->db->from("tbl_reportediario A");
        $this->db->join("empleados_view B","A.cat_rh_empleado_id=B.cat_rh_empleado_id");
        $this->db->where("tbl_reporteDiario_id",$idReporte);
        return $this->db->get()->result();
    }

    function getCortes(){
        $sql="SELECT A.tbl_OrdenCorte_id as id, concat(A.numero_corte,' - ',C.nombre_corto) as nombre,'' as txt 
FROM tbl_ordenCorte A
INNER join tbl_ordencorte_operaciones B on a.tbl_OrdenCorte_id=B.tbl_ordencorte_id
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id
WHERE A.validado = 1
GROUP by A.tbl_OrdenCorte_id
HAVING sum(B.resta)>0";
        return $this->db->query($sql)->result();
    }

    function getBultos($idCorte,$idOper){
        $this->db->select("tbl_OrdenCorte_operaciones as id, concat(num_bulto, '  (Restan  ',B.resta,' )') as nombre, '' as txt");
        $this->db->from("tbl_ordencorte_bultos A");
        $this->db->join("tbl_ordencorte_operaciones B","A.tbl_OrdenCorte_bultos_id=B.cat_ordencorte_bultos_id");
        $this->db->where("cat_operaciones_id",$idOper)->where("B.tbl_ordencorte_id",$idCorte)->where("B.resta>",0);
        return $this->db->get()->result();
    }

    function getOperaciones($idCorte){
        $this->db->select("A.cat_operaciones_id as id, concat(B.operacion,' - ',B.descripcion,' - RESTAN ', sum(A.resta)) as nombre,'' as txt");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("cat_operaciones B","A.cat_operaciones_id=B.cat_operaciones_id");
        $this->db->where("tbl_ordencorte_id",$idCorte)->where("resta>",0);
        $this->db->group_by('B.operacion');
        $query1 = $this->db->get()->result();

        $this->db->select("0 as id, concat(operacion,' - ', descripcion) as nombre, '' as txt");
        $this->db->where("operacion","S01");
        $query2 = $this->db->get("cat_operaciones")->result();

        $query = array_merge($query1, $query2);


        return $query;
    }

    function get_ReporteDiario($start,$length,$idEmpleado,$fecha_i){

        if($idEmpleado=='' and $fecha_i!=''){
            $sql="SELECT tbl_reporteDiario_id, A.cat_rh_empleado_id, B.NombreC, B.puesto, b.departamento, A.fecha_reporte_i, A.fecha_reporte_f
FROM tbl_reportediario A
INNER JOIN empleados_view B on A.cat_rh_empleado_id = B.cat_rh_empleado_id
where A.fecha_reporte_i=? LIMIT ?, ?";
            return $this->db->query($sql, array($fecha_i, (int) $start, (int) $length))->result();
        }else if($fecha_i=='' and $idEmpleado!=''){
            $sql="SELECT tbl_reporteDiario_id, A.cat_rh_empleado_id, B.NombreC, B.puesto, b.departamento, A.fecha_reporte_i, A.fecha_reporte_f
FROM tbl_reportediario A
INNER JOIN empleados_view B on A.cat_rh_empleado_id = B.cat_rh_empleado_id
where A.cat_rh_empleado_id = ? LIMIT ?, ?";
            return $this->db->query($sql, array((int) $idEmpleado, (int) $start, (int) $length))->result();
        }else{
            $sql="SELECT tbl_reporteDiario_id, A.cat_rh_empleado_id, B.NombreC, B.puesto, b.departamento, A.fecha_reporte_i, A.fecha_reporte_f
FROM tbl_reportediario A
INNER JOIN empleados_view B on A.cat_rh_empleado_id = B.cat_rh_empleado_id
where A.cat_rh_empleado_id = ? and A.fecha_reporte_i=? LIMIT ?, ?";
            return $this->db->query($sql, array((int) $idEmpleado, $fecha_i, (int) $start, (int) $length))->result();
        }
    }

    function getReporte($tbl_reportediario_id,$start,$length){
        if($length>=0){
            $sql="SELECT A.tbl_reportediario_detalle_id, B.numero_corte, C.nombre_corto, F.num_bulto, 
IFNULL(E.operacion,'S01') as operacion, IFNULL(E.descripcion,'SABADOS') as descripcion, A.cantidad, 
A.tbl_cordencorte_operaciones_id, A.tbl_ordencorte_bultos_id
FROM tbl_reportediario_detalle A
INNER JOIN tbl_ordencorte B on A.tbl_ordencorte_id=B.tbl_OrdenCorte_id
INNER JOIN tbl_clientes C on B.cat_clientes_id=C.tbl_clientes_id
LEFT JOIN tbl_ordencorte_operaciones D on A.tbl_cordencorte_operaciones_id=D.tbl_OrdenCorte_operaciones
LEFT JOIN cat_operaciones E on D.cat_operaciones_id = E.cat_operaciones_id
LEFT JOIN tbl_ordencorte_bultos F on D.cat_ordencorte_bultos_id=F.tbl_OrdenCorte_bultos_id
where A.tbl_reportediario_id = ? order by B.numero_corte, operacion, F.num_bulto LIMIT ?, ?";
            return $this->db->query($sql, array((int) $tbl_reportediario_id, (int) $start, (int) $length))->result();
        }else{
            $sql="SELECT A.tbl_reportediario_detalle_id, B.numero_corte, C.nombre_corto, F.num_bulto, 
IFNULL(E.operacion,'S01') as operacion, IFNULL(E.descripcion,'SABADOS') as descripcion, A.cantidad, 
A.tbl_cordencorte_operaciones_id, A.tbl_ordencorte_bultos_id
FROM tbl_reportediario_detalle A
INNER JOIN tbl_ordencorte B on A.tbl_ordencorte_id=B.tbl_OrdenCorte_id
INNER JOIN tbl_clientes C on B.cat_clientes_id=C.tbl_clientes_id
LEFT JOIN tbl_ordencorte_operaciones D on A.tbl_cordencorte_operaciones_id=D.tbl_OrdenCorte_operaciones
LEFT JOIN cat_operaciones E on D.cat_operaciones_id = E.cat_operaciones_id
LEFT JOIN tbl_ordencorte_bultos F on D.cat_ordencorte_bultos_id=F.tbl_OrdenCorte_bultos_id
where A.tbl_reportediario_id = ? order by B.numero_corte, operacion, F.num_bulto";
            return $this->db->query($sql, array((int) $tbl_reportediario_id))->result();
        }
    }

    function ifExistOper($cat_rh_empleado_id,$fecha_reporte_i){
        $this->db->where('cat_rh_empleado_id',$cat_rh_empleado_id)->where('fecha_reporte_i',$fecha_reporte_i);
        $r = $this->db->get('tbl_reportediario');

        if($r->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function ifExistS01($id_reporte){
        $this->db->where('tbl_reportediario_id',$id_reporte)->where('tbl_cordencorte_operaciones_id',0);
        $r = $this->db->get('tbl_reportediario_detalle');

        if($r->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function existencia($tbl_ordencorte_bultos_id){
        $this->db->select('resta')->where('tbl_OrdenCorte_bultos_id',$tbl_ordencorte_bultos_id);
        $r = $this->db->get("tbl_ordencorte_bultos")->result();
        return $r;
    }

    function existenciaOp($data){
        $this->db->select('sum(resta) as resta');
        $this->db->where_in('tbl_OrdenCorte_operaciones', $data);
        $this->db->group_by('cat_operaciones_id');
        $r = $this->db->get("tbl_ordencorte_operaciones")->result();
        return $r;
    }

    function existenciaBulto($bultoId){
        $this->db->select('resta');
        $this->db->where('tbl_OrdenCorte_operaciones', $bultoId);
        $r = $this->db->get("tbl_ordencorte_operaciones")->result();
        return $r;
    }

    function AddReporte($data){
        $this->db->trans_begin();

        $this->db->insert('tbl_reportediario', $data);
        $insert_id = $this->db->insert_id();

        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $insert_id;
        }
    }

    function AddReporte2($id_reporte, $data,$n,$tbl_ordencorte_bultos_id,$newResta = 0){
        $this->db->trans_begin();

        $this->db->insert_batch('tbl_reportediario_detalle', $data);

        if($n==1){
            for($i=0;$i<$n;$i++){
                if((int)$tbl_ordencorte_bultos_id[$i]!=0){
                    $data4 = array(
                        'resta' => $newResta,
                    );
                    $this->db->where('tbl_OrdenCorte_operaciones', $tbl_ordencorte_bultos_id[$i]);
                    $this->db->update('tbl_ordencorte_operaciones', $data4);
                }
            }
        }else{
            for($i=0;$i<$n;$i++){
                if((int)$tbl_ordencorte_bultos_id[$i]!=0){
                    $data4 = array(
                        'resta' => 0,
                    );
                    $this->db->where('tbl_OrdenCorte_operaciones', $tbl_ordencorte_bultos_id[$i]);
                    $this->db->update('tbl_ordencorte_operaciones', $data4);
                }
            }
        }


        if ($this->db->trans_status() === FALSE)
        {
            $this->db->trans_rollback();
            return false;
        }
        else
        {
            $this->db->trans_commit();
            return $id_reporte;
        }
    }

    function addHorasExtras($data,$tbl_reporteDiario_id){
        $this->db->where('tbl_reporteDiario_id', $tbl_reporteDiario_id);
        $res = $this->db->update('tbl_reportediario', $data);

        return $res;
    }

    function getDataReporte($idReporte){
        $this->db->select("A.*, B.NombreC, B.departamento");
        $this->db->from("tbl_reportediario A")->join("empleados_view B","A.cat_rh_empleado_id=B.cat_rh_empleado_id");
        $this->db->where('tbl_reporteDiario_id',$idReporte);
        return $this->db->get()->result();
    }

    function getDetalleR($idReporte){
        $this->db->select("A.tbl_reportediario_id, B.numero_corte, C.nombre_corto, F.num_bulto, E.operacion, E.descripcion, A.cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("tbl_ordencorte B","A.tbl_ordencorte_id=B.tbl_OrdenCorte_id");
        $this->db->join("tbl_clientes C","B.cat_clientes_id=C.tbl_clientes_id");
        $this->db->join("tbl_ordencorte_operaciones D","A.tbl_cordencorte_operaciones_id=D.tbl_OrdenCorte_operaciones");
        $this->db->join("cat_operaciones E","D.cat_operaciones_id = E.cat_operaciones_id");
        $this->db->join("tbl_ordencorte_bultos F","D.cat_ordencorte_bultos_id=F.tbl_OrdenCorte_bultos_id");
        $this->db->where('tbl_reportediario_id',$idReporte);
        $this->db->order_by("B.numero_corte, E.cat_operaciones_id, F.num_bulto", "asc");
        $query1 = $this->db->get()->result();

        $this->db->select("A.tbl_reportediario_id, '' AS numero_corte, '' AS nombre_corto, '' AS num_bulto, B.operacion, B.descripcion, A.cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("cat_operaciones B","B.operacion='S01'");
        $this->db->where("tbl_reportediario_id",$idReporte)->where("tbl_cordencorte_operaciones_id",0);
        $query2 = $this->db->get()->result();

        $query = array_merge($query1, $query2);


        return $query;
    }

    function getDataRecibo($idReporte){
        $this->db->select("C.operacion, C.tarifa_con, sum(A.cantidad) as cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("tbl_ordencorte_operaciones B","A.tbl_cordencorte_operaciones_id=B.tbl_OrdenCorte_operaciones");
        $this->db->join("cat_operaciones C","B.cat_operaciones_id=C.cat_operaciones_id");
        $this->db->where('tbl_reportediario_id',$idReporte);
        $this->db->group_by('C.operacion');
        $this->db->order_by("C.operacion", "asc");
        $query1 = $this->db->get()->result();

        $this->db->select("B.operacion, B.tarifa_con, A.cantidad as cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("cat_operaciones B","B.operacion='S01'");
        $this->db->where("tbl_reportediario_id",$idReporte)->where("tbl_cordencorte_operaciones_id",0);
        $query2 = $this->db->get()->result();

        $query = array_merge($query1, $query2);


        return $query;
    }

    function getHorasExtras($id){
        $this->db->select("he");
        $this->db->where('tbl_reporteDiario_id',$id);
        return $this->db->get("tbl_reportediario")->result();
    }

    function deleteOperacion($idReporteDetalle,$idOperacion,$sum){

        $this->db->delete('tbl_reportediario_detalle', array('tbl_reportediario_detalle_id' => $idReporteDetalle));

        $data = array(
            'resta' => $sum
        );
        $this->db->where('tbl_OrdenCorte_operaciones', $idOperacion);
        $res = $this->db->update('tbl_ordencorte_operaciones', $data);

        return $res;

    }

}