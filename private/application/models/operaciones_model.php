<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operaciones_model extends CI_Model
{

    var $table = 'cat_operaciones';

    public function __construct()
	{
		parent::__construct();
		$this->load->database();
    }
    public function obtner_todos()
    {
        $this->db->from('cat_operaciones');
        $query=$this->db->get();
        return $query->result();
    }
    public function insertar_operacion($data)
	{
		$this->db->insert($this->table, $data);
		return $this->db->insert_id();
    }
    public function get_by_id($id)
	{
		$this->db->from($this->table);
		$this->db->where('cat_operaciones_id',$id);
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
		$this->db->where('cat_operaciones_id', $id);
		$this->db->delete($this->table);
	}
}