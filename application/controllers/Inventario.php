<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Inventario extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Inventario_model');
        $this->load->model('Empresa_model');
        $this->load->model('Producto_model');
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
     * Listing of producto
     */
    function index()
    {
        

        if($this->acceso(24)){
            //**************** inicio contenido ***************
            $data['rolusuario'] = $this->session_data['rol'];
            $empresa_id = 1;
            $data['page_title'] = "Inventario";
            $data['empresa'] = $this->Empresa_model->get_empresa($empresa_id);
            
            $this->load->model('Parametro_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $this->load->model('Moneda_model');
            $data['moneda'] = $this->Moneda_model->get_moneda(2); //Obtener moneda extragera
            $data['lamoneda'] = $this->Moneda_model->getalls_monedasact_asc();
            
            $data['_view'] = 'inventario/index';
            $this->load->view('layouts/main',$data);

            //**************** fin contenido ***************
        }
			
    }

    /*
     * Listing of producto
     */
    function realizable()
    {
        if($this->acceso(24)){
            //**************** inicio contenido ***************
            $data['rolusuario'] = $this->session_data['rol'];
            $empresa_id = 1;
            $data['page_title'] = "Inventario";
            $data['empresa'] = $this->Empresa_model->get_empresa($empresa_id);
            
            $this->load->model('Parametro_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $this->load->model('Moneda_model');
            $data['moneda'] = $this->Moneda_model->get_moneda(2); //Obtener moneda extragera
            $data['lamoneda'] = $this->Moneda_model->getalls_monedasact_asc();
            
            $data['_view'] = 'inventario/realizable';
            $this->load->view('layouts/main',$data);
            
            //**************** fin contenido ***************
        }
    }

    /*
     * Kadex de producto
     */
    function kardex($producto_id)
    {
        if($this->acceso(29)){
            //**************** inicio contenido ***************           
            $empresa_id = 1;
            $data['page_title'] = "Kardex";
            $data['empresa'] = $this->Empresa_model->get_empresa($empresa_id);
            $data['producto'] = $this->Producto_model->get_producto($producto_id);
            $data['producto_id'] = $producto_id;
            $this->load->model('Parametro_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $this->load->model('Moneda_model');
            $data['moneda'] = $this->Moneda_model->get_moneda(2); //Obtener moneda extragera
            $data['lamoneda'] = $this->Moneda_model->getalls_monedasact_asc();
            $data['_view'] = 'inventario/kardex';
            $this->load->view('layouts/main',$data);
            //**************** fin contenido ***************
        }
    }
    /*
     * Kadex de producto
     */
    function buscar_kardex()
    {
        if($this->acceso(29)){
            //**************** inicio contenido ***************           
            $empresa_id = 1;
            $producto_id = $this->input->post('producto_id');
            $hasta = $this->input->post('hasta');
            $desde = $this->input->post('desde');
            $kardex = $this->Inventario_model->mostrar_kardex($desde, $hasta, $producto_id);
            echo json_encode($kardex);
            //**************** fin contenido ***************
        }
    }

    /*
     * Elimina el contenido de la tabla inventario y lo carga nuevamente
     */
    function actualizar_inventario()
    {   

        if($this->acceso(26)){
        //**************** inicio contenido ***************
		       
        $usuario_id = 1;
        
        $this->Inventario_model->actualizar_inventario();
        redirect('inventario/index');
		
        //**************** fin contenido ***************
			}
			
    }  

    /*
     * muestra inventario por parametro
     */
    function mostrar_inventario()
    {
        if($this->acceso(25)){
            //**************** inicio contenido ***************
            $parametro = $this->input->post("parametro");
            if ($parametro=="" || $parametro==null)
                $resultado = $this->Inventario_model->get_inventario();                
            else
                $resultado = $this->Inventario_model->get_inventario_parametro($parametro);
            echo json_encode($resultado);            
            //**************** fin contenido ***************
        }
    }

    function mostrar_inventario_existencia()
    {      
       

        if($this->acceso(25)){
        //**************** inicio contenido ***************
        
            $parametro = $this->input->post("parametro");
            if ($parametro=="" || $parametro==null)
                $resultado = $this->Inventario_model->get_inventario_existencia();                
            else
                $resultado = $this->Inventario_model->get_inventario_parametro_existencia($parametro);
            
            echo json_encode($resultado);            
        
        //**************** fin contenido ***************
            }
            
    }    
    
    /*
     * Adding a new producto
     */
    function actualizar_cantidad_inventario()
    {   

        if($this->acceso(26)){
        //**************** inicio contenido ***************
		       
        $usuario_id = 1;
        
        $this->Inventario_model->actualizar_cantidad_inventario();
        redirect('inventario/index');
		
        //**************** fin contenido ***************
			}
			
    }  
    
    /*
     * muestra los productos duplicados en inventario
     */
    function mostrar_duplicados()
    {
     

        if($this->acceso(28)){
        //**************** inicio contenido ***************
		        
        if($this->input->is_ajax_request()){
            
            $resultado = $this->Inventario_model->mostrar_duplicados_inventario();
            echo json_encode($resultado);      
            
        }
        else echo false;
		
        //**************** fin contenido ***************
			}

    }

    function generar_excel()
    {
            $llamadas = $this->Inventario_model->get_inventario();
            echo json_encode($llamadas); 
     
    }
    /* muestra operaciones en proceso de venta!! */
    function operacion_enproceso()
    {
        if($this->input->is_ajax_request()){
            $producto_id = $this->input->post('producto_id');
            $res_venta_aux = $this->Inventario_model->mostrar_productoventa_aux($producto_id);
            $res_pedido_nocons = $this->Inventario_model->mostrar_pedido_noconsolidado($producto_id);
            $data=array("enventa_aux"=>$res_venta_aux, "enpedido_noconsol" =>$res_pedido_nocons);
            echo   json_encode($data);
        }else{ show_404();}
    }
    /*
     * Inventario Fisico - valorado
     */
    function fvalorado()
    {
        if($this->acceso(24)){
            //**************** inicio contenido ***************
            $data['rolusuario'] = $this->session_data['rol'];
            $empresa_id = 1;
            $data['page_title'] = "Inventario Fisico-Valorado";
            $data['empresa'] = $this->Empresa_model->get_empresa($empresa_id);
            
            $this->load->model('Parametro_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $this->load->model('Moneda_model');
            $data['moneda'] = $this->Moneda_model->get_moneda(2); //Obtener moneda extragera
            $data['lamoneda'] = $this->Moneda_model->getalls_monedasact_asc();
            
            $data['_view'] = 'inventario/fvalorado';
            $this->load->view('layouts/main',$data);

            //**************** fin contenido ***************
        }
			
    }
    /*
     * muestra el inventario Fisico - Valorado
     */
    function mostrar_fvalorado()
    {
        if($this->acceso(25)){
            //**************** inicio contenido ***************
            $parametro = $this->input->post("parametro");
            if ($parametro=="" || $parametro==null)
                $resultado = $this->Inventario_model->getinventario_fvalorado();                
            else
                $resultado = $this->Inventario_model->get_inventario_parametro($parametro);
            echo json_encode($resultado);            
            //**************** fin contenido ***************
        }
    }
}
