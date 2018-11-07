<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Areas extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('areas_model');
    }
    public function index()
    {
        $data['obtner_todos']=$this->areas_model->obtner_todos();
        $this->load->view('areas_view',$data);
    }
    public function insertar_area()
		{
			$data = array(
					'descripcion' => $this->input->post('descripcion'),
					'estatus' => $this->input->post('estatus'),
				);
			$insert = $this->areas_model-> insertar_area($data);
			echo json_encode(array("status" => TRUE));
        }
     public function ajax_edit($id)
		{
			$data = $this->areas_model->get_by_id($id);
			echo json_encode($data);
        }
    public function actualizar_area()
        {
            $data = array(
                    'descripcion' => $this->input->post('descripcion'),
                    'estatus' => $this->input->post('estatus'),
                );
            $this->areas_model->actualizar(array('cat_rh_departamento_id' => $this->input->post('cat_rh_departamento_id')), $data);
            echo json_encode(array("status" => TRUE));
        }
    public function borrar_area($id)
        {
            $this->area_model->eliminar($id);
            echo json_encode(array("status" => TRUE));
        }    
}