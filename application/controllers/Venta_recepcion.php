<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com.
 */
 
class Venta_recepcion extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Venta_model');
        $this->load->model('Categoria_trabajo_model');
        if ($this->session->userdata('logged_in')) {
            $this->session_data = $this->session->userdata('logged_in');
        }else {
            redirect('', 'refresh');
        }
    }
    /* *****Funcion que verifica el acceso al sistema**** */
    private function acceso($id_rol){
        $rolusuario = $this->session_data['rol'];
        if($rolusuario[$id_rol-1]['rolusuario_asignado'] == 1){
            return true;
        }else{
            $data['_view'] = 'login/mensajeacceso';
            $this->load->view('layouts/main',$data);
        }
    } 

    /*
     * Listing of venta
     */
    function index()
    {

        if($this->acceso(12)){
        //**************** inicio contenido ***************

        //$data['venta'] = $this->Venta_model->get_all_venta($params);
        $data['page_title'] = "Pedido";
        $data['trabajos'] = $this->Categoria_trabajo_model->get_all_categoria_trabajo();
        
        $usuario_id = $this->session_data['usuario_id'];
        $data['usuario_id'] = $usuario_id;
        
        $data['_view'] = 'venta_recepcion/index';
        $this->load->view('layouts/main',$data);
        
        //**************** fin contenido ***************
		}
    }
    
    function venta_proceso()
    {
        if($this->acceso(12)){
            //**************** inicio contenido ***************
            $usuario_id = $this->session_data['usuario_id'];
            $data['ventas'] = $this->Venta_model->get_detalle_auxfoto($usuario_id);
            $data['trabajos'] = $this->Categoria_trabajo_model->get_all_categoria_trabajo();
            $data['_view'] = 'venta_recepcion/venta_proceso';
            $this->load->view('venta_recepcion/venta_proceso',$data);
            //**************** fin contenido ***************
        }
    }
    
}
