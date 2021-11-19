<?php
/* 
 * Generated by CRUDigniter v3.2 
 * www.crudigniter.com
 */
 
class Detalle_venta_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get detalle_venta by detalleven_id
     */
//    function get_detalle_venta($detalleven_id)
//    {
//        $detalle_venta = $this->db->query("
//            SELECT
//                *
//
//            FROM
//                `detalle_venta`
//
//            WHERE
//                `detalleven_id` = ?
//        ",array($detalleven_id))->row_array();
//
//        return $detalle_venta;
//    }
function get_all_entrega()
    {
        $sql = "SELECT e.* FROM entrega e WHERE 1=1 ORDER BY `entrega_id` ASC";
        $entrega = $this->db->query($sql)->result_array();
        
        return $entrega;
    }
function ventas_dia($estado)
  {
        $detalle_venta = $this->db->query("
            SELECT
                v.*, e.entrega_nombre, c.cliente_nombre, c.cliente_razon, ts.tiposerv_descripcion, m.*
            FROM
                venta v            
            LEFT JOIN mesa m on m.mesa_id = v.venta_numeromesa
            LEFT JOIN entrega e on v.entrega_id=e.entrega_id
            LEFT JOIN cliente c on v.cliente_id=c.cliente_id
            LEFT JOIN tipo_servicio ts on v.tiposerv_id=ts.tiposerv_id

            WHERE
            v.venta_fecha = date(now())
            and v.entrega_id=".$estado." 
            ORDER BY v.venta_id  
            
        ")->result_array();

        return $detalle_venta;
  }

  function ventas_dist($filtro)
  {
        $detalle_venta = $this->db->query("
            SELECT
                v.*, e.entrega_nombre,  c.cliente_nombre,c.cliente_latitud, c.cliente_nombrenegocio,
                c.cliente_longitud, c.cliente_razon, c.cliente_telefono, c.cliente_celular,
                c.cliente_direccion, es.estado_descripcion, u.usuario_nombre, pr.usuario_nombre as prevendedor
            FROM
                venta v 
            /*LEFT JOIN detalle_venta dv on v.venta_id=dv.venta_id*/
            LEFT JOIN entrega e on v.entrega_id=e.entrega_id
            LEFT JOIN cliente c on v.cliente_id=c.cliente_id
            LEFT JOIN estado es on v.estado_id=es.estado_id
            LEFT JOIN usuario u on v.usuario_id= u.usuario_id
            LEFT JOIN usuario pr on v.usuarioprev_id= pr.usuario_id

            WHERE
            1=1
            ".$filtro."
            ORDER BY v.venta_id  
            
        ")->result_array();

        return $detalle_venta;
  }

  function mapa_distribucion($filtro)
  {
        $detalle_venta = $this->db->query("
            SELECT
                v.*, e.entrega_nombre,  c.cliente_nombre,c.cliente_latitud, c.cliente_longitud, c.cliente_razon,c.cliente_telefono,c.cliente_direccion, es.estado_descripcion
            FROM
                venta v 
            /*LEFT JOIN detalle_venta dv on v.venta_id=dv.venta_id*/
            LEFT JOIN entrega e on v.entrega_id=e.entrega_id
            LEFT JOIN cliente c on v.cliente_id=c.cliente_id
            LEFT JOIN estado es on v.estado_id=es.estado_id

            WHERE
            v.entrega_id = 1 
            ".$filtro."
            ORDER BY v.venta_id  
            
        ")->result_array();

        return $detalle_venta;
  }
  function get_dventadia($estado,$destino,$usuario)
    {
        $result = $this->db->query(
                
        "SELECT d.detalleven_cantidad,d.detalleven_preferencia, d.venta_id, d.producto_id, p.producto_nombre, p.destino_id, v.venta_fecha, v.entrega_id,
                d.detalleven_unidadfactor, l.clasificador_nombre, t.preferencia_descripcion, t.preferencia_foto

        FROM detalle_venta d
        LEFT JOIN producto p ON d.producto_id=p.producto_id
        LEFT JOIN venta v ON d.venta_id=v.venta_id
        LEFT JOIN usuario_destino ud ON p.destino_id=ud.destino_id
        LEFT JOIN usuario u ON ud.usuario_id=u.usuario_id
        LEFT JOIN clasificador l ON l.clasificador_id = d.clasificador_id
        LEFT JOIN preferencia t ON t.preferencia_id = d.preferencia_id
        WHERE v.venta_fecha = date(now()) 
        and v.entrega_id=".$estado."
        and p.destino_id=".$destino."
        and u.usuario_id=".$usuario."
        ORDER BY d.venta_id
        ")->result_array();
        return $result;        
    } 

    function reporte_ventas($filtro)
    {
        
        $reporte = $this->db->query(
        "SELECT vs.*, fa.factura_id, cr.credito_cuotainicial FROM ventas vs LEFT JOIN factura fa on vs.venta_id = fa.venta_id LEFT JOIN credito cr on vs.venta_id = cr.venta_id WHERE  ".$filtro." ORDER BY venta_fecha DESC, venta_hora DESC;
        ")->result_array();
        return $reporte;
    }

    function reporte_simple($filtro)
    {
        $reporte = $this->db->query(
        "SELECT vs.*, c.cliente_nombre, tt.tipotrans_nombre, avg(dv.detalleven_tc) as tipo_cambio
          FROM venta vs
          LEFT JOIN detalle_venta dv on vs.venta_id = dv.venta_id
          LEFT JOIN cliente c on vs.cliente_id = c.cliente_id
          LEFT JOIN tipo_transaccion tt on vs.tipotrans_id = tt.tipotrans_id
          WHERE 
          	".$filtro."
          GROUP by `vs`.venta_id
          ORDER BY vs.venta_fecha DESC, vs.venta_hora DESC;
        ")->result_array();
        return $reporte;
    }

    function get_cliente($filtro)
    {
        
        $cliente = $this->db->query(
        "SELECT * FROM cliente WHERE cliente_nombre like '%".$filtro."%' or cliente_nit like '%".$filtro."%' or cliente_razon like '%".$filtro."%'
        ")->result_array();
        return $cliente;
    }
    function get_categoria($parametro)
    {
        
        $categoria = $this->db->query(
        "SELECT SUM(d.detalleven_cantidad) as cantidad,  SUM(d.detalleven_total) as total, v.venta_fecha, p.producto_nombre
        FROM detalle_venta d        
        LEFT JOIN producto p ON d.producto_id=p.producto_id
        LEFT JOIN categoria_producto c ON p.categoria_id=c.categoria_id
        LEFT JOIN venta v ON d.venta_id=v.venta_id
        WHERE ".$parametro."
        GROUP BY p.producto_nombre 
        ")->result_array();
        return $categoria;
    }


    function get_venta($venta_id)
    {
//        $sql = "select *  from venta v, cliente c, usuario u, tipo_transaccion t where v.cliente_id = c.cliente_id and "
//                . " v.usuario_id = u.usuario_id and v.tipotrans_id = t.tipotrans_id and v.venta_id = ".$venta_id;
        
        $sql = "select v.*,
                c.tipocliente_id,c.categoriaclie_id,c.usuario_id,c.cliente_codigo,c.cliente_nombre,c.cliente_ci,
                c.cliente_direccion,c.cliente_telefono,c.cliente_celular,c.cliente_foto,c.cliente_email,
                c.cliente_nombrenegocio,c.cliente_aniversario,c.cliente_latitud,c.cliente_longitud,c.cliente_nit,
                c.cliente_razon,c.cliente_departamento,c.zona_id,c.lun,c.mar,c.mie,c.jue,c.vie,c.sab,c.dom,
                c.cliente_puntos,
                u.usuario_nombre,t.tipotrans_nombre,z.zona_nombre,r.credito_id,r.compra_id,r.credito_monto,
                r.credito_cuotainicial,r.credito_interesproc,r.credito_interesmonto,r.credito_numpagos,
                r.credito_fechalimite,r.credito_fecha,r.credito_hora,r.credito_tipo,r.credito_tipointeres,r.servicio_id


                from venta v
                left join cliente c on c.cliente_id = v.cliente_id
                left join usuario u on u.usuario_id = v.usuario_id
                left join tipo_transaccion t on t.tipotrans_id = v.tipotrans_id
                left join zona z on z.zona_id = c.zona_id
                left join credito r on r.venta_id = v.venta_id
                where v.venta_id = ".$venta_id;
        
        $venta = $this->db->query($sql)->result_array();        
        return $venta;
    }

    function get_venta_id($venta_id)
    {
        
        $sql = "select v.*,                
                r.credito_cuotainicial,r.credito_interesproc,r.credito_interesmonto,r.credito_numpagos,
                u.usuario_nombre,t.tipotrans_nombre,r.credito_id,r.compra_id,r.credito_monto,
                r.credito_fechalimite,r.credito_fecha,r.credito_hora,r.credito_tipo,r.credito_tipointeres,r.servicio_id
                
                from venta v
                left join tipo_transaccion t on t.tipotrans_id = v.tipotrans_id
                left join usuario u on u.usuario_id = v.usuario_id
                left join credito r on r.venta_id = v.venta_id
                where v.venta_id = ".$venta_id;
        
        $venta = $this->db->query($sql)->result_array();        
        return $venta;
    }
    
    function get_venta_comanda($venta_id)
    {
        $sql = "select *  from venta v, cliente c, usuario u, tipo_transaccion t, tipo_servicio s where v.cliente_id = c.cliente_id  and "
                . " v.usuario_id = u.usuario_id and v.tipotrans_id = t.tipotrans_id and v.venta_id = ".$venta_id.
                " and v.tiposerv_id = s.tiposerv_id";
        $venta = $this->db->query($sql)->result_array();        
        return $venta;
    }
    
    function get_detalle_venta($venta_id)
    {
        $sql = "select d.*,  r.producto_nombre as preferencia_descripcion, r.producto_foto as preferencia_foto, 
                clasificador_codigo, clasificador_nombre,p.*
                from detalle_venta d
                left join producto p on p.producto_id = d.producto_id
                left join producto r on r.producto_id = d.preferencia_id
                left join clasificador c on c.clasificador_id = d.clasificador_id
                
                where d.producto_id = p.producto_id and venta_id = ".$venta_id;
        $detalle_venta = $this->db->query($sql)->result_array();        
        return $detalle_venta;
    }

    function get_detalle_factura($venta_id)
    {
        $sql = "select * from detalle_factura d where d.venta_id = ".$venta_id;
        $detalle_venta = $this->db->query($sql)->result_array();        
        return $detalle_venta;
    }

    function get_detalle_factura_id($factura_id)
    {
        $sql = "select * from detalle_factura d where d.factura_id = ".$factura_id;
        $detalle_venta = $this->db->query($sql)->result_array();        
        return $detalle_venta;
    }

    function cargar_detalle_venta($venta_id,$usuario_id)
    {
        $sql = "delete from detalle_venta_aux where usuario_id = ".$usuario_id;
        $this->db->query($sql);
        
        $sql =  "insert into detalle_venta_aux
        (
            producto_id,
            venta_id,
            moneda_id,
            detalleven_id,
            detalleven_codigo,
            detalleven_cantidad,
            detalleven_unidad,
            detalleven_costo,
            detalleven_precio,
            detalleven_subtotal,
            detalleven_descuento,
            detalleven_total,
            detalleven_caracteristicas,
            detalleven_preferencia,
            detalleven_comision,
            detalleven_tipocambio,
            usuario_id,
            existencia,
            producto_nombre,
            producto_unidad,
            producto_marca,
            categoria_id,
            producto_codigobarra,
            detalleven_envase,
            detalleven_nombreenvase,
            detalleven_costoenvase,
            detalleven_precioenvase,
            detalleven_cantidadenvase,
            detalleven_garantiaenvase,
            detalleven_devueltoenvase,
            detalleven_fechadevolucion,
            detalleven_horadevolucion,
            detalleven_montodevolucion,
            detalleven_prestamoenvase,
            detalleven_fechavenc,
            clasificador_id,
            detalleven_unidadfactor,
            preferencia_id,
            detalleven_tc
            
        )


        (SELECT 
            d.producto_id,
            ".$venta_id." as venta_id,
            d.moneda_id,
            d.detalleven_id,
            d.detalleven_codigo,
            d.detalleven_cantidad,
            d.detalleven_unidad,
            d.detalleven_costo,
            d.detalleven_precio,
            d.detalleven_subtotal,
            d.detalleven_descuento,
            d.detalleven_total+ (d.detalleven_descuento*d.detalleven_cantidad),
            d.detalleven_caracteristicas,
            d.detalleven_preferencia,
            d.detalleven_comision,
            d.detalleven_tipocambio,".
            $usuario_id.",
            i.existencia+d.detalleven_cantidad as existencia,
            i.producto_nombre, 
            i.producto_unidad, 
            i.producto_marca, 
            i.categoria_id, 
            i.producto_codigobarra,
            d.detalleven_envase,
            d.detalleven_nombreenvase,
            d.detalleven_costoenvase,
            d.detalleven_precioenvase,
            d.detalleven_cantidadenvase,
            d.detalleven_garantiaenvase,
            d.detalleven_devueltoenvase,
            d.detalleven_fechadevolucion,
            d.detalleven_horadevolucion,
            d.detalleven_montodevolucion,
            d.detalleven_prestamoenvase,
            d.detalleven_fechavenc,
            d.clasificador_id,
            d.detalleven_unidadfactor,
            d.preferencia_id,
            d.detalleven_tc
         

        FROM
          detalle_venta d, inventario i
        WHERE           
          venta_id=".$venta_id." and d.producto_id = i.producto_id order by d.detalleven_id  )";
        //echo $sql;
        $this->db->query($sql);
        
        $sql =  "select * from detalle_venta_aux d, producto p where "
               ." d.producto_id = p.producto_id and  d.venta_id=".$venta_id;        
        $detalle_venta = $this->db->query($sql)->result_array();

        
        return $detalle_venta;
    }
    
    /*
     * Get all detalle_venta count
     */
    function get_all_detalle_venta_count()
    {
        $detalle_venta = $this->db->query("
            SELECT
                count(*) as count

            FROM
                `detalle_venta`
        ")->row_array();

        return $detalle_venta['count'];
    }
        
    /*
     * Get all detalle_venta
     */
    function get_all_detalle_venta($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $detalle_venta = $this->db->query("
            SELECT
                *

            FROM
                detalle_venta d, producto p, venta v, moneda m

            WHERE
                d.producto_id = p.producto_id
                and d.venta_id = v.venta_id
                and d.moneda_id = m.moneda_id

            ORDER BY `detalleven_id` DESC

            " . $limit_condition . "
        ")->result_array();

        return $detalle_venta;
    }
        
    /*
     * function to add new detalle_venta
     */
    function add_detalle_venta($params)
    {
        $this->db->insert('detalle_venta',$params);
        return $this->db->insert_id();
    }
    
    function get_all_detalle_ventas($params = array())
    {
        $limit_condition = "";
        if(isset($params) && !empty($params))
            $limit_condition = " LIMIT " . $params['offset'] . "," . $params['limit'];
        
        $detalle_compra = $this->db->query("
           SELECT
                dc.*, p.*

            FROM
                detalle_venta dc, producto p

            WHERE
                dc.producto_id = p.producto_id

            ORDER BY `detalleven_id` DESC limit 30

            " . $limit_condition . "
        ")->result_array();

        return $detalle_compra;
    }
    
    /*
     * function to update detalle_venta
     */
    function update_detalle_venta($detalleven_id,$params)
    {
        $this->db->where('detalleven_id',$detalleven_id);
        return $this->db->update('detalle_venta',$params);
    }
    
    /*
     * function to delete detalle_venta
     */
    function delete_detalle_venta($detalleven_id)
    {
        return $this->db->delete('detalle_venta',array('detalleven_id'=>$detalleven_id));
    }
    
    /* ****Obtiene la cantidad de detalle venta (para insumos de servicio)****** */
    function get_cantidad_detalle_venta($detalleven_id)
    {
        $sql = "select detalleven_cantidad, producto_id from detalle_venta where detalleven_id = ".$detalleven_id;
        $res = $this->db->query($sql)->row_array();        
        return $res;
    }
    /* ********Nos da el resultado si esta asignado un insumo ******** */
    function existe_insumo_asignado($producto_id,$detalleserv_id)
    {
        $sql = "select
                        * 
                  from
                        detalle_venta
                 where
                        producto_id = '$producto_id'
                        and detalleserv_id = '$detalleserv_id'";
        $detalle_ven = $this->db->query($sql)->row_array();
        return $detalle_ven;
    }
    /* ****Obtiene todos los insumos de un detalle de servicio****** */
    function get_all_insumo_usado($detalleserv_id)
    {
        $sql = "select
                       dv.detalleven_id, p.producto_id, dv.detalleven_cantidad, dv.detalleven_total,
                       p.producto_nombre, p.producto_codigo, p.producto_codigobarra
                  from
                       detalle_venta dv, producto p
                 where
                       dv.producto_id = p.producto_id
                       and dv.detalleserv_id = ".$detalleserv_id;
        $res = $this->db->query($sql)->result_array();
        return $res;
    }
    /* ****Obtiene el total del precio del insumo usado****** */
    function get_costototal_insumos_usados($detalleserv_id)
    {
        $sql = "SELECT
                SUM(dv.detalleven_total) as total
            FROM
                detalle_venta dv
           WHERE
                
                 dv.detalleserv_id = ".$detalleserv_id;
        $res = $this->db->query($sql)->row_array();
        return $res['total'];
    }
    function get_all_detalle_ventas_servicio($detalleserv_id)
    {
        $detalle_ventaservicio = $this->db->query("
           SELECT
                dv.detalleven_id, p.producto_id, detalleven_cantidad

            FROM
                detalle_venta dv, producto p

            WHERE
                dv.producto_id = p.producto_id
                and dv.detalleserv_id = $detalleserv_id


        ")->result_array();

        return $detalle_ventaservicio;
    }
    function reporteventas_prodagrupados($filtro)
    {
        $reporte = $this->db->query(
            "SELECT
		vs.producto_id, vs.`producto_codigo`, vs.`producto_nombre`, tt.tipotrans_nombre,
                vs.producto_unidad, sum(vs.detalleven_cantidad) as total_cantidad,
                (sum(`vs`.`detalleven_total`) / sum(vs.detalleven_cantidad)) as total_punitario, 
                sum(`vs`.`detalleven_descuento`*`vs`.`detalleven_cantidad`) as total_descuento,
                sum(`vs`.`detalleven_total`) as total_venta,
                (sum(`vs`.`detalleven_costo`*`vs`.`detalleven_cantidad`)) as total_costo,
                (sum(`vs`.`detalleven_total`)-SUM(vs.`detalleven_costo`*`vs`.`detalleven_cantidad`)) as total_utilidad,
                avg(vs.detalleven_tc) as tipo_cambio
            FROM
                ventas vs
            LEFT JOIN tipo_transaccion tt on vs.tipotrans_id = tt.tipotrans_id
            WHERE 
                $filtro
            group by `vs`.producto_id
            order by total_venta desc
        ")->result_array();
        return $reporte;
    }
    function getdetalles_paravender()
    {
        $get_detalle = $this->db->query(
            "SELECT
		dv.detalleven_id, dv.producto_nombre, dv.detalleven_codigo, dv.detalleven_cantidad,
                dv.detalleven_precio, (dv.detalleven_cantidad*dv.detalleven_precio) as total,
                u.usuario_nombre
            FROM
                detalle_venta_aux dv
            LEFT JOIN usuario u on dv.usuario_id = u.usuario_id
            order by dv.detalleven_id desc
        ")->result_array();
        return $get_detalle;
    }
    function reporteventas_prodagrupados_porcategoria($filtro)
    {
        $reporte = $this->db->query(
            "SELECT
		vs.producto_id, vs.`producto_codigo`, vs.`producto_nombre`,
                vs.producto_unidad, sum(vs.detalleven_cantidad) as total_cantidad,
                (sum(`vs`.`detalleven_total`) / sum(vs.detalleven_cantidad)) as total_punitario, 
                sum(`vs`.`detalleven_descuento`*`vs`.`detalleven_cantidad`) as total_descuento,
                sum(`vs`.`detalleven_total`) as total_venta,
                (sum(`vs`.`detalleven_costo`*`vs`.`detalleven_cantidad`)) as total_costo,
                (sum(`vs`.`detalleven_total`)-SUM(vs.`detalleven_costo`*`vs`.`detalleven_cantidad`)) as total_utilidad,
                avg(vs.detalleven_tc) as tipo_cambio
            FROM
                ventas vs
            WHERE
                $filtro
            group by `vs`.producto_id
            order by total_venta desc
        ")->result_array();
        return $reporte;
    }
    /* obtiene los detalles de una producción */
    function get_detalle_produccion($produccion_id)
    {
        $sql = "select d.*,  r.producto_nombre as preferencia_descripcion, r.producto_foto as preferencia_foto, 
                clasificador_codigo, clasificador_nombre, p.*
                from detalle_venta d
                left join producto p on p.producto_id = d.producto_id
                left join producto r on r.producto_id = d.preferencia_id
                left join clasificador c on c.clasificador_id = d.clasificador_id
                where d.producto_id = p.producto_id and produccion_id = ".$produccion_id;
        $detalle_venta = $this->db->query($sql)->result_array();        
        return $detalle_venta;
    }
}