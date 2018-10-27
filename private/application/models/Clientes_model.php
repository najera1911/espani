<?php
class Clientes_model extends CI_Model{

    function addClient($data){
        $res = $this->db->insert('tbl_clientes',$data);
        $lastId = $res?$this->db->insert_id():$res;
        return $lastId;
    }

    function updateClient($id, $data){
        if(empty($id)){
            return FALSE;
        }
        $this->db->where('tbl_clientes_id', $id);
        $res = $this->db->update('tbl_clientes',$data);
        return $res;
    }
}