<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_cliente extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Categoria_cliente_model');
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
     * Listing of categoria_cliente
     */
    function index()
    {
        if($this->acceso(114)){
            $data['page_title'] = "Categoria Negocio Cliente";
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('categoria_cliente/index?');
            $config['total_rows'] = $this->Categoria_cliente_model->get_all_categoria_cliente_count();
            $this->pagination->initialize($config);
            
            $data['categoria_cliente'] = $this->Categoria_cliente_model->get_all_categoria_cliente($params);

            $data['_view'] = 'categoria_cliente/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new categoria_cliente
     */
    function add()
    {   
        if($this->acceso(114)){
            $data['page_title'] = "Categoria Negocio Cliente";
            $this->load->library('form_validation');

            //$this->form_validation->set_rules('categoriaclie_descripcion','Descripcion es requerida','trim|required|alpha', array('required' => 'Este Campo no debe ser vacio', 'alpha' => 'Solo valores alfanumericos'));
            $this->form_validation->set_rules('categoriaclie_descripcion','Descripcion es requerida','trim|required', array('required' => 'Este Campo no debe ser vacio'));
            $this->form_validation->set_rules('categoriaclie_porcdesc','Categoriaclie Porcdesc','required');
            $this->form_validation->set_rules('categoriaclie_montodesc','Categoriaclie Montodesc','required');
		
            if($this->form_validation->run())     
            {
                $params = array(
                                    'categoriaclie_descripcion' => $this->input->post('categoriaclie_descripcion'),
                                    'categoriaclie_porcdesc' => $this->input->post('categoriaclie_porcdesc'),
                                    'categoriaclie_montodesc' => $this->input->post('categoriaclie_montodesc'),
                );

                $categoria_cliente_id = $this->Categoria_cliente_model->add_categoria_cliente($params);
                redirect('categoria_cliente/index');
            }
            else
            {
                $data['_view'] = 'categoria_cliente/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a categoria_cliente
     */
    function edit($categoriaclie_id)
    {   
        if($this->acceso(114)){
            $data['page_title'] = "Categoria Negocio Cliente";
            // check if the categoria_cliente exists before trying to edit it
            $data['categoria_cliente'] = $this->Categoria_cliente_model->get_categoria_cliente($categoriaclie_id);

            if(isset($data['categoria_cliente']['categoriaclie_id']))
            {
                $this->load->library('form_validation');
                            $this->form_validation->set_rules('categoriaclie_descripcion','Descripcion es requerida','trim|required', array('required' => 'Este Campo no debe ser vacio'));
                            $this->form_validation->set_rules('categoriaclie_porcdesc','Categoriaclie Porcdesc','required');
                            $this->form_validation->set_rules('categoriaclie_montodesc','Categoriaclie Montodesc','required');

                            if($this->form_validation->run())     
                {   
                    $params = array(
                                            'categoriaclie_descripcion' => $this->input->post('categoriaclie_descripcion'),
                                            'categoriaclie_porcdesc' => $this->input->post('categoriaclie_porcdesc'),
                                            'categoriaclie_montodesc' => $this->input->post('categoriaclie_montodesc'),
                    );

                    $this->Categoria_cliente_model->update_categoria_cliente($categoriaclie_id,$params);            
                    redirect('categoria_cliente/index');
                }
                else
                {
                    $data['_view'] = 'categoria_cliente/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The categoria_cliente you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting categoria_cliente
     */
    function remove($categoriaclie_id)
    {
        if($this->acceso(114)){
            $categoria_cliente = $this->Categoria_cliente_model->get_categoria_cliente($categoriaclie_id);

            // check if the categoria_cliente exists before trying to delete it
            if(isset($categoria_cliente['categoriaclie_id']))
            {
                $this->Categoria_cliente_model->delete_categoria_cliente($categoriaclie_id);
                redirect('categoria_cliente/index');
            }
            else
                show_error('The categoria_cliente you are trying to delete does not exist.');
        }
    }
    
}