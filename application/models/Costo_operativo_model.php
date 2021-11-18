<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Costo_operativo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get costo_operativo by costoop_id
     */
    function get_costo_operativo($costoop_id)
    {
        $costo_operativo = $this->db->query("
            SELECT
                *
            FROM
                `costo_operativo`
            WHERE
                `costoop_id` = ?
        ",array($costoop_id))->row_array();

        return $costo_operativo;
    }
    
    /*
     * Get all costo_operativo count
     */
    function get_all_costo_operativo_count()
    {
        $costo_operativo = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `costo_operativo`
        ")->row_array();

        return $costo_operativo['count'];
    }
        
    /*
     * Get all costo_operativo
     */
    function get_all_costo_operativo()
    {
        $costo_operativo = $this->db->query("
            SELECT
                op.*, cd.costodesc_descripcion, /*p.produccion_descripcion,*/
                u.usuario_nombre, e.estado_color, e.estado_descripcion
            FROM
                `costo_operativo` op
            left join costo_descripcion cd on op.costodesc_id = cd.costodesc_id
            left join produccion p on op.produccion_id = p.produccion_id
            left join usuario u on op.usuario_id = u.usuario_id
            left join estado e on op.estado_id = e.estado_id
            WHERE
                1 = 1
            ORDER BY `costoop_costo`
        ")->result_array();

        return $costo_operativo;
    }
        
    /*
     * function to add new costo_operativo
     */
    function add_costo_operativo($params)
    {
        $this->db->insert('costo_operativo',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update costo_operativo
     */
    function update_costo_operativo($costoop_id,$params)
    {
        $this->db->where('costoop_id',$costoop_id);
        return $this->db->update('costo_operativo',$params);
    }
    
    /*
     * function to delete costo_operativo
     */
    function delete_costo_operativo($costoop_id)
    {
        return $this->db->delete('costo_operativo',array('costoop_id'=>$costoop_id));
    }
    
    
    
    
    
    
    /* ********** mmmmmmmm revisar ******** */
     /*
     * Get all costo_operativo
     */
    function get_all_categoria_de_producto()
    {
        $costo_operativo = $this->db->query("
            SELECT
                *

            FROM
                `costo_operativo`

            WHERE
                1 = 1

            ORDER BY `costoop_descripcion`

        ")->result_array();

        return $costo_operativo;
    }
    /*
     * Get all costo_operativo
     */
    function getall_ventapor_categoria($fecha_desde, $fecha_hasta)
    {
        $venta_categoriap = $this->db->query("
            SELECT
                vs.costoop_id, cp.`categoria_nombre`, SUM(vs.detalleven_total) as 'totalventas',
                SUM(vs.`detalleven_costo`* vs.`detalleven_cantidad`) as totalcosto
            FROM
                `ventas` vs
            left join `costo_operativo` cp on vs.costoop_id = cp.costoop_id
            where
            	date(vs.venta_fecha) >= '$fecha_desde'
                and date(vs.venta_fecha) <= '$fecha_hasta'
            group by cp.`costoop_id`
        ")->result_array();

        return $venta_categoriap;
    }
    /* usado en reporte de vetnas por categoria */
    function get_all_categoria_ventaproducto_count($fecha_desde, $fecha_hasta)
    {
        $costo_operativo = $this->db->query("
            SELECT
                `vs`.costoop_id
            FROM
                `ventas` vs
            where
            	date(vs.venta_fecha) >= '$fecha_desde'
                and date(vs.venta_fecha) <= '$fecha_hasta'
            group by vs.`costoop_id`
        ")->result_array();

        return $costo_operativo;
    }
    /* usado en reporte de ventas por usuario */
    function get_all_usuario_ventaproducto_count($fecha_desde, $fecha_hasta, $elusuario)
    {
        $costo_operativo = $this->db->query("
            SELECT
                `vs`.usuario_id
            FROM
                `ventas` vs
            where
            	date(vs.venta_fecha) >= '$fecha_desde'
                and date(vs.venta_fecha) <= '$fecha_hasta'
                ".$elusuario." 
            group by vs.`usuario_id`
        ")->result_array();

        return $costo_operativo;
    }
    /*
     * Get all costo_operativo
     */
    function getall_ventapor_usuario($fecha_desde, $fecha_hasta, $elusuario)
    {
        $venta_porusuario = $this->db->query("
            SELECT
                vs.usuario_id, vs.`usuario_nombre`, SUM(vs.detalleven_total) as 'totalventas',
                SUM(vs.`detalleven_costo`* vs.`detalleven_cantidad`) as totalcosto,
                avg(vs.detalleven_tc) as tipo_cambio
            FROM
                `ventas` vs
            where
            	date(vs.venta_fecha) >= '$fecha_desde'
                and date(vs.venta_fecha) <= '$fecha_hasta'
                ".$elusuario." 
            group by vs.`usuario_id`
            order by totalventas desc
        ")->result_array();

        return $venta_porusuario;
    }
}
