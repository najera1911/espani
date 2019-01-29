<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reportes_model extends CI_Model{

    function ReporteOC($idCorte,$start,$length){

        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->select("C.numero_corte,c.fecha_orden,C.modelo,D.nombre_corto,B.num_bulto,E.tipoCorte,E.operacion,E.descripcion,A.cantidad,A.resta");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("tbl_ordencorte_bultos B","A.cat_ordencorte_bultos_id=B.tbl_OrdenCorte_bultos_id");
        $this->db->join("tbl_ordencorte C","A.tbl_ordencorte_id = C.tbl_OrdenCorte_id");
        $this->db->join("tbl_clientes D","C.cat_clientes_id=D.tbl_clientes_id");
        $this->db->join("cat_operacion_view E","A.cat_operaciones_id = E.cat_operaciones_id");
        $this->db->where("A.tbl_ordencorte_id",$idCorte);
        $this->db->order_by('E.operacion,B.num_bulto');
        return $this->db->get()->result();
    }

    function ReporteOCSearch($idCorte,$start,$length,$value,$column){
        $this->db->like($column, $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->select("C.numero_corte,c.fecha_orden,C.modelo,D.nombre_corto,B.num_bulto,E.tipoCorte,E.operacion,E.descripcion,A.cantidad,A.resta");
        $this->db->from("tbl_ordencorte_operaciones A");
        $this->db->join("tbl_ordencorte_bultos B","A.cat_ordencorte_bultos_id=B.tbl_OrdenCorte_bultos_id");
        $this->db->join("tbl_ordencorte C","A.tbl_ordencorte_id = C.tbl_OrdenCorte_id");
        $this->db->join("tbl_clientes D","C.cat_clientes_id=D.tbl_clientes_id");
        $this->db->join("cat_operacion_view E","A.cat_operaciones_id = E.cat_operaciones_id");
        $this->db->where("A.tbl_ordencorte_id",$idCorte);
        $this->db->order_by('E.operacion,B.num_bulto');
        return $this->db->get()->result();
    }

    function ReporteOperacion($idCorte,$start,$length){

        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->select("F.numero_corte,G.nombre_corto,E.num_bulto,H.tipoCorte,H.operacion,H.descripcion, C.NombreC,C.departamento,B.fecha_reporte_i,A.cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("tbl_reportediario B","A.tbl_reportediario_id=B.tbl_reporteDiario_id");
        $this->db->join("empleados_view C","B.cat_rh_empleado_id=C.cat_rh_empleado_id");
        $this->db->join("tbl_ordencorte_operaciones D","A.tbl_cordencorte_operaciones_id = D.tbl_OrdenCorte_operaciones");
        $this->db->join("tbl_ordencorte_bultos E","D.cat_ordencorte_bultos_id=E.tbl_OrdenCorte_bultos_id");
        $this->db->join("tbl_ordencorte F","D.tbl_ordencorte_id = F.tbl_OrdenCorte_id");
        $this->db->join("tbl_clientes G","F.cat_clientes_id=G.tbl_clientes_id");
        $this->db->join("cat_operacion_view H","D.cat_operaciones_id = H.cat_operaciones_id");
        $this->db->where("A.tbl_ordencorte_id",$idCorte);
        $this->db->order_by('H.operacion, E.num_bulto');
        return $this->db->get()->result();
    }

    function ReporteOperacionSearch($idCorte,$start,$length,$value,$column){
        $this->db->like($column, $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        $this->db->select("F.numero_corte,G.nombre_corto,E.num_bulto,H.tipoCorte,H.operacion,H.descripcion, C.NombreC,C.departamento,B.fecha_reporte_i,A.cantidad");
        $this->db->from("tbl_reportediario_detalle A");
        $this->db->join("tbl_reportediario B","A.tbl_reportediario_id=B.tbl_reporteDiario_id");
        $this->db->join("empleados_view C","B.cat_rh_empleado_id=C.cat_rh_empleado_id");
        $this->db->join("tbl_ordencorte_operaciones D","A.tbl_cordencorte_operaciones_id = D.tbl_OrdenCorte_operaciones");
        $this->db->join("tbl_ordencorte_bultos E","D.cat_ordencorte_bultos_id=E.tbl_OrdenCorte_bultos_id");
        $this->db->join("tbl_ordencorte F","D.tbl_ordencorte_id = F.tbl_OrdenCorte_id");
        $this->db->join("tbl_clientes G","F.cat_clientes_id=G.tbl_clientes_id");
        $this->db->join("cat_operacion_view H","D.cat_operaciones_id = H.cat_operaciones_id");
        $this->db->where("A.tbl_ordencorte_id",$idCorte);
        $this->db->order_by('H.operacion, E.num_bulto');
        return $this->db->get()->result();
    }

}