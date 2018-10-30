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