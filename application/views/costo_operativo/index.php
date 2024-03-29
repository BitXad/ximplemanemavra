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
    <font size='4' face='Arial'><b>Costo Operativo</b></font>
    <br><font size='2' face='Arial'>Registros Encontrados: <?php echo sizeof($costo_operativo); ?></font>
            	<div class="box-tools no-print">
                    <a href="<?php echo site_url('costo_operativo/add'); ?>" class="btn btn-success btn-sm"><fa class='fa fa-pencil-square-o'></fa> Registrar Costo Operativo</a> 
                </div>
</div>
<div class="row">
    <div class="col-md-12">
            <!--------------------- parametro de buscador --------------------->
                  <div class="input-group no-print"> <span class="input-group-addon">Buscar</span>
                    <input id="filtrar" type="text" class="form-control" placeholder="Ingres la descripcion, costo">
                  </div>
            <!--------------------- fin parametro de buscador ---------------------> 
        <div class="box">
            
            <div class="box-body table-responsive">
                <table class="table table-striped table-condensed" id="mitabla">
                    <tr>
                        <th>#</th>
                        <th>Producción</th>
                        <th>Descripción</th>
                        <th>Costo</th>
                        <th>usuario</th>
                        <th>Estado</th>
                        <th class="no-print"></th>
                    </tr>
                    <tbody class="buscar">
                    <?php $i = 0;
                          foreach($costo_operativo as $c){; 
                              $i = $i+1;?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $c['produccion_id']; ?></td>
                        <td><?php echo $c['costodesc_descripcion']; ?></td>
                        <td><?php echo $c['costoop_costo']; ?></td>
                        <td><?php echo $c['usuario_nombre']; ?></td>
                        <td><?php echo $c['estado_descripcion']; ?></td>
                        <td>
                            <a href="<?php echo site_url('costo_operativo/edit/'.$c['costoop_id']); ?>" class="btn btn-info btn-xs"><span class="fa fa-pencil"></span></a> 
                        </td>
                    </tr>
                    <?php } ?>
                </table>
            </div>               
        </div>
    </div>
</div>
