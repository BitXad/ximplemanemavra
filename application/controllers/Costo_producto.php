<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Costo_producto extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Costo_operativo_model');
        $this->load->model('Detalle_produccion_model');
        $this->load->model('Costo_producto_model');
        $this->load->model('Categoria_costo_model');
        $this->load->library('form_validation');
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
    /**
     * get all costos_prodcuto
     */
    function get_costos_producto(){
        if($this->input->is_ajax_request()){
            $producto = $this->input->post("producto");
            $aux = "AND cp.catcosto_tipo = 2";
            $aux2 = "AND cp.catcosto_tipo = 1";
            $data['result'] = $this->Costo_producto_model->get_all_costos($producto);
            $data['categoria_costos'] = $this->Categoria_costo_model->get_all_categorias($aux);
            $data['porcentajes'] = $this->Categoria_costo_model->get_all_categorias($aux2);
            echo json_encode($data);
        }else{
            show_404();
        }
    }
    /*
     * Adding a new costo_operativo
     */
    function add_costo(){
        if($this->input->is_ajax_request()){
            $cproducto_id = $this->input->post('cproducto_id');
            $params = array(
                'cproducto_descripcion' => $this->input->post('form_insumo'),
                'producto_id' => $this->input->post('form_producto'),
                'catcosto_id' => $this->input->post('form_catcosto'),
                'cproducto_unidad' => $this->input->post('form_unidad'),
                'cproducto_cantidad' => $this->input->post('form_cantidad'),
                'cproducto_costo' => $this->input->post('form_punitario'),
                'cproducto_costoparcial' => $this->input->post('form_pparcial'),
                'costo_id' => $this->input->post('form_insumo'),
            );
            if($cproducto_id == 0){
                $cproducto_id = $this->Costo_producto_model->add_costo_producto($params);
            }else{
                $cproducto_id = $this->Costo_producto_model->edit_costo_producto($cproducto_id,$params);
            }
        }else{
            show_404();
        }
    }  
    /*
     * Editing a costo_operativo
     */
    function edit($costoop_id)
    {
        if($this->acceso(118)){
            $data['page_title'] = "Costo Operativo";
            // check if the costo_operativo exists before trying to edit it
            $data['costo_operativo'] = $this->Costo_operativo_model->get_costo_operativo($costoop_id);
            if(isset($data['costo_operativo']['costoop_id']))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('costoop_costo','Costo','trim|required', array('required' => 'Este Campo no debe ser vacio'));
                if($this->form_validation->run())     
                {
                    $params = array(
                        'produccion_id' => $this->input->post('produccion_id'),
                        'usuario_id' => $this->input->post('usuario_id'),
                        'estado_id' => $this->input->post('estado_id'),
                        'costodesc_id' => $this->input->post('costodesc_id'),
                        'costoop_costo' => $this->input->post('costoop_costo'),
                    );
                    $this->Costo_operativo_model->update_costo_operativo($costoop_id,$params);            
                    redirect('costo_operativo/index');
                }
                else
                {
                    $this->load->model('Produccion_model');
                    $data['all_produccion'] = $this->Produccion_model->get_all_produccion();
                    
                    $this->load->model('Usuario_model');
                    $data['all_usuario'] = $this->Usuario_model->get_all_usuario_activo();
                    
                    $this->load->model('Estado_model');
                    $tipo = 1;
                    $data['all_estado'] = $this->Estado_model->get_estado_tipo($tipo);
                    
                    $this->load->model('Costo_descripcion_model');
                    $data['all_costo_descripcion'] = $this->Costo_descripcion_model->get_all_costo_descripcion();
                    
                    $data['_view'] = 'costo_operativo/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The costo_operativo you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting costo_operativo
     */
    function remove($costoop_id)
    {
        if($this->acceso(118)){
        $costo_operativo = $this->Costo_operativo_model->get_costo_operativo($costoop_id);
        // check if the costo_operativo exists before trying to delete it
        if(isset($costo_operativo['costoop_id']))
        {
            $this->Costo_operativo_model->delete_costo_operativo($costoop_id);
            redirect('costo_operativo/index');
        }
        else
            show_error('The costo_operativo you are trying to delete does not exist.');
        }
    }

    function save_costo(){
        if($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post("detproduccion_id");
            $costo = $this->input->post("costo");
            $platabanda = $this->input->post("platabanda");
            $detcosto = $this->input->post("detcosto");
            $produccion = $this->Detalle_produccion_model->get_detproduccion($detproduccion_id);
            $estado_id = 1;
            $params = array(
                'produccion_id' => $produccion[0]['produccion_id'],
                'usuario_id' => $this->session_data['usuario_id'],
                'estado_id' => $estado_id,
                'costodesc_id' => $detcosto,
                'costoop_costo' => $costo,
                'costoop_fecha' => date('Y-m-d'),
                'controli_id' => $platabanda,
            );
            $this->Costo_operativo_model->add_costo_operativo($params);
        }else{
            show_404();
        }
    }

    function get_costos(){
        if ($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post('detproduccion_id');
            $costos = $this->Costo_operativo_model->get_costos($detproduccion_id);
            echo json_encode($costos);
        }
    } 
    
    function delete_costo_producto(){
        if($this->input->is_ajax_request()){
            $costo_producto = $this->input->post('costo_producto');
            $this->Costo_producto_model->delete_costo_producto($costo_producto);
        }else{
            show_404();
        }
    }
}
