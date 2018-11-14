<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Puestos_model extends CI_Model
{
	function obtenter_todos()
    {
		$this->db->where("estatus",TRUE);
		return $this->db->get("cat_rh_puesto")->result();		
	}
	function updatePuesto($idEmpleado, $data){
		if(empty($idEmpleado)){
			return FALSE;
		}

		$this->db->set($data);
		$this->db->where("cat_rh_puesto_id", $idEmpleado);
		$res = $this->db->update("cat_rh_puesto");
		return $res;
	}


	function addPuesto($data){
		$res = $this->db->insert("cat_rh_puesto",$data);
		return $res;
	}

	function deletePuesto($id){
		$data = array(
			"estatus" => false 
		);
		$this->db->set($data);
		$this->db->where("cat_rh_puesto_id", $id);
		$res = $this->db->update("cat_rh_puesto");
		
		return $res;

	}
}