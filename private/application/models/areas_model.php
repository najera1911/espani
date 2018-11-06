<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_model extends CI_Model
{
    var $table = 'cat_rh_departamento';

    public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    public function obtner_todos()
    {
        $this->db->from('cat_rh_departamento');
        $query=$this->db->get();
        return $query->result();
    }
    public function insertar_area($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
    }
    public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('cat_rh_departamento_id',$id);
		$query = $this->db->get();
		return $query->row();
    }
    public function actualizar($where, $data)
	{
		$this->db->update($this->table, $data, $where);
		return $this->db->affected_rows();
    }
    public function eliminar($id)
	{
		$this->db->where('cat_rh_departamento_id', $id);
		$this->db->delete($this->table);
	}

}
