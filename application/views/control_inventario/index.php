<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
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
<style>
    .button_add{
        /* -webkit-transition: all .3s linear;
        -o-transition: all .3s linear; */
        /* transition: all .3s linear; */
        position: static;
        top: -5px;
        right: 35%;
        z-index: 0;
        font-size: 90px;
        color: rgba(0, 0, 0, 0.15);
    }
</style>
<!-------------------------------------------------------->
<div class="box-header">
    <font size='4' face='Arial'><b>Control de producción</b></font>    
</div>
<div class="row">
    <div class="col-md-12">
    <div class="box-tools">
            <div class=" col-md-12"> <!-- panel panel-primary -->
                <div class="col-md-2">
                    &Aacute;reas: <select id="area_id" class="btn btn-primary" name="select_estado" id="select_estado" onchange="get_platabandas()">
                        <!-- <option value="0">Escoge una &aacute;rea</option> -->
                        <?php foreach ($areas as $a){ ?>
                            <option value="<?= $a['area_id'] ?>"><?= $a['area_nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>
        </div>

        <div><br><br><br></div>
        <div class="box">
            <div class="box-body table-responsive">
                <section id="platabandas"></section>
            </div>
        </div>
        <div class="modal fade" id="modal_info_platabanda" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-body">                        
                        <label for="inventario_descripcion">Descripci&oacute;n del inventario</label>
                        <div class="form-group">
                            <input type="text" class="form-control" id="inventario_descripcion" name="inventario_descripcion" required onkeyup="var start = this.selectionStart; var end = this.selectionEnd; this.value = this.value.toUpperCase(); this.setSelectionRange(start, end);">
                        </div>
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript(){}"></script>
<script>
    $(window).load(function(){ 
        get_platabandas();
    })
    var base_url = document.getElementById("base_url").value;
    function get_platabandas(){
        var area_id = document.getElementById("area_id").value;
        var controlador = `${base_url}control_inventario/get_platabanda_area`;
        $.ajax({
            url: controlador,
            type: "POST",
            data:{area_id:area_id},
            success:(respuesta)=>{
                var resp = JSON.parse(respuesta);
                let html = ``;
                let i = 1;
                html += `<div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="small-box bg-default">
                                <button class="btn btn-default" style="width: 100%;" onclick="agregar_platabanda()">
                                    <div class="inner button_add">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </div>
                                </button>
                            </div>
                        </div>`;
                resp.forEach(e => {
                    html+=`<div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="small-box ${(e['estado_id'] == 2) ? `bg-info`:`bg-green`}">
                                    <div class="inner">
                                        <h4><b>Platabanda: </b>${i}</h4>
                                        <p>Rosas (100)</p>
                                        <p>Girasoles (180)</p>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-pagelines" aria-hidden="true"></i>
                                        <!-- <i class="bi bi-flower1"></i> -->
                                    </div>
                                    <div style="width: 100%;">
                                        <button onclick="show_modal_info()" class="btn btn-sm btn-warning" style="width: 49%;"><i class="fa fa-eye" aria-hidden="true"></i></button>
                                        <button onclick="show_modal_compra()" class="btn btn-sm btn-primary" style="width: 50%;"><i class="fa fa-cart-plus" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            </div>`
                    i++;
                });
                
                $("#platabandas").html(html);
            },
            error:()=>{
                alert("ocurrio algo malo")
            }
        });
    }

    function agregar_platabanda(){
        var area_id = document.getElementById("area_id").value;
        var controlador = `${base_url}control_inventario/agregar_platabanda`;
        let html = ``;
        $.ajax({
            url: controlador,
            type: "POST",
            data:{area_id:area_id},
            success:(respuesta)=>{
                html+=`<div class="col-sm-12 col-md-4">
                            <div class="small-box bg-green">
                                <div class="inner">
                                    <h4><b>Platabanda: </b>1</h4>
                                    <p>Rosas (100)</p>
                                    <p>Girasoles (180)</p>
                                </div>
                                <div class="icon">
                                    <i class="fa fa-pagelines" aria-hidden="true"></i>
                                    <!-- <i class="bi bi-flower1"></i> -->
                                </div>
                                <div style="width: 100%;">
                                    <a href="<?php echo site_url('servicio/repinftecservicio'); ?>" class="btn btn-sm btn-warning" style="width: 49%;"><i class="fa fa-eye" aria-hidden="true"></i></a>
                                    <a href="<?php echo site_url('servicio/repinftecservicio'); ?>" class="btn btn-sm btn-primary" style="width: 50%;"><i class="fa fa-cart-plus" aria-hidden="true"></i></a>
                                </div>
                            </div>
                        </div>`
                // $('#new_platabanda').html(html);
                get_platabandas()
            },
            error:()=>{
                alert("algo salio mal al crear")
            }
        });
    }

    function show_modal_info(platabanda_id){
        let controlador = `${base_url}control_inventario/get_items_platabanda`;
        $.ajax({
            url: controlador,
            type: "POST",
            data:{platabanda_id:platabanda_id},
            success:(resultado)=>{
                result = JSON.parse(resultado);
                $("#show_modal_info").modal('show');
            },
            error:()=>{
                alert("algo salio mal para la información")
            }
        });
    }
</script>