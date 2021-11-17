<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Tipo_transaccion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get tipo_transaccion by tipotrans_id
     */
    function get_tipo_transaccion($tipotrans_id)
    {
        $tipo_transaccion = $this->db->query("
            SELECT
                *

            FROM
                `tipo_transaccion`

            WHERE
                `tipotrans_id` = ?
        ",array($tipotrans_id))->row_array();

        return $tipo_transaccion;
    }
    
    /*
     * Get all tipo_transaccion count
     */
    function get_all_tipo_transaccion_count()
    {
        $tipo_transaccion = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `tipo_transaccion`
        ")->row_array();

        return $tipo_transaccion['count'];
    }
        
    /*
     * Get all tipo_transaccion
     */
    function get_all_tipo_transaccion($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $tipo_transaccion = $this->db->query("
            SELECT
                *

            FROM
                `tipo_transaccion`

            WHERE
                1 = 1

            ORDER BY `tipotrans_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $tipo_transaccion;
    }

    function get_all_tipo()
    {
        $tipo_transaccion = $this->db->query("select * from tipo_transaccion")->result_array();
        return $tipo_transaccion;
    }
        
    /*
     * function to add new tipo_transaccion
     */
    function add_tipo_transaccion($params)
    {
        $this->db->insert('tipo_transaccion',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update tipo_transaccion
     */
    function update_tipo_transaccion($tipotrans_id,$params)
    {
        $this->db->where('tipotrans_id',$tipotrans_id);
        return $this->db->update('tipo_transaccion',$params);
    }
    
    /*
     * function to delete tipo_transaccion
     */
    function delete_tipo_transaccion($tipotrans_id)
    {
        return $this->db->delete('tipo_transaccion',array('tipotrans_id'=>$tipotrans_id));
    }
}
