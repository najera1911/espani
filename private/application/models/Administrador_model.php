<?php
class Administrador_model extends CI_Model{

    function get_user($where=null, $select=null, $table = 'usuario_view'){
        if(!empty($where))
            if(! is_array($where)){
                return FALSE;
            }
        if(!empty($select))
            $this->db->select($select);

        if(!empty($where))
            $this->db->where($where);

        return $this->db->get($table)->result();
    }

    function catPerfil(){
        $this->db->select("cat_perfil_id as id, descripcion as nombre,'' as txt")->where('cat_perfil_id >',1);
        return $this->db->get("cat_perfil")->result();
    }

    function addUser($data){
        $res = $this->db->insert('cat_usuario',$data);
        $lastId = $res?$this->db->insert_id():$res;
        return $lastId;
    }

    function updateUser($id, $data){
        if(empty($id)){
            return FALSE;
        }

        $this->db->where('cat_usuario_id', $id);
        $res = $this->db->update('cat_usuario',$data);

        return $res;
    }

    function deleteUser($idEmpleado){
        $data = array(
            'estatus' => false,
            'fcha_baja' => date('Y-m-d')
        );
        $this->db->where('cat_usuario_id', $idEmpleado);
        $res = $this->db->update('cat_usuario', $data);

        return $res;
    }

}