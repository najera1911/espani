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
}