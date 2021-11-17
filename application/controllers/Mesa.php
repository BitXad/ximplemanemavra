<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Mesa extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Mesa_model');
    } 

    /*
     * Listing of mesa
     */
    function index()
    {
        $data['mesa'] = $this->Mesa_model->get_all_mesa();
        
        $data['_view'] = 'mesa/index';
        $this->load->view('layouts/main',$data);
    }

    /*
     * Adding a new mesa
     */
    function add()
    {   
        if(isset($_POST) && count($_POST) > 0)     
        {
            $params = array(
                'usuario_id' => $this->input->post('usuario_id'),
                'mesa_nombre' => $this->input->post('mesa_nombre'),
            );
            $mesa_id = $this->Mesa_model->add_mesa($params);
            redirect('mesa/index');
        }
        else
        {
            $this->load->model('Usuario_model');
            $data['all_usuario'] = $this->Usuario_model->get_all_usuario_activo();
            
            $data['_view'] = 'mesa/add';
            $this->load->view('layouts/main',$data);
        }
    }  

    /*
     * Editing a mesa
     */
    function edit($mesa_id)
    {
        // check if the mesa exists before trying to edit it
        $data['mesa'] = $this->Mesa_model->get_mesa($mesa_id);
        if(isset($data['mesa']['mesa_id']))
        {
            if(isset($_POST) && count($_POST) > 0)
            {
                $params = array(
                    'usuario_id' => $this->input->post('usuario_id'),
                    'mesa_nombre' => $this->input->post('mesa_nombre'),
                );
                $this->Mesa_model->update_mesa($mesa_id,$params);            
                redirect('mesa/index');
            }else{
                $this->load->model('Usuario_model');
                $data['all_usuario'] = $this->Usuario_model->get_all_usuario();

                $data['_view'] = 'mesa/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The mesa you are trying to edit does not exist.');
    }

    /*
     * Deleting mesa
     */
    function remove($mesa_id)
    {
        $mesa = $this->Mesa_model->get_mesa($mesa_id);

        // check if the mesa exists before trying to delete it
        if(isset($mesa['mesa_id']))
        {
            $this->Mesa_model->delete_mesa($mesa_id);
            redirect('mesa/index');
        }
        else
            show_error('The mesa you are trying to delete does not exist.');
    }
    
}
