<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Config extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Config_model');
    } 

    /*
     * Listing of config
     */
    function index()
    {
        $data['config'] = $this->Config_model->get_all_config();
        
        $data['_view'] = 'config/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new config
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {   
            $params = array(
				'fecha_creacion' => $this->input->post('fecha_creacion'),
				'version' => $this->input->post('version'),
				'pie_ing_car_a' => $this->input->post('pie_ing_car_a'),
				'pie_ing_car_b' => $this->input->post('pie_ing_car_b'),
				'pie_ing_car_c' => $this->input->post('pie_ing_car_c'),
				'pie_egr_car_a' => $this->input->post('pie_egr_car_a'),
				'pie_egr_car_b' => $this->input->post('pie_egr_car_b'),
				'pie_egr_car_c' => $this->input->post('pie_egr_car_c'),
				'pie_tra_car_a' => $this->input->post('pie_tra_car_a'),
				'pie_tra_car_b' => $this->input->post('pie_tra_car_b'),
				'pie_tra_car_c' => $this->input->post('pie_tra_car_c'),
				'pie_est_car_a' => $this->input->post('pie_est_car_a'),
				'pie_est_car_b' => $this->input->post('pie_est_car_b'),
				'pie_est_car_c' => $this->input->post('pie_est_car_c'),
				'sw_interesado' => $this->input->post('sw_interesado'),
				'sw_moneda' => $this->input->post('sw_moneda'),
				'sw_proyectos' => $this->input->post('sw_proyectos'),
				'sw_cta_mayor' => $this->input->post('sw_cta_mayor'),
				'sw_referencia' => $this->input->post('sw_referencia'),
				'sw_fecha_hora' => $this->input->post('sw_fecha_hora'),
				'sw_mone_rexp' => $this->input->post('sw_mone_rexp'),
				'sw_asiento_lcv' => $this->input->post('sw_asiento_lcv'),
				'ufv_fin' => $this->input->post('ufv_fin'),
				'ufv_ini' => $this->input->post('ufv_ini'),
				'cuenta_resultado' => $this->input->post('cuenta_resultado'),
				'cta_resul_acum' => $this->input->post('cta_resul_acum'),
				'cta_capital_social' => $this->input->post('cta_capital_social'),
				'cta_credito_fiscal' => $this->input->post('cta_credito_fiscal'),
				'cta_debito_fiscal' => $this->input->post('cta_debito_fiscal'),
				'cta_it_pagar' => $this->input->post('cta_it_pagar'),
				'cta_impto_trans' => $this->input->post('cta_impto_trans'),
				'cta_descto_compras' => $this->input->post('cta_descto_compras'),
				'cta_descto_ventas' => $this->input->post('cta_descto_ventas'),
				'num_asi_apertura' => $this->input->post('num_asi_apertura'),
				'ult_fecha_actualiz' => $this->input->post('ult_fecha_actualiz'),
            );
            
            $config_id = $this->Config_model->add_config($params);
            redirect('config/index');
        }
        else
        {            
            $data['_view'] = 'config/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a config
     */
    function edit($cod_conf)
    {   
        // check if the config exists before trying to edit it
        $data['config'] = $this->Config_model->get_config($cod_conf);
        
        if(isset($data['config']['cod_conf']))
        {
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
					'fecha_creacion' => $this->input->post('fecha_creacion'),
					'version' => $this->input->post('version'),
					'pie_ing_car_a' => $this->input->post('pie_ing_car_a'),
					'pie_ing_car_b' => $this->input->post('pie_ing_car_b'),
					'pie_ing_car_c' => $this->input->post('pie_ing_car_c'),
					'pie_egr_car_a' => $this->input->post('pie_egr_car_a'),
					'pie_egr_car_b' => $this->input->post('pie_egr_car_b'),
					'pie_egr_car_c' => $this->input->post('pie_egr_car_c'),
					'pie_tra_car_a' => $this->input->post('pie_tra_car_a'),
					'pie_tra_car_b' => $this->input->post('pie_tra_car_b'),
					'pie_tra_car_c' => $this->input->post('pie_tra_car_c'),
					'pie_est_car_a' => $this->input->post('pie_est_car_a'),
					'pie_est_car_b' => $this->input->post('pie_est_car_b'),
					'pie_est_car_c' => $this->input->post('pie_est_car_c'),
					'sw_interesado' => $this->input->post('sw_interesado'),
					'sw_moneda' => $this->input->post('sw_moneda'),
					'sw_proyectos' => $this->input->post('sw_proyectos'),
					'sw_cta_mayor' => $this->input->post('sw_cta_mayor'),
					'sw_referencia' => $this->input->post('sw_referencia'),
					'sw_fecha_hora' => $this->input->post('sw_fecha_hora'),
					'sw_mone_rexp' => $this->input->post('sw_mone_rexp'),
					'sw_asiento_lcv' => $this->input->post('sw_asiento_lcv'),
					'ufv_fin' => $this->input->post('ufv_fin'),
					'ufv_ini' => $this->input->post('ufv_ini'),
					'cuenta_resultado' => $this->input->post('cuenta_resultado'),
					'cta_resul_acum' => $this->input->post('cta_resul_acum'),
					'cta_capital_social' => $this->input->post('cta_capital_social'),
					'cta_credito_fiscal' => $this->input->post('cta_credito_fiscal'),
					'cta_debito_fiscal' => $this->input->post('cta_debito_fiscal'),
					'cta_it_pagar' => $this->input->post('cta_it_pagar'),
					'cta_impto_trans' => $this->input->post('cta_impto_trans'),
					'cta_descto_compras' => $this->input->post('cta_descto_compras'),
					'cta_descto_ventas' => $this->input->post('cta_descto_ventas'),
					'num_asi_apertura' => $this->input->post('num_asi_apertura'),
					'ult_fecha_actualiz' => $this->input->post('ult_fecha_actualiz'),
                );

                $this->Config_model->update_config($cod_conf,$params);            
                redirect('config/index');
            }
            else
            {
                $data['_view'] = 'config/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The config you are trying to edit does not exist.');
    } 

    /*
     * Deleting config
     */
    function remove($cod_conf)
    {
        $config = $this->Config_model->get_config($cod_conf);

        // check if the config exists before trying to delete it
        if(isset($config['cod_conf']))
        {
            $this->Config_model->delete_config($cod_conf);
            redirect('config/index');
        }
        else
            show_error('The config you are trying to delete does not exist.');
    }
    
}
