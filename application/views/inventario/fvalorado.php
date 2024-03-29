<!----------------------------- script buscador --------------------------------------->
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>
<script src="<?php echo base_url('resources/js/inventario_fvalorado.js'); ?>"></script>

<script type="text/javascript">
        $(document).ready(function () {
            (function ($) {
                $('#filtrar').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
</script>   

<input type="text" value="<?php echo base_url(); ?>" id="base_url" hidden>
<input type="hidden" name="nombre_moneda" id="nombre_moneda" value="<?php echo $parametro[0]['moneda_descripcion']; ?>" />
<input type="hidden" name="lamoneda_id" id="lamoneda_id" value="<?php echo $parametro[0]['moneda_id']; ?>" />
<input type="hidden" name="lamoneda" id="lamoneda" value='<?php echo json_encode($lamoneda); ?>' />
<input type="hidden" name="resinventario" id="resinventario" />

<!----------------------------- fin script buscador --------------------------------------->
<!------------------ ESTILO DE LAS TABLAS ----------------->

<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/mitablaventas.css'); ?>" rel="stylesheet">

<!-------------------------------------------------------->
<table class="table" style="width: 20cm; padding: 0;" >
    <tr>
        <td style="width: 6cm; padding: 0; line-height:10px;" >
                
            <center>
                               
                    <img src="<?php echo base_url('resources/images/empresas/').$empresa[0]['empresa_imagen']; ?>" width="100" height="60"><br>
                    <font size="3" face="Arial"><b><?php echo $empresa[0]['empresa_nombre']; ?></b></font><br>
                    <!--<font size="2" face="Arial"><b><?php echo $empresa[0]['empresa_eslogan']; ?></b></font><br>-->
                    <!--<font size="1" face="Arial"><b><?php echo "De: ".$empresa[0]['empresa_propietario']; ?></b></font><br>-->
                    <!--<font size="1" face="Arial"><?php echo $factura[0]['factura_sucursal'];?><br>-->
                    <font size="1" face="Arial"><?php echo $empresa[0]['empresa_direccion']; ?><br>
                    <font size="1" face="Arial"><?php echo $empresa[0]['empresa_telefono']; ?></font><br>
                    <!--<font size="1" face="Arial"><?php echo $empresa[0]['empresa_ubicacion']; ?></font>-->
                

            </center>                      
        </td>
                   
        <td style="width: 6cm; padding: 0" > 
            <center>
            
                <br><br>
                <font size="3" face="arial"><b>INVENTARIO FISICO VALORADO</b></font> <br>
                <!--<font size="3" face="arial"><b>Nº 00<?php echo $venta[0]['venta_id']; ?></b></font> <br>-->
                <font size="1" face="arial"><b><?php echo date("d/m/Y H:i:s"); ?></b></font> <br>

            </center>
        </td>
        <td style="width: 4cm; padding: 0" >
<!--                ______________________________                
                   
                                
                <div id="datos_recorrido">
                    
                </div>
                
                ______________________________-->
        </td>
    </tr>
     
    
    
</table>
<div class="box-header no-print">
    <h3 class="box-title"></h3>
    <!--<div class="box-tools no-print">-->
    <div class="col-md-2">
        Desde: <input type="date" class="btn btn-warning btn-sm form-control" id="fecha_desde" value="<?php echo date("Y-m-d");?>" name="fecha_desde" required="true">
    </div>
    <div class="col-md-2">
        Hasta: <input type="date" class="btn btn-warning btn-sm form-control" id="fecha_hasta" value="<?php echo date("Y-m-d");?>"  name="fecha_hasta" required="true">
    </div>
    <!--<button class="btn btn-success btn-sm" onclick="actualizar_inventario()" type="button"><span class="fa fa-cubes"></span> Actualizar</button>-->
    <?php if($rolusuario[27-1]['rolusuario_asignado'] == 1){ ?>
    <div class="col-md-2">&nbsp;
        <button class="btn btn-primary btn-sm form-control" onclick="tabla_inventario()" type="button"><span class="fa fa-search"></span> Buscar</button>
    </div>
    <div class="col-md-2">&nbsp;
        <button class="btn btn-success btn-sm form-control" onclick="imprimir_fv()" type="button"><span class="fa fa-print"></span> Imprimir</button>
    </div>
    <!--<button class="btn btn-info btn-sm" onclick="tabla_inventario_existencia()" type="button"><span class="fa fa-list-ol" title="Ver Produtos con Existencia"></span> Con Existencia</button>-->
    <?php } if($rolusuario[28-1]['rolusuario_asignado'] == 1){ ?>
    <!--<button class="btn btn-facebook btn-sm" onclick="mostrar_duplicados()" type="button"><span class="fa fa-copy"></span> Prod. Duplicados</button>-->

    <div class="col-md-2">&nbsp;
    <button class="btn btn-danger btn-sm form-control" id="excel" onclick="generarexcel()"  type="button"><span class="fa fa-file-excel-o"></span> Exportar Excel</button>
    </div>
    <?php } ?>
</div>
<div id="lafecha" style="display: none">
    <span class="text-bold">Desde: </span><span id="esdesde"></span>&nbsp;&nbsp;
    <span class="text-bold">Hasta: </span><span id="eshasta"></span>
    <span id="esparametro"></span>
</div>
<div class="row">
    <div class="col-md-12">
            <!--------------------- parametro de buscador --------------------->
                  <div class="input-group no-print"> <span class="input-group-addon">Buscar</span>
                    <input id="filtrar" type="text" class="form-control" placeholder="Ingrese el nombre, precio, código"   onkeypress="validar(event,1)" >
                  </div>
            <!--------------------- fin parametro de buscador ---------------------> 
            <div class="box">
           
                       <!--------------------- inicio loader ------------------------->
                    <div class="row" id='loader'  style='display:none;'>
                        <center>
                            <img src="<?php echo base_url("resources/images/loader.gif"); ?>" >        
                        </center>
                    </div> 
                    <!--------------------- fin inicio loader ------------------------->
                    
                <div class="box-body  table-responsive" >
                    
                    
                    <div id="tabla_inventario">
                        
                    <!-------------------- aqui se muestra la tabla de productos del inventario--------------------->
                    
                    </div>
                </div>
            </div>
</div>
</div>
