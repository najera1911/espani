<?php
class Clientes_model extends CI_Model{

    function get_clientes($start, $length, $where=null, $select=null, $table = 'clientes_view'){
        if(!empty($where))
            if(! is_array($where)){
                return FALSE;
            }
        if(!empty($select))
            $this->db->select($select);

        if(!empty($where))
            $this->db->where($where);

        if($length>=0){
            $this->db->limit($length,$start);
        }
        return $this->db->get($table)->result();
    }

    function  getClienteSearch($start, $length, $value, $column){
        $this->db->like($column, $value);
        if($length>=0){
            $this->db->limit($length,$start);
        }
        return $this->db->get('clientes_view')->result();
    }


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

    function deleteCliente($idEmpleado){
        $data = array(
            'estatus' => false,
            'fcha_baja' => date('Y-m-d')
        );
        $this->db->where('tbl_clientes_id', $idEmpleado);
        $res = $this->db->update('tbl_clientes', $data);

        return $res;
    }
}