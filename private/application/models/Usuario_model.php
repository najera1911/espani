<?php

    /**
     * Created by REPSS Hidalgo.
     * User: Ulises Darío Martínez Salinas
     * Contact: ulises[dot]salinas[at]gmail[dot]com
     * Date: 14/07/2017
     * Time: 06:48 PM
     * @property CI_DB_query_builder db
     * @property CI_Session session
     */
    class Usuario_model extends CI_Model
    {
        function validar_usuario($usr, $psw){
            $this->db->where('usuario', $usr)->where('estatus',1)->select('clave, cat_usuario_id as id');
            $res = $this->db->get('cat_usuario');
            if($res->num_rows()>0){
                $row = $res->row();
                if(password_verify($psw, $row->clave )){
                    $res = $this ->db->where('cat_usuario_id', $row->id)->get('usuario_view');
                    if($res->num_rows()>0){
                        $this->iniciar_sesion($res->row());
                        return $res;
                    }else{
                        return FALSE;
                    }         
                }else{
                    return FALSE;
                }

            }else{
                return FALSE;
            }

        }

        function iniciar_sesion($empleado){
            $this->session->set_userdata([
                'isLoggedIn' => TRUE,
                'usuario' => $empleado->usuario,
                'idPerfil' => $empleado->cat_perfil_id,
                'idEmpleado' => $empleado->cat_usuario_id,
                'nombreCompleto' => $empleado->nombreC,
                'perfil' => $empleado->descripcion,
                'cambiarClave' => $empleado->cambiarClave,
                'idU' => $empleado->cat_usuario_id,
                'area' => $empleado->area
            ]);
        }

        function existe_usuario($usuario){
            $this->db->where('usuario',$usuario);
            $r = $this->db->get('usuario_view');

            if($r->num_rows()>0){
                return $r->row();
            }else{
                return FALSE;
            }

        }

        //Añade a los empleados 
        function add_usuario($data){
            if(isset($data['id']) && !empty($data['id'])){
                return $data['id'];
            }

            $existe = $this->existe_usuario($data['usuario']);

            if(! $existe){
                $params= [
                    "apellido_paterno" => $data['paterno'],
                    "apellido_materno" => $data['materno'],
                    "nombre"          => $data['nombre'],
                    "profesion_cedula"=> ($data['cedula']?$data['cedula']:NULL),
                    "fh_nacimiento"   => ($data['fh_nacimiento']?$data['fh_nacimiento'] :(date('Y-m-d'))),
                    "usuario"         => ($data['usuario']?$data['usuario']:NULL),
                    "clave"           => password_hash($data['clave'], PASSWORD_BCRYPT, ['cost' => 11]),
                    "cambia_clave"    => FALSE,
                    "cat_area_id"     => $data['idArea'],
                    "cat_perfil_id"   => $data['idPerfil'],
                    "sexo"            => ($data['sexo']?$data['sexo']: NULL),
                ];

                $r = $this->db->insert('cat_empleado', $params);
                if($r){
                    return $this->db->insert_id();
                }else{
                    return FALSE;
                }
            }else{
                return $existe->idEmpleado;
            }
        }

        function set_usuario($params){

            if(!is_array($params)){
                return FALSE;
            }

            if( empty($params['id']) ){

                return $this->add_usuario($params);

            }else{

                if(isset($params['usuario']) && ! empty($params['usuario'])){
                    $user =$this->existe_usuario($params['usuario']);
                    if($user) {
                        if ($user->idEmpleado != $params['id']) {
                            echo "Nombre de usuario ya existe. ";
                            return FALSE;
                        }
                    }
                }

                $this->db->where('cat_usuario_id', $params['id']);

                if(isset($params['paterno'])){
                    $this->db->set('apellido_p', $params['paterno']);
                }
                if(isset($params['materno'])){
                    $this->db->set('apellido_m', $params['materno']);
                }
                if(isset($params['estatus'])){
                    $this->db->set('estatus', $params['estatus']);
                }
                if(isset($params['usuario'])){
                    $this->db->set('usuario', $params['usuario']);
                }
                if(isset($params['clave'])){
                    $this->db->set('clave',password_hash($params['clave'], PASSWORD_BCRYPT, ['cost' => 11]));
                }
                if(isset($params['cambiaClave'])){
                    $this->db->set('cambia_clave', $params['cambiaClave']);
                }
                if(isset($params['sexo'])){
                    $this->db->set('sexo', $params['sexo']);
                }


                if(isset($params['fh_nacimiento'])){
                    $this->db->set('fh_nacimiento', $params['fh_nacimiento'] );
                }

                    if($this->db->update('cat_usuario')){
                        return   $params['id']  ;
                    }else{
                        return FALSE;
                    }

            }


        }

        /**
         * Devuelve los usuarios haciendo uso de la vista
         * @param array|null $where un array de forma ('columna' => 'valor'),
         *        en columna se puede especificar la restricción: idEmpleado!=
         * @param string $select , una cadena donde se puede devolver una o varias columnas separadas por comas
         * @param string $table nombre de la tabla de consulta, por defecto es: empleado_vw
         * @return mixed devuelve FALSE en caso de error
         */
        function get_usuario($where=null, $select=null, $table = 'usuario_view'){
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

        function get_permisos_pefil($idPerfil){
            $sql = "select t1.descripcion as nombre, t1.cat_permiso_id as id, t1.clave from cat_perfil_permiso as t0 " .
                   "inner join cat_permiso as t1 on t1.cat_permiso_id = t0.cat_permiso_id where t0.cat_perfil_id = ? ".
                   "and t0.activo = 1 ";
//            var_dump($sql);

            return $this->db->query($sql, [$idPerfil])->result();

        }

        function get_permisos_empleado($idEmpleado){
            $sql = "select t1.descripcion as nombre, t1.cat_permiso_id as id, t1.clave, t0.activo from cat_empleado_permiso as t0 " .
                "inner join cat_permiso as t1 on t1.cat_permiso_id = t0.cat_permiso_id where t0.cat_perfil_id = ?";

            return $this->db->query($sql, [$idEmpleado])->result();
        }

    }