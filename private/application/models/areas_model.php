<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_model extends CI_Model
{
   
    function obtenter_todos()
    {
		$this->db->where("estatus",TRUE);
		return $this->db->get("cat_rh_departamento")->result();		
	}
	function updateArea($idEmpleado, $data){
		if(empty($idEmpleado)){
			return FALSE;
		}

		$this->db->set($data);
		$this->db->where("cat_rh_departamento_id", $idEmpleado);
		$res = $this->db->update("cat_rh_departamento");
		
		return $res;
	}
	function addArea($data){
		$res = $this->db->insert("cat_rh_departamento",$data);
		return $res;
	}
	function deleteArea($id){
		$data = array(
			"estatus" => false 
		);
		$this->db->set($data);
		$this->db->where("cat_rh_departamento_id", $id);
		$res = $this->db->update("cat_rh_departamento");
		
		return $res;
	}
}
