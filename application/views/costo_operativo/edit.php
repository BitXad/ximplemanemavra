<script src="<?php echo base_url('resources/js/funciones_costodesc.js'); ?>" type="text/javascript"></script>
<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Editar Costo Operativo</h3>
            </div>
            <?php echo form_open('costo_operativo/edit/'.$costo_operativo['costoop_id']); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-4">
                        <label for="costodesc_id" class="control-label"><span class="text-danger">*</span>Descripción</label>
                        <div class="form-group" style="display: flex">
                            <select name="costodesc_id" class="form-control" id="costodesc_id" required>
                                <!--<option value="">- ESTADO -</option>-->
                                <?php 
                                foreach($all_costo_descripcion as $costo_descripcion)
                                {
                                    $selected = ($costo_descripcion['costodesc_id'] == $costo_operativo['costodesc_id']) ? ' selected="selected"' : "";
                                    echo '<option value="'.$costo_descripcion['costodesc_id'].'" '.$selected.'>'.$costo_descripcion['costodesc_descripcion'].'</option>';
                                }
                                ?>
                            </select>
                            <a data-toggle="modal" data-target="#modaldescripcion" onclick="ponercursor()" class="btn btn-warning" title="Registrar Nueva Descripción">
                                <i class="fa fa-plus-circle"></i></a>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="costoop_costo" class="control-label"><span class="text-danger">*</span>Costo</label>
                        <div class="form-group">
                            <input type="number" step="any" min="0"  name="costoop_costo" value="<?php echo $costo_operativo['costoop_costo']; ?>" class="form-control" id="costoop_costo" required />
                            <span class="text-danger"><?php echo form_error('costoop_costo');?></span>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="produccion_id" class="control-label"><span class="text-danger">*</span>Producción</label>
                        <div class="form-group">
                            <select name="produccion_id" class="form-control" id="produccion_id" required>
                                <?php 
                                foreach($all_produccion as $produccion)
                                {
                                    $selected = ($produccion['produccion_id'] == $costo_operativo['produccion_id']) ? ' selected="selected"' : "";
                                    echo '<option value="'.$produccion['produccion_id'].'" '.$selected.'>'.$produccion['costodesc_descripcion'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <label for="usuario_id" class="control-label"><span class="text-danger">*</span>Usuario</label>
                        <div class="form-group">
                            <select name="usuario_id" class="form-control" id="usuario_id" required>
                                <?php 
                                foreach($all_usuario as $usuario)
                                {
                                    $selected = ($usuario['usuario_id'] == $costo_operativo['usuario_id']) ? ' selected="selected"' : "";
                                    echo '<option value="'.$usuario['usuario_id'].'" '.$selected.'>'.$usuario['usuario_nombre'].'</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            	<button type="submit" class="btn btn-success">
		    <i class="fa fa-check"></i> Guardar
		</button>
                <a href="<?php echo site_url('costo_operativo'); ?>" class="btn btn-danger">
                       <i class="fa fa-times"></i> Cancelar</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>
<!------------------------ INICIO modal para Registrar nueva Descripción ------------------->
<div class="modal fade" id="modaldescripcion" tabindex="-1" role="dialog" aria-labelledby="modaldescripcionlabel">
    <div class="modal-dialog" role="document">
        <br><br>
        <div class="modal-content">
            <div class="modal-header text-center">
                <span class="text-bold" style="font-size: 16px">Nueva Descripción</span>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">x</span></button>
            </div>
            <div class="modal-body">
               <!------------------------------------------------------------------->
               <span class="text-danger" id="mensajemodal"></span>
               <div class="col-md-12">
                    <label for="nueva_descripcion" class="control-label"><span class="text-danger">*</span>Registrar Nueva Descripción</label>
                    <div class="form-group">
                        <input type="text" name="nueva_descripcion"  class="form-control" id="nueva_descripcion" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                    </div>
                </div>
               <!------------------------------------------------------------------->
            </div>
            <div class="modal-footer aligncenter">
                <a onclick="registrarnuevadescripcion()" class="btn btn-success"><span class="fa fa-check"></span> Registrar </a>
                <a href="#" class="btn btn-danger" data-dismiss="modal"><span class="fa fa-times"></span> Cancelar </a>
            </div>
        </div>
    </div>
</div>
<!------------------------ FIN modal para Registrar nueva Descripción ------------------->