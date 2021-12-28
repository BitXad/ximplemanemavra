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
    <font size='4' face='Arial'><b>Categoria costo</b></font>
    <br><font size='2' face='Arial'>Registros Encontrados: <?php echo sizeof($categoria_costos); ?></font>
    <div class="box-tools no-print">
        <!-- <a href="<?php echo site_url('categoria_costo/add'); ?>" class="btn btn-success btn-sm"><fa class='fa fa-pencil-square-o'></fa> Registrar Categoria</a>  -->
        
    </div>
</div>
<div class="row">
    <div class="col-md-12">
            <!--------------------- parametro de buscador --------------------->
                  <div class="input-group no-print"> <span class="input-group-addon">Buscar</span>
                    <input id="filtrar" type="text" class="form-control" placeholder="Ingrese nombre, descripción">
                  </div>
            <!--------------------- fin parametro de buscador --------------------->
            <div class="box">
            <div class="box-body  table-responsive">
                <table class="table table-striped table-condensed" id="mitabla">
                    <tr>
						<th>#</th>
						<th>Parametro</th>
						<th width="150px">%</th>
						<th></th>
                        <!-- <th class="no-print"></th> -->
                    </tr>
                    <tbody class="buscar">
                        <?php $i=1;?>
                        <?php foreach($categoria_costos as $cc){ ?>
                            <?php if($cc['catcosto_tipo'] == 1){ ?> 
                                <tr>
                                    <td><?= $i ?></td>
                                    <td><?= $cc['catcosto_descripcion'] ?></td>
                                    <td><?= number_format((float)($cc['catcosto_porcentaje']*100),2,'.','') ?></td>
                                    <!-- <td>
                                        <div class="input-group">
                                            <input type="number" step="any" class="form-control" value="<?= ($cc['catcosto_porcentaje']*100) ?>" placeholder="0.00" onclick="change('button_mano_obra_indirecta')">
                                            <!-- <span class="input-group-btn">
                                                <button class="btn btn-success" style="display: none" id="button_mano_obra_indirecta" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                            </span>
                                        </div>
                                    </td> -->
                                    <td>
                                        <a href="<?= site_url("categoria_costo/edit/{$cc['catcosto_id']}") ?>" class="btn btn-xs btn-info"><i class="fa fa-pencil" aria-hidden="true"></i></a href="" >
                                    </td>
                                </tr>
                                <?php $i++; ?>
                            <?php } ?>
                        <?php } ?>

                        <!-- <tr>
                            <td>A</td>
                            <td>MATERIAL</td>
                            <td></td>
                            <td>*</td>
                        </tr>
                        <tr>
                            <td>B</td>
                            <td>OBRERO</td>
                            <td></td>
                            <td>*</td>
                        </tr>
                        <tr>
                            <td>C</td>
                            <td>EQUIPO</td>
                            <td></td>
                            <td>*</td>
                        </tr>
                        <tr>
                            <td>D</td>
                            <td>TOTAL MATERIALES</td>
                            <td></td>
                            <td>A</td>
                        </tr>
                        <tr>
                            <td>E</td>
                            <td>MANO DE OBRA INDIRECTA</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="0.00" onclick="change('button_mano_obra_indirecta')">
                                    <span class="input-group-btn">
                                        <button class="btn btn-success" style="display: none" id="button_mano_obra_indirecta" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>F</td>
                            <td>BENEFICIOS SOCIALES</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="0.00" onclick="change('button_beneficios_sociales')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_beneficios_sociales" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>G</td>
                            <td>TOTAL MANO DE OBRA</td>
                            <td></td>
                            <td>B+E+F</td>
                        </tr>
                        <tr>
                            <td>H</td>
                            <td>HERRAMIENTAS MENORES</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_herramientas_menores')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_herramientas_menores" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>B</td>
                        </tr>
                        <tr>
                            <td>I</td>
                            <td>TOTAL HERRAMIENTAS Y EQUIPOS</td>
                            <td></td>
                            <td>C+H</td>
                        </tr>
                        <tr>
                            <td>J</td>
                            <td>SUB TOTAL</td>
                            <td></td>
                            <td>D+G+I</td>
                        </tr>
                        <tr>
                            <td>K</td>
                            <td>IMPREVISTOS</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_imprevistos')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_imprevistos" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>J</td>
                        </tr>
                        <tr>
                            <td>L</td>
                            <td>GASTOS GENERALES</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_gastos_generales')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_gastos_generales" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>J</td>
                        </tr>
                        <tr>
                            <td>M</td>
                            <td>UTILIDAD</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_utilidad')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_utilidad" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>J</td>
                        </tr>
                        <tr>
                            <td>N</td>
                            <td>PARCIAL</td>
                            <td></td>
                            <td>J+K+L+M</td>
                        </tr>
                        <tr>
                            <td>O</td>
                            <td>IVA</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_iva')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_iva" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>N</td>
                        </tr>
                        <tr>
                            <td>P</td>
                            <td>IT</td>
                            <td>
                                <div class="input-group">
                                    <input type="number" step="any" class="form-control" placeholder="5.00" value="5.00" onclick="change('button_it')">
                                    <span class="input-group-btn" >
                                        <button class="btn btn-success" style="display: none" id="button_it" type="button"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                    </span>
                                </div>
                            </td>
                            <td>N</td>
                        </tr>
                        <tr>
                            <td>Q</td>
                            <td>TOTAL ITEM</td>
                            <td></td>
                            <td>N+O+P</td>
                        </tr> -->
                    </tbody>
                </table>
                                
            </div>
        </div>
    </div>
</div>
<script>
    function change(span_id){
        ocultar_span(span_id);
        let html = `<div class="col-md-4 mb-3">
                        <label for="validationCustomUsername">Username</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                            <span class="input-group-text" id="inputGroupPrepend">@</span>
                            </div>
                            <input type="text" class="form-control" id="validationCustomUsername" placeholder="Username" aria-describedby="inputGroupPrepend" required>
                            <div class="invalid-feedback">
                            Please choose a username.
                            </div>
                        </div> 
                    </div>`
        // $(`${tr_id}`).html(html);
    }

    function ocultar_span(span_id){
        let form = document.getElementById(span_id);
        if (form.style.display == "none") {
            form.style.display = "block";
        } else {
            form.style.display = "none";
        }
    }
</script>