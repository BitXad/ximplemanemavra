<body onload="mostrar_grafica()">
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <title>Ximpleman | Sistema Integral de Ventas</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <!-- Bootstrap 3.3.7 -->
<!--  <link rel="stylesheet" href="bower_components/bootstrap/dist/css/bootstrap.min.css">
   Font Awesome 
  <link rel="stylesheet" href="bower_components/font-awesome/css/font-awesome.min.css">
   Ionicons 
  <link rel="stylesheet" href="bower_components/Ionicons/css/ionicons.min.css">
   Theme style 
  <link rel="stylesheet" href="dist/css/AdminLTE.min.css">
   AdminLTE Skins. Choose a skin from the css/skins
       folder instead of downloading all of them to reduce the load. 
  <link rel="stylesheet" href="dist/css/skins/_all-skins.min.css">
   Morris chart 
  <link rel="stylesheet" href="bower_components/morris.js/morris.css">
   jvectormap 
  <link rel="stylesheet" href="bower_components/jvectormap/jquery-jvectormap.css">
   Date Picker 
  <link rel="stylesheet" href="bower_components/bootstrap-datepicker/dist/css/bootstrap-datepicker.min.css">
   Daterange picker 
  <link rel="stylesheet" href="bower_components/bootstrap-daterangepicker/daterangepicker.css">
   bootstrap wysihtml5 - text editor 
  <link rel="stylesheet" href="plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css">-->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('resources/js/verventas_enprocesodashb.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/pedido_diario.js'); ?>"></script>
<!--<script src="<?php //echo base_url('resources/js/caja.js'); ?>"></script>-->
<script src="<?php echo base_url('resources/js/highcharts.js'); ?>"></script>
<script src="<?php echo base_url('resources/js/graficas.js'); ?>"></script>

<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" name="nombre_moneda" id="nombre_moneda" value="<?php echo $parametro[0]['moneda_descripcion']; ?>" />
<input type="hidden" name="caja_id" id="caja_id" value="<?php echo $caja[0]['caja_id']; ?>" />
<input type="hidden" name="estado_id" id="estado_id" value="<?php echo $caja[0]['estado_id']; ?>" />
<input type="hidden" name="tipousuario" id="tipousuario" value="<?= $tipousuario_id ?>" />
<!--
<button onclick="mostrar_grafica()">
 graficos    
</button>-->
<!--                <script type="text/javascript">
                    function esMobilx(){
    
                    var isMobile = {
                        Android: function() {
                            return navigator.userAgent.match(/Android/i);
                        },
                        BlackBerry: function() {
                            return navigator.userAgent.match(/BlackBerry/i);
                        },
                        iOS: function() {
                            return navigator.userAgent.match(/iPhone|iPad|iPod/i);
                        },
                        Opera: function() {
                            return navigator.userAgent.match(/Opera Mini/i);
                        },
                        Windows: function() {
                            return navigator.userAgent.match(/IEMobile/i);
                        },
                        any: function() {
                            return (isMobile.Android() || isMobile.BlackBerry() || isMobile.iOS() || isMobile.Opera() || isMobile.Windows());
                        }
                    };    

                    return isMobile.any()

                }
                var interlineado = "style='line-height: 10px;'";
//                if(esMobilx()){
//                    document.write("<h1 style='line-height: 0px;'><fa class='fa fa-money'></fa> </h1>");
//                    interlineado = "style='line-height: 2px;'";
//                }
//                    
                </script>
                -->
    

<?php $visual = 2;
    if ($visual == 1){ ?>
    
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
              <div class="inner" >
                
                
                <?php 
                    
                    //$interlineado = "<script> document.write(interlineado);</script>";
                    $interlineado = "";
                    
                ?>    

                <?php echo $interlineado; ?>
                
              <h4><b><?php echo number_format($ventas[0]['total_ventas'],2,'.',',')." Bs"; ?></b></h4>
              <p><?php echo "En ".$ventas[0]['cantidad_ventas']." ventas"; ?></p>
              
            </div>
              
            <div class="icon">
              <i class="ion ion-bag"></i>              
            </div>
            <a href="<?php echo base_url('venta/ventas'); ?>" class="small-box-footer">Realizar Ventas <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
          
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green" >
            <div class="inner">
                
                <script type="text/javascript">
//                if(esMobilx()){
//                    document.write("<h1><fa class='fa fa-money'></fa> </h1>");
//                }                    
                </script>
                
                
                <h4><b><?php echo number_format($pedidos[0]['total_pedidos'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?><sup style="font-size: 20px"></sup></b></h4>

              <p><?php echo "En ".$pedidos[0]['cantidad_pedidos']." pedidos"; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-stats-bars"></i>
            </div>
            <a href="<?php echo base_url('pedido'); ?>" class="small-box-footer">Realizar Pedidos <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
            <div class="inner">
                <h4><b><?php echo $clientes[0]['total_clientes']; ?></b></h4>

              <p>Clientes registrados</p>
            </div>
            <div class="icon">
              <i class="ion ion-person-add"></i>
            </div>
            <a href="<?php echo base_url('cliente'); ?>" class="small-box-footer">Registrar clientes <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
            <div class="inner">
                <h4><b><?php echo number_format($compras[0]['total_compras'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?></b></h3>

              <p><?php echo "En ".$compras[0]['cantidad_compras']." compras"; ?></p>
            </div>
            <div class="icon">
              <i class="ion ion-pie-graph"></i>
            </div>
            <a href="<?php echo base_url('compra'); ?>" class="small-box-footer">Realizar Compras <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      
      <div class="row">
        <div class="col-lg-3 col-xs-6">
           <!--small box--> 
          <div class="small-box bg-fuchsia">
            <div class="inner">
                <h4><b><?php echo number_format($ventas[0]['total_ventas'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?></b></h4>

              <p><?php echo "En ".$ventas[0]['cantidad_ventas']." ventas"; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?php echo base_url('venta'); ?>" class="small-box-footer">Ventas del Dia <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!--./col--> 
        <div class="col-lg-3 col-xs-6">
           <!--small box--> 
          <div class="small-box bg-blue-active">
            <div class="inner">
                <h4><b><?php echo number_format($pedidos[0]['total_pedidos'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?><sup style="font-size: 20px"></sup></b></h4>

              <p><?php echo "En ".$pedidos[0]['cantidad_pedidos']." inventario"; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-cubes"></i>
            </div>
            <a href="<?php echo base_url('inventario'); ?>" class="small-box-footer">Inventario <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!--./col--> 
        <div class="col-lg-3 col-xs-6">
           <!--small box--> 
          <div class="small-box bg-purple">
            <div class="inner">
                <h4><b><?php echo $clientes[0]['total_clientes']; ?></b></h4>

              <p>Reporte de Caja</p>
            </div>
            <div class="icon">
              <i class="fa fa-book"></i>
            </div>
            <a href="<?php echo base_url('reporte'); ?>" class="small-box-footer">Reporte de Caja <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         <!--./col--> 
        <div class="col-lg-3 col-xs-6">
           <!--small box--> 
          <div class="small-box bg-lime-active">
            <div class="inner">
                <h4><b><?php echo number_format($ventas[0]['total_ventas'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?></b></h4>

              <p><?php echo "Movimiento Diario"; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo base_url('reportes'); ?>" class="small-box-footer">Movimiento Diario <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
      </div>
      <!-- /.row -->
      
      
 </section>      
    
<?php }else{ ?>

    
    <!-- Main content -->
    <section class="content">
      <!-- Small boxes (Stat box) -->
      <div class="row">
          
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-aqua">
              <div class="inner" >

                <h3><b><fa class="fa fa-cart-plus"></fa></b></h3>
                <h5><b><?php echo "Ventas: ".number_format($ventas[0]['total_ventas'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-cart-plus"></i>              
            </div>
            <a href="<?php echo base_url('venta/ventas'); ?>" class="small-box-footer"><?php echo "En ".$ventas[0]['cantidad_ventas']." ventas"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-purple">
              <div class="inner" >

                <h3><b><fa class="fa fa-wrench"></fa></b></h3>
                <h5><b><?php echo number_format($servicios['cantidad_servicios'],0,'.',',')." en Produccion"; ?><sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-wrench"></i>              
            </div>
                <a href="<?php echo base_url('produccion'); ?>" class="small-box-footer"><?php echo "En produccion"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-blue-active">
              <div class="inner" >

                <h3><b><fa class="fa fa-cubes"></fa></b></h3>
                <!-- <h5><b><?php echo number_format($productos['total_inventario'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?><sup style="font-size: 20px"></sup></b></h5> -->
                <h5><b><?php echo number_format($productos['total_inventario'],2,'.',',')." Productos"; ?><sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-cubes"></i>              
            </div>
                <a href="<?php echo base_url('producto'); ?>" class="small-box-footer"><?php echo "Catalogo productos"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-green">
              <div class="inner" >

                <h3><b><i class="fa fa-leaf" aria-hidden="true"></i></b></h3>
                <h5><b><?php echo "Platabandas"?><sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-leaf" aria-hidden="true"></i>              
            </div>
                <a href="<?php echo base_url('control_inventario'); ?>" class="small-box-footer"><?php echo " Platabandas"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-yellow">
              <div class="inner" >

                <h3><b><fa class="fa fa-users"></fa></b></h3>
                <h5><b><?php echo number_format($clientes[0]['total_clientes'],0,'.',','); ?> Clientes<sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-users"></i>              
            </div>
                <a href="<?php echo base_url('cliente'); ?>" class="small-box-footer"><?php echo "Clientes "; //$clientes[0]['total_clientes']." Clientes"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
       
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-fuchsia">
              <div class="inner" >

                <h3><b><fa class="fa fa-cube"></fa></b></h3>
                <h5><b><?php echo " Inventario"; ?><sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-cube"></i>              
            </div>
                <a href="<?php echo base_url('inventario'); ?>" class="small-box-footer"><?php echo "En Inventario"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        
        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-red">
              <div class="inner" >

                <h3><b><fa class="fa fa-pie-chart"></fa></b></h3>
                <h5><b>Compras: <?php echo number_format($compras[0]['total_compras'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?><sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-pie-chart"></i>              
            </div>
                <a href="<?php echo base_url('compra'); ?>" class="small-box-footer"><?php echo "En ".$compras[0]['cantidad_compras']." compras"; ?> <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>

        <!-- ./col -->
        <div class="col-lg-3 col-xs-6">
          <!-- small box -->
          <div class="small-box bg-lime-active">
              <div class="inner" >

                <h3><b><fa class="fa fa-question-circle"></fa></b></h3>
                <h5><b>Soporte Técnico<sup style="font-size: 20px"></sup></b></h5>
            </div>
              
            <div class="icon">
              <i class="fa fa-question-circle"></i>              
            </div>
                <a href="http://passwordbolivia.com/site/" class="small-box-footer" target="_blank">Opciones de ayuda <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
        

        
<!--        
      

         ./col 
        <div class="col-lg-3 col-xs-6">
           small box 
          <div class="small-box bg-lime-active">
            <div class="inner">
                <h4><b><?php echo number_format($ventas[0]['total_ventas'],2,'.',',')." ".$parametro[0]["moneda_descripcion"]; ?></b></h4>

              <p><?php echo "Movimiento Diario"; ?></p>
            </div>
            <div class="icon">
              <i class="fa fa-money"></i>
            </div>
            <a href="<?php echo base_url('reportes'); ?>" class="small-box-footer">Movimiento Diario <i class="fa fa-arrow-circle-right"></i></a>
          </div>
        </div>
         ./col 
      </div>
       /.row 
      
      -->
 </section>      
        
    
<?php }?>
    
    
    
 
 <section class="col-lg-12 connectedSortable">
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-money"></i>

              <h3 class="box-title">Ventas del mes</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
              <div class="box-body">
                  
                  <div class="box-body" id="div_grafica_barras"></div>
                  <?php
                    $user_id = $usuario;
                    $tipouser_id = $tipousuario_id;
                  ?>
              </div>
            </div>
 </section>

        <section class="col-lg-5 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          
          <!-- /.box -->

          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-cubes"></i>

              <h3 class="box-title">Pedidos para hoy
              </h3>
              
                      <div id="div_fecha" style="display: none; padding:0; ">
                          
                          <input type="date" id="calendario" value="<?php echo date("Y-m-d"); ?>" class="btn btn-default btn-xs" onchange="buscar_pedido_diario(2)" style="padding:0;" />
                          
                      </div>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
                  
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">


              <table class="table table-condensed">
                <tr>
                  <th>#</th>
                  <th>
                      <div id="div_select" style="display: block; padding:0;">
                      
                      <select class="btn btn-default btn-xs" id="select_fecha" onchange="buscar_pedido_diario(1)" style="width:55px; padding: 0;">
                          <option value="1">Hoy</option>
                          <option value="2">Mañana</option>
                          <option value="3">Ayer</option>
                          <option value="4">Fecha</option>
                      </select>
                          
                      </div>

                  
                  </th>
                  <th>Proveedor/Detalle</th>
                  <th>
                        <?php echo $parametro[0]["moneda_descripcion"]; ?>
                        <a href="<?php echo base_url("pedido_diario/pedido_nuevo"); ?>" class="btn btn-default btn-xs" title="Registrar nuevo pedido"><fa class="fa fa-cube"></fa> </a>
                  </th>
                </tr>
                <tbody id="tabla_pedidos_diarios">
                    
                    
                 <?php $cont = 0; $total_dia = 0;
                  
                 foreach($pedidos_diarios as $pedidos){
                        $total_dia = $total_dia + $pedidos['pedido_montototal'];
                        $cont++;
                        if($cont%1 == 0){ $tipobar = "danger"; $color="red";}
                        if($cont%2 == 0){ $tipobar = "info";  $color="light-blue";}
                        if($cont%3 == 0){ $tipobar = "success"; $color="green";}
                        if($cont%4 == 0){ $tipobar = "warning"; $color="yellow";}
                        if($cont%5 == 0){ $tipobar = "facebook"; $color="blue";}
                ?>

                <tr>
                    
                      <td><?php echo $cont; ?></td>
                      <td>
                          <small>
                          
                          <?php 
                          $fecha = new DateTime($pedidos['pedido_fecha']);
                            $fecha_d_m_y = $fecha->format('d/m/Y');

                            echo $fecha_d_m_y; // 01/02/2017
                            ?>
                          </small>
                       </td>
                        <?php 
                            $nombre_proveedor = $pedidos['proveedor_nombre'];
                            
                            if (strlen($nombre_proveedor)>14){
                                $nombre_proveedor = substr($nombre_proveedor, 0, 12).".."; 
                            }
                                
                        ?>
                       
                      <td style="line-height: 10px;" >
                        <b><?php echo $nombre_proveedor; ?></b>
                        <a href='<?php echo base_url("pedido_diario/modificar_pedido/".$pedidos['pedido_id']); ?>'><fa class='fa fa-edit'></fa></a>
                        <br>
                        <small>
                            <?php echo $pedidos['pedido_resumen']; ?>
                        </small>
                      </td>
                      <td style="text-align: right;">
                          <span class="badge bg-<?php echo $color; ?>">
                              <?php echo number_format($pedidos['pedido_montototal'],2,'.',',');?>
                          </span>
                      </td>
                </tr>
                
                <?php } ?>
                <tr>
                    <td colspan="3"><b>TOTAL PEDIDOS PARA HOY <?php echo $parametro[0]["moneda_descripcion"]; ?></b></td>
                    <td >
                        <!--<span class="badge bg-purple">-->
                        <b>
                            <?php echo number_format($total_dia,2,'.',',');?>                        
                        </b>
                        <!--</span>-->
                    </td>
                </tr>
                
                </tbody>
              </table>

            </div>

          </div>

        </section>
   
    <!-- /.content -->
    
         <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          
          <!-- /.box -->

          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-cart-plus"></i>

              <h3 class="box-title">Ventas del dia</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
              </div>
              <!-- /. tools -->
            </div>
              <div class="box-body">
                          
<!--            <div class="box-header">
              <h3 class="box-title">Resumen de actividades del dia</h3>
            </div>-->
            <!-- /.box-header -->
            <div class="box-body no-padding">
              <table class="table table-condensed">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Operación</th>
                  <th>Ventas</th>
                  <th style="width: 40px"><?php echo $parametro[0]["moneda_descripcion"]; ?></th>
                </tr>
                <?php $cont = 0; $total_ventas = 0;
                    foreach($resumen_usuario as $user){
                        $cont++;
                        if($cont%1 == 0){ $tipobar = "danger"; $color="red";}
                        if($cont%2 == 0){ $tipobar = "info";  $color="light-blue";}
                        if($cont%3 == 0){ $tipobar = "success"; $color="green";}
                        if($cont%4 == 0){ $tipobar = "warning"; $color="yellow";}
                        if($cont%5 == 0){ $tipobar = "facebook"; $color="blue";}

                        ?>
             
                    <tr>
                       <td style="padding: 0;"><?php echo $cont; ?></td>
                       <td style="padding: 0; width:50px;" ><img src="<?php echo base_url('resources/images/usuarios/thumb_'.$user['usuario_imagen']); ?>" class="img-circle" width="50" height="50">
                          <?php //echo $user['usuario_nombre']; ?> 
                      </td>
                    
                      <td style="padding: 0;">
                          <small>
                              <?php echo $user['usuario_nombre']; ?>
                          </small>
                        <div class="progress progress-xs">   
                            
                          <div class="progress-bar progress-bar-<?php echo $tipobar; ?> progress-xs" style="width: <?php echo $user['total_ventas']/$ventas[0]['total_ventas']*100;?>%"></div>
                        </div>
                      </td>
                      <td style="padding: 0;"><span class="badge bg-<?php echo $color; ?>"><?php echo number_format($user['total_ventas'],2,'.',',');?></span></td>
                    </tr>
                    
<!--                    <tr style="padding: 0;">
                        <td colspan="2"  style="padding: 0;">
                            <small>
                               <?php echo $user['usuario_nombre']; ?>                                
                            </small>
                        </td>
                    </tr>-->
                
                <?php } ?>

              </table>
            </div>
            <!-- /.box-body -->
              
            </div>
          </div>
        </section>   
    

    
         <section class="col-lg-7 connectedSortable">
          <!-- Custom tabs (Charts with tabs)-->
          
          <!-- /.box -->

          <!-- quick email widget -->
          <div class="box box-info">
            <div class="box-header">
              <i class="fa fa-bar-chart"></i>

              <h3 class="box-title">Ventas de la semana</h3>
              <!-- tools box -->
              <div class="pull-right box-tools">
                <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip"
                        title="Remove">
                  <i class="fa fa-times"></i></button>
                  
              </div>
              <!-- /. tools -->
            </div>
            <div class="box-body">


              <table class="table table-condensed">
                <tr>
                  <th style="width: 10px">#</th>
                  <th>Fecha</th>
                  <th>Ventas</th>
                  <th style="width: 40px"><?php echo $parametro[0]["moneda_descripcion"]; ?></th>
                </tr>
                 <?php $cont = 0; $total_dia = 0;
                    foreach($ventas_semanales as $ventas){
                        $total_dia = $total_dia + $ventas['venta_dia'];
                        
                    }
                      
                        
                      
                    foreach($ventas_semanales as $ventas){
                        $cont++;
                        if($cont%1 == 0){ $tipobar = "danger"; $color="red";}
                        if($cont%2 == 0){ $tipobar = "info";  $color="light-blue";}
                        if($cont%3 == 0){ $tipobar = "success"; $color="green";}
                        if($cont%4 == 0){ $tipobar = "warning"; $color="yellow";}
                        if($cont%5 == 0){ $tipobar = "facebook"; $color="blue";}

                ?>

                <tr>
                      <td><?php echo $cont; ?></td>
                      <td>
                          <?php 
                          $fecha = new DateTime($ventas['venta_fecha']);
                            $fecha_d_m_y = $fecha->format('d/m/Y');

                            echo $fecha_d_m_y; // 01/02/2017
                            ?>
                       </td>
                    
                      <td>
                        <div class="progress progress-xs">             
                            
                          <div class="progress-bar progress-bar-<?php echo $tipobar; ?> progress-xs" style="width: <?php echo $ventas['venta_dia']/$total_dia*200;?>%"></div>
                        </div>
                      </td>
                      <td><span class="badge bg-<?php echo $color; ?>"><?php echo number_format($ventas['venta_dia'],2,'.',',');?></span></td>
                </tr>
                
                <?php } ?>

              </table>

            </div>

          </div>

    </section>
    <section class="col-lg-5 connectedSortable">
        <div class="box box-info">
            <div class="box-header">
                <i class="fa fa-file-text-o"></i>
                <h3 class="box-title">Ventas en proceso</h3>
                <a class="btn btn-success btn-xs" onclick="tabladetalle_venta()" data-toggle="tooltip" title="Actualizar lo que se esta vendiendo">
                    <i class="fa fa-refresh"></i>
                </a>
                <a class="btn btn-danger btn-xs" onclick="quitartodo()" data-toggle="tooltip" title="Anular todo lo que se esta vendiendo">
                    <i class="fa fa-trash"></i>
                </a>
                <!-- tools box -->
                <div class="pull-right box-tools">
                    <button type="button" class="btn btn-info btn-sm" data-widget="remove" data-toggle="tooltip" title="Remover">
                        <i class="fa fa-times"></i>
                    </button>
                </div>
                <!-- /. tools -->
            </div>
            <div class="box-body">
                <div class="box-body no-padding">
                    <table class="table table-condensed">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>Producto</th>
                            <th>Cant.</th>
                            <th>Precio</th>
                            <th>Total</th>
                            <th>Vendedor</th>
                            <th></th>
                        </tr>
                        <tbody id="tablaresultados"></tbody>
                    </table>
                </div>
            </div>
        </div>
    </section>

    <br>
        <section>
          <div class="container">
            <div class="row">
              <div class="col-md-12">
                Ximpleman ver 2.0
              </div>
            </div>
          </div>
            <!-- <br> -->

        </section>   
        <script> 
          var user_id = '<?= $user_id?>'; 
          var tipouser_id = '<?= $tipousuario_id ?>';
          // console.log(tipouser_id);
        </script>
 </body>   
 
 <!------------------------ INICIO modal para Seleccioanr nuevo asociado ------------------->
<div class="modal fade" id="modalconfirmar" tabindex="-1" role="dialog" aria-labelledby="modalconofirmarlabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <span class="text-bold">Eliminar detalle</span>
            </div>
            <div class="modal-body">
                <!------------------------------------------------------------------->
                <input type="hidden" name="eldetalle_id" id="eldetalle_id" />
                <div id="titulomodal" ></div>
                <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer" style="text-align: center">
                <a href="#" class="btn btn-success" onclick="quitardetalle()"><span class="fa fa-check"></span> Si</a>
                <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> No</a>
            </div>
        </div>
    </div>
</div>
<!------------------------ FIN modal para Seleccionar nuevo asociado ------------------->

<!-- --------------------- INICIO Modal mensaje caja ------------------- -->
<div id="modal_mensajecaja" class="modal fade" role="dialog">
  <div class="modal-dialog" style="font-family: Arial">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #CC660E">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title"><fa class="fa fa-frown-o"></fa><b> ADVERTENCIA</b></h2>
      </div>
      <div class="modal-body">
        <div class="col-md-8">
            <label for="monto_caja" class="control-label">
                <fa class="fa fa-money fa-2x"></fa>
                Existe una caja iniciada/abierta
            </label>
        </div>  
        <div class="col-md-4">
            <!--<button class="btn btn-warning btn-block" onclick="abrir_caja()"><fa class="fa fa-money"></fa> Registrar</button>-->
            <button class="btn btn-danger btn-block" data-dismiss="modal"><fa class="fa fa-times"></fa> Cerrar</button>
        </div>  
      
      </div>
      <div class="modal-footer">
      </div>
    </div>
  </div>
</div>
<!-- --------------------- F I N Modal mensaje caja ------------------- -->

<!--------------------- modal apertura de caja ---------------->

<!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#modalmensaje">Open Modal</button>-->

<!-- Modal -->
<div id="modalmensaje" class="modal fade" role="dialog">
  <div class="modal-dialog" style="font-family: Arial">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #CC660E">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h2 class="modal-title"><fa class="fa fa-frown-o"></fa><b> ADVERTENCIA</b></h2>
      </div>
      <div class="modal-body">
      
        
        <div class="col-md-6">
            <label for="monto_caja" class="control-label"><fa class="fa fa-money"></fa> <p> La caja aun esta pendiente por abrir...!!</p></label>
<!--            <div class="form-group">
                <input type="text" name="monto_caja" value="0.00" class="form-control" id="monto_caja" onclick="this.select();" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);"/>
            </div>-->
        </div>  

        <div class="col-md-6">
<!--            <label for="producto_marca" class="control-label"><p>Monto Registrado en Caja Bs</p></label>
            <div class="form-group">
                <input type="text" name="producto_marca" value="S/N" class="form-control" id="producto_marca" onclick="this.select();" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);"/>
            </div>-->
            <button class="btn btn-warning btn-block" data-dismiss="modal" onclick="modal_cajaabierta()"><fa class="fa fa-money"></fa> Registrar</button>
            <button class="btn btn-danger btn-block" data-dismiss="modal"><fa class="fa fa-times"></fa> Cerrar</button>
        </div>  
      
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>

  </div>
</div>


<!--------------------- fin modal Mensaje ------------>


<!--------------------- modal apertura de caja ---------------->

<!--<button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModal">Open Modal</button>-->

<!-- Modal -->
<div id="myModal" class="modal fade" role="dialog">
  <div class="modal-dialog" style="font-family: Arial">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header" style="background: #00c0ef">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"><fa class="fa fa-money"></fa><b> APERTURA DE CAJA</b></h4>
      </div>
      <div class="modal-body">
        <div class="col-md-12 text-bold">
          <span class="text-danger" id="elmensaje"></span>
        </div>
        <div class="col-md-6">
            <label for="monto_caja" class="control-label"><p>Monto Registrado en Caja Bs</p></label>
            <div class="form-group">
                <input type="text" name="monto_caja" value="0.00" class="form-control" id="monto_caja" onclick="this.select();" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);"/>
            </div>
        </div>  

        <div class="col-md-6">
<!--            <label for="producto_marca" class="control-label"><p>Monto Registrado en Caja Bs</p></label>
            <div class="form-group">
                <input type="text" name="producto_marca" value="S/N" class="form-control" id="producto_marca" onclick="this.select();" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);"/>
            </div>-->
            <button class="btn btn-warning btn-block" onclick="abrir_lacaja()"><fa class="fa fa-money"></fa> Registrar</button>
            <button class="btn btn-danger btn-block" data-dismiss="modal"><fa class="fa fa-times"></fa> Cerrar</button>
        </div>  
      
      </div>
      <div class="modal-footer">
        <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
      </div>
    </div>

  </div>
</div>


<!--------------------- fin modal apertura de caja ------------>
