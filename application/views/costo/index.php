<script src="<?php echo base_url('resources/js/costo.js'); ?>" type="text/javascript"></script>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<!----------------------------- script buscador --------------------------------------->
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
<!----------------------------- fin script buscador --------------------------------------->
<!------------------ ESTILO DE LAS TABLAS ----------------->
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<!-------------------------------------------------------->
<input type="hidden" name="categoria_costos" id="categoria_costos" value='<?php echo json_encode($categoria_costos); ?>' />
<div class="box-header">
    <font size='4' face='Arial'><b>Costos de productos</b></font>
    <br><font size='2' face='Arial'>Registros Encontrados: <span id="encontrados">0</span></font>
    <div class="box-tools no-print">
        <a href="<?php echo site_url('costo/add'); ?>" class="btn btn-success btn-sm"><fa class='fa fa-pencil-square-o'></fa> Registrar costo</a> 
    </div>
</div>
<div class="row">
    <div class="col-md-3">
        <label for="costcategoria" class="control-label">Costos:</label>
        <div class="form-group">
            <select name="categoriacosto" id="categoriacosto" class="form-control btn-facebook" onchange="mostrar_costos()">
            <?php
            foreach($categoria_costos as $cc){
                echo "<option value='{$cc['catcosto_id']}'>{$cc['catcosto_descripcion']}</option>";
            }
            ?>
            </select>
        </div>
    </div>
    <div class="row col-md-12" id='loader'  style='display:none; text-align: center'>
        <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >
    </div>
    <div class="col-md-12">
        <!--------------------- parametro de buscador --------------------->
        <div class="input-group no-print"> <span class="input-group-addon">Buscar</span>
            <input id="filtrar" type="text" class="form-control" placeholder="Ingrese nombre">
        </div>
        <!--------------------- fin parametro de buscador --------------------->
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-striped table-condensed" id="mitabla">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Insumo</th>
                            <th>unidad</th>
                            <th>costo unitario<br>Bs</th>
                            <th>Estado</th>
                            <th>Fecha actualización</th>
                            <th class="no-print"></th>
                        </tr>
                    </thead>
                    <tbody class="buscar" id="tablacostos">
                        <?php
                            /*$i = 0;
                            foreach($categoria_costos as $cc){
                                $porcentaje = ($cc['catcosto_porcentaje'])*(100);
                                echo "<tr>
                                        <th colspan='6' style='text-align: left'><b><span>{$cc['catcosto_descripcion']}</span></b> - <span>{$porcentaje}%</span></th>
                                        <th><button class='btn btn-xs btn-info' title='Editar porcentaje' onclick='show_form({$cc['catcosto_id']},`{$cc['catcosto_descripcion']}`,$porcentaje)'><i class='fa fa-pencil' aria-hidden='true'></i></button></th>
                                    </tr>";
                                foreach($costos as $c){
                                    if($cc['catcosto_id'] == $c['catcosto_id']){
                            ?>
                            <tr>
                                <td><?= $i+1; ?></td>
                                <td><?= $c['costo_descripcion']; ?></td>
                                <td><?= $c['costo_unidad']; ?></td>
                                <td class="text-center"><?= $c['costo_punitario']; ?></td>
                                <td><?= $c['estado_descripcion']; ?></td>
                                <td class="text-center"><?= (isset($c['costo_fecha']) ? date('d/m/Y',strtotime($c['costo_fecha'])) : '') ?></td>
                                <td class="no-print">
                                    <a href="<?php echo site_url('costo/edit/'.$c['costo_id']); ?>" class="btn btn-info btn-xs" title="Editar"><span class="fa fa-pencil"></span></a>
                                </td>
                            </tr>
                            <?php $i++; } ?>
                            <?php } ?>
                        <?php }*/ ?>
                    </tbody>
                </table>
                
                <div class="modal fade" id="form_porcentaje" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                    <div class="modal-dialog modal-dialog-centered" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalCenterTitle">Editar porcentaje</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="form-group">
                                <label for="porcentaje">Descripción</label>
                                <input type="text" class="form-control" id="descripcion" placeholder="Agregar descripción" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" >
                                <input type="hidden" class="form-control" id="id_descripcion">
                                <span id="descripcion_mensaje" style="color:red"></span>
                            </div>
                            <div class="form-group">
                                <label for="porcentaje">Porcentaje</label>
                                <input type="number" class="form-control" id="porcentaje" placeholder="5%" step="any" min="0" max="100">
                                <span id="porcentaje_mensaje" style="color:red"></span>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-success" onclick="edit_costo_porcentaje()"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                            <button type="button" class="btn btn-danger" data-dismiss="modal">Cerrar</button>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>
<script>
    function show_form(id,descripcion,porcentaje){
        $('#form_porcentaje').modal('show');
        $('#descripcion').val(descripcion)
        $('#id_descripcion').val(id)
        $('#porcentaje').val(porcentaje)
    }

    function edit_costo_porcentaje(){
        let descripcion = $('#descripcion').val();
        let id = $('#id_descripcion').val();
        let porcentaje = $('#porcentaje').val();
        let base_url = $('#base_url').val();
        let controlador = `${base_url}categoria_costo/edit_catcosto`
        let mensaje;

        if(descripcion != ""){
            if(porcentaje >= 1 && porcentaje <= 100){
                $.ajax({
                    url: controlador,
                    type: "POST",
                    cache: false,
                    data: {
                        descripcion,descripcion,
                        id,id,
                        porcentaje,porcentaje,
                    },
                    success: ()=>{
                        // alert("Se actualizo correctamente");
                        $('#form_porcentaje').modal('hide');
                        location.reload();
                    },
                    error: ()=>{
                        alert('Error: no se pudo actualizar');
                    }
                })
            }else{
                mensaje = `El porcentaje debe estar en el intervalo de 1 a 100`
                alerta('porcentaje','porcentaje_mensaje',mensaje);
            }
        }else{
            mensaje = `La descripción no puede estar vacio`
            alerta('descripcion','descripcion_mensaje',mensaje);
        }
    }

    function alerta(id,id_mensaje,mensaje){
        $(`#${id_mensaje}`).html(mensaje);
        $(`#${id}`).css('border',"1px solid red");
        $(`#${id}`).focus();
    }
</script>