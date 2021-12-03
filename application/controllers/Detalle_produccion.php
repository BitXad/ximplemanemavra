<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Detalle_produccion extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Detalle_produccion_model');
        $this->load->model('Estado_model');
        $this->load->model('Producto_model');
        $this->load->model('Inventario_model');
        $this->load->model('Compra_model');
        $this->load->model('Produccion_model');
        if ($this->session->userdata('logged_in')) {
            $this->session_data = $this->session->userdata('logged_in');
        }else {
            redirect('', 'refresh');
        }
    } 
    
    function get_all_detalle(){
        if ($this->input->is_ajax_request()) {
            $area_id = $this->input->post("area_id");
            $result = $this->Detalle_produccion_model->get_all_produccion($area_id);
            echo json_encode($result);
        }else{
            show_404();
        }
    }

    function pasar_siguiente_estado(){
        if ($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post("detproduccion_id");
            $estado_id = $this->input->post("estado_id");
            if ($estado_id < 35 ) {
                $estado_id++;
            }else{
                $estado_id = 33;
            }
            $params = array(
                'estado_id' => $estado_id,
            );
            $this->Detalle_produccion_model->update_detalle($detproduccion_id,$params);
        }else{
            show_404();
        }
    }
    function update_detproduccion(){
        if($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post("detproduccion_id");
            $perdida = $this->input->post("perdida");
            $observacion = $this->input->post("observacion");
            $detproduccion = $this->Detalle_produccion_model->get_detproduccion($detproduccion_id);
            $params = array(
                'detproduccion_perdida' => $detproduccion[0]['detproduccion_perdida'] + $perdida,
                'detproduccion_observacion' => $observacion,
            );
            $this->Detalle_produccion_model->update_detalle($detproduccion_id, $params);
        }else{
            show_404();
        }
    }

    function incrementar_inventario(){
        if ($this->input->is_ajax_request()) {
            $cantidad = $this->input->post('cantidad');
            $producto_id = $this->input->post('producto_id');
            $costo = $this->Detalle_produccion_model->get_precio_producto($producto_id);
            $producto_costo = $costo['producto_costo'];
            // $this->Compra->ingreso_rapido($cantidad, $producto,$costo);

            $usuario_id = $this->session_data['usuario_id'];
            $compra_fecha = "now()";
            $compra_hora = "'".date('H:i:s')."'";
            $compra = array(
                        'estado_id' => 1,
                        'tipotrans_id' => 1,
                        'usuario_id' => $usuario_id,
                        'moneda_id' => 1,
                        'proveedor_id' => 1,
                        'forma_id' => 1,
                        'compra_fecha' => $compra_fecha,
                        'compra_hora' => $compra_hora,
                        'compra_subtotal' => $producto_costo*$cantidad,
                        'compra_descuento' => 0,
                        'compra_descglobal' => 0,
                        'compra_total' => $producto_costo*$cantidad,
                        'compra_efectivo' => $producto_costo*$cantidad,
                        'compra_cambio' => 0,            
                    );

            $compra_id=$this->Compra_model->add_compra($compra);
            $detalle = "INSERT into detalle_compra(
                    compra_id,
                    producto_id,
                    detallecomp_codigo,
                    detallecomp_unidad,
                    detallecomp_costo,
                    detallecomp_cantidad,
                    detallecomp_precio,
                    detallecomp_descuento,
                    detallecomp_subtotal,
                    detallecomp_total              
                    )
                    (
                    SELECT
                    ".$compra_id.",
                    producto_id,
                    producto_codigo,
                    producto_unidad,
                    producto_costo,
                    ".$cantidad.",
                    producto_precio,
                    0,
                    ".$producto_costo." * ".$cantidad.",
                    ".$producto_costo." * ".$cantidad."
                    
                    from producto where producto_id = ".$producto_id."
                )";  
            $this->db->query($detalle);
            $inventario = "update inventario set inventario.existencia=inventario.existencia+".$cantidad." where producto_id=".$producto_id."";

                $this->db->query($inventario);

            $detproduccion_id = $this->input->post("detproduccion_id");
            $params = array(
                "estado_id"=>39
            );
            $this->Detalle_produccion_model->update_detalle($detproduccion_id,$params);

            // $this->Inventario_model->incrementar_inventario($cantidad,$producto);
        }else{
            show_404();
        }
    }

    function volver_estado_platabanda(){
        if($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post('detproduccion_id');
            $detproduccion = $this->Detalle_produccion_model->get_detproduccion($detproduccion_id);
            $detproduccion = $detproduccion[0];
            if($detproduccion != null){
                if($detproduccion['estado_id'] <= 35 && $detproduccion['estado_id'] > 33){
                    $detproduccion['estado_id'] = $detproduccion['estado_id'] - 1;
                }else{
                    if($detproduccion['estado_id'] == 39){
                        $detproduccion['estado_id'] = 35;
                    }
                }
            }
            $params = array(
                'estado_id' => $detproduccion['estado_id'],
            );
            $this->Detalle_produccion_model->update_detalle($detproduccion_id,$params);
            echo json_encode($detproduccion['produccion_id']);
        }else{
            show_404();
        }
    }

    function get_detproduccion_venta(){
        if($this->input->is_ajax_request()){
            $detproduccion_id = $this->input->post("detproduccion_id");
            $platabanda = $this->input->post("platabanda");
            $resultado = $this->Detalle_produccion_model->get_detproduccion_venta($detproduccion_id,$platabanda);
            echo json_encode($resultado);
        }else{
            show_404();
        } 
    }
}
