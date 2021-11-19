<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Presentacion extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Presentacion_model');
    } 

    /*
     * Listing of presentacion
     */
    function index()
    {
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('presentacion/index?');
        $config['total_rows'] = $this->Presentacion_model->get_all_presentacion_count();
        $this->pagination->initialize($config);

        $data['presentacion'] = $this->Presentacion_model->get_all_presentacion($params);
        
        $data['_view'] = 'presentacion/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new presentacion
     */
    function add()
    {   
        $this->load->library('form_validation');

		$this->form_validation->set_rules('presentacion_nombre','Presentacion Nombre','required');
		
		if($this->form_validation->run())     
        {   
            $params = array(
				'presentacion_nombre' => $this->input->post('presentacion_nombre'),
				'presentacion_contenido' => $this->input->post('presentacion_contenido'),
				'presentacion_unidad' => $this->input->post('presentacion_unidad'),
				'presentacion_precio' => $this->input->post('presentacion_precio'),
            );
            
            $presentacion_id = $this->Presentacion_model->add_presentacion($params);
            redirect('presentacion/index');
        }
        else
        {            
            $data['_view'] = 'presentacion/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a presentacion
     */
    function edit($presentacion_id)
    {   
        // check if the presentacion exists before trying to edit it
        $data['presentacion'] = $this->Presentacion_model->get_presentacion($presentacion_id);
        
        if(isset($data['presentacion']['presentacion_id']))
        {
            $this->load->library('form_validation');

			$this->form_validation->set_rules('presentacion_nombre','Presentacion Nombre','required');
		
			if($this->form_validation->run())     
            {   
                $params = array(
					'presentacion_nombre' => $this->input->post('presentacion_nombre'),
					'presentacion_contenido' => $this->input->post('presentacion_contenido'),
					'presentacion_unidad' => $this->input->post('presentacion_unidad'),
					'presentacion_precio' => $this->input->post('presentacion_precio'),
                );

                $this->Presentacion_model->update_presentacion($presentacion_id,$params);            
                redirect('presentacion/index');
            }
            else
            {
                $data['_view'] = 'presentacion/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The presentacion you are trying to edit does not exist.');
    } 

    /*
     * Deleting presentacion
     */
    function remove($presentacion_id)
    {
        $presentacion = $this->Presentacion_model->get_presentacion($presentacion_id);

        // check if the presentacion exists before trying to delete it
        if(isset($presentacion['presentacion_id']))
        {
            $this->Presentacion_model->delete_presentacion($presentacion_id);
            redirect('presentacion/index');
        }
        else
            show_error('The presentacion you are trying to delete does not exist.');
    }
    
}