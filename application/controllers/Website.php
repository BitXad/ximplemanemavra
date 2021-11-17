<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Website extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Pagina_web_model');
        $this->load->model('Producto_model');
        $this->load->model('Parametro_model');
        $this->load->model('Inventario_model');
        $this->load->model('Categoria_producto_model');
        $this->load->model('Imagen_producto_model');
        $this->load->model('Venta_model');
        $this->load->model('producto_model');
        $this->load->model('Cliente_model');
        $this->load->model('Configuracion_email_model');
        $this->load->helper('cookie');
        $this->load->model('Red_social_model');
    }            

    function index($idioma_id)
    {
        
        //$idioma_id = 1; //1 - español
        $data['idioma_id'] = $idioma_id;
        $data['pagina_web'] = $this->Pagina_web_model->get_pagina($idioma_id);
        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);
        $data['menu_item'] = $this->Pagina_web_model->get_menu_item($idioma_id);
        $data['slider'] = $this->Pagina_web_model->get_slider(1,$idioma_id); //tipo 1
        $data['seccion1'] = $this->Pagina_web_model->get_seccion(1,$idioma_id); //seccion 1
        $data['seccion2'] = $this->Pagina_web_model->get_seccion(2,$idioma_id); //seccion 2
        $data['seccion3'] = $this->Pagina_web_model->get_seccion(3,$idioma_id); //seccion 3        
        $data['ofertasemanal'] = $this->Pagina_web_model->get_oferta_semanal(); //seccion 3
        $data['ofertasdia'] = $this->Pagina_web_model->get_oferta_dia(); //seccion 3
        $data['slider2'] = $this->Pagina_web_model->get_slider(2,$idioma_id); //tipo 2
        $data['categorias'] = $this->Categoria_producto_model->get_all_categoria_producto(); //tipo 2
        $data['parametro'] = $this->Parametro_model->get_parametros();
        $data['all_redsocial'] = $this->Red_social_model->get_all_red_socialactivo(); //para redes sociales...
        
        //$data['mapa'] = $this->Mapa_model->get_mapa(1); //mapa
        
//        $data['_view'] = 'pagina_web/index';
//        $this->load->view('layouts/main',$data);        
        
        $data['_view'] = 'website';
//        $this->load->view('layouts/login',$data);
        $this->load->view('web/index',$data);
    }
    
    function categoria($idioma_id)
    {
        
        //$idioma_id = 1; //1 - español
        $data['idioma_id'] = $idioma_id;
        $data['pagina_web'] = $this->Pagina_web_model->get_pagina($idioma_id);
        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);
        $data['menu_item'] = $this->Pagina_web_model->get_menu_item($idioma_id);
        $data['slider'] = $this->Pagina_web_model->get_slider(1,$idioma_id); //tipo 1
        $data['seccion1'] = $this->Pagina_web_model->get_seccion(1,$idioma_id); //seccion 1
        $data['seccion2'] = $this->Pagina_web_model->get_seccion(2,$idioma_id); //seccion 2
        $data['seccion3'] = $this->Pagina_web_model->get_seccion(3,$idioma_id); //seccion 3        
        $data['ofertasemanal'] = $this->Pagina_web_model->get_oferta_semanal(); //seccion 3
        $data['ofertasdia'] = $this->Pagina_web_model->get_oferta_dia(); //seccion 3
        $data['slider2'] = $this->Pagina_web_model->get_slider(2,$idioma_id); //tipo 2
        $data['categorias'] = $this->Categoria_producto_model->get_all_categoria_producto(); //tipo 2
        $data['parametro'] = $this->Parametro_model->get_parametros();
        //$data['mapa'] = $this->Mapa_model->get_mapa(1); //mapa
        
//        $data['_view'] = 'pagina_web/index';
//        $this->load->view('layouts/main',$data);        
        
        $data['_view'] = 'website';
//        $this->load->view('layouts/login',$data);
        $this->load->view('web/category',$data);
    }

    function email(){

            $to = $this->input->post('empresa_email');
            $from = $this->input->post('froemail');
            $subject = $this->input->post('nomemail');
            $message = $this->input->post('mensaje12');
            $headers = "From: ".$from."";
             
            mail($to, $subject, $message, $headers);
                
            redirect('website/index/1');
            
    }

    function esp()
    {                
        $this->index(1);
    }
    function eng()
    {                
        $this->index(2);
        //site_url('website/index/2');
    }
    /* * buscar productos en web SIN ACCESO!! */
    function webbuscar_productos()
    {
        if($this->input->is_ajax_request()){
            $parametro = $this->input->post('parametro');
            $datos = $this->Producto_model->get_busqueda_productos($parametro);
            echo json_encode($datos);
        }
        else
        {                 
            show_404();
        }
    }

    function webbuscar_categoria($categoria_id)
    {
        if($this->input->is_ajax_request()){
                        
            $datos = $this->Producto_model->get_busqueda_categoria($categoria_id);
            echo json_encode($datos);
        }
        else
        {                 
            show_404();
        }
    }
    
    function webbuscar_subcategoria($subcategoria_id)
    {
        if($this->input->is_ajax_request()){
                        
            $datos = $this->Producto_model->get_busqueda_subcategoria($subcategoria_id);
            echo json_encode($datos);
        }
        else
        {                 
            show_404();
        }
    }
    
    
    function obtener_subcategoria($categoria_id)
    {
        if($this->input->is_ajax_request()){
                        
            $datos = $this->Producto_model->get_subcategorias($categoria_id);
            echo json_encode($datos);
        }
        else
        {                 
            show_404();
        }
    }
    
    function webbuscar_categoria_bloque($categoria_id)
    {
        if($this->input->is_ajax_request()){
                        
            $pagina = $this->input->post('pagina');
            $bloque = $this->input->post('bloque');
            
            $desde = ($pagina * $bloque) - ($bloque-1);
            $hasta = ($pagina * $bloque);
            
            $sql = "select * from inventario "
                    . " where categoria_id = ".$categoria_id
                    . " order by producto_nombre limit ".$desde.",".$hasta;
            
            $datos = $this->Inventario_model->consultar($sql);
            echo json_encode($datos);
        }
        else
        {                 
            show_404();
        }
    }
    
    function single($idioma_id,$producto_id)
    {
        
        //$idioma_id = 1; //1 - español
        
        $pagina_web = $this->Pagina_web_model->get_pagina($idioma_id);
        
        if (sizeof($pagina_web)>0){ //si es idioma valido
            
            $producto = $this->Pagina_web_model->get_producto($producto_id);
            
            if(sizeof($producto)>0){ //si el producto es valido

                $data['pagina_web'] = $pagina_web;
                $data['producto'] = $this->Pagina_web_model->get_producto($producto_id);
                $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
                $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);
                $data['menu_item'] = $this->Pagina_web_model->get_menu_item($idioma_id);
                $data['slider'] = $this->Pagina_web_model->get_slider(1,$idioma_id); //tipo 1
                $data['seccion1'] = $this->Pagina_web_model->get_seccion(1,$idioma_id); //seccion 1
                $data['seccion2'] = $this->Pagina_web_model->get_seccion(2,$idioma_id); //seccion 2
                $data['seccion3'] = $this->Pagina_web_model->get_seccion(3,$idioma_id); //seccion 3        
                $data['ofertasemanal'] = $this->Pagina_web_model->get_oferta_semanal(); //seccion 3
                $data['ofertasdia'] = $this->Pagina_web_model->get_oferta_dia(); //seccion 3
                $data['slider2'] = $this->Pagina_web_model->get_slider(2,$idioma_id); //tipo 2


                $data['idioma_id'] = $idioma_id;

                //Galeria de producto

               // $data['producto_nombre'] = $producto['producto_nombre'];
                $params = 0;
                $data['producto_id'] = $producto_id;
                $data['all_imagen_producto'] = $this->Imagen_producto_model->get_all_imagen_mi_producto($producto_id, $params);      

                //Galeria de producto

                $data['_view'] = 'website';
                $this->load->view('web/single',$data);
                
            }else{ redirect(""); }
            

        }else{ redirect(""); }
                    
    }


    function insertarproducto()
    {

        if ($this->input->is_ajax_request()) {
        $producto_id = $this->input->post('producto_id');
        $cantidad = $this->input->post('cantidad'); 
        $descuento = $this->input->post('descuento'); 
        $producto_precio = $this->input->post('producto_precio');
        $cliente = $this->input->post('cliente');

       $existe = "SELECT producto_id from carrito WHERE producto_id=". $producto_id." and cliente_id='".$cliente."' ";
        $exis=$this->db->query($existe)->row_array();
        if ($exis['producto_id'] > 0) {
         $sumar="UPDATE carrito
          SET carrito_cantidad=carrito_cantidad+".$cantidad.",
              carrito_subtotal = carrito_subtotal+(".$cantidad." * carrito_precio),
              carrito_total = carrito_total+(".$cantidad." * carrito_precio) - ".$descuento*$cantidad."  
              WHERE producto_id = ".$producto_id." ";
         $this->db->query($sumar);
       }else{

        $sql = "INSERT into carrito(
                
                producto_id,
                cliente_id,
                carrito_precio,
                carrito_costo,
                carrito_cantidad,
                carrito_descuento,
                carrito_subtotal,
                carrito_total
                            
                )
                (
                SELECT
                
                producto_id,
                '".$cliente."',
                ".$producto_precio.",
                producto_costo,
                ".$cantidad.",
                ".$descuento.",
                ".$cantidad." * ".$producto_precio.",
                (".$cantidad." * ".$producto_precio.") - ".$descuento."

                from producto where producto_id = ".$producto_id."
                )";
              
        $this->db->query($sql);

       }

    }          
    }

    function cantidad()
    {

        if ($this->input->is_ajax_request()) {
        $producto_id = $this->input->post('producto_id');
        $cantidad = $this->input->post('cantidad'); 
        $descuento = $this->input->post('descuento'); 
        $producto_precio = $this->input->post('producto_precio');

         $sumar="UPDATE carrito
          SET carrito_cantidad = ".$cantidad.",
              carrito_subtotal = (".$cantidad." * carrito_precio),
              carrito_total = (".$cantidad." * carrito_precio) - ".$descuento*$cantidad."  
              WHERE producto_id = ".$producto_id." ";
         $this->db->query($sumar);
       }
   }

    function carrito(){

        $cliente = $this->input->post('cliente');
        $datos = $this->Pagina_web_model->get_carrito($cliente);

        if(isset($datos)){
            echo json_encode($datos);
        }else { echo json_encode(null); } 
    }


    function sesioncliente(){
        
        $login = $this->input->post('login');
        $clave = md5($this->input->post('clave'));
        $ipe = $this->input->post('ipe');

//        $resultado = "SELECT * from cliente WHERE cliente_codigo='".$login."' AND cliente_codigo = '".$clave."' ";
        $resultado = "SELECT * from cliente WHERE cliente_email = '".$login."'".
                    " and cliente_clave = '".$clave."' ";
                    " and estado_id = 1";
        $result=$this->db->query($resultado)->row_array();
        
        if ($result){
        $clienteid = $result['cliente_id'];
        $clientenombre = $result['cliente_nombre'];
        $update="UPDATE carrito
                  SET cliente_id = '".$clienteid."' 
                  WHERE cliente_id = '".$ipe."' ";
        $this->db->query($update);

        setcookie("cliente_id", $clienteid, time() + (3600 * 24), "/");
        setcookie("cliente_nombre", $clientenombre, time() + (3600 * 24), "/");
        return true;
        
        }else{
            show_404();
        }
    }

    // ---------------------------------------FACEBOOK---------------------------------------------------
    function sesionclienteFacebook(){
        $name   = $this->input->post('name');
        $id     = $this->input->post('id');
        $ipe    = $this->input->post('ipe');
        $resultado = "SELECT * from cliente WHERE id_facebook = ".$id." and estado_id = 1";
        if($resultado){
            $result=$this->db->query($resultado)->row_array();
            if ($result){
                $clienteid = $result['cliente_id'];
                $clientenombre = $result['cliente_nombre'];
                $update="UPDATE carrito
                        SET cliente_id = '".$clienteid."' 
                        WHERE cliente_id = '".$ipe."' ";
                $this->db->query($update);
                setcookie("cliente_id", $clienteid, time() + (3600 * 24), "/");
                setcookie("cliente_nombre", $clientenombre, time() + (3600 * 24), "/");
                return true;
            }else{
                show_404();
            }
        }else{
            return false;
        }
    }

    function buscarCuenta(){
        $id = $this->input->post('id');
        $resultado = "SELECT count(*) as cantidad FROM cliente WHERE id_facebook = ".$id.";";
        $result=$this->db->query($resultado)->row_array();
        $respu = array("result"=>$result['cantidad']);
        echo json_encode($respu);
    }

    // ------------------------------------------------------------------------------------------

    function getcliente(){
            $cliente = $this->input->post('cliente');
        $datos = $this->Pagina_web_model->get_cliente($cliente);
         if(isset($datos)){
                            echo json_encode($datos);
                        }else { echo json_encode(null); } 
    }

    function quitar(){
            $producto_id = $this->input->post('producto_id');
        $sql = "DELETE FROM carrito
                WHERE producto_id=".$producto_id." ";
        $this->db->query($sql);
        return true;
    }


    function venta_online(){
        //renovar datos de cliente
        $nit = $this->input->post('nit');
        $razon = $this->input->post('razon');
        $telefono = $this->input->post('telefono');
        $direccion = $this->input->post('direccion');
        //datos para venta online
        $forma = $this->input->post('forma');
        $cliente = $this->input->post('cliente');
        $subtotal = $this->input->post('subtotal');
        $descuento = $this->input->post('descuento');
        $total = $this->input->post('total');
        $tipo_servicio = $this->input->post('tipo_servicio');

        $fecha = "now()";
        $hora = "'".date('H:i:s')."'";

        $updatecli = "UPDATE cliente SET cliente_nit='".$nit."', cliente_razon='".$razon."', cliente_telefono='".$telefono."',cliente_direccion='".$direccion."' WHERE cliente_id=".$cliente." ";
        $this->db->query($updatecli);
        $venta = "INSERT INTO venta_online
            (forma_id,
              tipotrans_id,
              cliente_id,
              moneda_id,
              estado_id,
              venta_fecha,
              venta_hora,
              venta_subtotal,
              venta_descuento,
              venta_total,
              venta_tipodoc,
              tiposerv_id,
              entrega_id
            )
            VALUES
            (".$forma.",          
              1,
              ".$cliente.",
              1,
              1,
              ".$fecha.",
              ".$hora.",
              ".$subtotal.",
              ".$descuento.",
              ".$total.",
              1,
              ".$tipo_servicio.",
              1          
              )"
            ;

            $this->db->query($venta);
            $venta_id = $this->db->insert_id();

        $detalle =  "INSERT INTO detalle_ventaonline
            (producto_id,
              venta_id,
              moneda_id,
              detalleven_codigo,
              detalleven_cantidad,
              detalleven_unidad,
              detalleven_costo,
              detalleven_precio,
              detalleven_subtotal,
              detalleven_descuento,
              detalleven_total,
              detalleven_caracteristicas,
              detalleven_comision,
              detalleven_tipocambio,
                detalleven_envase,
                detalleven_nombreenvase,
                detalleven_costoenvase,
                detalleven_precioenvase
            )


            (SELECT 
              c.producto_id,
              ".$venta_id.",
              1,
              producto_codigo,
              carrito_cantidad,
              producto_unidad,
              carrito_costo,
              carrito_precio,
              carrito_subtotal,
              carrito_descuento,
              carrito_total,
              producto_caracteristicas,
              producto_comision,
              producto_tipocambio,
                producto_envase,
                producto_nombreenvase,
                producto_costoenvase,
                producto_precioenvase
            FROM
              carrito c,producto p
              WHERE c.cliente_id=".$cliente." and c.producto_id=p.producto_id)"
            ;
            $this->db->query($detalle); 

            $borrar_carrito = "DELETE FROM carrito WHERE cliente_id='".$cliente."' ";
            $this->db->query($borrar_carrito);

    }

    function ximpleman(){

        header("location: https://www.ximpleman.com");
    }
    function password(){

        header("location: https://www.passwordbolivia.com");
    }

    function recuperarclave($idioma_id)
    {

        //$idioma_id = 1; //1 - español
        $data['idioma_id'] = $idioma_id;
        $data['pagina_web'] = $this->Pagina_web_model->get_pagina($idioma_id);
        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);

        $data['parametro'] = $this->Parametro_model->get_parametros();

        $data['_view'] = 'website';
        $this->load->view('web/recuperarclave',$data);
    }

    function miperfil($idioma_id)
    {
        //$idioma_id = 1; //1 - español
        $pagina_web = $this->Pagina_web_model->get_pagina($idioma_id);
        if (sizeof($pagina_web)>0){
            $data['pagina_web'] = $pagina_web;
            $data['idioma_id'] = $idioma_id;
        }
        else{

            redirect("website/miperfil/1");
        }


        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);

        if (isset($_COOKIE["cliente_id"])){

            $cliente_id = $_COOKIE["cliente_id"];
            if(is_numeric($cliente_id)){

                $data['cliente'] = $this->Cliente_model->get_cliente($cliente_id);
                $data['parametro'] = $this->Parametro_model->get_parametros();
                $data['_view'] = 'website';
                $this->load->view('web/miperfil',$data);

            }else{ redirect(); }

        }
        else{ redirect(); }

    }

    function micarrito($idioma_id)
    {
        //$idioma_id = 1; //1 - español
        $pagina_web = $this->Pagina_web_model->get_pagina($idioma_id);
        if (sizeof($pagina_web)>0){
            $data['pagina_web'] = $pagina_web;
            $data['idioma_id'] = $idioma_id;
        }
        else{

            redirect("website/micarrito/1");
        }    

    //    $data['idioma_id'] = $idioma_id;
        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);
        $data['parametro'] = $this->Parametro_model->get_parametros(); 

        if (isset($_COOKIE["cliente_id"])){

            $cliente_id = $_COOKIE["cliente_id"];

            if(is_numeric($cliente_id)){

                $cliente = $this->Cliente_model->get_cliente($cliente_id);
                $data['productos'] = $this->Pagina_web_model->get_carrito($cliente_id);

                $data['_view'] = 'website';
                $this->load->view('web/micarrito',$data);

            }else{ redirect(); }

        }
        else{ redirect(); }

    }

    function miscompras($idioma_id)
    {
        //$idioma_id = 1; //1 - español
        $pagina_web = $this->Pagina_web_model->get_pagina($idioma_id);
        if (sizeof($pagina_web)>0){
            $data['pagina_web'] = $pagina_web;
            $data['idioma_id'] = $idioma_id;
        }
        else{

            redirect("website/miscompras/1");
        }    

        //$idioma_id = 1; //1 - español
        $data['idioma_id'] = $idioma_id;
    //    $data['pagina_web'] = $this->Pagina_web_model->get_pagina($idioma_id);
        $data['menu_cabecera'] = $this->Pagina_web_model->get_menu_cabecera($idioma_id);
        $data['menu_principal'] = $this->Pagina_web_model->get_menu_principal($idioma_id);


        if (isset($_COOKIE["cliente_id"])){

            $cliente_id = $_COOKIE["cliente_id"];

            if(is_numeric($cliente_id)){

                $cliente = $this->Cliente_model->get_cliente($cliente_id);
                $data['cliente'] = $cliente;

                $data['parametro'] = $this->Parametro_model->get_parametros();


                $data['compras'] = $this->Pagina_web_model->get_compras($cliente_id);

                $data['_view'] = 'website';
                $this->load->view('web/miscompras',$data);

            }else{ redirect(); }

        }else{ redirect(); }

    }


    /*
     * Editing a cliente
     */
    function modificarperfil($cliente_id)
    {
       
        $data['page_title'] = "Cliente";
        // check if the cliente exists before trying to edit it
        $data['cliente'] = $this->Cliente_model->get_cliente($cliente_id);
        
        if(isset($data['cliente']['cliente_id']))
        {
            $this->load->library('form_validation');

			//$this->form_validation->set_rules('cliente_codigo','Cliente Codigo','required');
			$this->form_validation->set_rules('cliente_nombre','Cliente Nombre','required');
                        //$this->form_validation->set_rules('cliente_nombrenegocio','Cliente Nombre Negocio','required');
		
	    if($this->form_validation->run())     
            {
                //$usuario_id = $this->session_data['usuario_id'];
                /* *********************INICIO imagen***************************** */
                $foto="";
                $foto1= $this->input->post('cliente_foto1');
                if (!empty($_FILES['cliente_foto']['name']))
                {
                    $config['upload_path'] = './resources/images/clientes/';
                    $config['allowed_types'] = 'gif|jpeg|jpg|png';
                    $config['max_size'] = 0;
                    $config['max_width'] = 5900;
                    $config['max_height'] = 5900;

                    $new_name = time(); //str_replace(" ", "_", $this->input->post('proveedor_nombre'));
                    $config['file_name'] = $new_name; //.$extencion;
                    $config['file_ext_tolower'] = TRUE;
                    
                    $this->load->library('image_lib');
                    $this->image_lib->initialize($config);
                    
                    $this->load->library('upload', $config);
                    $this->upload->do_upload('cliente_foto');

                    $img_data = $this->upload->data();
                    $extension = $img_data['file_ext'];
                    /* ********************INICIO para resize***************************** */
                    if($img_data['file_ext'] == ".jpg" || $img_data['file_ext'] == ".png" || $img_data['file_ext'] == ".jpeg" || $img_data['file_ext'] == ".gif") {
                        $conf['image_library'] = 'gd2';
                        $conf['source_image'] = $img_data['full_path'];
                        $conf['new_image'] = './resources/images/clientes/';
                        $conf['maintain_ratio'] = TRUE;
                        $conf['create_thumb'] = FALSE;
                        $conf['width'] = 800;
                        $conf['height'] = 600;
                        
                        $this->image_lib->initialize($conf);
                        if(!$this->image_lib->resize()){
                            echo $this->image_lib->display_errors('','');
                        }
                        $this->image_lib->clear();
                    }
                    /* ********************F I N  para resize***************************** */
                    //$directorio = base_url().'resources/imagenes/';
                    $base_url = explode('/', base_url());
                    //$directorio = FCPATH.'resources\images\clientes\\';
                    $directorio = $_SERVER['DOCUMENT_ROOT'].'/'.$base_url[3].'/resources/images/clientes/';
                    //$directorio = $_SERVER['DOCUMENT_ROOT'].'/ximpleman_web/resources/images/clientes/';
                    if(isset($foto1) && !empty($foto1)){
                        if(file_exists($directorio.$foto1)){
                            unlink($directorio.$foto1);
                            $mimagenthumb = "thumb_".$foto1;
                            unlink($directorio.$mimagenthumb);
                        }
                    }
                    $confi['image_library'] = 'gd2';
                    $confi['source_image'] = './resources/images/clientes/'.$new_name.$extension;
                    $confi['new_image'] = './resources/images/clientes/'."thumb_".$new_name.$extension;
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
                            //$this->input->post('cliente_foto'),
                           //$mifecha = $this->Cliente_model->normalize_date($this->input->post('cliente_aniversario'));
                            //$mifecha = normalize_date($this->input->post('cliente_aniversario'));
                    
                
                    $params = array(
//                        'estado_id' => $this->input->post('estado_id'),
//                        'tipocliente_id' => $this->input->post('tipocliente_id'),
//                        'categoriaclie_id' => $this->input->post('categoriaclie_id'),
//                        'cliente_codigo' => $this->input->post('cliente_codigo'),
//                        'zona_id' => $this->input->post('zona_id'),
                        'cliente_nombre' => $this->input->post('cliente_nombre'),
//                        'cliente_ci' => $this->input->post('cliente_ci'),
                        'cliente_direccion' => $this->input->post('cliente_direccion'),
                        'cliente_telefono' => $this->input->post('cliente_telefono'),
                        'cliente_celular' => $this->input->post('cliente_celular'),
                        'cliente_foto' => $foto,
//                        'cliente_email' => $this->input->post('cliente_email'),
                        'cliente_nombrenegocio' => $this->input->post('cliente_nombrenegocio'),
//                        'cliente_aniversario' => $this->input->post('cliente_aniversario'),
                        'cliente_latitud' => $this->input->post('cliente_latitud'),
                        'cliente_longitud' => $this->input->post('cliente_longitud'),
                        'cliente_nit' => $this->input->post('cliente_nit'),
                        'cliente_razon' => $this->input->post('cliente_razon'),
//                        'cliente_departamento' => $this->input->post('cliente_departamento'),
//                        'usuario_id' => $this->input->post('usuario_id'),                        
//                        'cliente_ordenvisita' => $this->input->post('cliente_ordenvisita'),
                    );

                    $idioma_id = $this->input->post('idioma_id');
                    $this->Cliente_model->update_cliente($cliente_id,$params);            
//                    redirect('website/miperfil/'.$idioma_id);
                    redirect("website/miperfil/".$idioma_id);
                }
                else
                {
                    $idioma_id = $this->input->post('idioma_id');
                    redirect("website/miperfil/".$idioma_id);
                }
            }
            else
                show_error('The cliente you are trying to edit does not exist.');
        
    }
    
    
    /*
    * Registrar cliente
    */
    function registrarclienteonline()
    {
    //        if(($this->acceso(12)==true)||($this->acceso(30)==true)){
    //        //**************** inicio contenido ***************    
    //    
            if ($this->input->is_ajax_request()) {


                $cliente_nit = $this->input->post('nit');
                $cliente_razon = "'".$this->input->post('razon')."'";
                $cliente_telefono = "'".$this->input->post('telefono')."'";
                $tipocliente_id = $this->input->post('tipocliente_id');

                $nombre =  $this->input->post('cliente_nombre');
                $cliente_nombre =  "'".$nombre."'";
                $cliente_ci =  "'".$this->input->post('cliente_ci')."'";
                $cliente_nombrenegocio =  "'".$this->input->post('cliente_nombrenegocio')."'";
                $cliente_codigo =  "'".$this->input->post('cliente_codigo')."'";

                $cliente_direccion =  "'".$this->input->post('cliente_direccion')."'";
                $cliente_departamento =  "'".$this->input->post('cliente_departamento')."'";
                $cliente_celular =  "'".$this->input->post('cliente_celular')."'";
                $zona_id =  $this->input->post('zona_id');
                $email = $this->input->post('cliente_email');
                $cliente_email = "'".$email."'";
                $codigo = mt_rand(100000,1250000);
                $id_facebook = $this->input->post('id_facebook');
                if($id_facebook != "0"){
                    $estado_id = 1; //Se crea cliente con Facebook
                }else{
                    $estado_id = 2; //Se crea cliente con correo
                }
                
                $codigo_activacion = "'".$codigo."'";
                
                
                $cliente_clave = "'".md5($this->input->post('cliente_clave'))."'";


                $sql = "insert into cliente(tipocliente_id,categoriaclie_id,cliente_nombre,cliente_ci,cliente_nit,
                        cliente_razon,cliente_telefono,estado_id,usuario_id,
                        cliente_nombrenegocio, cliente_codigo, cliente_direccion, cliente_departamento,
                        cliente_celular, zona_id, cliente_email, cliente_clave,cliente_codactivacion,id_facebook
                        ) value(".$tipocliente_id.",1,".$cliente_nombre.",".$cliente_ci.",".$cliente_nit.",".
                        $cliente_razon.",".$cliente_telefono.",".$estado_id.",0,".
                        $cliente_nombrenegocio.",".$cliente_codigo.",".$cliente_direccion.",".$cliente_departamento.",".
                        $cliente_celular.",".$zona_id.",".$cliente_email.",".$cliente_clave.",".$codigo_activacion.",".$id_facebook.");";

                

                $datos = $this->Venta_model->registrarcliente($sql);
                $cliente_id = 0
                        ;
                if (isset($datos)){
                    $cliente_id  = $datos[0]["cliente_id"];                    
                }
                
                
                $parametros = base_url("verificar/activate/".$cliente_id."/".md5($codigo));
                
                $this->enviar_email($parametros,$email,$nombre);
                
                echo json_encode($datos);

            }
            else
            {                 
                show_404();

            }   


            //**************** fin contenido ***************
    //        			}

    }    

    function buscar_email(){

        $email = $this->input->post('email');
        $sql = "select cliente_email from cliente where cliente_email = '".$email."'";
        $resultado =  $this->Inventario_model->consultar($sql);
        echo json_encode($resultado);
    }
    
    function enviar_email($direccion,$email_destino,$nombre_cliente) {

            $this->load->library('email');
            $this->email->set_newline("\r\n");
            $configuracion = $this->Configuracion_email_model->get_configuracion_email(1);
            
            $config['protocol'] = $configuracion['email_protocolo'];
            $config['smtp_host'] = $configuracion['email_host'];
            $config['smtp_port'] = $configuracion['email_puerto'];
            $config['smtp_user'] = $configuracion['email_usuario'];
            $config['smtp_pass'] = $configuracion['email_clave'];
            $config['smtp_from_name'] = $configuracion['email_nombre'];
            $config['priority'] = $configuracion['email_prioridad'];
            $config['charset'] = $configuracion['email_charset'];
            $config['smtp_crypto'] = $configuracion['email_encriptacion'];
            $config['wordwrap'] = TRUE;
            $config['newline'] = "\r\n";
            $config['mailtype'] = $configuracion['email_tipo'];
            $email_copia = '';
            
            $this->email->initialize($config);

            $this->email->from($config['smtp_user'], $config['smtp_from_name']);
            $this->email->to($email_destino);
            $this->email->cc($configuracion['email_copia']);
//            $this->email->bcc($attributes['cc']);
            $this->email->subject("Felicidades por registrarte en nuestra plataforma");

            
            $html = "<html>";
            $html = "<head>";
            $html = "<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta/css/bootstrap.min.css' integrity='sha384-/Y6pD6FV/Vv2HJnA6t+vslU6fwYXjCFtcEpHbNJ0lyAFsXTsjBbfaDjzALeQsN6M' crossorigin='anonymous'>";
            $html = "</head>";
            $html = "<body>";
            
            $html .= "<div class='container' style='font-family: Arial'>";
            $html .= "<div class='col-md-2' style='background:gray;'></div>";
            
            $html .= "<div class='col-md-10'>";
            $html .= "<center>";
            $html .= "<h3>GRACIAS POR REGISTRARTE</h3>";
            $html .= " ";
            $html .= "<h4>".$nombre_cliente." BIENVENIDO(A) A NUESTRA PLATAFORMA</h4>";
            $html .= "<br>";
            $html .= $configuracion['email_cabecera'];
            $html .= "<br>";
            $html .= "<br><a href='".$direccion."' class='btn btn-info btn-sm' > Activar mi Cuenta</a>";
//            $html .= "<form method='get' action='/".$direccion."'>";
//            $html .= "<button type='submit'>Activar mi Cuenta</button>";
//            $html .= "</form>";
            
            $html .= "<br>";
            $html .= "<br>";

            $html .= $configuracion['email_pie'];
            $html .= "<br>";
            $html .= "<br>";
            $html .= "<br><a href='".$direccion."' class='btn btn-info btn-sm'>".$direccion."</a>";
           
            $html .= "</center>";
            $html .= "</div>";
            
            $html .= "<div class='col-md-2'></div>";            
            $html .= "</div>";
            
            $html .= "</body>";
            $html .= "</html>";
            
            
            $this->email->message($html);

            if($this->email->send()) {
                return true;        
            } else {
                return false;
            }       

    }

    function selecionar_sucursal(){
        $this->load->view("web/select_sucursal");
    }
   

}
