<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Perdida extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Perdida_model');
        $this->session_data = $this->session->userdata('logged_in');
    }
    
    /* busca y recupera todas las perdidas de una platabanda */
    function get_perdidas()
    {
        //if($this->acceso(118)){
            if ($this->input->is_ajax_request()) {
                $detproduccion_id = $this->input->post("detproduccion_id");
                $datos = $this->Perdida_model->get_perdidas_platabanda($detproduccion_id);
                echo json_encode($datos);
            }else{
                show_404();
            }
        //}
    }
}
