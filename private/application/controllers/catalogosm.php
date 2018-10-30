<?php defined('BASEPATH') OR exit('No direct script access allowed');
date_default_timezone_set('America/Mexico_City');

class Catalogosm extends CI_Controller {

    public function __construct(){
        parent::__construct();
    }
    
    
    function index($pagina = ''){
        if (!file_exists(VIEWPATH . 'catalogosm/vw_' . $pagina . '.php')) {
            show_404();
        }

        $this->load->view('catalogosm/vw_' . $pagina);
    }
    
}