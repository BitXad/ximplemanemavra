<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Asiento_eliminado_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get asiento_eliminado by cod_asiento_elim
     */
    function get_asiento_eliminado($cod_asiento_elim)
    {
        $asiento_eliminado = $this->db->query("
            SELECT
                *

            FROM
                `asiento_eliminado`

            WHERE
                `cod_asiento_elim` = ?
        ",array($cod_asiento_elim))->row_array();

        return $asiento_eliminado;
    }
        
    /*
     * Get all asiento_eliminado
     */
    function get_all_asiento_eliminado()
    {
        $asiento_eliminado = $this->db->query("
            SELECT
                *

            FROM
                `asiento_eliminado`

            WHERE
                1 = 1

            ORDER BY `cod_asiento_elim` DESC
        ")->result_array();

        return $asiento_eliminado;
    }
        
    /*
     * function to add new asiento_eliminado
     */
    function add_asiento_eliminado($params)
    {
        $this->db->insert('asiento_eliminado',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update asiento_eliminado
     */
    function update_asiento_eliminado($cod_asiento_elim,$params)
    {
        $this->db->where('cod_asiento_elim',$cod_asiento_elim);
        return $this->db->update('asiento_eliminado',$params);
    }
    
    /*
     * function to delete asiento_eliminado
     */
    function delete_asiento_eliminado($cod_asiento_elim)
    {
        return $this->db->delete('asiento_eliminado',array('cod_asiento_elim'=>$cod_asiento_elim));
    }
}
