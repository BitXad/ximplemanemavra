<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Categoria_insumo_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get categoria_insumo by catinsumo_id
     */
    function get_categoria_insumo($catinsumo_id)
    {
        return $this->db->get_where('categoria_insumo',array('catinsumo_id'=>$catinsumo_id))->row_array();
    }
         
    /*
     * function to add new categoria_insumo
     */
    function add_categoria_insumo($params)
    {
        $this->db->insert('categoria_insumo',$params);
        return $this->db->insert_id();
    }
    
    /*
     * function to update categoria_insumo
     */
    function update_categoria_insumo($catinsumo_id,$params)
    {
        $this->db->where('catinsumo_id',$catinsumo_id);
        return $this->db->update('categoria_insumo',$params);
    }
    
    /*
     * function to delete categoria_insumo
     */
    function delete_categoria_insumo($catinsumo_id)
    {
        return $this->db->delete('categoria_insumo',array('catinsumo_id'=>$catinsumo_id));
    }
    
    /*
     * Get all categoria_insumo ACTIVOS
     */
    function get_all_categoria_insumo_id1()
    {
        $categoria = $this->db->query("
            SELECT
                *

            FROM
                categoria_insumo ci, estado e

            WHERE
                ci.estado_id = e.estado_id
                and e.estado_id = 1

        ")->result_array();

        return $categoria;
    }
    
    
    /*
     * Get all categoria_insumo count
     */
    function get_all_categoria_insumo_count()
    {
        $categoria_insumo = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `categoria_insumo`
        ")->row_array();

        return $categoria_insumo['count'];
    }
        
    /*
     * Get all categoria_insumo
     */
    function get_all_categoria_insumo($subcatserv_id)
    {
        $categoria_insumo = $this->db->query("
            SELECT p.*
              FROM inventario p, categoria_insumo ci, subcategoria_servicio sc, estado e
             WHERE p.estado_id = 1
                   and p.estado_id = e.estado_id
                   and ci.producto_id = p.producto_id
                   and ci.subcatserv_id = sc.subcatserv_id
                   and ci.subcatserv_id = '$subcatserv_id'
               GROUP BY p.producto_id
               ORDER BY p.producto_nombre asc
        ")->result_array();

        return $categoria_insumo;
    }
    
    function get_all_insumos_usados($detalleserv_id)
    {
        $categoria_insumo = $this->db->query("
            SELECT dv.*, p.producto_nombre, p.producto_marca, p.producto_industria,
             p.producto_codigobarra
              FROM
                detalle_venta dv, inventario p, detalle_serv ds
              WHERE 
                    dv.producto_id = p.producto_id
                    and dv.detalleserv_id = ds.detalleserv_id
                    and ds.detalleserv_id = '$detalleserv_id'
              
              ORDER By p.producto_id
        ")->result_array();

        return $categoria_insumo;
        /*
         SELECT dv.*, p.producto_nombre, p.producto_marca, p.producto_industria,
             p.producto_codigobarra
              FROM
                detalle_venta dv, producto p, detalle_serv ds
              WHERE p.estado_id=1
                    and dv.producto_id = p.producto_id
                    and dv.detalleserv_id = ds.detalleserv_id
                    and ds.detalleserv_id = '$detalleserv_id'
              GROUP BY
                p.producto_id
              ORDER By p.producto_id
         */
    }
    /*
     * Recupera lo necesario para mostrar cuantos fueron asignados a una determinada subcategoria
     */
    function get_all_insumo_from_subcatserv($subcatserv_id)
    {
        $categoria_insumo = $this->db->query("
            SELECT
                i.`producto_id`,
                i.`producto_nombre`, i.producto_unidad, i.producto_marca, i.`producto_industria`,
                i.`producto_codigo`, i.`producto_codigobarra`, e.`estado_color`, e.`estado_descripcion`,
                e.estado_id, ci.`catinsumo_id`, m.`moneda_id`
                
            FROM
                categoria_insumo ci, estado e, inventario i, moneda m, subcategoria_servicio sc

            WHERE
                ci.estado_id = e.estado_id
                and ci.producto_id = i.producto_id
                and i.`moneda_id` = m.`moneda_id`
                and ci.`subcatserv_id` = sc.`subcatserv_id`
                and ci.subcatserv_id = '$subcatserv_id'

            ORDER BY `catinsumo_id` DESC

        ")->result_array();

        return $categoria_insumo;
    }
    
    function get_exist_insumo_asignado($subcatserv_id, $producto_id)
    {
        $categoria_insumo = $this->db->query("
            select
                ci.catinsumo_id
            from
                categoria_insumo ci
            where
                ci.subcatserv_id = '$subcatserv_id'
                and ci.producto_id = '$producto_id'
        ")->row_array();

        return $categoria_insumo['catinsumo_id'];
    }
    
    /*
    function get_all_categoria_insumo($subcatserv_id)
    {
        $categoria_insumo = $this->db->query("
            SELECT p.*,
                (SELECT if(sum(d.detallecomp_cantidad) > 0, sum(d.detallecomp_cantidad), 0) AS FIELD_1 FROM detalle_compra d WHERE d.producto_id = p.producto_id) AS compras,
                (SELECT if(sum(d.detalleven_cantidad) > 0, sum(d.detalleven_cantidad), 0) AS FIELD_1 FROM detalle_venta d WHERE d.producto_id = p.producto_id) AS ventas,
                (SELECT if(sum(e.detalleped_cantidad) > 0, sum(e.detalleped_cantidad), 0) AS FIELD_1 FROM detalle_pedido e, pedido t WHERE t.pedido_id = e.pedido_id AND e.producto_id = p.producto_id AND t.estado_id = 11) AS pedidos,
                ((select if(sum(d.detallecomp_cantidad) > 0, sum(d.detallecomp_cantidad), 0) from detalle_compra d where d.producto_id = p.producto_id) - (select if(sum(d.detalleven_cantidad) > 0, sum(d.detalleven_cantidad), 0) from detalle_venta d where d.producto_id = p.producto_id) - (select if(sum(e.detalleped_cantidad) > 0, sum(e.detalleped_cantidad), 0) from detalle_pedido e, pedido t where t.pedido_id = e.pedido_id and e.producto_id = p.producto_id and t.estado_id = 11)) AS existencia,
                e.estado_color, e.estado_descripcion
              FROM
                producto p, categoria_insumo ci, subcategoria_servicio sc, estado e
              WHERE p.estado_id=1
                    and p.estado_id = e.estado_id
                    and ci.producto_id = p.producto_id
                    and ci.subcatserv_id = sc.subcatserv_id
                    and ci.subcatserv_id = '$subcatserv_id'
              GROUP BY
                p.producto_id
              ORDER By p.producto_id

        ")->result_array();

        return $categoria_insumo;
    } */
}
