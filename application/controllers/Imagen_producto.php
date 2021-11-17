<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Imagen_producto extends CI_Controller{
    private $session_data = "";
    function __construct()
    {
        parent::__construct();
        $this->load->model('Imagen_producto_model');
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
     * Listing of imagen_producto
     */
    function index()
    {
        if($this->acceso(109)){
            $data['page_title'] = "Imagen Producto";
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('imagen_producto/index?');
        $config['total_rows'] = $this->Imagen_producto_model->get_all_imagen_producto_count();
        $this->pagination->initialize($config);

        $data['all_imagen_producto'] = $this->Imagen_producto_model->get_all_imagen_producto($params);
        
        $data['_view'] = 'imagen_producto/index';
        $this->load->view('layouts/main',$data);
        }
    }

    /*
     * Adding a new imagen_producto
     */
     function add($producto_id)
    {
        if($this->acceso(69)){
            //$this->load->library('form_validation');
            /* *********************INICIO imagen***************************** */
            $foto="";
            if (!empty($_FILES['file']['name'])){
		
                        $this->load->library('image_lib');
                        $config['upload_path'] = './resources/images/productos/';
                        $img_full_path = $config['upload_path'];

                        $config['allowed_types'] = 'gif|jpeg|jpg|png';
                        $config['image_library'] = 'gd2';
                        $config['max_size'] = 0;
                        $config['max_width'] = 9900;
                        $config['max_height'] = 9900;
                        
                        $new_name = time(); //str_replace(" ", "_", $this->input->post('proveedor_nombre'));
                        $config['file_name'] = $new_name; //.$extencion;
                        $config['file_ext_tolower'] = TRUE;

                        $this->load->library('upload', $config);
                        $this->upload->do_upload('file');

                        $img_data = $this->upload->data();
                        $extension = $img_data['file_ext'];
                        /* ********************INICIO para resize***************************** */
                        if ($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif") {
                            $conf['image_library'] = 'gd2';
                            $conf['source_image'] = $img_data['full_path'];
                            $conf['new_image'] = './resources/images/productos/';
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
                        $confi['source_image'] = './resources/images/productos/'.$new_name.$extension;
                        $confi['new_image'] = './resources/images/productos/'."thumb_".$new_name.$extension;
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
            $estado_id = 1;
            $params = array(
                'producto_id' => $producto_id,
                'estado_id' => $estado_id,
                'imagenprod_titulo' => $foto,
                'imagenprod_archivo' => $foto,
                'imagenprod_descripcion' => $foto,
            );
            
            $imagenprod_id = $this->Imagen_producto_model->add_imagen_producto($params);
            sleep(1);
            redirect('imagen_producto/catalogoprod/'.$producto_id);
            
        }
    }

    /*
     * Editing a imagen_producto
     */
    function edit($producto_id, $imagenprod_id)
    {
        if($this->acceso(109)){
            $data['page_title'] = "Imagen Producto";
        // check if the imagen_producto exists before trying to edit it
        $data['imagen_producto'] = $this->Imagen_producto_model->get_imagen_producto($imagenprod_id);
        
        if(isset($data['imagen_producto']['imagenprod_id']))
        {
            $this->load->library('form_validation');

	    $this->form_validation->set_rules('imagenprod_titulo','Imagen producto Titulo','required');
		
	    if($this->form_validation->run())     
            {
                /* *********************INICIO imagen***************************** */
                $foto="";
                    $foto1= $this->input->post('imagenprod_archivo1');
                if (!empty($_FILES['imagenprod_archivo']['name']))
                {
                    $this->load->library('image_lib');
                    $config['upload_path'] = './resources/images/productos/';
                    $config['allowed_types'] = 'gif|jpeg|jpg|png';
                    $config['max_size'] = 200000;
                    $config['max_width'] = 2900;
                    $config['max_height'] = 2900;

                    $new_name = time();
                    $config['file_name'] = $new_name; //.$extencion;
                    $config['file_ext_tolower'] = TRUE;

                    $this->load->library('upload', $config);
                    $this->upload->do_upload('imagenprod_archivo');

                    $img_data = $this->upload->data();
                    $extension = $img_data['file_ext'];
                    /* ********************INICIO para resize***************************** */
                    if($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif") {
                        $conf['image_library'] = 'gd2';
                        $conf['source_image'] = $img_data['full_path'];
                        $conf['new_image'] = './resources/images/productos/';
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
                    $directorio = FCPATH.'resources\images\productos\\';
                    //$directorio = $_SERVER['DOCUMENT_ROOT'].'/ximpleman_web/resources/images/productos/';
                    if(isset($foto1) && !empty($foto1)){
                      if(file_exists($directorio.$foto1)){
                          unlink($directorio.$foto1);
                          $mimagenthumb = "thumb_".$foto1;
                          //$mimagenthumb = str_replace(".", "_thumb.", $foto1);
                          unlink($directorio.$mimagenthumb);
                      }
                  }
                    $confi['image_library'] = 'gd2';
                    $confi['source_image'] = './resources/images/productos/'.$new_name.$extension;
                    $confi['new_image'] = './resources/images/productos/'."thumb_".$new_name.$extension;
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
			        'producto_id' => $producto_id,
			        'estado_id' => $this->input->post('estado_id'),
				'imagenprod_titulo' => $this->input->post('imagenprod_titulo'),
				'imagenprod_archivo' => $foto,
				'imagenprod_descripcion' => $this->input->post('imagenprod_descripcion'),
                );

                $this->Imagen_producto_model->update_imagen_producto($imagenprod_id,$params);            
                redirect('imagen_producto/catalogoprod/'.$producto_id);
            }
            else
            {
		$this->load->model('Estado_model');
		$data['all_estado'] = $this->Estado_model->get_all_estado();
		$data['producto_id'] = $producto_id;

                $data['_view'] = 'imagen_producto/edit';
                $this->load->view('layouts/main',$data);
            }
        }
        else
            show_error('The imagen_producto you are trying to edit does not exist.');
        }
    } 

    /*
     * Deleting imagen_producto
     */
    function remove($imagenprod_id)
    {
        if($this->acceso(109)){
        $imagen_producto = $this->Imagen_producto_model->get_imagen_producto($imagenprod_id);

        // check if the imagen_producto exists before trying to delete it
        if(isset($imagen_producto['imagenprod_id']))
        {
            $this->Imagen_producto_model->delete_imagen($imagenprod_id);
            redirect('imagen_producto/catalogoprod/'.$imagen_producto['producto_id']);
        }
        else
            show_error('The imagen_producto you are trying to delete does not exist.');
        }
    }
    /*
     * Funcion que muestra las imagenes de un producto
     */
    function catalogoprod($producto_id)
    {
        if($this->acceso(109)){
            $data['page_title'] = "Imagenen Producto";
            $data['tipousuario_id'] = $this->session_data['tipousuario_id'];
            
        $params['limit'] = RECORDS_PER_PAGE; 
        $params['offset'] = ($this->input->get('per_page')) ? $this->input->get('per_page') : 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('imagen_producto/index?');
        $config['total_rows'] = $this->Imagen_producto_model->get_all_imagen_mi_producto_count($producto_id);
        $this->pagination->initialize($config);

        $this->load->model('Producto_model');
	$producto = $this->Producto_model->get_esteproducto($producto_id);
        $data['producto_id'] = $producto_id;
        $data['producto_nombre'] = $producto['producto_nombre'];
        $data['all_imagen_producto'] = $this->Imagen_producto_model->get_all_imagen_mi_producto($producto_id, $params);
        
        $data['_view'] = 'imagen_producto/catalogoprod';
        $this->load->view('layouts/main',$data);
        }
    }
    
    /*
     * Muestra la Galeria de Imagenes de un Producto(producto_id)
     */
    function galeriaproducto($producto_id)
    {
        if($this->acceso(109)){
            $data['page_title'] = "Galeria Producto";
       
        $params = 0;
        
        $config = $this->config->item('pagination');
        $config['base_url'] = site_url('imagen_producto/index?');
        $config['total_rows'] = $this->Imagen_producto_model->get_all_imagen_mi_producto_count($producto_id);
        $this->pagination->initialize($config);

        $this->load->model('Producto_model');
	$producto = $this->Producto_model->get_esteproducto($producto_id);
        $data['producto_nombre'] = $producto['producto_nombre'];
        $data['producto_id'] = $producto_id;
        $data['all_imagen_producto'] = $this->Imagen_producto_model->get_all_imagen_mi_producto($producto_id, $params);
        
        $data['_view'] = 'imagen_producto/galeriaproducto';
        $this->load->view('layouts/main',$data);
        }
    }
    /* ***** Funcion que muestra las imagenes de DETALLES DE SERVICIO ***** */
    function catalogodet($detalleserv_id, $b = null)
    {
        if($this->acceso(69)){
            $data['page_title'] = "Imagenen Producto";
            $data['b'] = $b;
            $data['tipousuario_id'] = $this->session_data['tipousuario_id'];
            $this->load->model('Detalle_serv_model');
            $detalle_serv = $this->Detalle_serv_model->get_detalle_serv($detalleserv_id);
            $data['detalleserv_id'] = $detalleserv_id;
            $data['servicio_id'] = $detalle_serv['servicio_id'];
            $data['detalleserv_descripcion'] = $detalle_serv['detalleserv_descripcion'];
            $data['detalleservestado_id'] = $detalle_serv['estado_id'];
            $data['all_imagen_detalle_serv'] = $this->Imagen_producto_model->get_all_imagen_mi_det($detalleserv_id);

            $data['_view'] = 'imagen_producto/catalogodet';
            $this->load->view('layouts/main',$data);
        }
    }
    function addimg_det($detalleserv_id, $b = null)
    {
        if($this->acceso(69)){
            //$this->load->library('form_validation');
            $this->load->model('Parametro_model');
            $parametro = $this->Parametro_model->get_parametro(1);
            $data['b'] = $b;
            if($b == "s"){
                $esunico = "/s";
            }else{ $esunico = ""; }
            $tipousuario_id = $this->session_data['tipousuario_id'];
            /* *********************INICIO imagen***************************** */
            $foto="";
            if (!empty($_FILES['galeria_imagen']['name'])){
		
                        $this->load->library('image_lib');
                        $config['upload_path'] = './resources/images/servicios/';
                        $img_full_path = $config['upload_path'];

                        $config['allowed_types'] = 'gif|jpeg|jpg|png';
                        $config['image_library'] = 'gd2';
                        $config['max_size'] = 0;
                        /*$config['max_width'] = 9900;
                        $config['max_height'] = 9900;*/
                        
                        $new_name = time(); //str_replace(" ", "_", $this->input->post('proveedor_nombre'));
                        $config['file_name'] = $new_name; //.$extencion;
                        $config['file_ext_tolower'] = TRUE;

                        $this->load->library('upload', $config);
                        $this->upload->do_upload('galeria_imagen');
                        //si´parametro es 0 ---> imagen comprimido
                        if($parametro['parametro_imagenreal'] == 0){
                        $img_data = $this->upload->data();
                        $extension = $img_data['file_ext'];
                        /* ********************INICIO para resize***************************** */
                        if ($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif")
                        {
                            $conf['image_library'] = 'gd2';
                            $conf['source_image'] = $img_data['full_path'];
                            $conf['new_image'] = './resources/images/servicios/';
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
                        $confi['source_image'] = './resources/images/servicios/'.$new_name.$extension;
                        $confi['new_image'] = './resources/images/servicios/'."thumb_".$new_name.$extension;
                        $confi['create_thumb'] = FALSE;
                        $confi['maintain_ratio'] = TRUE;
                        $confi['width'] = 50;
                        $confi['height'] = 50;

                        $this->image_lib->clear();
                        $this->image_lib->initialize($confi);
                        $this->image_lib->resize();

                        $foto = $new_name.$extension;
                        }else{
                            $img_data = $this->upload->data();
                            $extension = $img_data['file_ext'];
                            
                            $confi['image_library'] = 'gd2';
                            $confi['source_image'] = './resources/images/servicios/'.$new_name.$extension;
                            $confi['new_image'] = './resources/images/servicios/'."thumb_".$new_name.$extension;
                            $confi['create_thumb'] = FALSE;
                            $confi['maintain_ratio'] = TRUE;
                            $confi['width'] = 50;
                            $confi['height'] = 50;

                            $this->image_lib->clear();
                            $this->image_lib->initialize($confi);
                            $this->image_lib->resize();

                            
                            $foto = $new_name.$extension;
                        }
                    }
            /* *********************FIN imagen***************************** */
            $estado_id = 1;
            $params = array(
                'detalleserv_id' => $detalleserv_id,
                'estado_id' => $estado_id,
                'imagenprod_titulo' => $foto,
                'imagenprod_archivo' => $foto,
                'imagenprod_descripcion' => $this->input->post('galeria_descripcion'),
            );
            
            $imagenprod_id = $this->Imagen_producto_model->add_imagen_producto($params);
            //sleep(1);
            redirect('imagen_producto/catalogodet/'.$detalleserv_id.$esunico);
            
        }
    }
    
    function eliminar($imagenprod_id, $b = null)
    {
        if($this->acceso(69)){
        $imagen_producto = $this->Imagen_producto_model->get_imagen_producto($imagenprod_id);
        $data['b'] = $b;
        if($b == "s"){
            $esunico = "/s";
        }else{ $esunico = ""; }
        // check if the imagen_producto exists before trying to delete it
        if(isset($imagen_producto['imagenprod_id']))
        {
            $imagen= $this->Imagen_producto_model->get_imagen_producto($imagenprod_id);
            $base_url = explode('/', base_url());
            //$directorio = FCPATH.'resources\images\clientes\\';
            $directorio = $_SERVER['DOCUMENT_ROOT'].'/'.$base_url[3].'/resources/images/servicios/';
            //$directorio = $_SERVER['DOCUMENT_ROOT'].'/ximpleman_web/resources/images/clientes/';
            $foto1 = $imagen['imagenprod_archivo'];
            if(isset($foto1) && !empty($foto1)){
              if(file_exists($directorio.$foto1)){
                  unlink($directorio.$foto1);
                  $mimagenthumb = "thumb_".$foto1;
                  unlink($directorio.$mimagenthumb);
                }
            }
            $this->Imagen_producto_model->delete_imagen($imagenprod_id);
            redirect('imagen_producto/catalogodet/'.$imagen_producto['detalleserv_id'].$esunico);
        }
        else
            show_error('The imagen_producto you are trying to delete does not exist.');
        }
    }
    
    function galeriadetalle($detalleserv_id, $b = null)
    {
        if($this->acceso(69)){
            $data['b'] = $b;
        $this->load->model('Detalle_serv_model');
	$detalle_serv = $this->Detalle_serv_model->get_detalle_serv($detalleserv_id);
        $data['detalleserv_descripcion'] = $detalle_serv['detalleserv_descripcion'];
        $data['detalleserv_id'] = $detalleserv_id;
        $data['all_imagen_detalle_serv'] = $this->Imagen_producto_model->get_all_imagen_mi_det($detalleserv_id);
        
        $data['_view'] = 'imagen_producto/galeriadetalle';
        $this->load->view('layouts/main',$data);
        }
    }
}
