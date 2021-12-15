<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Editar Perdida Detalle</h3>
            </div>
            <?php echo form_open('perdida_detalle/edit/'.$perdida_detalle['perdidad_id']); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="perdidad_descripcion" class="control-label"><span class="text-danger">*</span>Descripción</label>
                        <div class="form-group">
                            <input type="text" name="perdidad_descripcion" value="<?php echo ($this->input->post('perdidad_descripcion') ? $this->input->post('perdidad_descripcion') : $perdida_detalle['perdidad_descripcion']); ?>" class="form-control" id="perdidad_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                            <span class="text-danger"><?php echo form_error('perdidad_descripcion');?></span>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <label for="perdidaf_id" class="control-label"><span class="text-danger">*</span>Factor</label>
                        <div class="form-group">
                            <select name="perdidaf_id" class="form-control" id="perdidaf_id" required>
                                <?php 
                                foreach($all_perdida_factor as $factor)
                                {
                                    $selected = ($factor['perdidaf_id'] == $perdida_detalle['perdidaf_id']) ? ' selected="selected"' : "";
                                    echo '<option value="'.$factor['perdidaf_id'].'" '.$selected.'>'.$factor['perdidaf_descripcion'].'</option>';
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
                <a href="<?php echo site_url('perdida_detalle'); ?>" class="btn btn-danger">
                       <i class="fa fa-times"></i> Cancelar</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>