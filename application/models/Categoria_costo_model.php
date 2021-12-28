<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_costo_model extends CI_Model{
    function __construct(){
        parent::__construct();
    }

    /**
     * get a categoria costo for id
     */
    function get_catcosto($catcosto_id){
        return $this->db->query(
            "SELECT cc.* 
            FROM categoria_costo cc
            WHERE 1=1
            AND  cc.catcosto_id = $catcosto_id"
        )->row_array();
    }

    function get_all_categoria_costo(){
        return $this->db->query(
            "SELECT cc.*
            from categoria_costo cc"
        )->result_array();
    }
    /*
     * Get all categoria_costo
     */
    function get_all_categorias($aux = "AND cp.catcosto_id < 3"){
        return $this->db->query(
            "SELECT cp.*
            from categoria_costo cp
            where 1=1   
            $aux"
        )->result_array();
    }
    
    function edit_costo($id,$params){
        $this->db->where('catcosto_id',$id);
        return $this->db->update('categoria_costo',$params);
    }

    function get_catcostos_porcentajes(){
        return $this->db->query(
            "SELECT cc.*
            from categoria_costo cc
            where cc.catcosto_tipo = 1
            order by cc.catcosto_id asc"
        )->result_array();
    }
}
