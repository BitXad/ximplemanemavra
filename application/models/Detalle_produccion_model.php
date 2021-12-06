<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Detalle_produccion_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * function to add new area
     */
    function add_detalle_produccion($params)
    {
        $this->db->insert('detalle_produccion',$params);
        return $this->db->insert_id();
    }
    
    function get_all_produccion($area_id){
        return $this->db->query(
            "SELECT ci.*, p.producto_nombre, dp.* 
            from control_inventario ci
            left join detalle_produccion dp on ci.controli_id = dp.controli_id 
            left join estado e on ci.estado_id = e.estado_id
            left join producto p on dp.producto_id = p.producto_id
            where 1=1
            and ci.area_id = $area_id"
        )->result_array();
    }

    function update_detalle($id, $params){
        $this->db->where('detproduccion_id',$id);
        return $this->db->update('detalle_produccion',$params);
    }
    /* obtiene todos los detalles de una producción */
    function get_all_detalleproduccion($produccion_id){
        return $this->db->query(
            "SELECT dp.*, p.producto_nombre, a.area_id, a.area_nombre, e.estado_color, e.estado_descripcion
            from detalle_produccion dp
            left join producto p on dp.producto_id = p.producto_id
            left join control_inventario ci on dp.controli_id = ci.controli_id 
            left join estado e on dp.estado_id = e.estado_id
            left join area a on ci.area_id = a.area_id
            where
                dp.produccion_id = $produccion_id
        ")->result_array();
    }

    function get_detproduccion($detproduccion_id){
        return $this->db->query(
            "SELECT dp.*
            from detalle_produccion dp
            where 1 = 1
            and dp.detproduccion_id = $detproduccion_id"
        )->result_array();
    }
    
    /*
     * funccion para agregar a detalle aux
     */
    function add_detalle_produccion_aux($params)
    {
        $this->db->insert('detalle_produccion_aux',$params);
        return $this->db->insert_id();
    }
    /* obtiene todos los detalles de aux */
    function get_all_detalleproduccion_aux($usuario_id){
        return $this->db->query(
            "SELECT dp.*, p.producto_nombre, a.area_nombre, e.estado_color, e.estado_descripcion
            from detalle_produccion_aux dp
            left join producto p on dp.producto_id = p.producto_id
            left join control_inventario ci on dp.controli_id = ci.controli_id 
            left join estado e on dp.estado_id = e.estado_id
            left join area a on ci.area_id = a.area_id
            where
                dp.usuario_id = $usuario_id
        ")->result_array();
    }
    /*
     * function to delete one detalle produccion aux
     */
    function delete_detalleproduccion_aux($detproduccion_id)
    {
        return $this->db->delete('detalle_produccion_aux',array('detproduccion_id'=>$detproduccion_id));
    }
    /*
     * function to delete one detalle produccion aux
     */
    function delete_alldetalleproduccion_aux($usuario_id)
    {
        return $this->db->delete('detalle_produccion_aux',array('usuario_id'=>$usuario_id));
    }
    /*
     * inserta el detalle_formula_aux de una Formula en detalle_venta
     */
    function insertar_detalleprod_aux_endetalleprod($usuario_id, $produccion_id)
    {
        $detalle_formula = $this->db->query("
            insert into detalle_produccion
            (
            produccion_id, producto_id, controli_id, estado_id, detproduccion_cantidad,
            detproduccion_costo, detproduccion_perdida, detproduccion_observacion
            )
            (SELECT
                $produccion_id, df.producto_id, df.controli_id, df.estado_id, df.detproduccion_cantidad,
                df.detproduccion_costo, 0, df.detproduccion_observacion
            FROM
              `detalle_produccion_aux` df
            WHERE 
              df.usuario_id = $usuario_id)"
            ); //->result_array();

        return true;
    }
    /**
     * Get price for a producto
     */
    function get_precio_producto($producto_id) {
        return $this->db->query(
            "SELECT p.producto_costo 
            from producto p 
            where 1=1
            and p.producto_id = $producto_id"
            )->row_array();
    }

    function get_costo_producto($detproduccion_id){
        return $this->db->query(
            "SELECT p.producto_costo 
            from producto p 
            left join detalle_produccion dp on dp.producto_id = p.producto_id 
            where 1=1
            and dp.detproduccion_id = $detproduccion_id"
        )->row_array();
    }

    function get_detproduccion_venta($detproduccion_id,$controli_id){
        return $this->db->query(
            "SELECT dp.*,p2.producto_nombre
            from detalle_produccion dp 
            left join produccion p on p.produccion_id = dp.produccion_id 
            left join producto p2 on p2.producto_id = dp.producto_id 
            where 1=1
            and dp.controli_id = $controli_id
            and dp.detproduccion_id = $detproduccion_id"
        )->result_array();
    }
}
