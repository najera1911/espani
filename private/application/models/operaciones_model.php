<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operaciones_model extends CI_Model
{



    public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    public function obtener_todos()
    {
		$this->db->where("estatus",TRUE);
		return $this->db->get("cat_operacion_view")->result();
    }
	function updateOperacion($idEmpleado, $data){
		if(empty($idEmpleado)){
		return FALSE;
		}
		$this->db->set($data);
		$this->db->where("cat_operaciones_id", $idEmpleado);
		$res = $this->db->update("cat_operaciones");
		return $res;
	}
	function addOperacion($data){
		$res = $this->db->insert("cat_operaciones",$data);
		return $res;
	}

	function deleteOperacion($id){
		$data = array(
		    "estatus" => false
		);
		$this->db->set($data);
		$this->db->where("cat_operaciones_id", $id);
		$res = $this->db->update("cat_operaciones");
		return $res;
	}

    public function obtener_tipoCorte()
    {
        $this->db->where("estatus",TRUE);
        return $this->db->get("cat_tipo_corte")->result();
    }

    function updateTipoCorte($idEmpleado, $data){
        if(empty($idEmpleado)){
            return FALSE;
        }

        $this->db->set($data);
        $this->db->where("cat_tipo_corte_id", $idEmpleado);
        $res = $this->db->update("cat_tipo_corte");
        return $res;
    }


    function addTipoCorte($data){
        $res = $this->db->insert("cat_tipo_corte",$data);
        return $res;
    }

    function deleteTipoCorte($id){
        $data = array(
            "estatus" => false
        );
        $this->db->set($data);
        $this->db->where("cat_tipo_corte_id", $id);
        $res = $this->db->update("cat_tipo_corte");
        return $res;
    }

    function catTipoCorte(){
        $this->db->select("cat_tipo_corte_id as id, descripcion as nombre,'' as txt")->where('estatus',true);
        return $this->db->get("cat_tipo_corte")->result();
    }

}