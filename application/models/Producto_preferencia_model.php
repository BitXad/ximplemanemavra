<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Producto_preferencia_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get preferencia by productopref_id
     */
    function get_producto_preferencia($productopref_id)
    {
        $producto_preferencia = $this->db->query("
            SELECT
                *
            FROM
                `producto_preferencia`
            WHERE
                `productopref_id` = ?
        ",array($productopref_id))->row_array();

        return $producto_preferencia;
    }
        
    /*
     * Get all preferencia
     */
    function get_all_producto_preferencia()
    {
        $producto_preferencia = $this->db->query("
            SELECT
                *
            FROM
                `productopref_id`
            WHERE
                1 = 1

            ORDER BY `productopref_id` DESC
        ")->result_array();

        return $producto_preferencia;
    }
        
    /*
     * function to add new producto_preferencia
     */
    function add_producto_preferencia($params)
    {
        $this->db->insert('producto_preferencia',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update preferencia
     */
    function update_producto_preferencia($productopref_id,$params)
    {
        $this->db->where('productopref_id',$productopref_id);
        return $this->db->update('producto_preferencia',$params);
    }
    
    /*
     * function to delete preferencia
     */
    function delete_producto_preferencia($productopref_id)
    {
        return $this->db->delete('producto_preferencia',array('productopref_id'=>$productopref_id));
    }
    /*
     * Get all preferencia count
     */
    function get_all_producto_preferencia_count()
    {
        $producto_preferencia = $this->db->query("
            SELECT
                count(*) as count
            FROM
                `producto_preferencia`
        ")->row_array();

        return $producto_preferencia['count'];
    }
    /*
     * Get all preferencia
     */
    function get_producto_preferencia_all($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $producto_preferencia = $this->db->query("
            SELECT
                pp.*, p.producto_nombre
            FROM
                `conspreferencia` pp
            left join producto p on pp.producto_id = p.producto_id
            ORDER BY p.`producto_nombre`
            " . $limit_condition . "
        ")->result_array();

        return $producto_preferencia;
    }
    /* Get all preferencias dado un producto */
    function get_allproductos_preferencia($producto_id)
    {
        $producto_preferencia = $this->db->query("
            SELECT
                pp.*, p.producto_nombre
            FROM
                `conspreferencia` pp
            left join producto p on pp.producto_id = p.producto_id
            where
                pp.producto_id = $producto_id
            ORDER BY pp.`preferencia_descripcion`
        ")->result_array();

        return $producto_preferencia;
    }
    /* Get all productos que hacen preferencia */
    function get_allpreferencia_producto()
    {
        $producto_preferencia = $this->db->query("
            SELECT
                pp.*
            FROM
                `conspreferencia` pp            
            ORDER BY pp.`preferencia_descripcion`
        ")->result_array();

        return $producto_preferencia;
    }
}
