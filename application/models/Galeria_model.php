<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Galeria_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get galeria by galeria_id
     */
    function get_galeria($galeria_id)
    {
        $galeria = $this->db->query("
            SELECT
                *

            FROM
                `galeria`

            WHERE
                `galeria_id` = ?
        ",array($galeria_id))->row_array();

        return $galeria;
    }
    
    /*
     * Get all galeria count
     */
    function get_all_galeria_count()
    {
        $galeria = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `galeria`
        ")->row_array();

        return $galeria['count'];
    }
        
    /*
     * Get all galeria
     */
    function get_all_galeria($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $galeria = $this->db->query("
            SELECT
                *

            FROM
                galeria g, estado_pagina e

            WHERE
                g.estadopag_id = e.estadopag_id

            ORDER BY `galeria_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $galeria;
    }
        
    /*
     * function to add new galeria
     */
    function add_galeria($params)
    {
        $this->db->insert('galeria',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update galeria
     */
    function update_galeria($galeria_id,$params)
    {
        $this->db->where('galeria_id',$galeria_id);
        return $this->db->update('galeria',$params);
    }
    
    /*
     * function to delete galeria
     */
    function delete_galeria($galeria_id)
    {
        return $this->db->delete('galeria',array('galeria_id'=>$galeria_id));
    }
}