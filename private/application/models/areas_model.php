<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas_model extends CI_Model
{
   
    function obtenter_todos()
    {
		return $this->db->get("cat_rh_departamento")->result();		
    }

}
