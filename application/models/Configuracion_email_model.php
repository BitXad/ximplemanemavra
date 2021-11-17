<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Configuracion_email_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get configuracion_email by email_id
     */
    function get_configuracion_email($email_id)
    {
        $configuracion_email = $this->db->query("
            SELECT
                *

            FROM
                `configuracion_email`

            WHERE
                `email_id` = ?
        ",array($email_id))->row_array();

        return $configuracion_email;
    }
        
    /*
     * Get all configuracion_email
     */
    function get_all_configuracion_email()
    {
        $configuracion_email = $this->db->query("
            SELECT
                c.*, e.estado_descripcion
            FROM
                `configuracion_email` c, `estado` e
            WHERE
                c.estado_id = e.estado_id
            ORDER BY `email_id` ASC
        ")->result_array();

        return $configuracion_email;
    }
        
   
    /*
     * function to add new configuracion_email
     */
    function add_configuracion_email($params)
    {
        $this->db->insert('configuracion_email',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update configuracion_email
     */
    function update_configuracion_email($email_id,$params)
    {
        $this->db->where('email_id',$email_id);
        return $this->db->update('configuracion_email',$params);
    }
    
    /*
     * function to delete configuracion_email
     */
    function delete_configuracion_email($email_id)
    {
        return $this->db->delete('configuracion_email',array('email_id'=>$email_id));
    }
}
