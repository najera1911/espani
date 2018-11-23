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

    public function getModelosCorte(){
        $this->db->where("estatus",TRUE);
        return $this->db->get("cat_modelos_cortes")->result();
    }

    public function datosModelosCortesDetalle($idModel){
        $this->db->where("estatus",TRUE)->where("cat_modelos_cortes_id",$idModel);
        $this->db->order_by("cat_tipo_corte_id", "asc");
        return $this->db->get("modelos_cortes_view")->result();
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

    function existeNombre($descripcion){
        $this->db->where('descripcion',$descripcion);
        $r = $this->db->get('cat_modelos_cortes');

        if($r->num_rows()>0){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    function UpdateModeloCorte($id,$data, $myArray){
        $this->db->trans_begin();

        $this->db->where('cat_modelos_cortes_id', $id);
        $this->db->delete('cat_modelos_cortes_detalle');

        $this->db->set($data);
        $this->db->where("cat_modelos_cortes_id", $id);
        $this->db->update("cat_modelos_cortes");

        $dataDetalle= array();
        $longitud = count($myArray);
        for($i=0; $i<$longitud; $i++)
        {
            $array=array();
            $array['cat_modelos_cortes_id'] = $id;
            $array['cat_operaciones_id'] = (int) $myArray[$i];
            array_push($dataDetalle ,$array);
        }

        $this->db->insert_batch('cat_modelos_cortes_detalle', $dataDetalle);

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

    function addModeloCorte($data, $myArray){

        $this->db->trans_begin();

        $this->db->insert('cat_modelos_cortes', $data);
        $insert_id = $this->db->insert_id();

        $dataDetalle= array();
        $longitud = count($myArray);
        for($i=0; $i<$longitud; $i++)
        {
            $array=array();
            $array['cat_modelos_cortes_id'] = $insert_id;
            $array['cat_operaciones_id'] = (int) $myArray[$i];
            array_push($dataDetalle ,$array);
        }

        $this->db->insert_batch('cat_modelos_cortes_detalle', $dataDetalle);

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

}