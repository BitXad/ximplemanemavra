var base_url;
$(window).load(function(){ 
    base_url = document.getElementById("base_url").value;
    get_platabandas();
})
// const base_url = url;
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
            let color, boton, info, cant_fotos;
            html += `<div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="cuadro bg-default">
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
                cant_fotos = 0;
                
                switch (e['estado_id']) {
                    case '36':
                        color = `bg-info`;
                        info = `<span>Vacio</span>`;
                        break;
                    case '37':
                        color = `bg-green`;
                        boton = `<button onclick="show_modal_info(${e['controli_id']})" class="btn btn-sm btn-info" style="width: 100%;z-index:8;"><i class="fa fa-eye" aria-hidden="true"></i></button>`;
                        // if(resp['plantas'].count > 0){}
                        let platabanda;
                        let cambiar = true;
                        resp['plantas'].forEach(p => {
                            if (e['controli_id'] == p['controli_id']) {
                                info += `<a onclick="show_modal_info(${e['controli_id']})" title="Mostar información" style="cursor:pointer; text-decoration: none; color: black;">
                                            <div class="col-md-10 bg-success" style="border-radius: 10px; color:black; margin: 1px; background:#${p['estado_color']}">
                                                <img src="${base_url}resources/images/productos/${p['producto_foto']}" width="25px" heigth="25px" class="img-circle img-responsive" style="display: inline-block" alt="${p['producto_nombre']}">
                                                <span style="font-size: 7pt;"><b>  ${p['producto_nombre']}</b></span>
                                                <span style="font-size: 7pt;"><b> (${p['detproduccion_cantidad']})</b></span>
                                            </div>
                                        </a>`;
                                if (p['estado_id'] == '39'){
                                    platabanda = e['controli_id'];
                                }else{
                                    cambiar = false;
                                }
                            }
                            
                        });
                        if(cambiar) {
                            cambiar_estado_platabanda(platabanda, 38);
                            // console.log(platabanda);
                        }
                        break;
                    case '38':
                        color = `bg-danger`; 
                        break;
                    default:
                        color = `bg-danger`;
                        break;
                }
                let estado = (e['estado_id'] == '38' ? `off" title="Inactivo"` : `on" title="Activo"`);
                html+=`<div class="col-xs-12 col-sm-6 col-md-3">
                            <div class="small-box ${color}">
                                <div class="inner">
                                    <span style="font-size: 8pt;"><b>Platabanda: </b>${e['controli_id']}<a style="float:right; cursor:pointer; color:${e['estado_id'] == 38 ? "":"#00019E"}" onclick="cambiar_estado_platabanda(${e['controli_id']},${e['estado_id']})"><i class="fa fa-toggle-${estado}" aria-hidden="true"></i></a></span><br>
                                    ${info}
                                    <br>
                                    <br>
                                    <br>
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

function show_modal_info(platabanda_id){
    let controlador = `${base_url}control_inventario/get_items_platabanda`;
    $("#modal_info_platabanda").modal('show');
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data:{platabanda_id:platabanda_id},
        success:(resultado)=>{
            result = JSON.parse(resultado);
            let res = result['plantas'];
            let costos = result['costos'];
            let html = ``;
            res.forEach(item => {
                html += `<div class="row">
                            <article class="col-md-7">
                                <div class="col-md-8">
                                    <div class="form-inline">
                                        <label for="planta_nombre">Producci&oacute;n: </label>
                                        <span id="planta_nombre${item['detproduccion_id']}">${item['producto_nombre']}</span><sub>[${item['produccion_id']}]</sub>
                                    </div>
                                    <div class="form-inline">
                                        <label for="planta_nombre">Fecha de producción: </label>
                                        <span id="fecha${item['detproduccion_id']}">${item['produccion_registro']}</span>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <label for="cantidad${item['detproduccion_id']}">Cantidad</label>
                                            <input type="number" min="0" class="form-control" id="cantidad${item['detproduccion_id']}" name="cantidad${item['detproduccion_id']}" value="${item['detproduccion_cantidad'] - item['detproduccion_perdida']}" style="border: 0; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="perdida${item['detproduccion_id']}">Perdida</label>
                                            <input type="number" min="0" max="${item['detproduccion_cantidad'] - item['detproduccion_perdida']}" class="form-control" id="perdida${item['detproduccion_id']}" name="perdida${item['detproduccion_id']}" value="0" style="border: 0; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off" onchange="calcular(${item['detproduccion_id']})">
                                        </div>
                                    </div>
                                    <div class="form-inline">
                                        <div class="form-group mb-2">
                                            <b>Etapa</b>
                                            <span id="etapa${item['detproduccion_id']}" style="border: 0; background-color: #${item['estado_color']}; padding: 3px; border-radius: 6px">${item['estado_descripcion']}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <figure>
                                        <img class="img-rounded" src="${base_url}resources/images/productos/${item['producto_foto']}" width="100%" alt="${item['producto_nombre']}" title="${item['producto_nombre']}">
                                    </figure>
                                </div>
                                <div class="col-md-12">
                                    <div class="form-group mb-2">
                                        <label for="observacion">Observación</label>
                                        <textarea class="form-control" id="observacion_${item['detproduccion_id']}" placeholder="Ingrese una observación">${(item['detproduccion_observacion'] == null)?"":item['detproduccion_observacion']}</textarea>
                                        <input type="hidden" id="platabanda-${item['detproduccion_id']}" name="platabanda-${item['detproduccion_id']}" placeholder="Ingrese una observación">
                                    </div>
                                    <div class="form-group mb-12">
                                        <button class="btn btn-success btn-sm" onclick="actulizar_informacion(${item['detproduccion_id']})" title="Guardar información" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                        <button class="btn btn-primary btn-sm" onclick="form_costo(${item['detproduccion_id']},${platabanda_id})" title="Agregar costo operativo" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-plus-square-o" aria-hidden="true"></i> Costo</button>
                                        <button class="btn btn-${item['estado_id'] != 35 ? `info`: `success`} btn-sm" ${ item['estado_id'] != 35 ? `onclick="pasar_etapa(${item['detproduccion_id']},${item['estado_id']})"`: `onclick="send_inventario(${item['detproduccion_id']},${item['producto_id']})"` }  title="${ item['estado_id'] != 35 ? `Pasar a siguiente etapa` : `Mandar a ventas` }" ${ item['estado_id'] == '39' ? `disabled`:`` }>${ item['estado_id'] != 35 ? `<i class="fa fa-arrow-right" aria-hidden="true"></i>` : `<i class="fa fa-shopping-cart" aria-hidden="true"></i>`}</button>
                                    </div>
                                </div>
                                <div class="col-md-12" id="formulario-costo-${item['detproduccion_id']}" style="display:none;"></div>
                            </article>
                            <article class="col-md-5">
                                <table class="table table-striped" style="font-size: 8pt;">
                                    <thead class="thead-light">
                                        <tr>
                                            <th>#</th>
                                            <th>Detalle</th>
                                            <th># Pb.</th>
                                            <th>Costo</th>
                                            <th>Fecha</th>
                                        </tr>
                                    </thead>
                                    <tbody id="tabla_costo${ item['detproduccion_id'] }" style="font-size:8pt;">`
                html += get_tabla_costo(item['detproduccion_id'],costos,item['produccion_id']);
                html +=`            </tbody>
                                </table>
                            </article>
                        </div>`;
                get_tabla_costo(item['detproduccion_id'],costos,item['produccion_id']);
            });
            $('#modal_infor_platabanda').html(html);
            $('#platabanda_number').html(platabanda_id);
            $("#show_modal_info").modal('show');
        },
        error:()=>{
            alert("algo salio mal para la información")
        }
    });
}

function get_tabla_costo(detproduccion_id,costos="",produccion, id = ``){
    let html = ``;
    let i = 1;
    if (costos != "") {
        costos.forEach(costo => {
            costo.forEach(cost => {
                console.log(cost['produccion_id']);
                if(produccion == cost['produccion_id']){
                    html += `<tr>
                                <td>${i}</td>
                                <td>${cost['costodesc_descripcion']}</td>
                                <td>${cost['controli_id']}</td>
                                <td>${cost['costoop_costo']}</td>
                                <td>${ cost['costoop_fecha'] }</td>
                            </tr>`;
                    i++;
                }
            });
        });
    }else{
        let controlador = `${base_url}costo_operativo/get_costos`;
        $.ajax({
            url: controlador,
            type: 'POST',
            cache: false,
            data: {detproduccion_id:detproduccion_id},
            success: (result)=>{
                let costos = JSON.parse(result);
                let html = ``;
                let i = 1;
                costos.forEach(cost => {
                    html += `<tr>
                                <td>${i}</td>
                                <td>${cost['costodesc_descripcion']}</td>
                                <td>${cost['controli_id']}</td>
                                <td>${cost['costoop_costo']}</td>
                                <td>${ cost['costoop_fecha'] }</td>
                            </tr>`;
                    i++;
                });
                $(`#tabla_costo${detproduccion_id}`).html(html);
            },error: ()=>{
                alert('error algo salio mal en la consulta para obtener los costos')
            }
        });
    }
    if (id === ``) {
        return html;
    }
}

function actulizar_informacion(detproduccion_id){
    let controlador = `${base_url}detalle_produccion/update_detproduccion`;
    let perdida = document.getElementById(`perdida${detproduccion_id}`).value;
    let observacion = $(`#observacion_${detproduccion_id}`).val();
    $.ajax({
        url: controlador,
        type: 'POST',
        cache: false,
        data: {
            detproduccion_id:detproduccion_id,
            perdida: perdida,
            observacion:observacion,
        },
        success:()=>{
            alert("Se guardo correctamente");
        },
        error:()=>{
            alert("Algo salio mal...!!!");
        }
    });
}

function cambiar_estado_platabanda(controli_id, estado_id){
    if(estado_id == '38'){
        estado_id = 36;
    }else{
        if(estado_id != '37'){
            estado_id = 38;
        }else{
            alert("No puede cambiar de estado porque la platabanda contiene productos en desarrollo")
        }
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

function form_costo(detproduccion_id, platabanda){
    let form = document.getElementById(`formulario-costo-${detproduccion_id}`);
    show_close_form(detproduccion_id);

    let controlador = `${base_url}costo_descripcion/get_costo_descripcion`
    $.ajax({
        url: controlador,
        type: "POST",
        data:{},
        success:(result)=>{
            let ress = JSON.parse(result);
            html = `<div class="col-md-12 mb-2" style="margin-bottom: 15px">
                        <div class="form-inline">
                            <label for="planta_nombre">Agregar costo operativo: </label>
                        </div>
                        <div class="form-inline">
                            <div class="form-group mb-2">
                                <label for="costo${detproduccion_id}"><span style="color: red;">*</span>Costo</label>
                                <input type="number" min="0" class="form-control" id="costo${detproduccion_id}" name="costo${detproduccion_id}" value="" style=" cursor: pointer" placeholder="Costo" autocomplete="off" required>
                            </div>
                            <div class="form-group mb-2">
                                <label for="cantidad">Perdida</label>
                                <select class="form-control" id="detcosto${detproduccion_id}">`;
            ress.forEach(r => {
                html +=             `<option value="${r['costodesc_id']}">${r['costodesc_descripcion']}</option>`;
            });
            html +=             `</select>
                            </div>
                            <div class="form-group" mb-2 ml-2>
                                <button class="btn btn-sm btn-success" title="Guardar" onclick="add_form(${detproduccion_id},${platabanda})"><i class="fa fa-floppy-o" aria-hidden="true"></i></button>
                                <button class="btn btn-sm btn-danger" title="Cancelar" onclick="show_close_form(${detproduccion_id})"><i class="fa fa-times" aria-hidden="true"></i></button>
                            </div>
                        </div>
                    </div>`;
            form.innerHTML = html;
        },
        error:()=>{
            alert("algo salio mal")
        }
    });
    
}

function show_close_form(detproduccion_id) {
    let form = document.getElementById(`formulario-costo-${detproduccion_id}`);
    if (form.style.display == "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

function add_form(detproduccion_id,platabanda){
    let controlador = `${base_url}costo_operativo/save_costo`
    let costo = document.getElementById(`costo${detproduccion_id}`).value;
    let detcosto = document.getElementById(`detcosto${detproduccion_id}`).value;
    if(costo != ""){
        $.ajax({
            url: controlador,
            type: "POST",
            data: {
                    detproduccion_id:detproduccion_id,
                    costo:costo,
                    platabanda:platabanda,
                    detcosto:detcosto,
            },
            success:()=>{
                alert("Se guardo correctamente");
                show_close_form(detproduccion_id);
                get_tabla_costo(detproduccion_id);
            },
            errocr:()=>{
                alert("Ha ocurrido un error al guardar el costo");
            }
        });
    }else{
        document.getElementById(`costo${detproduccion_id}`).style.border = "1px solid red";
    }
}

function calcular(detproduccion_id){
    let cantidad = document.getElementById(`cantidad${detproduccion_id}`).value;
    let perdida = document.getElementById(`perdida${detproduccion_id}`).value;

    $(`#cantidad${detproduccion_id}`).val(cantidad-perdida);
}

function send_inventario(detproduccion_id,producto_id){
    let controlador = `${base_url}detalle_produccion/incrementar_inventario`
    let cantidad = $(`#cantidad${detproduccion_id}`).val();
    $.ajax({
        url: controlador,
        type: 'POST',
        cache: false,
        data: {
            detproduccion_id:detproduccion_id,
            cantidad:cantidad,
            producto_id:producto_id,
        },
        success:()=>{
            alert("Se mando a inventario");
            $("#modal_info_platabanda").modal('hide');
            get_platabandas();
        },
        error:()=>{
            alert("Algo salio mal al mandar a inventario...")
        }
    });
}