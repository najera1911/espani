<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Nomina_model extends CI_Model{

    function getEmpleados(){
        $this->db->select("cat_rh_empleado_id AS id, CONCAT(departamento,' -',NombreC) as nombre,'' as txt");
        $this->db->where("estatus",1);
        return $this->db->get("empleados_view")->result();
    }

    function getEmpleadosData($idEmpleado){
        $this->db->select("cat_rh_empleado_id, departamento, puesto, NombreC");
        $this->db->where("estatus",1)->where("cat_rh_empleado_id",$idEmpleado);
        return $this->db->get("empleados_view")->result();
    }

    function getCortes(){
        $sql="SELECT DISTINCT A.tbl_OrdenCorte_id as id, concat(A.numero_corte,' - ',C.nombre_corto) as nombre,'' as txt 
FROM tbl_ordenCorte A
INNER join tbl_ordencorte_bultos B on a.tbl_OrdenCorte_id=B.tbl_ordencorte_id
INNER JOIN tbl_clientes C on A.cat_clientes_id=C.tbl_clientes_id
GROUP by A.tbl_OrdenCorte_id
HAVING sum(B.resta)>0";
        return $this->db->query($sql)->result();
    }

    function getBultos($idCorte){
        $this->db->select("tbl_OrdenCorte_bultos_id as id, concat('Bulto ', num_bulto) as nombre,'' as txt");
        $this->db->where("tbl_ordencorte_id",$idCorte)->where("resta>",0);
        return $this->db->get("tbl_ordencorte_bultos")->result();
    }

    function getOperaciones($idCorte,$idBulto){
        $this->db->select("A.tbl_ordencorte_operaciones as id, concat(B.operacion,' - ',B.descripcion,' - RESTAN ',A.resta) as nombre,'' as txt");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("cat_operaciones B","A.cat_operaciones_id=B.cat_operaciones_id");
        $this->db->where("tbl_ordencorte_id",$idCorte)->where('cat_ordencorte_bultos_id',$idBulto)->where("resta>",0);
        $query1 = $this->db->get()->result();

        $this->db->select("0 as id, concat(operacion,' - ', descripcion) as nombre, '' as txt");
        $this->db->where("operacion","S01");
        $query2 = $this->db->get("cat_operaciones")->result();

        $query = array_merge($query1, $query2);


        return $query;
    }

    function get_ReporteDiario($start,$length,$idEmpleado,$fecha_i,$fecha_f){
        $sql="SELECT tbl_reporteDiario_id, A.cat_rh_empleado_id, B.NombreC, B.puesto, b.departamento, A.fecha_reporte_i, A.fecha_reporte_f
FROM tbl_reportediario A
INNER JOIN empleados_view B on A.cat_rh_empleado_id = B.cat_rh_empleado_id
where A.cat_rh_empleado_id = ? and A.fecha_reporte_i BETWEEN ? and ? LIMIT ?, ?";
        return $this->db->query($sql, array((int) $idEmpleado, $fecha_i, $fecha_f,(int) $start, (int) $length))->result();
    }

    function getReporte($tbl_reportediario_id,$start,$length){
        $sql="SELECT B.numero_corte, C.nombre_corto, F.num_bulto, 
IFNULL(E.operacion,'S01') as operacion, IFNULL(E.descripcion,'SABADOS') as descripcion, A.cantidad
FROM tbl_reportediario_detalle A
INNER JOIN tbl_ordencorte B on A.tbl_ordencorte_id=B.tbl_OrdenCorte_id
INNER JOIN tbl_clientes C on B.cat_clientes_id=C.tbl_clientes_id
LEFT JOIN tbl_ordencorte_operaciones D on A.tbl_cordencorte_operaciones_id=D.tbl_OrdenCorte_operaciones
LEFT JOIN cat_operaciones E on D.cat_operaciones_id = E.cat_operaciones_id
INNER JOIN tbl_ordencorte_bultos F on A.tbl_ordencorte_bultos_id=F.tbl_OrdenCorte_bultos_id
where A.tbl_reportediario_id = ? LIMIT ?, ?";
        return $this->db->query($sql, array((int) $tbl_reportediario_id, (int) $start, (int) $length))->result();
    }

    function ifExistOper($cat_rh_empleado_id,$fecha_reporte_i,$fecha_reporte_f){
        $this->db->where('cat_rh_empleado_id',$cat_rh_empleado_id)->where('fecha_reporte_i>=',$fecha_reporte_i)->where('fecha_reporte_i<=',$fecha_reporte_i);
        $r = $this->db->get('tbl_reportediario');

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

    function existenciaOp($tbl_cordencorte_operaciones_id){
        $this->db->select('resta')->where('tbl_OrdenCorte_operaciones',$tbl_cordencorte_operaciones_id);
        $r = $this->db->get("tbl_ordencorte_operaciones")->result();
        return $r;
    }

    function AddReporte($data,$tbl_ordencorte_id,$tbl_ordencorte_bultos_id,$tbl_cordencorte_operaciones_id,$cantidad,$restaO){
        $this->db->trans_begin();

        $this->db->insert('tbl_reportediario', $data);
        $insert_id = $this->db->insert_id();

        $data2 = array(
            "tbl_reportediario_id" => $insert_id,
            "tbl_ordencorte_id" => $tbl_ordencorte_id,
            "tbl_ordencorte_bultos_id" => $tbl_ordencorte_bultos_id,
            "tbl_cordencorte_operaciones_id" => $tbl_cordencorte_operaciones_id,
            "cantidad" => $cantidad
        );

        $this->db->insert('tbl_reportediario_detalle', $data2);

        if((int)$tbl_cordencorte_operaciones_id!=99){
            $r2= (int) $restaO - (int) $cantidad;
            $data4 = array(
                'resta' => $r2,
            );

            $this->db->where('tbl_OrdenCorte_operaciones', $tbl_cordencorte_operaciones_id);
            $this->db->update('tbl_ordencorte_operaciones', $data4);

            $this->db->select('sum(resta)')->where('cat_ordencorte_bultos_id',$tbl_ordencorte_bultos_id);
            $r = $this->db->get("tbl_ordencorte_operaciones")->result();

            if($r===0){
                $data3 = array(
                    'resta' => 0,
                );

                $this->db->where('tbl_OrdenCorte_bultos_id', $tbl_ordencorte_bultos_id);
                $this->db->update('tbl_ordencorte_bultos', $data3);
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
            return $insert_id;
        }
    }

    function AddReporte2($id_reporte,$tbl_ordencorte_id,$tbl_ordencorte_bultos_id,$tbl_cordencorte_operaciones_id,$cantidad,$restaO){
        $this->db->trans_begin();

        $data2 = array(
            "tbl_reportediario_id" => $id_reporte,
            "tbl_ordencorte_id" => $tbl_ordencorte_id,
            "tbl_ordencorte_bultos_id" => $tbl_ordencorte_bultos_id,
            "tbl_cordencorte_operaciones_id" => $tbl_cordencorte_operaciones_id,
            "cantidad" => $cantidad
        );

        $this->db->insert('tbl_reportediario_detalle', $data2);

        if((int)$tbl_cordencorte_operaciones_id!=99){
            $r2= (int) $restaO - (int) $cantidad;
            $data4 = array(
                'resta' => $r2,
            );

            $this->db->where('tbl_OrdenCorte_operaciones', $tbl_cordencorte_operaciones_id);
            $this->db->update('tbl_ordencorte_operaciones', $data4);

            $this->db->select('sum(resta)')->where('cat_ordencorte_bultos_id',$tbl_ordencorte_bultos_id);
            $r = $this->db->get("tbl_ordencorte_operaciones")->result();

            if($r===0){
                $data3 = array(
                    'resta' => 0,
                );

                $this->db->where('tbl_OrdenCorte_bultos_id', $tbl_ordencorte_bultos_id);
                $this->db->update('tbl_ordencorte_bultos', $data3);
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

}