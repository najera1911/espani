<?php defined('BASEPATH') OR exit('No direct script access allowed');

    if(!function_exists('is_empty')) {

        /**
         * @param $var
         * @param bool $allow_false permite valores binarios, es decir:  is_empty(FALSE) == true pero con esta activado
         * is_empty(FALSE) == false
         * @param bool $allow_ws  permite strings vacías
         * @return bool
         */
        function is_empty($var, $allow_false = FALSE, $allow_ws = FALSE)
        {
            if (!isset($var) || is_null($var) || ($allow_ws == FALSE && trim($var) == "" && !is_bool($var)) || ($allow_false === FALSE && is_bool($var) && $var === FALSE) || (is_array($var) && empty($var))) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
    
class Acl
{
    var $perms = array(); //Array : Stores the permissions for the user
    var $userID; //Integer : Stores the ID of the current user
    var $userRoles = array(); //Array : Stores the roles of the current user
    var $ci;

    function __construct($config = array())
    {
        $this->ci = &get_instance();
        if($this->ci->session->userdata('isLoggedIn')) {
            if (is_array($config) && isset($config['userID'])) {
                $this->userID    = floatval($config['userID']);
                $this->userRoles = $this->getUserRoles();
                $this->buildACL();
            }
        }
    }
    function setUserId($id){
        $this->userID = floatval($id);
        $this->userRoles = $this->getUserRoles();
        $this->buildACL();
    }

    function buildACL()
    {
        //first, get the rules for the user's role, always have role
//        if (count($this->userRoles) > 0) {
        if(!empty($this->userID)) {

            $this->perms = array_merge($this->perms, $this->getRolePerms($this->userRoles));
            //        }
            //then, get the individual user permissions
            $this->perms = array_merge($this->perms, $this->getUserPerms($this->userID));
        }/*else{
            var_dump($this->userID);
            var_dump($this->userRoles);
            exit(2);
        }*/
        if(count($this->perms) <= 0){
            /**  ooHH mFG   this user has no perms so.... please kick ass*/
            $this->ci->session->unset_userdata('isLoggedIn');
            $this->ci->session->sess_destroy();
        }
    }


    //-----CAT_PERMISOS

    /**
     * Obtener la clave del permiso
     * @param int $permID el permiso ID
     * @return
     */
    function getPermKeyFromID($permID)
    {
        //$strSQL = "SELECT `permKey` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $this->ci->db->select('clave');
        $this->ci->db->where('cat_permiso_id', floatval($permID));
        $sql = $this->ci->db->get('cat_permiso', 1);
        $data = $sql->result();
        return $data[0]->clave;
    }

    /**
     * Obtener la descripción del permiso
     * @param int $permID
     * @return mixed
     */
    function getPermNameFromID($permID)
    {
        //$strSQL = "SELECT `permName` FROM `".DB_PREFIX."permissions` WHERE `ID` = " . floatval($permID) . " LIMIT 1";
        $this->ci->db->select('descripcion');
        $this->ci->db->where('cat_permiso_id', floatval($permID));
        $sql = $this->ci->db->get('cat_permiso', 1);
        $data = $sql->result();
        return $data[0]->descripcion;
    }
    //-----CAT_PERMISOS

    //-----CAT_PERFILES
    /**
     * Obtener la descripción del perfil
     * @param int $roleID
     * @return
     */
    function getRoleNameFromID($roleID)
    {
        //$strSQL = "SELECT `roleName` FROM `".DB_PREFIX."roles` WHERE `ID` = " . floatval($roleID) . " LIMIT 1";
        $this->ci->db->select('descripcion');
        $this->ci->db->where('cat_perfil_id', floatval($roleID), 1);
        $sql = $this->ci->db->get('cat_perfil');
        $data = $sql->result();
        return $data[0]->descripcion;
    }




    /**
     * Obtener los perfiles del usuario que inicia sesión
     * @return array un arreglo de todos los perfiles que tiene el usuario actual
     */
    function getUserRoles()
    {
        //$strSQL = "SELECT * FROM `".DB_PREFIX."user_roles` WHERE `userID` = " . floatval($this->userID) . " ORDER BY `addDate` ASC";
        $this->ci->db->where("cat_usuario_id",floatval($this->userID));
        $sql = $this->ci->db->get('cat_usuario');
        $data = $sql->result();


        $resp = array();
        foreach ($data as $row) {
            $resp[] = $row->cat_perfil_id;
        }
        return $resp;
    }


    /**
     * Obtener todos los perfiles existentes, por defecto solo regresa los ID's,
     * @param string $format posibles valores (ids||full)
     * @return array
     */
    function getAllRoles($format = 'ids')
    {
        $format = strtolower($format);
        //$strSQL = "SELECT * FROM `".DB_PREFIX."roles` ORDER BY `roleName` ASC";
        $this->ci->db->order_by('descripcion', 'asc');
        $sql = $this->ci->db->get('cat_perfil');
        $data = $sql->result();

        $resp = array();
        foreach ($data as $row) {
            if ($format == 'full') {
                $resp[] = array("id" => $row->cat_perfil_id, "name" => $row->descripcion);
            } else {
                $resp[] = $row->cat_perfil_id;
            }
        }
        return $resp;
    }
    /**-----CAT_PERMISOS*/

    /**-----CAT_PERMISOS*/

    /**
     * Obtener todos los permisos existentes
     * @param string $format posibles valores (ids||full)
     * @return array
     */
    function getAllPerms($format = 'ids')
    {
        $format = strtolower($format);
        //$strSQL = "SELECT * FROM `".DB_PREFIX."permissions` ORDER BY `permKey` ASC";

        $this->ci->db->order_by('clave', 'asc');
        $sql = $this->ci->db->get('cat_permiso');
        $data = $sql->result();

        $resp = array();
        foreach ($data as $row) {
            if ($format == 'full') {
                $resp[$row->clave] = array('id' => $row->cat_permiso_id, 'name' => $row->descripcion, 'key' => $row->clave);
            } else {
                $resp[] = $row->cat_permiso_id;
            }
        }
        return $resp;
    }


    /**
     * OBTENER LOS PERMISOS DEL PERFIL O PERFILES EN ESPECIFICO
     * @param $role array||int
     * @return array
     */
    function getRolePerms($role)
    {
        if (is_array($role)) {
            //$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` IN (" . implode(",",$role) . ") ORDER BY `ID` ASC";
            $this->ci->db->where_in('cat_perfil_id', $role);
        } else {
            //$roleSQL = "SELECT * FROM `".DB_PREFIX."role_perms` WHERE `roleID` = " . floatval($role) . " ORDER BY `ID` ASC";
            $this->ci->db->where('cat_perfil_id',floatval($role));
        }

        $this->ci->db->order_by('cat_permiso_id', 'asc');
        $sql = $this->ci->db->get('cat_perfil_permiso'); //$this->db->select($roleSQL);
        $data = $sql->result();
        $perms = array();
        foreach ($data as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->cat_permiso_id));
            if ($pK == '') {
                continue;
            }


            $perms[$pK] = ['perm'       => $pK,
                           'inheritted' => TRUE,
                           'value'      => TRUE,
                           'name'       => $this->getPermNameFromID($row->cat_permiso_id),
                           'id'         => $row->cat_permiso_id];
        }
        return $perms;
    }


    /**
     * Obtener los permisos de un usuario
     * @param $userID
     * @return array
     */
    function getUserPerms($userID)
    {
        //$strSQL = "SELECT * FROM `".DB_PREFIX."user_perms` WHERE `userID` = " . floatval($userID) . " ORDER BY `addDate` ASC";

        $this->ci->db->where('cat_usuario_id', floatval($userID));
        $sql = $this->ci->db->get('cat_usuario_permiso');
        $data = $sql->result();

        $perms = array();
        foreach ($data as $row) {
            $pK = strtolower($this->getPermKeyFromID($row->cat_permiso_id));
            if ($pK == '') {
                continue;
            }

            $perms[$pK] = ['perm'       => $pK,
                           'inheritted' => FALSE,
                           'value'      => TRUE,
                           'name'       => $this->getPermNameFromID($row->cat_permiso_id),
                           'id'         => $row->cat_permiso_id];
        }


        return $perms;
    }

    function hasRole($roleID)
    {
        foreach ($this->userRoles as $k => $v) {
            if (floatval($v) === floatval($roleID)) {
                return true;
            }
        }
        return false;
    }

    function hasPermission($permKey)
    {
//       var_dump($this->perms);
        
        $permKey = strtolower($permKey);

        if (array_key_exists($permKey, $this->perms)) {
            if ($this->perms[$permKey]['value'] === '1' || $this->perms[$permKey]['value'] === TRUE) {
                return true;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }
}