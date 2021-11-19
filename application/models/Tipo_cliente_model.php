<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Tipo_cliente_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tipo_cliente by tipocliente_id
     */
    function get_tipo_cliente($tipocliente_id)
    {
        $tipo_cliente = $this->db->query("
            SELECT
                *

            FROM
                `tipo_cliente`

            WHERE
                `tipocliente_id` = ?
        ",array($tipocliente_id))->row_array();

        return $tipo_cliente;
    }
    
    /*
     * Get all tipo_cliente count
     */
    function get_all_tipo_cliente_count()
    {
        $tipo_cliente = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `tipo_cliente`
        ")->row_array();

        return $tipo_cliente['count'];
    }
        
    /*
     * Get all tipo_cliente
     */
    function get_all_tipo_cliente()
    {
//        $limit_condition = "";
//        if(isset($params) && !empty($params))
//            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $sql = "SELECT * FROM `tipo_cliente` WHERE 1 = 1
                ORDER BY `tipocliente_id`";
        
        $tipo_cliente = $this->db->query($sql)->result_array();

        return $tipo_cliente;
    }
        
    /*
     * function to add new tipo_cliente
     */
    function add_tipo_cliente($params)
    {
        $this->db->insert('tipo_cliente',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tipo_cliente
     */
    function update_tipo_cliente($tipocliente_id,$params)
    {
        $this->db->where('tipocliente_id',$tipocliente_id);
        return $this->db->update('tipo_cliente',$params);
    }
    
    /*
     * function to delete tipo_cliente
     */
    function delete_tipo_cliente($tipocliente_id)
    {
        return $this->db->delete('tipo_cliente',array('tipocliente_id'=>$tipocliente_id));
    }
    /*
     * Get all tipo_cliente ASC
     */
    function get_all_tipo_cliente_asc($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $tipo_cliente = $this->db->query("
            SELECT
                *

            FROM
                `tipo_cliente`

            WHERE
                1 = 1

            ORDER BY `tipocliente_id` ASC

            " . $limit_condition . "
        ")->result_array();

        return $tipo_cliente;
    }
}