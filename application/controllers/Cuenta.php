<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Cuenta extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Cuenta_model');
    } 

    /*
     * Listing of cuenta
     */
    function index()
    {
        $data['cuenta'] = $this->Cuenta_model->get_all_cuenta();
        
        $data['_view'] = 'cuenta/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new cuenta
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'saldo_sus_ant' => $this->input->post('saldo_sus_ant'),
				'tot_debe_bs_act' => $this->input->post('tot_debe_bs_act'),
				'tot_haber_bs_act' => $this->input->post('tot_haber_bs_act'),
				'tot_debe_sus_act' => $this->input->post('tot_debe_sus_act'),
				'tot_haber_sus_act' => $this->input->post('tot_haber_sus_act'),
				'saldo_bs_act' => $this->input->post('saldo_bs_act'),
				'saldo_sus_act' => $this->input->post('saldo_sus_act'),
				'saldo_debe_bs' => $this->input->post('saldo_debe_bs'),
				'saldo_haber_bs' => $this->input->post('saldo_haber_bs'),
				'saldo_debe_sus' => $this->input->post('saldo_debe_sus'),
				'saldo_haber_sus' => $this->input->post('saldo_haber_sus'),
				'variacion_bs' => $this->input->post('variacion_bs'),
				'variacion_sus' => $this->input->post('variacion_sus'),
				'num_cuenta' => $this->input->post('num_cuenta'),
				'nombre_cuenta' => $this->input->post('nombre_cuenta'),
				'nivel' => $this->input->post('nivel'),
				'folio_mayor' => $this->input->post('folio_mayor'),
				'tipo' => $this->input->post('tipo'),
				'subgrupo' => $this->input->post('subgrupo'),
				'orden_fe' => $this->input->post('orden_fe'),
				'flujo_efectivo' => $this->input->post('flujo_efectivo'),
				'evolucion' => $this->input->post('evolucion'),
				'cta_especifica' => $this->input->post('cta_especifica'),
				'moneda' => $this->input->post('moneda'),
				'rubro_ajuste' => $this->input->post('rubro_ajuste'),
				'saldo_bs_ini' => $this->input->post('saldo_bs_ini'),
				'saldo_sus_ini' => $this->input->post('saldo_sus_ini'),
				'tot_debe_bs_ant' => $this->input->post('tot_debe_bs_ant'),
				'tot_haber_bs_ant' => $this->input->post('tot_haber_bs_ant'),
				'tot_debe_sus_ant' => $this->input->post('tot_debe_sus_ant'),
				'tot_haber_sus_ant' => $this->input->post('tot_haber_sus_ant'),
				'saldo_bs_ant' => $this->input->post('saldo_bs_ant'),
            );
            
            $cuenta_id = $this->Cuenta_model->add_cuenta($params);
            redirect('cuenta/index');
        }
        else
        {            
            $data['_view'] = 'cuenta/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a cuenta
     */
    function edit($cod_cuenta)
    {   
        // check if the cuenta exists before trying to edit it
        $data['cuenta'] = $this->Cuenta_model->get_cuenta($cod_cuenta);
        
        if(isset($data['cuenta']['cod_cuenta']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'saldo_sus_ant' => $this->input->post('saldo_sus_ant'),
					'tot_debe_bs_act' => $this->input->post('tot_debe_bs_act'),
					'tot_haber_bs_act' => $this->input->post('tot_haber_bs_act'),
					'tot_debe_sus_act' => $this->input->post('tot_debe_sus_act'),
					'tot_haber_sus_act' => $this->input->post('tot_haber_sus_act'),
					'saldo_bs_act' => $this->input->post('saldo_bs_act'),
					'saldo_sus_act' => $this->input->post('saldo_sus_act'),
					'saldo_debe_bs' => $this->input->post('saldo_debe_bs'),
					'saldo_haber_bs' => $this->input->post('saldo_haber_bs'),
					'saldo_debe_sus' => $this->input->post('saldo_debe_sus'),
					'saldo_haber_sus' => $this->input->post('saldo_haber_sus'),
					'variacion_bs' => $this->input->post('variacion_bs'),
					'variacion_sus' => $this->input->post('variacion_sus'),
					'num_cuenta' => $this->input->post('num_cuenta'),
					'nombre_cuenta' => $this->input->post('nombre_cuenta'),
					'nivel' => $this->input->post('nivel'),
					'folio_mayor' => $this->input->post('folio_mayor'),
					'tipo' => $this->input->post('tipo'),
					'subgrupo' => $this->input->post('subgrupo'),
					'orden_fe' => $this->input->post('orden_fe'),
					'flujo_efectivo' => $this->input->post('flujo_efectivo'),
					'evolucion' => $this->input->post('evolucion'),
					'cta_especifica' => $this->input->post('cta_especifica'),
					'moneda' => $this->input->post('moneda'),
					'rubro_ajuste' => $this->input->post('rubro_ajuste'),
					'saldo_bs_ini' => $this->input->post('saldo_bs_ini'),
					'saldo_sus_ini' => $this->input->post('saldo_sus_ini'),
					'tot_debe_bs_ant' => $this->input->post('tot_debe_bs_ant'),
					'tot_haber_bs_ant' => $this->input->post('tot_haber_bs_ant'),
					'tot_debe_sus_ant' => $this->input->post('tot_debe_sus_ant'),
					'tot_haber_sus_ant' => $this->input->post('tot_haber_sus_ant'),
					'saldo_bs_ant' => $this->input->post('saldo_bs_ant'),
                );

                $this->Cuenta_model->update_cuenta($cod_cuenta,$params);            
                redirect('cuenta/index');
            }
            else
            {
                $data['_view'] = 'cuenta/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The cuenta you are trying to edit does not exist.');
    } 

    /*
     * Deleting cuenta
     */
    function remove($cod_cuenta)
    {
        $cuenta = $this->Cuenta_model->get_cuenta($cod_cuenta);

        // check if the cuenta exists before trying to delete it
        if(isset($cuenta['cod_cuenta']))
        {
            $this->Cuenta_model->delete_cuenta($cod_cuenta);
            redirect('cuenta/index');
        }
        else
            show_error('The cuenta you are trying to delete does not exist.');
    }
    
}
