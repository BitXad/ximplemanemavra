<script type="text/javascript">
    function imprimir()
    {
         window.print(); 
    }
</script>   

<style type="text/css">
 /*@page { 
        size: landscape;
    }*/
     
</style>
<!----------------------------- fin script buscador --------------------------------------->
<!------------------ ESTILO DE LAS TABLAS ----------------->
<link href="<?php echo base_url('resources/css/cabecera.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<?php $tipo_factura = $parametro[0]["parametro_altofactura"]; //15 tamaño carta 
      $ancho = $parametro[0]["parametro_anchofactura"]."cm";
      //$margen_izquierdo = "col-xs-".$parametro[0]["parametro_margenfactura"];;
      $margen_izquierdo = $parametro[0]["parametro_margenfactura"]."cm";
?>
<table class="table" >
    <tr>
        <td style="padding: 0; width: <?php echo $margen_izquierdo; ?>"></td>
        <td style="padding: 0;">
            <div style="width: <?php echo $ancho;?>">
                <div class="cuerpo">
                    <div class="columna_derecha">
                        <center> 
                        <img src="<?php echo base_url('resources/images/empresas/'.$empresa[0]["empresa_imagen"].''); ?>"  style="width:80px;height:80px">
                    </center>
                    </div>
                    <div class="columna_izquierda">
                        <center> 
                            <font size="4"><b><u><?php echo $empresa[0]['empresa_nombre']; ?></u></b></font><br>
                            <?php echo $empresa[0]['empresa_zona']; ?><br>
                            <?php echo $empresa[0]['empresa_direccion']; ?><br>
                            <?php echo $empresa[0]['empresa_telefono']; ?>
                        </center>
                    </div>
                    <div class="columna_central">
                        <center>
                            <font class="box-title text-bold" style="font-size: 13pt">
                                PRODUCCION
                                <!--<br>
                                <?php //echo $produccion["produccion_descripcion"]; ?><br>-->
                            </font>
                            <span class="text-bold" style="font-size: 12pt"><?php echo "Nro.:".$produccion["produccion_numeroorden"]; ?></span><br>
                            <?php echo date('d/m/Y H:i:s'); ?><br>
                        </center>
                    </div>
                    <div class="text-center col-md-2 no-print">
                        <label for="expotar" class="control-label"> &nbsp; </label>
                        <div class="form-group">
                            <a onclick="imprimir()" class="btn btn-success btn-sm form-control"><i class="fa fa-print"> Imprimir</i></a>
                        </div>
                    </div>
                </div>
                
                <div class="row col-md-12 no-print" id='loader'  style='display:none;'>
                    <center>
                        <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >        
                    </center>
                </div>
                <br>
                
                <div  class="col-md-12">
                    <div  class="col-md-12 text-bold text-center">
                        <?php echo $produccion['produccion_descripcion']; ?>
                    </div>
                    <div  class="col-md-12">
                        <table>
                            <tr>
                                <td style="width: 45%" class="text-right">Inicio de Producción:&nbsp;</td>
                                <td style="width: 55%"><?php echo date("d/m/Y", strtotime($produccion['produccion_inicio'])); ?></td>
                            </tr>
                            <tr>
                                <td style="width: 45%" class="text-right">Fecha Estimada:&nbsp;</td>
                                <td style="width: 55%">
                                    <?php
                                    if($produccion['produccion_estimada'] != "" && $produccion['produccion_estimada'] != null && $produccion['produccion_estimada'] != "0000-00-00" ){
                                        echo date("d/m/Y", strtotime($produccion['produccion_estimada']));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <tr>
                                <td style="width: 45%" class="text-right">Fecha Finalización:&nbsp;</td>
                                <td style="width: 55%">
                                    <?php
                                    if($produccion['produccion_fin'] != "" && $produccion['produccion_fin'] != null && $produccion['produccion_fin'] != "0000-00-00" ){
                                        echo date("d/m/Y", strtotime($produccion['produccion_fin']));
                                    }
                                    ?>
                                </td>
                            </tr>
                            <!--<tr>
                                <td style="width: 15%" class="text-right">Descripción:&nbsp;</td>
                                <td style="width: 85%" class="text-bold"><?php //echo $produccion['produccion_descripcion']; ?></td>
                            </tr>-->
                            <tr>
                                <td style="width: 15%" class="text-right">Responsable:&nbsp;</td>
                                <td style="width: 85%"><?php echo $produccion['responsable']; ?></td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-condensed" id="mitabla">
                            <tr>
                                <th style="padding: 2px">#</th>
                                <th style="padding: 2px">Producto</th>
                                <th style="padding: 2px">Cantidad</th>
                                <th style="padding: 2px">Costo</th>
                                <th style="padding: 2px">Costo Total</th>
                                <th style="padding: 2px">Observación</th>
                                <th style="padding: 2px">Area</th>
                                <th style="padding: 2px">Platabanda</th>
                                <th style="padding: 2px">Estado</th>
                            </tr>
                            <?php
                            $i = 0;
                            $costototal1 = 0;
                            $cantidadtotal = 0;
                            $elcostot = 0;
                            foreach ($all_detalle as $detalle) {
                                $costototal1 += ($detalle['detproduccion_cantidad']*$detalle['detproduccion_costo']);
                                $cantidadtotal += $detalle['detproduccion_cantidad'];
                                $elcostot += $detalle['detproduccion_costo'];
                            ?>
                            <tr>
                                <td style="padding: 2px" class="text-center"><?php echo $i+1; ?></td>
                                <td style="padding: 2px"><?php echo $detalle['producto_nombre']; ?></td>
                                <td style="padding: 2px" class="text-right"><?php echo $detalle['detproduccion_cantidad']; ?></td>
                                <td style="padding: 2px" class="text-right"><?php echo $detalle['detproduccion_costo']; ?></td>
                                <td style="padding: 2px" class="text-right"><?php echo $detalle['detproduccion_cantidad']*$detalle['detproduccion_costo']; ?></td>
                                <td style="padding: 2px"><?php echo $detalle['detproduccion_observacion']; ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo $detalle['area_nombre']; ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo $detalle['controli_id']; ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo $detalle['estado_descripcion']; ?></td>
                            </tr>
                            <?php
                            $i++;
                            }
                            ?>
                            <tr>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold" colspan="2">Total:</th>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold"><?php echo number_format($cantidadtotal, 2, ".", ",")?></th>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold"><?php echo number_format($costototal1/$cantidadtotal, 2, ".", ",")?></th>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold"><?php echo number_format($costototal1, 2, ".", ","); ?></th>
                            </tr>
                        </table>
                    </div>
                    <div  class="col-md-6">
                        <table>
                            <tr>
                                <td class="text-bold text-left" style="font-size: 12pt">Costos Operativos:</td>
                            </tr>
                        </table>
                    </div>
                    <div class="col-md-12">
                        <table class="table table-striped table-condensed" id="mitabla">
                            <tr>
                                <th style="padding: 2px">#</th>
                                <th style="padding: 2px">Detalle</th>
                                <th style="padding: 2px">Costo</th>
                                <th style="padding: 2px">Fecha</th>
                                <th style="padding: 2px">Registrado por</th>
                                <th style="padding: 2px">Estado</th>
                            </tr>
                            <?php
                            $i = 0;
                            $costototal = 0;
                            foreach ($all_costooperativo as $costo) {
                                $costototal += ($costo['costoop_costo']);
                            ?>
                            <tr>
                                <td style="padding: 2px" class="text-center"><?php echo $i+1; ?></td>
                                <td style="padding: 2px"><?php echo $costo['costodesc_descripcion']; ?></td>
                                <td style="padding: 2px" class="text-right"><?php echo $costo['costoop_costo']; ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo date("d/m/Y", strtotime($costo['costoop_fecha'])); ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo $costo['usuario_nombre']; ?></td>
                                <td style="padding: 2px" class="text-center"><?php echo $costo['estado_descripcion']; ?></td>
                            </tr>
                            <?php
                            $i++;
                            }
                            ?>
                            <tr>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold" colspan="2">Total:</th>
                                <th style="padding: 2px; font-size: 10pt; text-align: right" class="text-bold"><?php echo number_format($costototal, 2, ".", ","); ?></th>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>
        </td>
    </tr>
</table>