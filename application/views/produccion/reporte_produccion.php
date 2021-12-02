<!--<script src="<?php /*echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('resources/js/reporte_generalventa.js');*/ ?>" type="text/javascript"></script>
-->
<script type="text/javascript">
    function imprimir()
    {
         window.print(); 
    }
</script>   

<style type="text/css">
 @page { 
        size: landscape;
    }
     
</style>
<!----------------------------- fin script buscador --------------------------------------->
<!------------------ ESTILO DE LAS TABLAS ----------------->
<link href="<?php echo base_url('resources/css/cabecera.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<!-------------------------------------------------------->
<!--<input type="hidden" name="base_url" id="base_url" value="<?php /*echo base_url(); ?>">
<input type="hidden" name="tipousuario_id" id="tipousuario_id" value="<?php echo $tipousuario_id; ?>">
<input type="hidden" name="nombre_moneda" id="nombre_moneda" value="<?php echo $elparametro[0]['moneda_descripcion']; ?>" />
<input type="hidden" name="lamoneda_id" id="lamoneda_id" value="<?php echo $elparametro[0]['moneda_id']; ?>" />
<input type="hidden" name="lamoneda" id="lamoneda" value='<?php echo json_encode($lamoneda);*/ ?>' />
<input type="hidden" name="resproducto" id="resproducto" />
-->
<div style="width: 18cm !important">
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
</div>
<div class="text-center col-md-2 no-print">
    <label for="expotar" class="control-label"> &nbsp; </label>
    <div class="form-group">
        <a onclick="imprimir()" class="btn btn-success btn-sm form-control"><i class="fa fa-print"> Imprimir</i></a>
    </div>
</div>
<div class="row col-md-12 no-print" id='loader'  style='display:none;'>
    <center>
        <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >        
    </center>
</div>
<br>
<br>

<div  class="col-md-12">
    <div  class="col-md-12 text-bold text-center">
        <?php echo $produccion['produccion_descripcion']; ?>
    </div>
    <div  class="col-md-6">
        <table>
            <tr>
                <td style="width: 15%" class="text-right">Inicio:&nbsp;</td>
                <td style="width: 85%"><?php echo date("d/m/Y", strtotime($produccion['produccion_inicio'])); ?></td>
            </tr>
            <tr>
                <td style="width: 15%" class="text-right">Fin:&nbsp;</td>
                <td style="width: 85%">
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
                <th style="padding: 2px">Observación</th>
                <th style="padding: 2px">Area</th>
                <th style="padding: 2px">Platabanda</th>
                <th style="padding: 2px">Estado</th>
            </tr>
            <?php
            $i = 0;
            foreach ($all_detalle as $detalle) {
            ?>
            <tr>
                <td style="padding: 2px" class="text-center"><?php echo $i+1; ?></td>
                <td style="padding: 2px"><?php echo $detalle['producto_nombre']; ?></td>
                <td style="padding: 2px" class="text-right"><?php echo $detalle['detproduccion_cantidad']; ?></td>
                <td style="padding: 2px" class="text-right"><?php echo $detalle['detproduccion_costo']; ?></td>
                <td style="padding: 2px"><?php echo $detalle['detproduccion_observacion']; ?></td>
                <td style="padding: 2px" class="text-center"><?php echo $detalle['area_nombre']; ?></td>
                <td style="padding: 2px" class="text-center"><?php echo $detalle['controli_id']; ?></td>
                <td style="padding: 2px" class="text-center"><?php echo $detalle['estado_descripcion']; ?></td>
            </tr>
            <?php
            $i++;
            }
            ?>
            
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
                $costototal = ($costototal+$costo['costoop_costo']);
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
                <td style="padding: 2px; font-size: 10pt" class="text-bold text-right" colspan="2">Total:</td>
                <td style="padding: 2px; font-size: 10pt" class="text-bold text-right"><?php echo number_format($costototal, 2, ".", ","); ?></td>
            </tr>
        </table>
    </div>
</div>
</div>
<!--
<div class="box" style="padding: 0;">
    <div class="box-body table-responsive" >
        <table class="table table-striped table-condensed" id="mitabla" >
                <tr>
                <th>#</th>
                <th>CLIENTE</th>
                <th>VENTA (<?php /*echo $elparametro[0]["moneda_descripcion"]; ?>)</th>
                <th>VENTA (
                    <?php 
                    if($elparametro[0]["moneda_id"] == 1){
                        echo $lamoneda[1]['moneda_descripcion'];
                    }else{
                        echo $lamoneda[0]['moneda_descripcion'];
                    } ?>)
                </th>
                <?php if($tipousuario_id == 1){ ?>
                <th>COSTO (<?php echo $elparametro[0]["moneda_descripcion"]; ?>)</th>
                <th>UTILIDAD (<?php echo $elparametro[0]["moneda_descripcion"]; ?>)</th>
                <?php }*/ ?>
            </tr>
            <tbody class="buscar" id="resultado_ventas"></tbody>
        </table>
    </div>
</div>-->
<!--
                    <center>
    <ul style="margin-bottom: -5px;margin-top: 35px;" >--------------------------------</ul>
    <ul style="margin-bottom: -5px;">RESPONSABLE</ul><ul>FIRMA - SELLO</ul>
</center>
                    -->
