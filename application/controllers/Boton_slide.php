<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Boton_slide extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Boton_slide_model');
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
     * Listing of boton_slide
     */
    function index()
    {
        if($this->acceso(155)){
            $data['page_title'] = "Boton Slide";
            $params['limit'] = RECORDS_PER_PAGE; 
            $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;

            $config = $this->config->item('pagination');
            $config['base_url'] = site_url('boton_slide/index?');
            $config['total_rows'] = $this->Boton_slide_model->get_all_boton_slide_count();
            $this->pagination->initialize($config);

            $data['boton_slide'] = $this->Boton_slide_model->get_all_boton_slide($params);

            $data['_view'] = 'boton_slide/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new boton_slide
     */
    function add()
    {
        if($this->acceso(155)){
            $data['page_title'] = "Boton Slide";
            if(isset($_POST) && count($_POST) > 0)     
            {   
                $params = array(
                                    'slide_id' => $this->input->post('slide_id'),
                                    'boton_id' => $this->input->post('boton_id'),
                );

                $boton_slide_id = $this->Boton_slide_model->add_boton_slide($params);
                redirect('boton_slide/index');
            }
            else
            {
                            $this->load->model('Slide_model');
                            $data['all_slide'] = $this->Slide_model->get_all_slide();

                            $this->load->model('Boton_model');
                            $data['all_boton'] = $this->Boton_model->get_all_boton();

                $data['_view'] = 'boton_slide/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }

    /*
     * Editing a boton_slide
     */
    function edit($botonslide_id)
    {
        if($this->acceso(155)){
            $data['page_title'] = "Boton Slide";
            // check if the boton_slide exists before trying to edit it
            $data['boton_slide'] = $this->Boton_slide_model->get_boton_slide($botonslide_id);

            if(isset($data['boton_slide']['botonslide_id']))
            {
                if(isset($_POST) && count($_POST) > 0)     
                {   
                    $params = array(
                                            'slide_id' => $this->input->post('slide_id'),
                                            'boton_id' => $this->input->post('boton_id'),
                    );

                    $this->Boton_slide_model->update_boton_slide($botonslide_id,$params);            
                    redirect('boton_slide/index');
                }
                else
                {
                                    $this->load->model('Slide_model');
                                    $data['all_slide'] = $this->Slide_model->get_all_slide();

                                    $this->load->model('Boton_model');
                                    $data['all_boton'] = $this->Boton_model->get_all_boton();

                    $data['_view'] = 'boton_slide/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The boton_slide you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting boton_slide
     */
    function remove($botonslide_id)
    {
        if($this->acceso(155)){
            $boton_slide = $this->Boton_slide_model->get_boton_slide($botonslide_id);

            // check if the boton_slide exists before trying to delete it
            if(isset($boton_slide['botonslide_id']))
            {
                $this->Boton_slide_model->delete_boton_slide($botonslide_id);
                redirect('boton_slide/index');
            }
            else
                show_error('The boton_slide you are trying to delete does not exist.');
        }
    }
    
}
