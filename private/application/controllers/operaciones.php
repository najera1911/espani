<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Operaciones extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('operaciones_model');
    }
    public function index()
    {

        $data['obtner_todos']=$this->operaciones_model->obtner_todos();
        $this->load->view('operaciones_view',$data);  
    }
    public function insertar_operacion()
    {
        $data = array(
                'operaciones' => $this->input->post('operaciones'),
                'descripcion' => $this->input->post('descripcion'),
                'tarifa_con' => $this->input->post('tarifa_con'),
                'tarifa_sin' => $this->input->post('tarifa_sin'),
            );
        $insert = $this->puesto_model-> insertar_operacion($data);
        echo json_encode(array("descripcion" => TRUE));
    }
    public function ajax_edit($id)
    {
        $data = $this->oepraciones_model->get_by_id($id);
        echo json_encode($data);
    }
    public function actualizar_operacion()
        {
            $data = array(
                'operaciones' => $this->input->post('operaciones'),
                'descripcion' => $this->input->post('descripcion'),
                'tarifa_con' => $this->input->post('tarifa_con'),
                'tarifa_sin' => $this->input->post('tarifa_sin'),
                );
            $this->puesto_model->actualizar(array('cat_operaciones_id' => $this->input->post('cat_rh_puesto_id')), $data);
            echo json_encode(array("descripcion" => TRUE));
        }
    public function borrar_operacion($id)
        {
            $this->operciones_model->eliminar($id);
            echo json_encode(array("descripcion" => TRUE));
        }
     
}