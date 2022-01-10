<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Añadir Costo</h3>
            </div>
            <?php echo form_open('costo/add'); ?>
          	<div class="box-body">
                    <div class="row clearfix">
                        <div class="col-md-6">
                            <label for="costo_descripcion" class="control-label"><span class="text-danger">*</span>Insumo</label>
                            <div class="form-group">
                                <input type="text" name="costo_descripcion" value="<?php echo $this->input->post('costo_descripcion'); ?>" class="form-control" id="costo_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                                <span class="text-danger"><?php echo form_error('costo_descripcion');?></span>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="costo_unidad" class="control-label">Unidad</label>
                            <div class="form-group">
                                <input type="text" name="costo_unidad" value="<?php echo $this->input->post('costo_unidad'); ?>" class="form-control" id="costo_unidad" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                            </div>
                        </div>
                        <div class="col-md-3">
                            <label for="costo_unitario" class="control-label">Costo unitario (Bs)</label>
                            <div class="form-group">
                                <input type="number" step="any" name="costo_unitario" value="" class="form-control" id="costo_unitario" required/>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="costcategoria" class="control-label">Categoria</label>
                            <div class="form-group">
                                <select name="costcategoria" id="costcategoria" class="form-control">
                                    <?php foreach($categorias as $categoria){
                                    echo "<option value='{$categoria['catcosto_id']}'>{$categoria['catcosto_descripcion']}</option>";
                                    } 
                                    ?>
                                </select>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <label for="estado" class="control-label">Estado</label>
                            <div class="form-group">
                                <select name="estado" id="estado" class="form-control">
                                    <?php foreach($estados as $estado){
                                    echo "<option value='{$estado['estado_id']}'>{$estado['estado_descripcion']}</option>";
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
                    <a href="<?php echo site_url('costo'); ?>" class="btn btn-danger">
                        <i class="fa fa-times"></i> Cancelar
                    </a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>