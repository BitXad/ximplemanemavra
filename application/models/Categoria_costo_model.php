<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_costo_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }
    /*
     * Get all categoria_costo
     */
    function get_all_categorias(){
        return $this->db->query(
            "SELECT cp.*
            from categoria_costo cp
            where 1=1
            and cp.catcosto_id < 3"
        )->result_array();
    }
    
}