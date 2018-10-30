<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Catpuesto extends CI_Controller {

    public function __construct()
    {
        parent::__construct();
        $this->load->helper('url');
        $this->load->model('puesto_model');
    }

    public function index()
    {
        $data['obtner_todos']=$this->puesto_model->obtner_todos();
        $this->load->view('puesto_view',$data);
    }
    public function insertar_puesto()
		{
			$data = array(
					'descripcion' => $this->input->post('descripcion'),
					'estatus' => $this->input->post('estatus'),
				);
			$insert = $this->puesto_model-> insertar_puesto($data);
			echo json_encode(array("status" => TRUE));
        }
     public function ajax_edit($id)
		{
			$data = $this->puesto_model->get_by_id($id);
			echo json_encode($data);
        }
    public function actualizar_puesto()
        {
            $data = array(
                    'descripcion' => $this->input->post('descripcion'),
                    'estatus' => $this->input->post('estatus'),
                );
            $this->puesto_model->actualizar(array('cat_rh_puesto_id' => $this->input->post('cat_rh_puesto_id')), $data);
            echo json_encode(array("status" => TRUE));
        }
    public function borrar_puesto($id)
        {
            $this->puesto_model->eliminar($id);
            echo json_encode(array("status" => TRUE));
        }

}