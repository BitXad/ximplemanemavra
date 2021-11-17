<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Articulo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get articulo by articulo_id
     */
    function get_articulo($articulo_id)
    {
        $articulo = $this->db->query("
            SELECT
                *

            FROM
                `articulo`

            WHERE
                `articulo_id` = ?
        ",array($articulo_id))->row_array();

        return $articulo;
    }
    
    /*
     * Get all articulo count
     */
    function get_all_articulo_count()
    {
        $articulo = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `articulo`
        ")->row_array();

        return $articulo['count'];
    }
        
    /*
     * Get all articulo
     */
    function get_all_articulo($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $articulo = $this->db->query("
            SELECT
                *

            FROM
                articulo a, estado_pagina e, seccion s, slide l

            WHERE
                a.estadopag_id = e.estadopag_id
                and a.seccion_id = s.seccion_id
                and a.slide_id = l.slide_id

            ORDER BY `articulo_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $articulo;
    }
        
    /*
     * function to add new articulo
     */
    function add_articulo($params)
    {
        $this->db->insert('articulo',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update articulo
     */
    function update_articulo($articulo_id,$params)
    {
        $this->db->where('articulo_id',$articulo_id);
        return $this->db->update('articulo',$params);
    }
    
    /*
     * function to delete articulo
     */
    function delete_articulo($articulo_id)
    {
        return $this->db->delete('articulo',array('articulo_id'=>$articulo_id));
    }
}
