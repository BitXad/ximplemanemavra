<script src="<?php echo base_url('resources/js/producir.js'); ?>"></script>
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
<style type="text/css">
    .contorno{
        padding: 2;
        padding-left: 1px;
        margin: 0;
        line-height: 15px;
    }
</style>
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">

<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<!--<input type="hidden" name="laformula" id="laformula" value='<?php //echo json_encode($all_formula); ?>' />-->
<div class="box-header">
    <font size='4' face='Arial'><b>PRODUCCION</b></font>
</div>
<div class="col-md-6">
    <table style="width: 100%">
        <tr>
            <td style="width: 15%" class="text-right"><label for="fecha_inicio"><span class="text-danger">*</span>Fecha Inicio:</label></td>
            <td style="width: 85%">
                <input style="width: 50%" type="date" name="fecha_inicio" value="<?php echo ($this->input->post('fecha_inicio') ? $this->input->post('fecha_inicio') : date("Y-m-d")); ?>" class="form-control" id="fecha_inicio" required />
            </td>
        </tr>
        <!--<tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="fecha_fin">Fecha Fin:</label></td>
            <td style="width: 85%">
                <input type="date" name="fecha_fin" value="<?php //echo ($this->input->post('fecha_fin') ? $this->input->post('fecha_fin') : ""); ?>" class="form-control" id="fecha_fin" />
            </td>
        </tr>-->
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="descripcion"><span class="text-danger">*</span>Descripción:</label></td>
            <td style="width: 85%">
                <input type="text" width="100%" name="descripcion" value="<?php echo ($this->input->post('descripcion') ? $this->input->post('descripcion') : ""); ?>" class="form-control" id="descripcion"  required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="producto_id">Producto:</label></td>
            <td style="width: 85%">
                <select name="producto_id" class="form-control" id="producto_id">
                    <!--<option value="">select produccion</option>-->
                    <?php 
                    foreach($all_producto as $producto)
                    {
                        //$selected = ($produccion['produccion_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                        echo '<option value="'.$producto['producto_id'].'">'.$producto['producto_nombre'].'</option>';
                    } 
                    ?>
                </select>
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="descripcion">Ing. a Cargo:</label></td>
            <td style="width: 85%">
                <select style="width: 50%" name="acargode_id" class="form-control" id="acargode_id">
                    <!--<option value="">select produccion</option>-->
                    <?php 
                    foreach($all_usuario as $usuario)
                    {
                        //$selected = ($produccion['produccion_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                        echo '<option value="'.$usuario['usuario_id'].'">'.$usuario['usuario_nombre'].'</option>';
                    } 
                    ?>
                </select>
            </td>
        </tr>
        <!--<tr style="padding-top: 5px">
            <td style="width: 100%" class="text-center" colspan="2">
                <a class="form-control btn btn-soundcloud btn-block" onclick="calcularformula()"><span></span> Calcular</a>
            </td>
        </tr>-->
    </table>
</div>
<div class="col-md-2">
    <a class="form-control btn btn-success btn-block" onclick="ponercursornuevaplatabanda()" data-toggle="modal" data-target="#modalparaplatabanda"><span></span> Añadir</a>
</div>
<div class="row">
    <div class="col-md-12">
        <!--------------------- parametro de buscador --------------------->
        <div class="input-group"> <span class="input-group-addon">Buscar</span>
            <input id="filtrar" type="text" class="form-control" placeholder="Nombre del producto,...">
        </div>
        <div id='loader' style='display:none; text-align: center !important'>
            <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >
        </div>
        <!--------------------- fin parametro de buscador --------------------->
        <div class="box">
            <div class="box-body table-responsive">
                <table class="table table-striped" id="mitabla">
                    <tr>
                        <th>#</th>
                        <th>Producto</th>
                        <th>Cantidad</th>
                        <th>Costo</th>
                        <th>Observación</th>
                        <th>Area</th>
                        <th>Platabanda</th>
                        <th>Estado</th>
                        <th>
                            <a onclick='eliminar_tododetalleproduccion_aux()' class='btn btn-danger btn-xs' title='Eliminar todo el detalle de producción'><span class='fa fa-trash'></span></a>
                        </th>
                    </tr>
                    <tbody class="buscar" id="tabladetalleproduccion_aux"></tbody>
                </table>
                                
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center">
        <a class="btn btn-success" onclick="producir()">
            <i class="fa fa-check"></i> Producir
        </a>
        <a href="<?php echo site_url('produccion'); ?>" class="btn btn-danger">
            <i class="fa fa-times"></i>Cancelar
        </a>
    </div>
</div>

<!------------------------ INICIO modal para Registrar a auxiliar la paltabanda ------------------->
<div class="modal fade" id="modalparaplatabanda" tabindex="-1" role="dialog" aria-labelledby="modalparaplatabandalabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <span class="text-bold" style="font-size: 16px" id="titulodetalle"></span>
                <!--<span class="text-bold" style="font-size: 16px">Nuevo Detalle</span>-->
            </div>
            <div class="modal-body">
               <!------------------------------------------------------------------->
               <span class="col-md-12 text-danger" id="mensajenuevodetalle"></span>
               <div class="col-md-6">
                    <label for="detproduccion_cantidad" class="control-label"><span class="text-danger">*</span>Cantidad</label>
                    <div class="form-group">
                        <input type="number" step="any" min="0"  name="detproduccion_cantidad" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="detproduccion_cantidad" />
                    </div>
                </div>
               <div class="col-md-6">
                    <label for="detproduccion_costo" class="control-label">Costo</label>
                    <div class="form-group">
                        <input type="number" step="any" min="0"  name="detproduccion_costo" value="0" class="form-control" id="detproduccion_costo" />
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="area_id" class="control-label">Area</label>
                    <div class="form-group">
                        <select name="area_id" class="form-control" id="area_id" onchange="buscar_platabanda()">
                            <option value="">-- Elegir Area --</option>
                            <?php
                            foreach ($all_area as $area) {
                                //$selected = ($produccion['produccion_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                                echo '<option value="' . $area['area_id'] . '">' . $area['area_nombre'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                </div>
               <div class="col-md-12">
                   <label for="controli_id" class="control-label">Platabanda</label>
                   <div class="form-group">
                       <span id="paraplatabanda"></span>
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="detproduccion_observacion" class="control-label">Observación</label>
                    <div class="form-group">
                        <input type="text"  name="detproduccion_observacion" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="detproduccion_observacion" />
                    </div>
                </div>
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <a onclick="registrarnuevodetalleaux()" class="btn btn-success"><span class="fa fa-check"></span> Ingresar </a>
                    <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cancelar </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------ F I N  modal para Registrar a auxiliar la paltabanda ------------------->