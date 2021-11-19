<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Cambio_producto extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cambio_producto_model');
        $this->load->model('Producto_model');
        $this->load->model('Inventario_model');
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
     * Listing of cambio_producto
     */
    function index()
    {   
        if($this->acceso(65)){
            $data['page_title'] = "Cambios/Devoluciones";
            $this->load->model('Detalle_venta_model');
            $data['detalle_venta'] = $this->Detalle_venta_model->get_all_detalle_ventas();
            $this->load->model('Detalle_compra_model');
            $data['detalle_compra'] = $this->Detalle_compra_model->get_all_detalle_compras();
            $data['cambio_producto'] = $this->Cambio_producto_model->get_all_cambio_producto();
            
            $data['rol'] = $this->session_data['rol'];
            
            $data['_view'] = 'cambio_producto/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new cambio_producto
     */
    function devolverproducto()
    {
        if($this->acceso(65)){
            $usuario_id = $this->session_data['usuario_id'];
            $cambio_producto_id = $this->input->post('cambio_producto_id');
            $producto_id = $this->input->post('producto_id');
            $cantidad = $this->input->post('cantidad'); 
            $descuento = $this->input->post('descuento'); 
            $producto_costo = $this->input->post('producto_costo');
            $producto_precio = $this->input->post('producto_precio');


           $sql = "INSERT into detalle_compra(

                    producto_id,
                    detallecomp_codigo,
                    detallecomp_unidad,
                    detallecomp_costo,
                    detallecomp_cantidad,
                    detallecomp_precio,
                    detallecomp_descuento,
                    detallecomp_subtotal,
                    detallecomp_total,
                    cambio_id              
                    )
                    (
                    SELECT

                    producto_id,
                    producto_codigo,
                    producto_unidad,
                    ".$producto_costo.",
                    ".$cantidad.",
                    ".$producto_precio.",
                    ".$descuento.",
                    ".$cantidad." * ".$producto_precio.",
                    (".$cantidad." * ".$producto_precio.") - ".$descuento.",
                    ".$cambio_producto_id."

                    from producto where producto_id = ".$producto_id."
                    )";

                    $pro = "UPDATE producto
                    SET

                    producto_costo = ".$producto_costo.",
                    producto_precio = ".$producto_precio."

                    WHERE producto_id = ".$producto_id."
                    ";

            $this->Cambio_producto_model->ejecutar($pro);
            $this->Cambio_producto_model->ejecutar($sql);
             redirect('cambio_producto/add/'.$cambio_producto_id);
        }
    }
    function crearcambio()
    {
        if($this->acceso(66)){
            $usuario_id = $this->session_data['usuario_id'];
            $cambio_producto_id = $this->Cambio_producto_model->crear_cambio($usuario_id);        
            redirect('cambio_producto/add/'.$cambio_producto_id);
        }
    }
    
    function entradas()
    {
        if ($this->input->is_ajax_request()) {
            
            $parametro = $this->input->post('parametro');   
            
            if ($parametro!=""){
            $datos = $this->Inventario_model->get_inventario_coti($parametro);            
            //$datos = $this->Inventario_model->get_inventario_bloque();
            echo json_encode($datos);
            }
            else echo json_encode(null);
        }
        else
        {                 
            show_404();
        }              
}

 function salidas()
{
        if ($this->input->is_ajax_request()) {
            
            $parametro = $this->input->post('parametro');   
            
            if ($parametro!=""){
            $datos = $this->Inventario_model->get_inventario_coti($parametro);            
            //$datos = $this->Inventario_model->get_inventario_bloque();
            echo json_encode($datos);
            }
            else echo json_encode(null);
        }
        else
        {                 
            show_404();
        }              
}
    function addee()
    {
        if($this->acceso(65)){
            $data['page_title'] = "Cambios/Devoluciones";
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
                    'cambio_producto_fecha' => $this->input->post('cambio_producto_fecha'),
                    'detallecomp_id' => $this->input->post('detallecomp_id'),
                    'detallevent_id' => $this->input->post('detallevent_id'),
                    'cambio_egreso' => $this->input->post('cambio_egreso'),
                    'cambio_ingreso' => $this->input->post('cambio_ingreso'),
                );

                $cambio_producto_id = $this->Cambio_producto_model->add_cambio_producto($params);
                redirect('cambio_producto/index');
            }
            else
            {            
                $data['_view'] = 'cambio_producto/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    function add($cambio_producto_id)
    {
        if($this->acceso(66)){
            $data['page_title'] = "Cambios/Devoluciones";
            $data['cambio_producto'] = $this->Cambio_producto_model->get_cambio_producto($cambio_producto_id);
            $this->load->model('Detalle_compra_model');
            $data['cambio_producto_id'] = $cambio_producto_id;
             $this->load->model('Detalle_compra_model');
            $data['detalle_compra'] = $this->Cambio_producto_model->get_detalle_compra($cambio_producto_id);
             $this->load->model('Detalle_venta_model');
            $data['detalle_venta'] = $this->Cambio_producto_model->get_detalle_venta($cambio_producto_id);
          
            $this->load->model('Producto_model');
            $data['inventario'] = $this->Producto_model->get_all_productos();       
            $data['_view'] = 'cambio_producto/add';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function anular($cambio_producto_id)
    {
       if($this->acceso(68)){
           $data['page_title'] = "Cambios/Devoluciones";
            $this->Cambio_producto_model->get_cambio_producto($cambio_producto_id);
            $this->load->model('Detalle_compra_model');
            $data['cambio_producto_id'] = $cambio_producto_id;
             $this->load->model('Detalle_compra_model');
            $data['detalle_compra'] = $this->Cambio_producto_model->get_detalle_compra($cambio_producto_id);
             $this->load->model('Detalle_venta_model');
            $data['detalle_venta'] = $this->Cambio_producto_model->get_detalle_venta($cambio_producto_id);
          
            $this->load->model('Inventario_model');
            //$this->load->model('Producto_model');
            //$data['inventario'] = $this->Producto_model->get_all_productos();    
            $data['inventario'] = $this->Inventario_model->get_inventario();
            $data['_view'] = 'cambio_producto/anular';
            $this->load->view('layouts/main',$data);
         
            }
    }

     function anulacion($cambio_producto_id)
    {
        if($this->acceso(68)){
           //  $cambio_producto_id = $this->input->post('cambio_producto_id');
            $comp = "UPDATE detalle_compra
                    SET
                    detallecomp_cantidad = 0,               
                    detallecomp_descuento = 0,
                    detallecomp_subtotal = 0,
                    detallecomp_total = 0                       
                    WHERE cambio_id = ".$cambio_producto_id."
                    ";

            $this->Cambio_producto_model->ejecutar($comp);

            $vent = "UPDATE detalle_venta
                    SET
                    detalleven_cantidad = 0,               
                    detalleven_descuento = 0,
                    detalleven_subtotal = 0,
                    detalleven_total = 0                       
                    WHERE cambio_id = ".$cambio_producto_id."
                    ";

            $this->Cambio_producto_model->ejecutar($vent);

            $sql = "UPDATE cambio_producto
                        SET

                    cambio_egreso = 0,
                    cambio_ingreso = 0

                    WHERE cambio_producto_id = ".$cambio_producto_id."
                        ";
                        $this->Cambio_producto_model->ejecutar($sql);

             redirect('cambio_producto/index');
        }
    }
    function entregarproducto()
    {
       if($this->acceso(65)){
            $cambio_producto_id = $this->input->post('cambio_producto_id');
            $producto_id = $this->input->post('producto_id');
            $cantidad = $this->input->post('cantidad'); 
            $descuento = $this->input->post('descuento'); 
            $producto_costo = $this->input->post('producto_costo');
            $producto_precio = $this->input->post('producto_precio');


           $sql = "INSERT into detalle_venta(

                    producto_id,
                    detalleven_codigo,
                    detalleven_unidad,
                    detalleven_costo,
                    detalleven_cantidad,
                    detalleven_precio,
                    detalleven_descuento,
                    detalleven_subtotal,
                    detalleven_total,
                    cambio_id              
                    )
                    (
                    SELECT

                    producto_id,
                    producto_codigo,
                    producto_unidad,
                    ".$producto_costo.",
                    ".$cantidad.",
                    ".$producto_precio.",
                    ".$descuento.",
                    ".$cantidad." * ".$producto_precio.",
                    (".$cantidad." * ".$producto_precio.") - ".$descuento.",
                    ".$cambio_producto_id."

                    from producto where producto_id = ".$producto_id."
                    )";

                    $pro = "UPDATE producto
                    SET

                    producto_costo = ".$producto_costo.",
                    producto_precio = ".$producto_precio."

                    WHERE producto_id = ".$producto_id."
                    ";

            $this->Cambio_producto_model->ejecutar($pro);
            $this->Cambio_producto_model->ejecutar($sql);
             redirect('cambio_producto/add/'.$cambio_producto_id);
        }
    }

    /*
     * Editing a cambio_producto
     */
    function edit($cambio_producto_id)
    {
        if($this->acceso(67)){
            $data['page_title'] = "Cambios/Devoluciones";
            // check if the cambio_producto exists before trying to edit it
            $data['cambio_producto'] = $this->Cambio_producto_model->get_cambio_producto($cambio_producto_id);

            if(isset($data['cambio_producto']['cambio_producto_id']))
            {
                if(isset($_POST) && count($_POST) > 0)     
                {   
                    $params = array(
                                            'producto_id' => $this->input->post('producto_id'),
                                            'detallecomp_id' => $this->input->post('detallecomp_id'),
                                            'detalleven_id' => $this->input->post('detalleven_id'),
                    );

                    $this->Cambio_producto_model->update_cambio_producto($cambio_producto_id,$params);            
                    redirect('cambio_producto/index');
                }
                else
                {
                    $data['_view'] = 'cambio_producto/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The cambio_producto you are trying to edit does not exist.');
        }
    } 

    function fincambio($cambio_producto_id)
    {
        if($this->acceso(65)){
            $usuario_id = $this->session_data['usuario_id'];
    $cambio_producto = $this->Cambio_producto_model->get_cambio_producto($cambio_producto_id);
     $params = array(
                'cambio_producto_fecha' => date('Y-m-d   H:i:s'),
                'cambio_egreso' => $this->input->post('cambio_egreso'),
                'cambio_ingreso' => $this->input->post('cambio_ingreso'),
                'usuario_id' => $usuario_id,
                );

                $this->Cambio_producto_model->update_cambio_producto($cambio_producto_id,$params);            
                 redirect('cambio_producto/index');
        }
    }
    /*
     * Deleting cambio_producto
     */
    function remove($cambio_producto_id)
    {
        if($this->acceso(65)){
            $cambio_producto = $this->Cambio_producto_model->get_cambio_producto($cambio_producto_id);

            // check if the cambio_producto exists before trying to delete it
            if(isset($cambio_producto['cambio_producto_id']))
            {
                $this->Cambio_producto_model->delete_cambio_producto($cambio_producto_id);
                redirect('cambio_producto/index');
            }
            else
                show_error('The cambio_producto you are trying to delete does not exist.');
        }
    }
    
}