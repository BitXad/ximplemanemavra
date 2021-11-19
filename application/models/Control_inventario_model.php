<?php

class Control_inventario_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get all control inventario
     */
    function get_all_control_inventario($fecha_inicio = " ", 
                                        $fecha_fin = " ",
                                        $estado = " ")
    {
        return $this->db->query(
            "SELECT ci.*, e.estado_descripcion
            from control_inventario ci 
            left join estado e on ci.estado_id = e.estado_id
            where 1 = 1 
            $fecha_inicio 
            $fecha_fin 
            $estado
            order by ci.controli_id desc")->result_array();
    }
    
    /*
     * Get control inventario por controli_id
     */
    function get_control_inventario($controli_id)
    {
        return $this->db->query(
            "SELECT ci.*
            from control_inventario ci 
            where ci.controli_id = $controli_id")->row_array();
    }
    
    /*
     * function to add new control inventario
     */
    function add_control_inventario($params)
    {
        $this->db->insert('control_inventario',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update control invetario
     */
    function update_control_inventario($controli_id,$params)
    
    {
        $this->db->where('controli_id',$controli_id);
        return $this->db->update('control_inventario',$params);
    }


    function get_ubicacion($controli){
        return $this->db->query(
            "SELECT u.ubicacion_id, u.ubicacion_nombre, u.ubicacion_descripcion 
            from ubicacion u, control_inventario ci 
            where 1 = 1
            and ci.ubicacion_id = u.ubicacion_id 
            and ci.controli_id = $controli"
        )->result_array();
    }
    function get_ultimo_registro(){
        return $this->db->query(
            "SELECT ci.controli_id 
            from control_inventario ci 
            order by ci.controli_id desc limit 1
            ")->row_array();
    } 
    function delete_inventario($controli_id){
        return $this->db->delete('control_inventario',array('controli_id'=>$controli_id));
    }

    function get_platabanda($area_id){
        return $this->db->query(
            "SELECT ci.*,e.*
            from control_inventario ci
            left join estado e on ci.estado_id = e.estado_id
            where 1=1
            and ci.area_id = $area_id
            and e.estado_tipo = 9
            order by ci.controli_id desc"
        )->result_array();
    }

    function get_platabanda_area($area_id = 1){
        return $this->db->query(
            "SELECT ci.*, p.producto_nombre, dp.*,e.* 
            from control_inventario ci
            left join detalle_produccion dp on ci.controli_id = dp.controli_id 
            left join estado e on dp.estado_id = e.estado_id
            left join producto p on dp.producto_id = p.producto_id
            where 1=1
            and ci.area_id = $area_id
            and e.estado_tipo = 9
            order by ci.controli_id desc"
        )->result_array();
    }

    function add_platabanda($params)
    {
        $this->db->insert('control_inventario',$params);
        return $this->db->insert_id();
    }

    function get_items_platabanda($controli_id){
        return $this->db->query(
            "SELECT dp.*,p.producto_nombre, e.*,p2.*
            from detalle_produccion dp 
            left join producto p on p.producto_id = dp.producto_id 
            left join control_inventario ci on ci.controli_id = dp.controli_id 
            left join estado e on e.estado_id = dp.estado_id 
            left join produccion p2 on p2.produccion_id = dp.produccion_id 
            where 1=1
            and ci.controli_id = $controli_id"
        )->result_array();
    }
}