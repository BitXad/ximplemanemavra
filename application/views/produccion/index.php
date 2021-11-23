<script src="<?php echo base_url('resources/js/funciones_produccion.js'); ?>" type="text/javascript"></script>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" id="produccion_id" />
<!----------------------------- script buscador --------------------------------------->
<!--<script src="<?php //echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript"></script>-->
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
<div class="box-header">
    <font size='4' face='Arial'><b>Producción</b></font>
    <br><font size='2' face='Arial'>Registros Encontrados: <?php echo sizeof($produccion); ?></font>
    <div class="box-tools no-print">
        <a data-toggle="modal" data-target="#modalnuevaproduccion" onclick="ponercursor()" class="btn btn-success btn-sm" title="Registrar Nueva Producción"><fa class='fa fa-pencil-square-o'></fa> Nueva Producción</a>
    </div>
</div>
<div class="row">
    <div class="col-md-12">
        <!--------------------- parametro de buscador --------------------->
        <div class="input-group"> <span class="input-group-addon">Buscar</span>
            <input id="filtrar" type="text" class="form-control" placeholder="Ingrese producto, formula,..">
        </div>
        <div id='loader' style='display:none; text-align: center !important'>
            <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >
        </div>
        <!--------------------- fin parametro de buscador --------------------->
        <div class="box">
            <div class="box-body">
                <table class="table table-striped" id="mitabla">
                    <tr>
                        <th>#</th>
                        <th>Descripción</th>
                        <th>Fecha<br>Inicio</th>
                        <th>Usuario</th>
                        <th>Estado</th>
                        <th></th>
                    </tr>
                    <tbody class="buscar" id="tablaproduccion">
                    <?php
                    /*$i = 0;
                    foreach($produccion as $p){ ?>
                    <tr>
                        <td class="text-center"><?php echo ($i+1); ?></td>
                        <td><?php echo $p['producto_nombre']; ?></td>
                        <td class="text-center"><?php echo $p['produccion_numeroorden']; ?></td>
                        <td><?php echo $p['produccion_unidad']; ?></td>
                        <td class="text-center"><b><?php echo $p['produccion_cantidad']; ?></b></td>
                        <td class="text-right"><?php echo $p['produccion_costounidad']; ?></td>
                        <td class="text-right"><?php echo $p['produccion_preciounidad']; ?></td>
                        <td class="text-right"><?php echo $p['produccion_total']; ?></td>
                        <td class="text-center"><?php echo $p['produccion_fecha']; ?></td>
                        <td class="text-center"><?php echo $p['produccion_hora']; ?></td>
                        <td><?php echo $p['formula_nombre']; ?></td>
                        <td class="text-center"><?php echo $p['usuario_nombre']; ?></td>
                        <td>
                            <a href="<?php echo site_url('produccion/imprimir_nota/'.$p['produccion_id']); ?>" class="btn btn-success btn-xs" target="_blank" title="Imprimir nota de producción"><span class="fa fa-print"></span></a> 
                            <!--<a href="<?php //echo site_url('produccion/remove/'.$p['produccion_id']); ?>" class="btn btn-danger btn-xs"><span class="fa fa-trash"></span> Delete</a>-->
                        </td>
                    </tr>
                    <?php
                    $i++;
                    }*/ ?>
                    </tbody>
                </table>
                                
            </div>
        </div>
    </div>
</div>
<!------------------------ INICIO modal para Registrar nueva Producción ------------------->
<div class="modal fade" id="modalnuevaproduccion" tabindex="-1" role="dialog" aria-labelledby="modalnuevaproduccionlabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <span class="text-bold" style="font-size: 16px">Nueva Producción</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
               <!------------------------------------------------------------------->
               <span class="text-danger" id="mensajedescripcion"></span>
               <div class="col-md-12">
                    <label for="produccion_descripcion" class="control-label">Descripción</label>
                    <div class="form-group">
                        <input type="text" maxlength="250" name="produccion_descripcion" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="produccion_descripcion" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                    </div>
                </div>
               <div class="col-md-6">
                    <label for="produccion_inicio" class="control-label">Fecha de Inicio</label>
                    <div class="form-group">
                        <input type="date" name="produccion_inicio" value="<?php //echo ($this->input->post('produccion_fecha') ? $this->input->post('produccion_fecha') : date("Y-m-d")); ?>" class="form-control" id="produccion_inicio" />
                    </div>
                </div>
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <a onclick="registrarnuevaproduccion()" class="btn btn-success"><span class="fa fa-check"></span> Registrar </a>
                    <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cancelar </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------ FIN modal para Registrar nueva Producción ------------------->
<!------------------------ INICIO modal para Registrar un nuevo detalle ------------------->
<div class="modal fade" id="modalnuevodetalle" tabindex="-1" role="dialog" aria-labelledby="modalnuevodetallelabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <span class="text-bold" style="font-size: 16px" id="titulodetalle"></span>
                <span class="text-bold" style="font-size: 16px">Nuevo Detalle</span>
            </div>
            <div class="modal-body">
               <!------------------------------------------------------------------->
               <span class="text-danger" id="mensajenuevodetalle"></span>
               <div class="col-md-6">
                    <label for="detproduccion_cantidad" class="control-label"><span class="text-danger">*</span>Cantidad</label>
                    <div class="form-group">
                        <input type="number" step="any" min="0"  name="detproduccion_cantidad" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="detproduccion_cantidad" />
                    </div>
                </div>
               <div class="col-md-6">
                    <label for="detproduccion_observacion" class="control-label">Observación</label>
                    <div class="form-group">
                        <input type="text"  name="detproduccion_observacion" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="detproduccion_observacion" />
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="producto_id" class="control-label">Producto</label>
                    <div class="form-group">
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
                
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <a onclick="registrarnuevodetalle()" class="btn btn-success"><span class="fa fa-check"></span> Registrar </a>
                    <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cancelar </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------ FIN modal para Registrar un nuevo detalle ------------------->
<!------------------------ INICIO modal para ver los detalles de producción ------------------->
<div class="modal fade" id="modaldetallesproduccion" tabindex="-1" role="dialog" aria-labelledby="modaldetallesproduccionlabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <span class="text-bold" style="font-size: 16px" id="titulomostrardetalle"></span>
                    <span class="text-bold" style="font-size: 16px">Detalle de Producción</span>
            </div>
            <div class="modal-body">
                <div id='loader3' style='display:none; text-align: center !important'>
                    <img src="<?php echo base_url("resources/images/loader.gif"); ?>"  >
                </div>
               <!------------------------------------------------------------------->
               <!--<span class="text-danger" id="mensajenuevodetalle"></span>-->
               <div class="box-body">
                    <table class="table table-striped" id="mitabla">
                        <tr>
                            <th>#</th>
                            <th>Producto</th>
                            <th>Cantidad</th>
                            <th>Observación</th>
                            <th>Area</th>
                            <th>Platabanda</th>
                            <th>Estado</th>
                            <th></th>
                        </tr>
                        <tbody class="buscardetalle" id="tabladetalleproduccion"></tbody>
                    </table>
                </div>
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cerrar </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------ FIN modal para ver los detalles de producción ------------------->
<!------------------------ INICIO modal para modificar detalles de una Producción ------------------->
<div class="modal fade" id="modalmodificardetalle" tabindex="-1" role="dialog" aria-labelledby="modalmodificardetallelabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
                <span class="text-bold" style="font-size: 16px">Modificar Detalle de</span><br>
                <span class="text-bold" style="font-size: 16px" id="titulomodificardetalle"></span>
            </div>
            <div class="modal-body">
               <!------------------------------------------------------------------->
               <span class="text-danger" id="mensajemodifcardetalle"></span>
               <div class="col-md-6">
                    <label for="ladetproduccion_cantidad" class="control-label"><span class="text-danger">*</span>Cantidad</label>
                    <div class="form-group">
                        <input type="number" step="any" min="0"  name="ladetproduccion_cantidad" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="ladetproduccion_cantidad" />
                    </div>
                </div>
               <div class="col-md-6">
                    <label for="ladetproduccion_observacion" class="control-label">Observación</label>
                    <div class="form-group">
                        <input type="text"  name="ladetproduccion_observacion" value="<?php //echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="ladetproduccion_observacion" />
                    </div>
                </div>
                <div class="col-md-12">
                    <label for="producto_id" class="control-label">Producto</label>
                    <div class="form-group">
                        <select name="laproducto_id" class="form-control" id="laproducto_id">
                            <!--<option value="">select produccion</option>-->
                            <?php 
                            foreach($all_producto as $producto)
                            {
                                $selected = ($producto['producto_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                                echo '<option value="'.$producto['producto_id'].'">'.$producto['producto_nombre'].'</option>';
                            } 
                            ?>
                        </select>
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
                
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer">
                <div class="col-md-12 text-center">
                    <a onclick="registrarnuevodetalle()" class="btn btn-success"><span class="fa fa-check"></span> Registrar </a>
                    <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cancelar </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!------------------------ F I N  modal para modificar detalles de una Producción ------------------->