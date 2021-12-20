<script src="<?php echo base_url('resources/js/bootstrap-select.js'); ?>"></script>
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
        $('#producto_id').selectpicker({
    style: 'btn-default'
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
<link href="<?php echo base_url('resources/css/bootstrap-select.css'); ?>" rel="stylesheet">
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">

<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" name="ultimo_costo" id="ultimo_costo" />
<!--<input type="hidden" name="laformula" id="laformula" value='<?php //echo json_encode($all_formula); ?>' />-->
<div class="box-header">
    <font size='4' face='Arial'><b>PRODUCCION</b></font>
</div>
<div class="col-md-4">
    <table style="width: 100%">
        <tr>
            <td style="width: 15%" class="text-right"><label for="fecha_inicio"><span class="text-danger">*</span>Fecha Inicio:</label></td>
            <td style="width: 85%">
                <input style="width: 50%" type="date" name="fecha_inicio" value="<?php echo ($this->input->post('fecha_inicio') ? $this->input->post('fecha_inicio') : date("Y-m-d")); ?>" class="form-control" id="fecha_inicio" required />
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="descripcion"><span class="text-danger">*</span>Descripción:</label></td>
            <td style="width: 85%">
                <input type="text" width="100%" name="descripcion" value="<?php echo ($this->input->post('descripcion') ? $this->input->post('descripcion') : ""); ?>" class="form-control" id="descripcion"  required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="producto_id"><span class="text-danger">*</span>Producto:</label></td>
            <td style="width: 85%">
                <select name="producto_id" class="selectpicker form-control" onchange="elegir_tiempoestimado()" id="producto_id" data-show-subtext="true" data-live-search="true" required>
                    <option value="">--Seleccionar Producto --</option>
                    <?php 
                    foreach($all_producto as $producto)
                    {
                        //$selected = ($produccion['produccion_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                        echo '<option data-tokens="'.$producto['producto_nombre'].'" value="'.$producto['producto_id'].'">'.$producto['producto_nombre'].'</option>';
                    } 
                    ?>
                </select>
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 15%" class="text-right"><label for="descripcion">Responsable del Vivero:</label></td>
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
    </table>
</div>
<div class="col-md-4">
    <table style="width: 100%">
        <tr style="padding-top: 5px">
            <td style="width: 40%" class="text-right"><label for="produccion_cantidaesperada"><span class="text-danger">*</span>Cantidad Esperada:</label></td>
            <td style="width: 60%">
                <input style="width: 100%" type="number" min="0" name="produccion_cantidaesperada" onchange="calcular_preciototal()" value="<?php echo ($this->input->post('produccion_cantidaesperada') ? $this->input->post('produccion_cantidaesperada') : ""); ?>" class="form-control" id="produccion_cantidaesperada" required />
            </td>
        </tr>
        <tr>
            <td style="width: 40%" class="text-right"><label for="produccion_cantidadobtenida"><span class="text-danger">*</span>Cantidad Obtenida:</label></td>
            <td style="width: 60%">
                <input style="width: 100%" type="number" min="0" name="produccion_cantidadobtenida" value="<?php echo ($this->input->post('produccion_cantidadobtenida') ? $this->input->post('produccion_cantidadobtenida') : ""); ?>" class="form-control" id="produccion_cantidadobtenida" required />
            </td>
        </tr>
        <tr>
            <td style="width: 40%" class="text-right"><label for="produccion_metodoreproduccion"><span class="text-danger">*</span>Metodo de Reproducción:</label></td>
            <td style="width:60%">
                <select style="width: 100%" name="produccion_metodoreproduccion" class="form-control" id="produccion_metodoreproduccion">
                    <option value="Semilla">Semilla</option>
                    <option value="Esqueje">Esqueje</option>
                </select>
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 40%" class="text-right"><label for="produccion_semillaprecio"><span class="text-danger">*</span>Precio Total de la Semilla:</label></td>
            <td style="width: 60%">
                <input style="width: 100%" type="number" step="any" min="0" name="produccion_semillaprecio" value="<?php echo ($this->input->post('produccion_semillaprecio') ? $this->input->post('produccion_semillaprecio') : ""); ?>" class="form-control" id="produccion_semillaprecio" required />
            </td>
        </tr>
        
    </table>
</div>
<div class="col-md-4">
    <table style="width: 100%">
        <tr style="padding-top: 5px">
            <td style="width: 40%" class="text-right"><label for="produccion_tiempoestimadog"><span class="text-danger">*</span>Tiempo Estimado de Germinación:</label></td>
            <td style="width:60%">
                <input style="width: 100%" type="number" min="0" name="produccion_tiempoestimadog" value="<?php echo ($this->input->post('produccion_tiempoestimadog') ? $this->input->post('produccion_tiempoestimadog') : ""); ?>" class="form-control" id="produccion_tiempoestimadog" placeholder="en dias" required />
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 40%" class="text-right"><label for="produccion_costototalxgermin"><span class="text-danger">*</span>Costos Operativos Totales x Germinación:</label></td>
            <td style="width: 60%">
                <input style="width: 100%" type="number" step="any" min="0" name="produccion_costototalxgermin" value="<?php echo ($this->input->post('produccion_costototalxgermin') ? $this->input->post('produccion_costototalxgermin') : ""); ?>" class="form-control" id="produccion_costototalxgermin" required />
            </td>
        </tr>
        <tr style="padding-top: 5px">
            <td style="width: 40%" class="text-right"><label for="produccion_costounidefectiva"><span class="text-danger">*</span>Costo x Unidad:</label></td>
            <td style="width: 60%">
                <input style="width: 100%" type="number" step="any" min="0" name="produccion_costounidefectiva" value="<?php echo ($this->input->post('produccion_costounidefectiva') ? $this->input->post('produccion_costounidefectiva') : ""); ?>" class="form-control" id="produccion_costounidefectiva" required />
            </td>
        </tr>
    </table>
</div>
<div class="col-md-2">
    <!-- <a class="form-control btn btn-success btn-block" onclick="ponercursornuevaplatabanda()" data-toggle="modal" data-target="#modalparaplatabanda"><span></span> Añadir</a> -->
    <a class="form-control btn btn-success btn-block" onclick="ponercursornuevaplatabanda()"><span></span> Añadir</a>
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
                        <th>Costo Total</th>
                        <th>Observación</th>
                        <th>Area</th>
                        <th>Platabanda</th>
                        <th>Estado</th>
                        <th class="no-print">
                            <a onclick='eliminar_tododetalleproduccion_aux()' class='btn btn-danger btn-xs' title='Eliminar todo el detalle de producción'><span class='fa fa-trash'></span></a>
                        </th>
                    </tr>
                    <tbody class="buscar" id="tabladetalleproduccion_aux"></tbody>
                </table>
                                
            </div>
        </div>
    </div>
    <div class="col-md-12 text-center no-print">
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