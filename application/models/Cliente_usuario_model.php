<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Cliente_usuario_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get cliente_usuario by cliente_id
     */
    function get_cliente_usuario($cliente_id)
    {
        $cliente_usuario = $this->db->query("
            SELECT
                *

            FROM
                `cliente_usuario`

            WHERE
                `cliente_id` = ?
        ",array($cliente_id))->row_array();

        return $cliente_usuario;
    }
    
    /*
     * Get all cliente_usuario count
     */
    function get_all_cliente_usuario_count()
    {
        $cliente_usuario = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `cliente_usuario`
        ")->row_array();

        return $cliente_usuario['count'];
    }
        
    /*
     * Get all cliente_usuario
     */
    function get_all_cliente_usuario($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $cliente_usuario = $this->db->query("
            SELECT
                *

            FROM
                `cliente_usuario`

            WHERE
                1 = 1

            ORDER BY `cliente_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $cliente_usuario;
    }
        
    /*
     * function to add new cliente_usuario
     */
    function add_cliente_usuario($params)
    {
        $this->db->insert('cliente_usuario',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update cliente_usuario
     */
    function update_cliente_usuario($cliente_id,$params)
    {
        $this->db->where('cliente_id',$cliente_id);
        return $this->db->update('cliente_usuario',$params);
    }
    
    /*
     * function to delete cliente_usuario
     */
    function delete_cliente_usuario($cliente_id)
    {
        return $this->db->delete('cliente_usuario',array('cliente_id'=>$cliente_id));
    }
}