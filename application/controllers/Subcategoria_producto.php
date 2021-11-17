<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Subcategoria_producto extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Subcategoria_producto_model');
        $this->load->model('Categoria_producto_model');
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
     * Listing of subcategoria_producto
     */
    function index()
    {
        if($this->acceso(118)){
            $data['page_title'] = "Subcategoria Producto";
            
            $data['subcategoria_producto'] = $this->Subcategoria_producto_model->get_all_subcategoria_producto();

            $data['_view'] = 'subcategoria_producto/index';
            $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new subcategoria_producto
     */
    function add()
    {
        if($this->acceso(118)){
            $data['page_title'] = "Subcategoria Producto";
            $this->load->library('form_validation');
            $this->form_validation->set_rules('subcategoria_nombre','Nombre','trim|required', array('required' => 'Este Campo no debe ser vacio'));
            if($this->form_validation->run())
            {
                /* *********************INICIO imagen***************************** */
                $foto="";
                if (!empty($_FILES['subcategoria_imagen']['name'])){
		
                        $this->load->library('image_lib');
                        $config['upload_path'] = './resources/images/subcategorias/';
                        $img_full_path = $config['upload_path'];

                        $config['allowed_types'] = 'gif|jpeg|jpg|png';
                        $config['image_library'] = 'gd2';
                        $config['max_size'] = 0;
                        $config['max_width'] = 0;
                        $config['max_height'] = 0;
                        
                        $new_name = time(); //str_replace(" ", "_", $this->input->post('proveedor_nombre'));
                        $config['file_name'] = $new_name; //.$extencion;
                        $config['file_ext_tolower'] = TRUE;

                        $this->load->library('upload', $config);
                        $this->upload->do_upload('subcategoria_imagen');

                        $img_data = $this->upload->data();
                        $extension = $img_data['file_ext'];
                        /* ********************INICIO para resize***************************** */
                        if ($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif") {
                            $conf['image_library'] = 'gd2';
                            $conf['source_image'] = $img_data['full_path'];
                            $conf['new_image'] = './resources/images/subcategorias/';
                            $conf['maintain_ratio'] = TRUE;
                            $conf['create_thumb'] = FALSE;
                            $conf['width'] = 800;
                            $conf['height'] = 600;
                            $this->image_lib->clear();
                            $this->image_lib->initialize($conf);
                            if(!$this->image_lib->resize()){
                                echo $this->image_lib->display_errors('','');
                            }
                        }
                        /* ********************F I N  para resize***************************** */
                        $confi['image_library'] = 'gd2';
                        $confi['source_image'] = './resources/images/subcategorias/'.$new_name.$extension;
                        $confi['new_image'] = './resources/images/subcategorias/'."thumb_".$new_name.$extension;
                        $confi['create_thumb'] = FALSE;
                        $confi['maintain_ratio'] = TRUE;
                        $confi['width'] = 50;
                        $confi['height'] = 50;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($confi);
                        $this->image_lib->resize();

                        $foto = $new_name.$extension;
                    }
                /* *********************FIN imagen***************************** */
                $params = array(
                    'subcategoria_nombre' => $this->input->post('subcategoria_nombre'),
                    'categoria_id' => $this->input->post('categoria_id'),
                    'subcategoria_imagen' => $foto,
                );

                $subcategoria_id = $this->Subcategoria_producto_model->add_subcategoria_producto($params);
                redirect('subcategoria_producto/index');
            }
            else
            {
                $data['all_categoria_producto'] = $this->Categoria_producto_model->get_all_categoria_producto();
                $data['_view'] = 'subcategoria_producto/add';
                $this->load->view('layouts/main',$data);
            }
        }
    }  

    /*
     * Editing a subcategoria_producto
     */
    function edit($subcategoria_id)
    {
        if($this->acceso(118)){
            $data['page_title'] = "Subcategoria Producto";
            // check if the subcategoria_producto exists before trying to edit it
            $data['subcategoria_producto'] = $this->Subcategoria_producto_model->get_subcategoria_producto($subcategoria_id);
            if(isset($data['subcategoria_producto']['subcategoria_id']))
            {
                $this->load->library('form_validation');
                $this->form_validation->set_rules('subcategoria_nombre','Nombre','trim|required', array('required' => 'Este Campo no debe ser vacio'));
                if($this->form_validation->run())
                {
                    /* *********************INICIO imagen***************************** */
                $foto="";
                    $foto1= $this->input->post('subcategoria_imagen1');
                if (!empty($_FILES['subcategoria_imagen']['name']))
                {
                    $this->load->library('image_lib');
                    $config['upload_path'] = './resources/images/subcategorias/';
                    $config['allowed_types'] = 'gif|jpeg|jpg|png';
                    $config['max_size'] = 0;
                    $config['max_width'] = 0;
                    $config['max_height'] = 0;

                    $new_name = time(); //str_replace(" ", "_", $this->input->post('proveedor_nombre'));
                    $config['file_name'] = $new_name; //.$extencion;
                    $config['file_ext_tolower'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->do_upload('subcategoria_imagen');

                    $img_data = $this->upload->data();
                    $extension = $img_data['file_ext'];
                    /* ********************INICIO para resize***************************** */
                    if($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif") {
                        $conf['image_library'] = 'gd2';
                        $conf['source_image'] = $img_data['full_path'];
                        $conf['new_image'] = './resources/images/subcategorias/';
                        $conf['maintain_ratio'] = TRUE;
                        $conf['create_thumb'] = FALSE;
                        $conf['width'] = 800;
                        $conf['height'] = 600;
                        $this->image_lib->clear();
                        $this->image_lib->initialize($conf);
                        if(!$this->image_lib->resize()){
                            echo $this->image_lib->display_errors('','');
                        }
                    }
                    /* ********************F I N  para resize***************************** */
                    //$directorio = base_url().'resources/imagenes/';
                    $base_url = explode('/', base_url());
                    //$directorio = FCPATH.'resources\images\productos\\';
                    $directorio = $_SERVER['DOCUMENT_ROOT'].'/'.$base_url[3].'/resources/images/subcategorias/';
                    //$directorio = $_SERVER['DOCUMENT_ROOT'].'/ximpleman_web/resources/images/productos/';
                    if(isset($foto1) && !empty($foto1)){
                      if(file_exists($directorio.$foto1)){
                          unlink($directorio.$foto1);
                          //$mimagenthumb = str_replace(".", "_thumb.", $foto1);
                          $mimagenthumb = "thumb_".$foto1;
                          unlink($directorio.$mimagenthumb);
                      }
                  }
                    $confi['image_library'] = 'gd2';
                    $confi['source_image'] = './resources/images/subcategorias/'.$new_name.$extension;
                    $confi['new_image'] = './resources/images/subcategorias/'."thumb_".$new_name.$extension;
                    $confi['create_thumb'] = FALSE;
                    $confi['maintain_ratio'] = TRUE;
                    $confi['width'] = 50;
                    $confi['height'] = 50;

                    $this->image_lib->clear();
                    $this->image_lib->initialize($confi);
                    $this->image_lib->resize();

                    $foto = $new_name.$extension;
                }else{
                    $foto = $foto1;
                }
                /* *********************FIN imagen***************************** */
                    $params = array(
                        'subcategoria_nombre' => $this->input->post('subcategoria_nombre'),
                        'categoria_id' => $this->input->post('categoria_id'),
                        'subcategoria_imagen' => $foto,
                    );
                    $this->Subcategoria_producto_model->update_subcategoria_producto($subcategoria_id,$params);            
                    redirect('subcategoria_producto/index');
                }
                else
                {
                    $data['all_categoria_producto'] = $this->Categoria_producto_model->get_all_categoria_producto();
                    $data['_view'] = 'subcategoria_producto/edit';
                    $this->load->view('layouts/main',$data);
                }
            }
            else
                show_error('The subcategoria_producto you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting subcategoria_producto
     */
    function remove($subcategoria_id)
    {
        if($this->acceso(118)){
        $subcategoria_producto = $this->Categoria_producto_model->get_subcategoria_producto($subcategoria_id);
        // check if the subcategoria_producto exists before trying to delete it
        if(isset($subcategoria_producto['subcategoria_id']))
        {
            $this->Subcategoria_producto_model->delete_subcategoria_producto($subcategoria_id);
            redirect('subcategoria_producto/index');
        }
        else
            show_error('The subcategoria_producto you are trying to delete does not exist.');
        }
    }
    
}
