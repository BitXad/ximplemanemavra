<div class="row">
    <div class="col-md-12">
      	<div class="box box-info">
            <div class="box-header with-border">
              	<h3 class="box-title">Nueva Producción</h3>
            </div>
            <?php echo form_open('produccion/add'); ?>
          	<div class="box-body">
                    <div class="row clearfix">
                        <!--<div class="col-md-6">
                            <label for="produccion_numeroorden" class="control-label">Produccion</label>
                            <div class="form-group">
                                <select name="produccion_numeroorden" class="form-control">
                                    <option value="">select produccion</option>
                                    <?php 
                                    /*foreach($all_produccion as $produccion)
                                    {
                                        $selected = ($produccion['produccion_id'] == $this->input->post('produccion_numeroorden')) ? ' selected="selected"' : "";
                                        echo '<option value="'.$produccion['produccion_id'].'" '.$selected.'>'.$produccion['produccion_numeroorden'].'</option>';
                                    }*/
                                    ?>
                                </select>
                            </div>
                        </div>-->
                        <div class="col-md-3">
                            <label for="produccion_inicio" class="control-label">Fecha de Inicio</label>
                            <div class="form-group">
                                <input type="date" name="produccion_inicio" value="<?php echo ($this->input->post('produccion_fecha') ? $this->input->post('produccion_fecha') : date("Y-m-d")); ?>" class="form-control" id="produccion_inicio" />
                            </div>
                        </div>
                        <div class="col-md-9">
                            <label for="produccion_descripcion" class="control-label">Descripción</label>
                            <div class="form-group">
                                <input type="text" maxlength="250" name="produccion_descripcion" value="<?php echo ($this->input->post('produccion_descripcion') ? $this->input->post('produccion_fecha') : ""); ?>" class="form-control" id="produccion_descripcion" onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);" />
                            </div>
                        </div>
					<div class="col-md-6">
						<label for="produccion_hora" class="control-label">Produccion Hora</label>
						<div class="form-group">
							<input type="text" name="produccion_hora" value="<?php echo $this->input->post('produccion_hora'); ?>" class="form-control" id="produccion_hora" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="produccion_unidad" class="control-label">Produccion Unidad</label>
						<div class="form-group">
							<input type="text" name="produccion_unidad" value="<?php echo $this->input->post('produccion_unidad'); ?>" class="form-control" id="produccion_unidad" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="produccion_cantidad" class="control-label">Produccion Cantidad</label>
						<div class="form-group">
							<input type="text" name="produccion_cantidad" value="<?php echo $this->input->post('produccion_cantidad'); ?>" class="form-control" id="produccion_cantidad" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="produccion_total" class="control-label">Produccion Total</label>
						<div class="form-group">
							<input type="text" name="produccion_total" value="<?php echo $this->input->post('produccion_total'); ?>" class="form-control" id="produccion_total" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="produccion_costounidad" class="control-label">Produccion Costounidad</label>
						<div class="form-group">
							<input type="text" name="produccion_costounidad" value="<?php echo $this->input->post('produccion_costounidad'); ?>" class="form-control" id="produccion_costounidad" />
						</div>
					</div>
					<div class="col-md-6">
						<label for="produccion_preciounidad" class="control-label">Produccion Preciounidad</label>
						<div class="form-group">
							<input type="text" name="produccion_preciounidad" value="<?php echo $this->input->post('produccion_preciounidad'); ?>" class="form-control" id="produccion_preciounidad" />
						</div>
					</div>
				</div>
			</div>
          	<div class="box-footer">
                    <button type="submit" class="btn btn-success">
            		<i class="fa fa-check"></i> Guardar
                    </button>
                    <a href="<?php echo site_url('produccion'); ?>" class="btn btn-danger">
                    <i class="fa fa-times"></i> Cancelar</a>
          	</div>
            <?php echo form_close(); ?>
      	</div>
    </div>
</div>