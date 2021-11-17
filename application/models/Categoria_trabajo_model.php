<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_trabajo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get categoria_trabajo by cattrab_id
     */
    function get_categoria_trabajo($cattrab_id)
    {
        return $this->db->get_where('categoria_trabajo',array('cattrab_id'=>$cattrab_id))->row_array();
    }
        
    /*
     * Get all categoria_trabajo
     */
    function get_all_categoria_trabajo()
    {
        $trabajo = $this->db->query("
            SELECT
                *

            FROM
                categoria_trabajo ct, estado e

            WHERE
                ct.estado_id = e.estado_id
                
                ORDER BY ct.cattrab_id DESC

        ")->result_array();

        return $trabajo;
    }
        
    /*
     * function to add new categoria_trabajo
     */
    function add_categoria_trabajo($params)
    {
        $this->db->insert('categoria_trabajo',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update categoria_trabajo
     */
    function update_categoria_trabajo($cattrab_id,$params)
    {
        $this->db->where('cattrab_id',$cattrab_id);
        return $this->db->update('categoria_trabajo',$params);
    }
    
    /*
     * function to delete categoria_trabajo
     */
    function delete_categoria_trabajo($cattrab_id)
    {
        return $this->db->delete('categoria_trabajo',array('cattrab_id'=>$cattrab_id));
    }
    
    /*
     * Get all categoria_trabajo con id ==1
     */
    function get_all_categoria_trabajo_id1()
    {
        $cattrab = $this->db->query("
            SELECT
                ct.`cattrab_id`, ct.`cattrab_descripcion`

            FROM
                categoria_trabajo ct, estado e

            WHERE
                ct.estado_id = e.estado_id
                and e.`estado_tipo` = 1
                and e.estado_id = 1
                
        ")->result_array();

        return $cattrab;
    }
}
