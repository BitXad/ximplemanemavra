<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Orden_pago extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Orden_pago_model');
        $this->load->model('Usuario_model');
        $this->load->helper('numeros');
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
     * Listing of orden_pago
     */
    function index()
    {
        if($this->acceso(89)) {
            $data['rol'] = $this->session_data['rol'];
        $data['page_title'] = "Orden de pago";
        $filtro = "1=1";
        $data['orden_pago'] = $this->Orden_pago_model->get_pago_pendiente($filtro);
        $data['usuario'] = $this->Orden_pago_model->get_usuarios();
        
        $data['page_title'] = "Orden Pago"; 
        $data['_view'] = 'orden_pago/index';
        $this->load->view('layouts/main',$data);
    }
    }
    function pendientes()
    {
        if($this->acceso(89)) {
        $filtro = $this->input->post('filtro');
        $data = $this->Orden_pago_model->get_pago_pendiente($filtro);
        echo json_encode($data);
    }
    }

    function pagadas_hoy()
    {
        if($this->acceso(89)) {
        $filtro = $this->input->post('filtro');
        $data = $this->Orden_pago_model->get_pagadas_hoy($filtro);

        echo json_encode($data);
        /*$data['usuario'] = $this->Orden_pago_model->get_usuarios();
        $data['page_title'] = "Orden Pago";
        $data['_view'] = 'orden_pago/index';
        $this->load->view('layouts/main',$data);*/
    }
}

    function pagadas_antes()
    {
        if($this->acceso(89)) {
            $filtro = $this->input->post('filtro');
            $data = $this->Orden_pago_model->get_pagadas_antes($filtro);
            echo json_encode($data);
        }
    }
    /* muestra ordenes de pagos anuladas */
    function mostrar_anuladas()
    {
        if($this->acceso(89)) {
            $filtro = $this->input->post('filtro');
            $data = $this->Orden_pago_model->get_anuladas($filtro);
            echo json_encode($data);
        }
    }

    /*
     * Adding a new orden_pago
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'usuario_id1' => $this->input->post('usuario_id1'),
				'usuario_id2' => $this->input->post('usuario_id2'),
				'proveedor_id' => $this->input->post('proveedor_id'),
				'estado_id' => $this->input->post('estado_id'),
				'cuota_id' => $this->input->post('cuota_id'),
				'compra_id' => $this->input->post('compra_id'),
				'orden_fecha' => $this->input->post('orden_fecha'),
				'orden_hora' => $this->input->post('orden_hora'),
				'orden_monto' => $this->input->post('orden_monto'),
				'orden_motivo' => $this->input->post('orden_motivo'),
				'orden_fechapago' => $this->input->post('orden_fechapago'),
				'orden_horapago' => $this->input->post('orden_horapago'),
				'orden_cobradapor' => $this->input->post('orden_cobradapor'),
				'orden_ci' => $this->input->post('orden_ci'),
            );
            
            $orden_pago_id = $this->Orden_pago_model->add_orden_pago($params);
            redirect('orden_pago/index');
        }
        else
        {
			$this->load->model('Usuario_model');
			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();
			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();

			$this->load->model('Proveedor_model');
			$data['all_proveedor'] = $this->Proveedor_model->get_all_proveedor();

			$this->load->model('Estado_model');
			$data['all_estado'] = $this->Estado_model->get_all_estado();

			$this->load->model('Cuotum_model');
			$data['all_cuota'] = $this->Cuotum_model->get_all_cuota();

			$this->load->model('Compra_model');
			$data['all_compra'] = $this->Compra_model->get_all_compra();
            $data['page_title'] = "Orden Pago";
            $data['_view'] = 'orden_pago/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Adding a new orden_pago
     */
    function nueva_orden()
    {   
        if($this->acceso(90)) {
        
        //**************** inicio contenido ***************            
        
        $usuario_id = $this->session_data['usuario_id'];
        $orden_fecha = "'".date("Y-m-d")."'"; 
        $orden_hora = "'".date("H:n:s")."'"; 
        $orden_monto = $this->input->post('orden_monto');
        $orden_motivo = "'".$this->input->post('orden_motivo')."'";
        $orden_destinatario = "'".$this->input->post('orden_destinatario')."'";
        
                
        if(isset($_POST) && count($_POST) > 0)     
        {   
            
            $sql = "insert into orden_pago(usuario_id1,usuario_id2,orden_monto,orden_destinatario,orden_motivo,orden_fecha,orden_hora,estado_id,orden_cancelado,cuota_id,compra_id) "
                    . "value(".$usuario_id.",0".",".$orden_monto.",".$orden_destinatario.",".$orden_motivo.",".$orden_fecha.",".$orden_hora.",8,0,0,0)";
            //echo $sql;
            $orden_pago_id = $this->Orden_pago_model->registrar_orden($sql);
            redirect('orden_pago/index');
        }
        else
        {
//			$this->load->model('Usuario_model');
//			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();
//			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();

//			$this->load->model('Proveedor_model');
//			$data['all_proveedor'] = $this->Proveedor_model->get_all_proveedor();

//			$this->load->model('Estado_model');
//			$data['all_estado'] = $this->Estado_model->get_all_estado();

//			$this->load->model('Cuotum_model');
//			$data['all_cuota'] = $this->Cuotum_model->get_all_cuota();

//			$this->load->model('Compra_model');
//			$data['all_compra'] = $this->Compra_model->get_all_compra();
                $data['page_title'] = "Orden Pago";
                $data['_view'] = 'orden_pago/orden';
                $this->load->view('layouts/main',$data);
            
        }
        
        //**************** fin contenido ***************
        			}
        			         
        
    }  

    function generar_orden($orden_monto,$orden_motivo,$orden_destinatario,$compra_id,$cuota_id)
    {   
        
        if($this->acceso(90)) {
        //**************** inicio contenido ***************            
        
        $usuario_id = $this->session_data['usuario_id'];
        $orden_fecha = "'".date("Y-m-d")."'"; 
        $orden_hora = "'".date("H:n:s")."'"; 
        
//        $orden_monto = $this->input->post('orden_monto');
//        $orden_motivo = "'".$this->input->post('orden_motivo')."'";
//        $orden_destinatario = "'".$this->input->post('orden_destinatario')."'";
//        
                
        if(isset($_POST) && count($_POST) > 0)     
        {   
            
            $sql = "insert into orden_pago(usuario_id1,usuario_id2,orden_monto,orden_destinatario,orden_motivo,orden_fecha,orden_hora,estado_id,orden_cancelado,compra_id,cuota_id) "
                    . "value(".$usuario_id.",0".",".$orden_monto.",".$orden_destinatario.",".$orden_motivo.",".$orden_fecha.",".$orden_hora.",8,0,".$compra_id.",".$cuota_id.")";
            //echo $sql;
            $orden_pago_id = $this->Orden_pago_model->registrar_orden($sql);
            redirect('orden_pago/index');
        }
        else
        {
//			$this->load->model('Usuario_model');
//			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();
//			$data['all_usuario'] = $this->Usuario_model->get_all_usuario();

//			$this->load->model('Proveedor_model');
//			$data['all_proveedor'] = $this->Proveedor_model->get_all_proveedor();

//			$this->load->model('Estado_model');
//			$data['all_estado'] = $this->Estado_model->get_all_estado();

//			$this->load->model('Cuotum_model');
//			$data['all_cuota'] = $this->Cuotum_model->get_all_cuota();

//			$this->load->model('Compra_model');
//			$data['all_compra'] = $this->Compra_model->get_all_compra();
                $data['page_title'] = "Orden Pago";
                $data['_view'] = 'orden_pago/orden';
                $this->load->view('layouts/main',$data);
            
        }
        
        //**************** fin contenido ***************
        			}
        			  
        
    }  

    function pagar_orden($orden_id){
        
        if($this->acceso(89)) {
        
        //**************** inicio contenido ***************            
        
        $usuario_id2 = $this->session_data['usuario_id'];
        $orden_fechapago = "'".date("Y-m-d")."'"; 
        $orden_horapago = "'".date("H:m:s")."'"; 
        $orden_cancelado = $this->input->post('cancelado');
        $orden_cobradapor = "'".$this->input->post('cobrado')."'";
        $orden_ci = "'".$this->input->post('cicobra')."'";
        $estado_id = 9;
                
            
        $sql = "update orden_pago set ".
               " usuario_id2 = ".$usuario_id2.
               ",orden_fechapago = ".$orden_fechapago.
               ",orden_horapago = ".$orden_horapago.
               ",orden_cancelado = ".$orden_cancelado.
               ",orden_cobradapor = ".$orden_cobradapor.
               ",orden_ci = ".$orden_ci.
               ",estado_id = ".$estado_id.
               " where orden_id = ".$orden_id;

        $orden_pago_id = $this->Orden_pago_model->registrar_orden($sql);
        

//        $data['_view'] = 'orden_pago/orden';
//        $this->load->view('layouts/main',$data);
            
        
        
        //**************** fin contenido ***************
            }
                           
        
    }         
    
    /*
     * Editing a orden_pago
     */
    function edit($orden_id)
    {   
        // check if the orden_pago exists before trying to edit it
        $data['orden_pago'] = $this->Orden_pago_model->get_orden_pago($orden_id);
        
        if(isset($data['orden_pago']['orden_id']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'usuario_id1' => $this->input->post('usuario_id1'),
					'usuario_id2' => $this->input->post('usuario_id2'),
					'proveedor_id' => $this->input->post('proveedor_id'),
					'estado_id' => $this->input->post('estado_id'),
					'cuota_id' => $this->input->post('cuota_id'),
					'compra_id' => $this->input->post('compra_id'),
					'orden_fecha' => $this->input->post('orden_fecha'),
					'orden_hora' => $this->input->post('orden_hora'),
					'orden_monto' => $this->input->post('orden_monto'),
					'orden_motivo' => $this->input->post('orden_motivo'),
					'orden_fechapago' => $this->input->post('orden_fechapago'),
					'orden_horapago' => $this->input->post('orden_horapago'),
					'orden_cobradapor' => $this->input->post('orden_cobradapor'),
					'orden_ci' => $this->input->post('orden_ci'),
                );

                $this->Orden_pago_model->update_orden_pago($orden_id,$params);            
                redirect('orden_pago/index');
            }
            else
            {
				$this->load->model('Usuario_model');
				$data['all_usuario'] = $this->Usuario_model->get_all_usuario();
				$data['all_usuario'] = $this->Usuario_model->get_all_usuario();

				$this->load->model('Proveedor_model');
				$data['all_proveedor'] = $this->Proveedor_model->get_all_proveedor();

				$this->load->model('Estado_model');
				$data['all_estado'] = $this->Estado_model->get_all_estado();

				$this->load->model('Cuotum_model');
				$data['all_cuota'] = $this->Cuotum_model->get_all_cuota();

				$this->load->model('Compra_model');
				$data['all_compra'] = $this->Compra_model->get_all_compra();
                $data['page_title'] = "Orden Pago";
                $data['_view'] = 'orden_pago/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The orden_pago you are trying to edit does not exist.');
    } 

    /*
     * Deleting orden_pago
     */
    function remove($orden_id)
    {
        $orden_pago = $this->Orden_pago_model->get_orden_pago($orden_id);

        // check if the orden_pago exists before trying to delete it
        if(isset($orden_pago['orden_id']))
        {
            $this->Orden_pago_model->delete_orden_pago($orden_id);
            redirect('orden_pago/index');
        }
        else
            show_error('The orden_pago you are trying to delete does not exist.');
    }
    /*************** funcion para mostrar la vista del recibo de orden pagado ******************/
    function imprimir($orden_id){
        if($this->acceso(89)){
        //**************** inicio contenido ***************
            $this->load->model('Parametro_model');
            $parametros = $this->Parametro_model->get_parametros();
            if (sizeof($parametros)>0){
                
                if ($parametros[0]['parametro_tipoimpresora']=="FACTURADORA")
                    $this->reciboboucher($orden_id);
                else
                    $this->recibo($orden_id);
            }
        //**************** fin contenido ***************
        }             
    }
    /* Nota de impresion tamaño carta*/
    function recibo($orden_id){
        if($this->acceso(89)){
            //$this->load->model('Parametro_model');
            $this->load->model('Empresa_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $data['orden_pago'] = $this->Orden_pago_model->get_orden_pagousuario($orden_id);
            $data['empresa'] = $this->Empresa_model->get_empresa(1);
            $data['page_title'] = "Recibo orden de pago"; 
            $data['_view'] = 'orden_pago/recibo';
            $this->load->view('layouts/main',$data);
        }
    }
    /* Nota de impresion formato Buecher */
    function reciboboucher($orden_id){
        if($this->acceso(89)){
            //$this->load->model('Parametro_model');
            $this->load->model('Empresa_model');
            $data['parametro'] = $this->Parametro_model->get_parametros();
            $data['orden_pago'] = $this->Orden_pago_model->get_orden_pagousuario($orden_id);
            $data['empresa'] = $this->Empresa_model->get_empresa(1);
            $data['page_title'] = "Recibo orden de pago"; 
            $data['_view'] = 'orden_pago/reciboboucher';
            $this->load->view('layouts/main',$data);
        }
    }
    
    function anular_orden(){
        if($this->acceso(89)){
            $orden_id = $this->input->post('orden_id');
            $estado_id = 27;
            $params = array(
                'estado_id' => $estado_id,
                'orden_monto' => $this->input->post('tipocliente_id'),
            );
            $this->Orden_pago_model->update_orden_pago($orden_id, $params);
            echo json_encode("ok");
        }
    }
    
}
