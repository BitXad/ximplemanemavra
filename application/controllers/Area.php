<?php

class Area extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Area_model');
        $this->load->model('Estado_model');
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
     * Listing of unidad
     */
    function index(){
        if($this->acceso(136)){
            $data['areas'] = $this->Area_model->get_all_area();
            $data['tipousuario_id'] = $this->session_data['tipousuario_id'];
            $data['page_title'] = "Area";
            $data['_view'] = 'area/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new areas
     */
    function add(){   
        if($this->acceso(136)){
            $this->load->library('form_validation');

            $this->form_validation->set_rules('area_nombre','Nombre','trim|required', array('required' => 'Este Campo no debe ser vacio'));
            $estado = 1;
            if($this->form_validation->run()){
                $params = array(
                    'estado_id' => $estado,
                    'area_nombre' => $this->input->post('area_nombre'),
                    'area_descripcion' => $this->input->post('area_descripcion'),
                );
                
                $this->Area_model->add_area($params);
                redirect('area/index');
            }else{
                $data['page_title'] = "Area";
                $data['_view'] = 'area/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a unidad
     */
    function edit($area_id){   
        if($this->acceso(136)){
            // check if the tipo_servicio exists before trying to edit it
            $data['area'] = $this->Area_model->get_area($area_id);
            
            if(isset($data['area']['area_id'])){
                $this->load->library('form_validation');
                $this->form_validation->set_rules('area_nombre','Nombre','trim|required', array('required' => 'Este Campo no debe ser vacio'));
                if($this->form_validation->run()){
                    $params = array(
                        'estado_id' => $this->input->post('estado'),
                        'area_nombre' => $this->input->post('area_nombre'),
                        'area_descripcion' => $this->input->post('area_descripcion'),
                    );

                    $this->Area_model->update_area($area_id,$params);            
                    redirect('area/index');
                }else{
                    $data['estados'] = $this->Estado_model->get_all_estado_activo_inactivo  ();
                    $data['page_title'] = "Area";
                    $data['_view'] = 'area/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('La Ubiacion que estas intentando editar no existe.');
        }           
    }
}
