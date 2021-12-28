<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Editar Categoria Costo</h3>
            </div>
			<?php echo form_open('categoria_costo/edit/'.$catcosto['catcosto_id']); ?>
			<div class="box-body">
				<div class="row clearfix">
					<div class="col-md-6">
						<label for="catcosto_descripcion" class="control-label"><span class="text-danger">*</span>Descripción</label>
						<div class="form-group">
							<input type="text" name="catcosto_descripcion" value="<?php echo ($this->input->post('catcosto_descripcion') ? $this->input->post('catcosto_descripcion') : $catcosto['catcosto_descripcion']); ?>" class="form-control" id="catcosto_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
						</div>
					</div>
					<div class="col-md-2">
						<label for="catcosto_porcentaje" class="control-label"><span class="text-danger">*</span>Porcentaje</label>
						<div class="input-group">
							<input type="number" step="any" name="catcosto_porcentaje" value="<?php echo ($this->input->post('catcosto_porcentaje') ? $this->input->post('catcosto_porcentaje') : ($catcosto['catcosto_porcentaje']*100)); ?>" class="form-control" id="catcosto_porcentaje" max="100" min="0" />
							<span class="input-group-addon" id="basic-addon1">%</span>
						</div>
					</div>
				</div>
			</div>
			<div class="box-footer">
            	<button type="submit" class="btn btn-success">
		    <i class="fa fa-check"></i>Guardar
		</button>
                 <a href="<?php echo site_url('categoria_costo'); ?>" class="btn btn-danger">
                                <i class="fa fa-times"></i> Cancelar</a>
	        </div>				
			<?php echo form_close(); ?>
		</div>
    </div>
</div>