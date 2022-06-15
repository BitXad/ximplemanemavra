<!--<script src="<?php //echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>-->
<script src="<?php echo base_url('resources/js/reporte_distritos.js'); ?>" type="text/javascript"></script>
<script type="text/javascript">
    $(document).ready(function () {
        (function ($) {
            $('#comprar').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar tr').hide();
                $('.buscar tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
    });
     $(document).ready(function () {
        (function ($) {
            $('#filtrar2').keyup(function () {
                var rex = new RegExp($(this).val(), 'i');
                $('.buscar2 tr').hide();
                $('.buscar2 tr').filter(function () {
                    return rex.test($(this).text());
                }).show();
            })
        }(jQuery));
    });
    function imprimir()
    {
         window.print(); 
    }
</script>   

<!--<style type="text/css">
 @page { 
        size: landscape;
    }
     
</style>-->
<!----------------------------- fin script buscador --------------------------------------->
<!------------------ ESTILO DE LAS TABLAS ----------------->
<link href="<?php echo base_url('resources/css/alejo.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/cabecera.css'); ?>" rel="stylesheet">
<!-------------------------------------------------------->
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>">
<input type="hidden" name="all_cliente" id="all_cliente" value='<?php echo json_encode($all_cliente); ?>' />

<input type="hidden" name="tipousuario_id" id="tipousuario_id" value="<?php echo $tipousuario_id; ?>">
<input type="hidden" name="nombre_moneda" id="nombre_moneda" value="<?php echo $parametro[0]['moneda_descripcion']; ?>" />
<input type="hidden" name="lamoneda_id" id="lamoneda_id" value="<?php echo $parametro[0]['moneda_id']; ?>" />
<input type="hidden" name="lamoneda" id="lamoneda" value='<?php echo json_encode($lamoneda); ?>' />
<input type="hidden" name="resproducto" id="resproducto" />
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
            <h3 class="box-title"><u>RESUMEN SALIDA DE PLANTAS A LOS DIFERENTES DISTRITOS <span id="lagestion"></span></u></h3>
            <?php echo date('d/m/Y H:i:s'); ?><br>
        </center>
    </div>
</div>
<div class="row">
    <div class="panel panel-primary col-md-12 no-print" id='buscador_oculto' >
        <div class="col-md-2 no-print">
            
            <label for="gestion" class="control-label"> Gestión: </label>
            <select class="btn btn-primary btn-sm form-control" name="gestion" id="gestion" onchange="gestion()" required>
                <?php
                $fecha  = date("Y");
                $fecha_aux = 2020;
                $cont = 1;
                while ($fecha_aux < $fecha) {
                    echo '<option value="'.$fecha_aux.'">'.$fecha_aux.'</option>';
                    $fecha_aux = 2020+$cont;
                    $cont ++;
                }
                ?>
                <option value="<?php echo $fecha; ?>" selected><?php echo $fecha; ?></option>
                <?php
                $fecha_aux = $fecha+2;
                $cont = 1;
                while ($fecha < $fecha_aux) {
                    $fecha = $fecha+1;
                    echo '<option value="'.$fecha.'">'.$fecha.'</option>';
                }
                ?>
            </select>
        </div>
        <div class="col-md-2 no-print" id="serv_vendedor" style="display: block">
            <label for="cliente_id" class="control-label"> Unidad: </label>
            <select class="btn btn-primary btn-sm form-control" name="cliente_id" id="cliente_id" >
                <?php
                foreach($all_cliente as $cliente){
                    if($cliente['cliente_nombre'] == "MANTENIMIENTO" || $cliente['cliente_nombre'] == "PARQUE ESCUELA" || $cliente['cliente_nombre'] == "PARQUES" || $cliente['cliente_nombre'] == "PROYECTOS"){
                ?>
                    <option value="<?php echo $cliente['cliente_nombre']; ?>" <?php //echo $selected; ?>><?php echo $cliente['cliente_nombre']; ?></option>
                <?php
                    }
                }
                ?>
            </select>
        </div>
        <div class="col-md-2 no-print">
            <label for="exportar" class="control-label"> &nbsp; </label>
            <div class="form-group" style="display: flex; margin-bottom: 0px">
                <a class="btn btn-facebook btn-sm form-control" onclick="reporte_general()" title="Buscar ventas"><i class="fa fa-search"> Buscar</i></a>
            </div>
        </div>
        
        <div class="col-md-2 no-print">
            <label for="expotar" class="control-label"> &nbsp; </label>
           <div class="form-group">
                <a onclick="imprimir()" class="btn btn-success btn-sm form-control"><i class="fa fa-print"> Imprimir</i></a>
            </div>
        </div>
        <div class="col-md-2 no-print">
            <label for="expotar" class="control-label"> &nbsp; </label>
           <div class="form-group">
                <a onclick="generarexcel_reportegrl()" class="btn btn-danger btn-sm form-control" ><span class="fa fa-file-excel-o"> </span> Exportar a Excel</a>
            </div>
        </div>
        <div id="tablas" style="visibility: block">  
            <div class="col-md-6 no-print" id="tablareproducto_ojo" hidden></div>
            <!--<div class="col-md-6 no-print" id="tablarecliente"></div>-->
            <div class="col-md-6 no-print" id="tablareproveedor"></div>
            <input id="producto" type="hidden" class="form-control" >
            <input id="cliente" type="hidden" class="form-control" > 
            <input id="proveedor" type="hidden" class="form-control" > 
        </div>
    </div>
     <span id="desde"></span>
     <span id="hasta"></span>
   <div id="labusqueda"></div>
</div>
<div class="row no-print" id='loader'  style='display:none;'>
    <center>
        <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >        
    </center>
</div>
<div class="box" style="padding: 0;">
    <div class="box-body table-responsive" >
        <table class="table table-striped table-condensed" id="mitabla" >
            <tr>
                <th>DISTRITO</th>
                <th>ENERO</th>
                <th>FEBRERO</th>
                <th>MARZO</th>
                <th>ABRIL</th>
                <th>MAYO</th>
                <th>JUNIO</th>
                <th>JULIO</th>
                <th>AGOSTO</th>
                <th>SEPTIEMBRE</th>
                <th>OCTUBRE</th>
                <th>NOVIEMBRE</th>
                <th>DICIEMBRE</th>
                <th>TOTAL</th>
            </tr>
            <tbody class="buscar">
                <tr>
                    <td id="d11"></td><td id="d12"></td><td id="d13"></td><td id="d14"></td><td id="d15"></td><td id="d16"></td>
                    <td id="d17"></td><td id="d18"></td><td id="d19"></td><td id="d110"></td><td id="d111"></td><td id="d112"></td>
                </tr>
                <tr>
                    <td id="d21"></td><td id="d22"></td><td id="d23"></td><td id="d24"></td><td id="d25"></td><td id="d26"></td>
                    <td id="d27"></td><td id="d28"></td><td id="d29"></td><td id="d210"></td><td id="d211"></td><td id="d212"></td>
                </tr>
                <tr>
                    <td id="d31"></td><td id="d32"></td><td id="d33"></td><td id="d34"></td><td id="d35"></td><td id="d36"></td>
                    <td id="d37"></td><td id="d38"></td><td id="d39"></td><td id="d310"></td><td id="d311"></td><td id="d312"></td>
                </tr>
                <tr>
                    <td id="d41"></td><td id="d42"></td><td id="d43"></td><td id="d44"></td><td id="d45"></td><td id="d46"></td>
                    <td id="d47"></td><td id="d48"></td><td id="d49"></td><td id="d410"></td><td id="d411"></td><td id="d412"></td>
                </tr>
                <tr>
                    <td id="d51"></td><td id="d52"></td><td id="d53"></td><td id="d54"></td><td id="d55"></td><td id="d56"></td>
                    <td id="d57"></td><td id="d58"></td><td id="d59"></td><td id="d510"></td><td id="d511"></td><td id="d512"></td>
                </tr>
                <tr>
                    <td id="d61"></td><td id="d62"></td><td id="d63"></td><td id="d64"></td><td id="d65"></td><td id="d66"></td>
                    <td id="d67"></td><td id="d68"></td><td id="d69"></td><td id="d610"></td><td id="d611"></td><td id="d612"></td>
                </tr>
                <tr>
                    <td id="d71"></td><td id="d72"></td><td id="d73"></td><td id="d74"></td><td id="d75"></td><td id="d76"></td>
                    <td id="d77"></td><td id="d78"></td><td id="d79"></td><td id="d710"></td><td id="d711"></td><td id="d712"></td>
                </tr>
                <tr>
                    <td id="d81"></td><td id="d82"></td><td id="d83"></td><td id="d84"></td><td id="d85"></td><td id="d86"></td>
                    <td id="d87"></td><td id="d88"></td><td id="d89"></td><td id="d810"></td><td id="d811"></td><td id="d812"></td>
                </tr>
                <tr>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                </tr>
                <tr>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                </tr>
                <tr>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                </tr>
                <tr>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                    <td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td><td id="d"></td>
                </tr>
            </tbody>
        </table>
    </div>
</div>
<center>
    <ul style="margin-bottom: -5px;margin-top: 35px;" >--------------------------------</ul>
    <ul style="margin-bottom: -5px;">RESPONSABLE</ul><ul>FIRMA - SELLO</ul>
</center>
