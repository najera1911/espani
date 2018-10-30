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

}