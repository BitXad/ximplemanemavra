<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_costo extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categoria_costo_model');
        // $this->load->model('Categoria_egreso_model');
        $this->load->model('Costo_producto_model');
        $this->load->model('Costo_model');
        $this->load->model('Unidad_model');
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
     * Listing of categoria_costo
     */
    function index()
    {
        if($this->acceso(116)){
            $data['page_title'] = "Categoria Costos";
            $data['categoria_costos'] = $this->Categoria_costo_model->get_all_categoria_costo();

            $data['_view'] = 'categoria_costo/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /**
     * edit categoria costo
     */
    function edit($catcosto_id){
        $data['catcosto'] = $this->Categoria_costo_model->get_catcosto($catcosto_id);
        if(isset($data['catcosto']['catcosto_id'])){
            if(isset($_POST) && count($_POST) > 0){
                $catcosto_tipo = 1;
                $porcentaje = ($this->input->post('catcosto_porcentaje')/100);
                $params = array(    
                    'catcosto_tipo' => $catcosto_tipo,
                    'catcosto_descripcion' => $this->input->post('catcosto_descripcion'),
                    'catcosto_porcentaje' => $porcentaje,
                );

                $this->Categoria_costo_model->edit_costo($catcosto_id,$params);            
                redirect('categoria_costo/index');
            }else{
                $data['_view'] = 'categoria_costo/edit';
                $this->load->view('layouts/main',$data);
            }
        }else
            show_error('The produccion you are trying to edit does not exist.');
    }

    /*
     * Adding a new categoria_costo
     */
    function add()
    {
        if($this->acceso(116)){
            $data['page_title'] = "Categoria Egreso";
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
                    'categoria_categr' => $this->input->post('categoria_categr'),
                    'descrip_categr' => $this->input->post('descrip_categr'),
                );

                $categoria_egreso_id = $this->Categoria_egreso_model->add_categoria_egreso($params);
                redirect('categoria_egreso/index');
            }
            else
            {            
                $data['_view'] = 'categoria_egreso/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a categoria_egreso
     */
    function get_all_costos(){
        if($this->input->is_ajax_request()){
            $categoria = $this->input->post('categoria');
            $data['categorias'] = $this->Categoria_costo_model->get_all_categorias();
            $data['unidades'] = $this->Unidad_model->get_all_unidad();
            $data['costos'] = $this->Costo_model->get_costo_categoria(($categoria != 0 ? $categoria : 1));
            $costop_id = $this->input->post('costop_id');
            // if ($costop_id != 0) {
            $data['costo_producto'] = $this->Costo_producto_model->get_costos($costop_id);
            // }else{
                // $data['costo_producto'] = [0];
            // }
            echo json_encode($data);
        }else{
            show_404();
        }
    } 
    function get_costo_producto(){
        if($this->input->is_ajax_request()){
            $data['categorias'] = $this->Categoria_costo_model->get_all_categorias();
            $data['unidades'] = $this->Unidad_model->get_all_unidad();
            $data['costo_producto'] = $this->Costo_producto_model->get_costo();
            echo json_encode($data);
        }else{
            show_404();
        }
    } 

    function edit_catcosto(){
        if($this->input->is_ajax_request()){
            $descripcion = $this->input->post("descripcion");
            $id = $this->input->post("id");
            $porcentaje = $this->input->post("porcentaje");
            $porcentaje = $porcentaje/100;
            $params = array(
                'catcosto_descripcion' => $descripcion,
                'catcosto_porcentaje' => $porcentaje,
            );
            $this->Categoria_costo_model->edit_costo($id,$params);
        }else{
            show_404();
        }
    }

    function get_categoria_costos(){
        if($this->input->is_ajax_request()){
            $catcostos = $this->Categoria_costo_model->get_catcostos_porcentajes();
            echo json_encode($catcostos);
        }else{
            show_404();
        }
    }
}
