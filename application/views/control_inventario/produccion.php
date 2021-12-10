<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<input type="hidden" name="produccion" id="produccion" value="<?= $produccion_id ?>" />
<!----------------------------- script buscador --------------------------------------->
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
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<!-------------------------------------------------------->
<style>
 .button_add{
    position: static;
    right: 20vw;
    height: 13vh;
    top: -15px;
    /* z-index: 0; */
    font-size: 60px;
    /* color: rgba(0, 0, 0, 0.15); */
}
.small-box{
    color: black !important;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10pt;
}

.inner{
    display: flow-root; 
}
.icon{
    font-size: 70px !important;
    right: 40px !important;
}

.cuadro_fondo{
    margin: 10px;
    width: 50em;
    display: inline-block;;
}

.forma{
    clip-path: polygon(66%   0%, 100% 0%, 66% 100%, 33% 100%);
}
</style>
<div class="box-header">
    <div class="col-md-12">
        <div  class="col-md-12 text-bold text-center">
            <font size='4' face='Arial'><b>PRODUCCION Nro.: <?php echo $produccion['produccion_numeroorden']; ?></b></font><br>
            <font size='4' face='Arial'><b><?php echo $produccion['produccion_descripcion']; ?></b></font>    
        </div>
        <div  class="col-md-6">
            <table>
                <tr>
                    <td style="width: 15%" class="text-right"><b>Inicio:&nbsp;</b></td>
                    <td style="width: 85%"><?php echo date("d/m/Y", strtotime($produccion['produccion_inicio'])); ?></td>
                </tr>
                <tr>
                    <td style="width: 15%" class="text-right"><b>Fin:&nbsp;</b></td>
                    <td style="width: 85%">
                        <?php
                        if($produccion['produccion_fin'] != "" && $produccion['produccion_fin'] != null && $produccion['produccion_fin'] != "0000-00-00" ){
                            echo date("d/m/Y", strtotime($produccion['produccion_fin']));
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="width: 15%" class="text-right"><b>Responsable:&nbsp;</b></td>
                    <td style="width: 85%"><?php echo $produccion['responsable']; ?></td>
                </tr>
            </table>
        </div>
    </div>
    <!-- <button class="btn btn-success btn-sm" style="float: right;">+ Añadir producci&oacute;n</button>  -->
</div>
<div class="row">
    <div class="col-md-12">
        <!--<div class="box-tools"></div>-->

        <!--<div><br><br><br><br><br></div>-->
        <div class="box">
            <div class="box-body">
                <section id="platabandas_produccion" class="row"></section>
            </div>
        </div>
        <div class="modal fade" id="modal_info_platabanda" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true" style="font-family: Arial !important;">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: inline;"><b>PLATABANDA: <span id="platabanda_number"></span></b></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">
                            <span aria-hidden="true" style="padding-right: 10px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="modal_infor_platabanda"></div>
                        
                    </div>            
                </div>
            </div>
        </div>
        <!-------------------------------- modal venta ------------------------------------------->
        <div class="modal fade" id="modal_form_venta" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h3 class="modal-title" style="display: inline;">ENVIAR A VENTAS</h3>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">
                            <span aria-hidden="true" style="padding-right: 10px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="box-body">
                                <div class="row clearfix">

                                    <form action="">
                                        <div class="col-md-12">
                                            <label for="form_producto" class="control-label">Producto</label>
                                            <div class="form-group">
                                                <input type="text" name="form_producto" value="" class="form-control" id="form_producto" disabled/>
                                                <input type="hidden" name="form_producto_id" value="" class="form-control" id="form_producto_id"/>
                                            </div>
                                        </div>
                                        <div class="form-row">
                                            <div class="col-md-12">
                                                <label for="form_cantidad" class="control-label"><span class="text-danger">*</span>Cantidad</label>
                                                <div class="form-group">
                                                    <input type="number" name="form_cantidad" value="" class="form-control" id="form_cantidad" placeholder="Ejm. 30" required/>
                                                    <input type="hidden" id="platabanda">
                                                    <input type="hidden" id="det_produccion">
                                                </div>
                                            </div>
                                            <!-- <div class="col-md-3">
                                                <label for="form_costo">Costo Bs</label>
                                                <input type="number" id="form_costo" name="form_costo" class="form-control" placeholder="Last name">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="form_precio">Precio</label>
                                                <input type="number" id="form_precio" name="form_precio" class="form-control" placeholder="Last name">
                                            </div>
                                            <div class="col-md-3">
                                                <label for="form_total">Total</label>
                                                <input type="number" id="form_total" name="form_total" class="form-control" placeholder="Last name">
                                            </div> -->
                                        </div>
                                    </form>
                                </div>
                            </div>
                            <div class="box-footer">
                                <div class="col-md-12 text-center">
                                    <a class="btn btn-success" onclick="save_compra()">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> Vender
                                    </a>
                                    <a data-dismiss="modal" class="btn btn-danger"><i class="fa fa-times"></i> Cancelar</a>
                                </div>
                            </div>
                        </div>  
                    </div>            
                </div>
            </div>
        </div>
        <!-------------------------------- modal venta ------------------------------------------->
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript(){}"></script>
<script src="<?php echo base_url('resources/js/platabanda_produccion.js'); ?>"></script>