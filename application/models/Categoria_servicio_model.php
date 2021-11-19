<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_servicio_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get categoria_servicio by catserv_id
     */
    function get_categoria_servicio($catserv_id)
    {
        return $this->db->get_where('categoria_servicio',array('catserv_id'=>$catserv_id))->row_array();
    }
    
    /*
     * Get all categoria_servicio + sus subcategorias
     */
    function get_all_categoria_servicio()
    {
        $servicio = $this->db->query("
            SELECT
                *

            FROM
                categoria_servicio cs, estado e

            WHERE
                cs.estado_id = e.estado_id
            ORDER BY `catserv_id` DESC

        ")->result_array();

        return $servicio;
    }
    function get_all_categoria_servicio_asc()
    {
        $servicio = $this->db->query("
            SELECT
                *

            FROM
                categoria_servicio cs, estado e

            WHERE
                cs.estado_id = e.estado_id

        ")->result_array();

        return $servicio;
    }
        
    /*
     * Get all categoria_servicio + sus subcategorias
     */
    function get_all_categoria_subcat_servicio()
    {
        $servicio = $this->db->query("
            SELECT
                *, cs.catserv_id as id

            FROM
                categoria_servicio cs, subcategoria_servicio sc, estado e

            WHERE
                cs.estado_id = e.estado_id
                and cs.catserv_id = sc.catserv_id
            ORDER BY `id` DESC

        ")->result_array();

        return $servicio;
    }
        
    /*
     * function to add new categoria_servicio
     */
    function add_categoria_servicio($params)
    {
        $this->db->insert('categoria_servicio',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update categoria_servicio
     */
    function update_categoria_servicio($catserv_id,$params)
    {
        $this->db->where('catserv_id',$catserv_id);
        return $this->db->update('categoria_servicio',$params);
    }
    
    /*
     * function to delete categoria_servicio
     */
    function delete_categoria_servicio($catserv_id)
    {
        return $this->db->delete('categoria_servicio',array('catserv_id'=>$catserv_id));
    }
    
    /*
     * Get all categoria_servicio ACTIVOS
     */
    function get_all_categoria_servicio_id1()
    {
        $categoria = $this->db->query("
            SELECT
                *

            FROM
                categoria_servicio cs, estado e

            WHERE
                cs.estado_id = e.estado_id
                and e.estado_id = 1

        ")->result_array();

        return $categoria;
    }
}