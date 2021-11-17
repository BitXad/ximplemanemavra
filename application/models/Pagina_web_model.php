<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Pagina_web_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get pagina_web by pagina_id
     */
    function get_pagina_web($pagina_id)
    {
        $pagina_web = $this->db->query("
            SELECT
                *

            FROM
                `pagina_web`

            WHERE
                `pagina_id` = ?
        ",array($pagina_id))->row_array();

        return $pagina_web;
    }
    
    /*
     * Get all pagina_web count
     */
    function get_all_pagina_web_count()
    {
        $pagina_web = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `pagina_web`
        ")->row_array();

        return $pagina_web['count'];
    }
        
    /*
     * Get all pagina_web
     */
    function get_all_pagina_web($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $pagina_web = $this->db->query("
            SELECT
                *

            FROM
                pagina_web p, idioma i, estado_pagina e, empresa em

            WHERE
                p.idioma_id = i.idioma_id
                and p.estadopag_id = e.estadopag_id
                and p.empresa_id = em.empresa_id

            ORDER BY `pagina_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $pagina_web;
    }
        
    /*
     * Get all pagina_web
     */
    function get_pagina($idioma_id)
    {
        $pagina_web = $this->db->query("
            SELECT * FROM pagina_web p, empresa_pagina x, empresa e
            WHERE p.idioma_id = ".$idioma_id." and p.pagina_id = x.pagina_id and 
                x.empresa_id = e.empresa_id 
            ORDER BY p.pagina_id DESC" )->result_array();

        return $pagina_web;
    }
        
    /*
     * Get all pagina_web
     */
    function get_menu_cabecera($idioma_id)
    {
        
        if ($idioma_id%2==1){ //español
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=1 ";
        }
        else //ingles
        {
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=2 ";          
        }
        
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;
    }
        
    /*
     * Get all menu_principal
     */
    function get_menu_principal($idioma_id)
    {
        if ($idioma_id%2==1){ //español
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=3 ";
        }
        else //ingles
        {
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=4 ";          
        }
        
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;        
    }
        
    /*
     * Get all menu_item
     */

    function get_menu_item($idioma_id)
    {
        if ($idioma_id%2==1){ //español
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=3 ";
        }
        else //ingles
        {
            $sql = "select * from pagina_web p, menu_principal mp, menu m
            where p.pagina_id = mp.pagina_id and mp.menup_id = m.menup_id and p.idioma_id = ".$idioma_id.
            "  and mp.menup_id=4 ";          
        }
        
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;        
    }
        
    /*
     * Get all menu_item
     */
    function get_slider($tipo,$idioma_id)
    {
        $sql = "select * from slide s, pagina_web p 
                where s.pagina_id = p.pagina_id and p.idioma_id=".$idioma_id." and s.slide_tipo=".$tipo;
       
        $resultado = $this->db->query($sql)->result_array();
        return $resultado; 
        
    }
        
    /*
     * Secciones
     */
    function get_seccion($tipo,$idioma_id)
    {
        $sql = "select * from seccion s, pagina_web p
                where p.pagina_id = s.pagina_id and s.seccion_tipo=".$tipo." and p.idioma_id=".$idioma_id;
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;        
    }
      
    /*
     * Ofertas
     */
    function get_oferta_dia()
    {
        $sql = "select * from producto p, promocion m where p.producto_id = m.producto_id and m.promocion_fecha=date(now())";
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;        
    }
        
    /*
     * Ofertas
     */
    function get_oferta_semanal()
    {
        $sql = "select * from producto p, promocion m where p.producto_id = m.producto_id";
        $resultado = $this->db->query($sql)->result_array();
        return $resultado;        
    }
    
    function get_producto($producto_id)
    {
        $sql = "select c.*, p.* from categoria_producto c, producto p 
                where c.categoria_id = p.categoria_id and p.producto_id=".$producto_id."";
       
        $resultado = $this->db->query($sql)->result_array();
        return $resultado; 
        
    }
    
    function get_carrito($cliente_id)
    {
        $sql = "SELECT c.*, p.producto_nombre, p.producto_unidadentera,p.producto_foto from carrito c, inventario p
               where c.producto_id=p.producto_id and cliente_id='".$cliente_id."' ORDER BY c.carrito_id asc ";
        $result = $this->db->query($sql)->result_array();
        return $result;        
    }

    function get_compras($cliente_id)
    {

        $sql = "select * from venta_online v
                left join estado e on e.estado_id = v.estado_id 
                where v.cliente_id = ".$cliente_id;
        $result = $this->db->query($sql)->result_array();
        return $result;
        
    }
    
    function get_cliente($cliente)
    {
        $sql = "SELECT * from cliente
               where cliente_id='".$cliente."' ";
        $result = $this->db->query($sql)->row_array();
        return $result;        
    }

        
    /*
     * function to add new pagina_web
     */
    function add_pagina_web($params)
    {
        $this->db->insert('pagina_web',$params);
        return $this->db->insert_id();
    }

    /*
     * function to update pagina_web
     */
    function update_pagina_web($pagina_id,$params)
    {
        $this->db->where('pagina_id',$pagina_id);
        return $this->db->update('pagina_web',$params);
    }
    
    /*
     * function to delete pagina_web
     */
    function delete_pagina_web($pagina_id)
    {
        return $this->db->delete('pagina_web',array('pagina_id'=>$pagina_id));
    }
}
