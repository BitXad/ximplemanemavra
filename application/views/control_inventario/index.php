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
        position: static;
        top: -5px;
        right: 35%;
        z-index: 0;
        font-size: 45px;
        color: rgba(0, 0, 0, 0.15);
    }
    .small-box{
        color: black !important;
    }
    .icon{
        font-size: 70px !important;
        right: 40px !important;
    }
</style>
<!-------------------------------------------------------->
<div class="box-header">
    <font size='4' face='Arial'><b>Control de producción</b></font>    
    <div class="box-tools">
        <button class="btn btn-success btn-sm">+ Añadir producci&oacute;n</button> 
    </div>
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
            <div class="box-body">
                <section id="platabandas" class="row"></section>
            </div>
        </div>
        <div class="modal fade" id="modal_info_platabanda" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: inline;">Platabanda #1</h4>
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
        <div class="modal fade" id="modal_info_platabanda2" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: inline;">Platabanda #1</h4>
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
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript(){}"></script>
<script>
    $(window).load(function(){ 
        get_platabandas();
    })
    const base_url = document.getElementById("base_url").value;
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
                let i = resp['respuesta'].length;
                let color, boton, info;
                html += `<div class="col-xs-12 col-sm-6 col-md-4">
                            <div class="small-box bg-default">
                                <button class="btn btn-default" style="width: 100%;" onclick="agregar_platabanda()">
                                    <div class="inner button_add">
                                        <i class="fa fa-plus-circle" aria-hidden="true"></i>
                                    </div>
                                </button>
                            </div>
                        </div>`;
                console.log(resp['respuesta']);
                resp['respuesta'].forEach(e => {
                    color = "";
                    boton = "";
                    info = "";
                    switch (e['estado_id']) {
                        case '36':
                            color = `bg-success`;
                            info = `<span>Vacio</span>`;
                            break;
                        case '37':
                            color = `bg-green`;
                            boton = `<button onclick="show_modal_info(${e['controli_id']})" class="btn btn-sm btn-info" style="width: 100%;z-index:8;"><i class="fa fa-eye" aria-hidden="true"></i></button>`;
                            resp['plantas'].forEach(p => {
                                if (e['controli_id'] == p['controli_id']) {
                                    info += `<div class="col-md-6 bg-info" style="border-radius: 10px; color:black; margin: 1px; background:#${p['estado_color']}"><span>${p['producto_nombre']}</span><span> (${p['detproduccion_cantidad']})</span></div>`;
                                }
                            });    
                            break;
                        case '38':
                            color = `bg-danger`; 
                            break;
                        default:
                            color = `bg-danger`;
                            break;
                    }
                    let estado = (e['estado_id'] == '38' ? `off" title="Inactivo"` : `on" title="Activo"`);
                    html+=`<div class="col-xs-12 col-sm-6 col-md-4">
                                <div class="small-box ${color}">
                                    <div class="inner">
                                        <h4><b>Platabanda: </b>${i}<a style="float:right; cursor:pointer; color:${e['estado_id'] == 38 ? "":"#00019E"}" onclick="cambiar_estado_platabanda(${e['controli_id']},${e['estado_id']})"><i class="fa fa-toggle-${estado}" aria-hidden="true"></i></a></h4>
                                        ${info}
                                        <br>
                                    </div>
                                    <div class="icon">
                                        <i class="fa fa-pagelines" aria0 0-hidden="true"></i>
                                    </div>
                                    <div style="width: 100%;">
                                        ${boton}
                                    </div>
                                </div>
                            </div>`;
                    i--;
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
        $.ajax({
            url: controlador,
            type: "POST",
            data:{area_id:area_id},
            success:(respuesta)=>{
                get_platabandas()
            },
            error:()=>{
                alert("algo salio mal al crear")
            }
        });
    }

    function show_modal_info(platabanda_id = 0){
        let controlador = `${base_url}control_inventario/get_items_platabanda`;
        $("#modal_info_platabanda").modal('show');
        $.ajax({
            url: controlador,
            type: "POST",
            data:{platabanda_id:platabanda_id},
            success:(resultado)=>{
                result = JSON.parse(resultado);
                html = ``;
                result.forEach(item => {
                    html += `<div class="col-md-12">
                                <div class="form-inline">
                                    <label for="planta_nombre">Producci&oacute;n: </label>
                                    <span id="planta_nombre${item['controli_id']}">${item['producto_nombre']}</span><sub>[${item['produccion_id']}]</sub>
                                </div>
                                <div class="form-inline">
                                    <label for="planta_nombre">Fecha de producción: </label>
                                    <span id="fecha${item['controli_id']}">${item['produccion_fecha'].replace(/^(\d{4})-(\d{2})-(\d{2})$/g,'$3/$2/$1')} - ${item['produccion_hora']}</span>
                                </div>
                                <div class="form-inline">
                                    <div class="form-group mb-2">
                                        <label for="cantidad">Cantidad</label>
                                        <input type="number" min="0" class="form-control" id="cantidad${item['controli_id']}" name="cantidad${item['controli_id']}" value="${item['detproduccion_cantidad']}" style="border: 0; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off">
                                    </div>
                                </div>
                                <div class="form-inline">
                                    <div class="form-group mb-2">
                                        <b>Etapa</b>
                                        <span id="etapa${item['controli_id']}" style="border: 0; background-color: #${item['estado_color']}; padding: 3px; border-radius: 6px">${item['estado_descripcion']}</span>
                                    </div>
                                </div>
                                <div class="form-group mb-2">
                                    <label for="observacion">Observación</label>
                                    <textarea class="form-control" id="observacion_${item['controli_id']}" placeholder="Ingrese una observación"></textarea>
                                    <input type="hidden" id="platabanda-${item['controli_id']}" name="platabanda-${item['controli_id']}" placeholder="Ingrese una observación">
                                </div>
                                <div class="form-group mb-12">
                                    <button class="btn btn-success btn-sm" onclick="actulizar informacion()" title="Guardar información"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                    <button class="btn btn-primary btn-sm" onclick="" title="Agregar costo operativo"><i class="fa fa-plus-square-o" aria-hidden="true"></i> Costo</button>
                                    <button class="btn btn-info btn-sm" onclick="pasar_etapa(${item['detproduccion_id']},${item['estado_id']})" title="pasar a siguiente etapa"><i class="fa fa-arrow-right" aria-hidden="true"></i></button>
                                </div>
                            </div>`;
                });

                $('#modal_infor_platabanda').html(html);
                $("#show_modal_info").modal('show');
            },
            error:()=>{
                alert("algo salio mal para la información")
            }
        });
    }
    
    function cambiar_estado_platabanda(controli_id, estado_id){
        if(estado_id == '38'){
            estado_id = 36;
        }else{
            estado_id = 38;
        }
        let controlador = `${base_url}control_inventario/cambiar_estado`;
        $.ajax({
            url: controlador,
            type: "POST",
            data:{estado_id:estado_id,controli_id:controli_id},
            cache:false,
            success:()=>{
                get_platabandas();
            },
            error:()=>{
                alert("Ocurrio un error al modificar el estado de la platabanda")
            }
        });
    }

    function pasar_etapa(detproduccion_id, estado_id){
        let controlador = `${base_url}detalle_produccion/pasar_siguiente_estado`
        $.ajax({
            url: controlador,
            type: "POST",
            cache: false,
            data:{detproduccion_id:detproduccion_id, estado_id:estado_id},
            success:()=>{
                $("#modal_info_platabanda").modal('hide');
                get_platabandas();
            },
            error:()=>{
                alert("Ocurrio un error al cambiar de estado")
            }
        });
    }
</script>