<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Añadir &Aacute;rea</h3>
            </div>
            <?php echo form_open('area/add'); ?>
          	<div class="box-body">
                    <div class="row clearfix">
                        <div class="col-md-4">
                            <label for="area_nombre" class="control-label"><span class="text-danger">*</span>Nombre</label>
                            <div class="form-group">
                                <input type="text" name="area_nombre" value="<?php echo $this->input->post('area_nombre'); ?>" class="form-control" id="area_nombre" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                                <span class="text-danger"><?php echo form_error('area_nombre');?></span>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="area_descripcion" class="control-label">Descripci&oacute;n</label>
                            <div class="form-group">
                                <input type="text" name="area_descripcion" value="<?php echo $this->input->post('area_descripcion'); ?>" class="form-control" id="area_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                            </div>
                        </div>
                        <div class="col-md-4">
                            <label for="usuario_id" class="control-label">Encargado</label>
                            <div class="form-group">
                                <select name="usuario_id" id="usuario_id" class="form-control">
                                    <?php foreach($all_usuario as $usuario){
                                    echo '<option value="'.$usuario['usuario_id'].'">'.$usuario['usuario_nombre'].'</option>';
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
                    <a href="<?php echo site_url('area'); ?>" class="btn btn-danger">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>