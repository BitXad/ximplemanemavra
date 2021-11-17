<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Clasificador extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Clasificador_model');
        if ($this->session->userdata('logged_in')) {
            $this->session_data = $this->session->userdata('logged_in');
        }else {
            redirect('', 'refresh');
        }
    }
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
     * Listing of clasificador
     */
    function index()
    {
        if($this->acceso(191)){
        $data['clasificador'] = $this->Clasificador_model->get_all_clasificador();
        $data['page_title'] = "Clasificador";
        $data['_view'] = 'clasificador/index';
        $this->load->view('layouts/main',$data);
        
        }
    }

    /*
     * Adding a new clasificador
     */
    function add()
    {
        if($this->acceso(191)){
            $this->load->library('form_validation');
            $this->form_validation->set_rules('clasificador_nombre','Clasificador','trim|required', array('required' => 'Este Campo no debe ser vacio'));

            if($this->form_validation->run())     
            {
                $params = array(
                    'clasificador_nombre' => $this->input->post('clasificador_nombre'),
                    'clasificador_codigo' => $this->input->post('clasificador_codigo'),
                );
            $clasificador_id = $this->Clasificador_model->add_clasificador($params);
            redirect('clasificador/index');
            }else{
                $data['page_title'] = "Clasificador";
                $data['_view'] = 'clasificador/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a clasificador
     */
    function edit($clasificador_id)
    {
        if($this->acceso(191)){
            // check if the clasificador exists before trying to edit it
            $data['clasificador'] = $this->Clasificador_model->get_clasificador($clasificador_id);

            if(isset($data['clasificador']['clasificador_id']))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('clasificador_nombre','Clasificador','trim|required', array('required' => 'Este Campo no debe ser vacio'));
                if($this->form_validation->run())     
                {  
                    $params = array(
                        'clasificador_nombre' => $this->input->post('clasificador_nombre'),
                        'clasificador_codigo' => $this->input->post('clasificador_codigo'),
                    );
                    $this->Clasificador_model->update_clasificador($clasificador_id,$params);            
                    redirect('clasificador/index');
                }else{
                    $data['page_title'] = "Clasificador";
                    $data['_view'] = 'clasificador/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The clasificador you are trying to edit does not exist.');
        }
            
    } 

    /*
     * Deleting clasificador
     */
    /*function remove($clasificador_id)
    {
        if($this->acceso(191)){

        // check if the clasificador exists before trying to delete it
        if(isset($clasificador['clasificador_id']))
        {
            $this->Clasificador_model->delete_clasificador($clasificador_id);
            redirect('clasificador/index');
        }
        else
            show_error('The clasificador you are trying to delete does not exist.');
        }
            
    }*/
    /*
     * muestra el inventario de los clasificadores
     */
    function inventario()
    {
        if($this->acceso(192)){
            $data['rolusuario'] = $this->session_data['rol'];
            $empresa_id = 1;
            $data['page_title'] = "Inventario";
            $this->load->model('Empresa_model');
            $data['empresa'] = $this->Empresa_model->get_empresa($empresa_id);
            
            $this->load->model('Clasificador_model');
            $data['all_clasificadores'] = $this->Clasificador_model->get_all_clasificadores();
            $data['_view'] = 'clasificador/inventario';
            $this->load->view('layouts/main',$data);
        }
    }
    /*
     * Funcion que se encarga de llenar la tabla catalogo!!...
     */
    function cargar_catalogo()
    {
        //if($this->acceso(191)){
            if ($this->input->is_ajax_request()) {
                $data['rolusuario'] = $this->session_data['rol'];
                
                $this->load->model('Catalogo_model');
                $this->Catalogo_model->truncar_catalogo();
                $this->load->model('Producto_model');
                $all_producto = $this->Producto_model->buscar_allproductos();
                $this->load->model('Clasificador_model');
                //$all_clasificadores = $this->Clasificador_model->get_all_clasificadores();
                foreach ($all_producto as $producto) {
                    $params = array(
                        'catalogo_foto' => $producto["producto_foto"],
                        'catalogo_nombre' => $producto["producto_nombre"],
                        'catalogo_codigo' => $producto["producto_codigo"],
                    );
                    $catalogo_id = $this->Catalogo_model->add_catalogo($params);
                    $all_movclasificador = $this->Clasificador_model->get_allmovclasificador($producto["producto_id"]);
                    foreach ($all_movclasificador as $movclasif) {
                        $total = $movclasif["compras"]-$movclasif["ventas"];
                        $sql = "update catalogo set c".$movclasif["clasificador_id"]." = $total
                                where catalogo_id = $catalogo_id";
                        //echo $sql;
                        //break;
                        $this->Clasificador_model->ejecutar($sql);
                        /*$res = array("'c".$movclasif["clasificador_id"]."'" => $total,);
                        array_push($params, $res);*/
                    }
                    
                }
                
                echo json_encode("ok");
            }else{
                show_404();
            }
        //}
    }
    function mostrar_clasificadorinventario()
    {
        if($this->acceso(192)){
            $parametro = $this->input->post("parametro");
            if ($parametro=="" || $parametro==null){
                $maximo = $this->Clasificador_model->get_maxclasificadorusado();
                $resultado = $this->Clasificador_model->get_clasificadorinventario();
            }else{
                $maximo = $this->Clasificador_model->get_maxclasificadorusado_parametro($parametro);
                $resultado = $this->Clasificador_model->get_clasificadorinventario_parametro($parametro);
            }
            $data=array("elmaximo"=>$maximo[0], "resultado" =>$resultado);
            echo   json_encode($data);
        }
    }
    
}
