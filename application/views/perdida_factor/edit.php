<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Editar Perdida Factor</h3>
            </div>
            <?php echo form_open('perdida_factor/edit/'.$perdida_factor['perdidaf_id']); ?>
            <div class="box-body">
                <div class="row clearfix">
                    <div class="col-md-6">
                        <label for="perdidaf_descripcion" class="control-label"><span class="text-danger">*</span>Descripción</label>
                        <div class="form-group">
                            <input type="text" name="perdidaf_descripcion" value="<?php echo ($this->input->post('perdidaf_descripcion') ? $this->input->post('perdidaf_descripcion') : $perdida_factor['perdidaf_descripcion']); ?>" class="form-control" id="perdidaf_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                            <span class="text-danger"><?php echo form_error('perdidaf_descripcion');?></span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="box-footer">
            	<button type="submit" class="btn btn-success">
		    <i class="fa fa-check"></i> Guardar
		</button>
                <a href="<?php echo site_url('perdida_factor'); ?>" class="btn btn-danger">
                       <i class="fa fa-times"></i> Cancelar</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>