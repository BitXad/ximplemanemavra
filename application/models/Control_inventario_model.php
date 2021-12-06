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

    function get_platabanda($area_id, $activo=""){
        return $this->db->query(
            "SELECT ci.*,e.*
            from control_inventario ci
            left join estado e on ci.estado_id = e.estado_id
            where 1=1
            and ci.area_id = $area_id
            and e.estado_tipo = 9
            $activo
            order by ci.controli_id asc"
        )->result_array();
    }

    function get_platabanda_area($area_id = 1){
        return $this->db->query(
            "SELECT p.producto_nombre, p.producto_foto, dp.*,e.estado_color, ap.aproducto_dias, ap.aproducto_dias2, p2.*,c2.*
            from control_inventario ci
            left join detalle_produccion dp on ci.controli_id = dp.controli_id 
            left join estado e on dp.estado_id = e.estado_id
            left join producto p on dp.producto_id = p.producto_id
            left join aviso_producto ap on ap.producto_id = dp.producto_id
            left join produccion p2 on p2.produccion_id = dp.produccion_id
            left join (
                select dp2.*, if(sum(dc.detallecomp_cantidad)>0,sum(dc.detallecomp_cantidad),0) as cant_compra, d3.cant_perdida
                from detalle_produccion dp2
                left join control_inventario ci2 on dp2.controli_id = ci2.controli_id
                left join detalle_compra dc on dc.detproduccion_id = dp2.detproduccion_id 
                left join (
                    select dp3.detproduccion_id , if(sum(p.perdida_cantidad)>0,sum(p.perdida_cantidad),0) as cant_perdida
                    from detalle_produccion dp3
                    left join control_inventario ci3 on ci3.controli_id = dp3.controli_id 
                    left join perdida p on dp3.detproduccion_id = p.detproduccion_id 
                    where 1=1
                    and ci3.area_id = $area_id
                    and dp3.estado_id <> 39
                    group by dp3.detproduccion_id
                ) as d3 on d3.detproduccion_id = dp2.detproduccion_id 
                where 1=1
                and ci2.area_id = $area_id
                and dp2.estado_id <> 39
                group by dp2.detproduccion_id 
            ) c2 on c2.detproduccion_id = dp.detproduccion_id 
            where 1=1
            and ci.area_id = $area_id
            and e.estado_tipo = 9
            and dp.estado_id <> 39
            order by ci.controli_id,dp.estado_id asc"
        )->result_array();
    }

    function add_platabanda($params){
        $this->db->insert('control_inventario',$params);
        return $this->db->insert_id();
    }

    function get_items_platabanda($controli_id, $produccion=""){
        return $this->db->query(
            "SELECT dp.*,p.producto_nombre,p.producto_foto, e.*,p2.produccion_id,p2.produccion_registro, sa.*
            from detalle_produccion dp 
            left join producto p on p.producto_id = dp.producto_id 
            left join control_inventario ci on ci.controli_id = dp.controli_id 
            left join estado e on e.estado_id = dp.estado_id 
            left join produccion p2 on p2.produccion_id = dp.produccion_id
            left join (
                select dp2.*, if(sum(dc.detallecomp_cantidad)>0,sum(dc.detallecomp_cantidad),0) as cant_compra, d3.cant_perdida
                from detalle_produccion dp2
                left join control_inventario ci2 on dp2.controli_id = ci2.controli_id
                left join detalle_compra dc on dc.detproduccion_id = dp2.detproduccion_id 
                left join (
                    select dp3.detproduccion_id , if(sum(p.perdida_cantidad)>0,sum(p.perdida_cantidad),0) as cant_perdida
                    from detalle_produccion dp3
                    left join control_inventario ci3 on ci3.controli_id = dp3.controli_id 
                    left join perdida p on dp3.detproduccion_id = p.detproduccion_id 
                    where 1=1
                    and dp3.controli_id = $controli_id
                    and dp3.estado_id <> 39
                    group by dp3.detproduccion_id
                ) as d3 on d3.detproduccion_id = dp2.detproduccion_id 
                where 1=1
                and dp2.controli_id = $controli_id
                and dp2.estado_id <> 39
                group by dp2.detproduccion_id 
            )sa on sa.detproduccion_id = dp.detproduccion_id 
            where 1=1
            and dp.controli_id = $controli_id
            and dp.estado_id <> 39
            $produccion
            order by dp.estado_id asc"
        )->result_array();
    }
    
    function get_platabanda_produccion($produccion_id){
        return $this->db->query(
            "SELECT ci.*,e.*
            from control_inventario ci
            left join estado e on ci.estado_id = e.estado_id
            left join detalle_produccion dp on dp.controli_id = ci.controli_id 
            where 1=1
            and dp.produccion_id = $produccion_id
            and e.estado_tipo = 9
            order by ci.controli_id asc
                        "
        )->result_array();
    }
    function get_platabanda_producciont_items($produccion_id){
        return $this->db->query(
            "SELECT p.producto_nombre, p.producto_foto, dp.*,e.estado_color, ap.aproducto_dias, ap.aproducto_dias2, p2.*,c2.*
            from control_inventario ci
            left join detalle_produccion dp on ci.controli_id = dp.controli_id 
            left join estado e on dp.estado_id = e.estado_id
            left join producto p on dp.producto_id = p.producto_id
            left join aviso_producto ap on ap.producto_id = dp.producto_id
            left join produccion p2 on p2.produccion_id = dp.produccion_id
            left join (
                select dc.detproduccion_id, sum(dc.detallecomp_cantidad) as cant_compra, p2.cant_perdida
                from compra c 
                left join detalle_compra dc on c.compra_id = dc.compra_id 
                left join (
                    select dp.detproduccion_id , if(sum(p.perdida_cantidad) >=0,sum(p.perdida_cantidad),0) as cant_perdida 
                    from detalle_produccion dp 
                    left join perdida p on p.detproduccion_id = dp.detproduccion_id 
                    where 1=1
                    and dp.produccion_id = $produccion_id
                    group by p.detproduccion_id 
                ) as p2 on p2.detproduccion_id = dc.detproduccion_id
                where 1=1
                and c.produccion_id = $produccion_id
                group by dc.detproduccion_id
            ) c2 on c2.detproduccion_id = dp.detproduccion_id 
            where 1=1
            and dp.produccion_id = $produccion_id
            and e.estado_tipo = 9
            and dp.estado_id <> 39
            order by ci.controli_id,dp.estado_id asc"
        )->result_array();
    }
}
