<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Asiento_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get asiento by cod_asiento
     */
    function get_asiento($cod_asiento)
    {
        $asiento = $this->db->query("
            SELECT
                *

            FROM
                `asiento`

            WHERE
                `cod_asiento` = ?
        ",array($cod_asiento))->row_array();

        return $asiento;
    }
        
    /*
     * Get all asiento
     */
    function get_all_asiento()
    {
        $asiento = $this->db->query("
            SELECT
                *

            FROM
                `asiento`

            WHERE
                1 = 1

            ORDER BY `cod_asiento` DESC
        ")->result_array();

        return $asiento;
    }
        
    /*
     * function to add new asiento
     */
    function add_asiento($params)
    {
        $this->db->insert('asiento',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update asiento
     */
    function update_asiento($cod_asiento,$params)
    {
        $this->db->where('cod_asiento',$cod_asiento);
        return $this->db->update('asiento',$params);
    }
    
    /*
     * function to delete asiento
     */
    function delete_asiento($cod_asiento)
    {
        return $this->db->delete('asiento',array('cod_asiento'=>$cod_asiento));
    }
}