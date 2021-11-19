<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Boton_articulo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get boton_articulo by botonartic_id
     */
    function get_boton_articulo($botonartic_id)
    {
        $boton_articulo = $this->db->query("
            SELECT
                *

            FROM
                `boton_articulo`

            WHERE
                `botonartic_id` = ?
        ",array($botonartic_id))->row_array();

        return $boton_articulo;
    }
    
    /*
     * Get all boton_articulo count
     */
    function get_all_boton_articulo_count()
    {
        $boton_articulo = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `boton_articulo`
        ")->row_array();

        return $boton_articulo['count'];
    }
        
    /*
     * Get all boton_articulo
     */
    function get_all_boton_articulo($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $boton_articulo = $this->db->query("
            SELECT
                *

            FROM
                boton_articulo ba, articulo a, boton b

            WHERE
                ba.articulo_id = a.articulo_id
                and ba.boton_id = b.boton_id

            ORDER BY `botonartic_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $boton_articulo;
    }
        
    /*
     * function to add new boton_articulo
     */
    function add_boton_articulo($params)
    {
        $this->db->insert('boton_articulo',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update boton_articulo
     */
    function update_boton_articulo($botonartic_id,$params)
    {
        $this->db->where('botonartic_id',$botonartic_id);
        return $this->db->update('boton_articulo',$params);
    }
    
    /*
     * function to delete boton_articulo
     */
    function delete_boton_articulo($botonartic_id)
    {
        return $this->db->delete('boton_articulo',array('botonartic_id'=>$botonartic_id));
    }
}