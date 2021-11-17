<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Submenu extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Submenu_model');
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
     * Listing of submenu
     */
    function index()
    {
        if($this->acceso(155)){
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('submenu/index?');
            $config['total_rows'] = $this->Submenu_model->get_all_submenu_count();
            $this->pagination->initialize($config);

            $data['submenu'] = $this->Submenu_model->get_all_submenu($params);
            $data['page_title'] = "Submenu";
            $data['_view'] = 'submenu/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new submenu
     */
    function add()
    {
        if($this->acceso(155)){
            $this->load->library('form_validation');

                    $this->form_validation->set_rules('submenu_nombre','Submenu Nombre','required');

                    if($this->form_validation->run())     
            {   
                $params = array(
                                    'estadopag_id' => $this->input->post('estadopag_id'),
                                    'menu_id' => $this->input->post('menu_id'),
                                    'submenu_nombre' => $this->input->post('submenu_nombre'),
                                    'submenu_enlace' => $this->input->post('submenu_enlace'),
                                    'submenu_imagen' => $this->input->post('submenu_imagen'),
                                    'submenu_descipcion' => $this->input->post('submenu_descipcion'),
                );

                $submenu_id = $this->Submenu_model->add_submenu($params);
                redirect('submenu/index');
            }
            else
            {
                            $this->load->model('Estado_pagina_model');
                            $data['all_estado_pagina'] = $this->Estado_pagina_model->get_all_estado_pagina();

                            $this->load->model('Menu_model');
                            $data['all_menu'] = $this->Menu_model->get_all_menu();
                 $data['page_title'] = "Submenu";           
                $data['_view'] = 'submenu/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a submenu
     */
    function edit($submenu_id)
    {
        if($this->acceso(155)){
            // check if the submenu exists before trying to edit it
            $data['submenu'] = $this->Submenu_model->get_submenu($submenu_id);

            if(isset($data['submenu']['submenu_id']))
            {
                $this->load->library('form_validation');

                            $this->form_validation->set_rules('submenu_nombre','Submenu Nombre','required');

                            if($this->form_validation->run())     
                {   
                    $params = array(
                                            'estadopag_id' => $this->input->post('estadopag_id'),
                                            'menu_id' => $this->input->post('menu_id'),
                                            'submenu_nombre' => $this->input->post('submenu_nombre'),
                                            'submenu_enlace' => $this->input->post('submenu_enlace'),
                                            'submenu_imagen' => $this->input->post('submenu_imagen'),
                                            'submenu_descipcion' => $this->input->post('submenu_descipcion'),
                    );

                    $this->Submenu_model->update_submenu($submenu_id,$params);            
                    redirect('submenu/index');
                }
                else
                {
                                    $this->load->model('Estado_pagina_model');
                                    $data['all_estado_pagina'] = $this->Estado_pagina_model->get_all_estado_pagina();

                                    $this->load->model('Menu_model');
                                    $data['all_menu'] = $this->Menu_model->get_all_menu();
                    $data['page_title'] = "Submenu";
                    $data['_view'] = 'submenu/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The submenu you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting submenu
     */
    function remove($submenu_id)
    {
        if($this->acceso(155)){
            $submenu = $this->Submenu_model->get_submenu($submenu_id);

            // check if the submenu exists before trying to delete it
            if(isset($submenu['submenu_id']))
            {
                $this->Submenu_model->delete_submenu($submenu_id);
                redirect('submenu/index');
            }
            else
                show_error('The submenu you are trying to delete does not exist.');
        }
    }
    
}
