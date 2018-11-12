<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operaciones_model extends CI_Model
{
	function obtenter_todos()
    {
		$this->db->where("cat_operaciones_id",TRUE);
		return $this->db->get("cat_operaciones")->result();		
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
		"cat_operaciones_id" => false 
		);
		$this->db->set($data);
		$this->db->where("cat_operaciones_id", $id);
		$res = $this->db->update("cat_operaciones");
		return $res;
	}
}