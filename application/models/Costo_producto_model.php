<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Costo_producto_model extends CI_Model{
    function __construct()
    {
        parent::__construct();
    }
    /**
     * Return all costos for a producto
     */
    function get_all_costos($producto){
        return $this->db->query(
            "SELECT cp.* , cc.catcosto_descripcion, c.costo_descripcion 
            from costo_producto cp
            left join categoria_costo cc on cc.catcosto_id = cp.catcosto_id
            left join costo c on c.costo_id = cp.costo_id 
            where 1 = 1
            and cp.producto_id = $producto"
        )->result_array();
    }

    function add_costo_producto($params){
        $this->db->insert('costo_producto',$params);
        return $this->db->insert_id();
    }

    function edit_costo_producto($cproducto_id,$params){
        $this->db->where('cproducto_id',$cproducto_id);
        return $this->db->update('costo_producto',$params);
    }

    function get_costos($costop_id){
        return $this->db->query(
            "SELECT cp.*,cc.*, c.costo_descripcion 
            from costo_producto cp
            left join categoria_costo cc on cp.catcosto_id = cc.catcosto_id 
            left join costo c on c.costo_id = cp.costo_id 
            where cp.cproducto_id = $costop_id"
        )->result_array();
    }

    function delete_costo_producto($costo_producto){
        return $this->db->delete('costo_producto',array('cproducto_id'=>$costo_producto));
    }
    
    /* obtiene los costos productos por id */
    function get_costos_porid($costo_id){
        return $this->db->query(
            "select cp.*
            from costo_producto cp
            where cp.costo_id = $costo_id"
        )->result_array();
    }
}
