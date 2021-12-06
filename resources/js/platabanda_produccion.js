var base_url;
$(window).load(function(){ 
    base_url = document.getElementById("base_url").value;
    let produccion_id = document.getElementById("produccion").value;
    get_platabandas(produccion_id);
})
// const base_url = url;
function get_platabandas(produccion_id){
    var controlador = `${base_url}control_inventario/get_platabanda_produccion`;
    $.ajax({
        url: controlador,
        type: "POST",
        data:{produccion_id:produccion_id},
        success:(respuesta)=>{
            var resp = JSON.parse(respuesta);
            let color, boton, info;
            let html = ``;
            resp['respuesta'].forEach(e => {
                color = "";
                boton = "";
                info = "";
                
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
                            let suma = parseInt(p['cant_perdida']) + parseInt(p['cant_compra']);
                            if (e['controli_id'] == p['controli_id']) {
                                if (p['estado_id'] != '39'){
                                    info += `<a onclick="show_modal_info(${e['controli_id']},${produccion_id})" title="Mostar información" style="cursor:pointer; text-decoration: none; color: black;">
                                                <div class="col-md-10 bg-success" style="border-radius: 10px; color:black; margin: 1px; background:#${p['estado_color']}; ${ false ? `border: red 3px solid;`: ``}">
                                                    <img src="${base_url}resources/images/productos/${p['producto_foto']}" width="25px" heigth="25px" class="img-circle img-responsive" style="display: inline-block" alt="${p['producto_nombre']}">
                                                    <span style="font-size: 7pt;"><b>  ${p['producto_nombre']}</b></span>
                                                    <span style="font-size: 7pt;"><b> (${(parseInt(p['detproduccion_cantidad'])-suma)}/${p['detproduccion_cantidad']})</b></span>
                                                    <div class="progress" style="height: 4px;border-radius: 10px; color:black; margin: 1px; background: #766;">
                                                        <div class="progress-bar" role="progressbar" aria-valuenow="${p['detproduccion_cantidad']}" aria-valuemin="0" aria-valuemax="${p['detproduccion_cantidad']}" style="width: ${100-(((suma)*100)/p['detproduccion_cantidad'])}%">
                                                        </div>
                                                    </div>
                                                </div>
                                            </a>
                                            `;
                                    cambiar = false;
                                }else{
                                    platabanda = e['controli_id'];
                                }
                            }
                            
                        });
                        if(cambiar) {
                            cambiar_estado_platabanda(platabanda, 38, produccion_id);
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
            });
            
            $("#platabandas_produccion").html(html);
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

function show_modal_info(platabanda_id,produccion_id = 0){
    let controlador = `${base_url}control_inventario/get_items_platabanda`;
    $("#modal_info_platabanda").modal('show');
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data:{
            platabanda_id:platabanda_id,
            produccion_id:produccion_id
        },
        success:(resultado)=>{
            result = JSON.parse(resultado);
            let res = result['plantas'];
            let costos = result['costos'];
            let perdidas = result['perdidas'];
            let html = ``;
            res.forEach(item => {
                if(item['estado_id'] != 39){
                    html += `<div class="row">
                                <article class="col-md-7">
                                    <div class="col-md-7">
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
                                                <input type="number" min="0" class="form-control" id="cantidad${item['detproduccion_id']}" name="cantidad${item['detproduccion_id']}" value="${item['detproduccion_cantidad'] - item['detproduccion_perdida']}" style="border: 0; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off" disabled>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="laperdida${item['detproduccion_id']}" title='Perdida total de plantas'>Perdida</label>
                                                <input type="number" min="0" class="form-control" id="laperdida${item['detproduccion_id']}" name="laperdida${item['detproduccion_id']}" style="border: 0; cursor: pointer; background-color: #fff" autocomplete="off" value="${item['cant_perdida']}" readonly>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="lasalida${item['detproduccion_id']}" title='Salida(Venta) de plantas'>Salida</label>
                                                <input type="number" min="0" class="form-control" id="lasalida${item['detproduccion_id']}" name="lasalida${item['detproduccion_id']}" style="border: 0; cursor: pointer; background-color: #fff" autocomplete="off" value="${item['cant_compra']}" readonly>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="elsaldo${item['detproduccion_id']}" title='Saldo de plantas en esta platabanda'>Saldo</label>
                                                <input type="number" min="0" class="form-control" id="elsaldo${item['detproduccion_id']}" name="elsaldo${item['detproduccion_id']}" style="border: 0; cursor: pointer; background-color: #fff" autocomplete="off" value="${(item['detproduccion_cantidad'] - item['cant_compra'] - item['cant_perdida'])}" readonly>
                                            </div>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group mb-2">
                                                <b>Etapa</b>
                                                <span id="etapa${item['detproduccion_id']}" style="border: 0; background-color: #${item['estado_color']}; padding: 3px; border-radius: 6px">${item['estado_descripcion']}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-5">
                                        <figure>
                                            <img class="img-rounded" src="${base_url}resources/images/productos/${item['producto_foto']}" width="100%" alt="${item['producto_nombre']}" title="${item['producto_nombre']}">
                                        </figure>
                                    </div>
                                    <div class="col-md-12">
                                        <div class="form-inline">
                                            <div class="form-group mb-2">
                                                <label for="perdida${item['detproduccion_id']}">Reg. Perdida</label>
                                                <input type="number" min="0" max="${item['detproduccion_cantidad'] - item['detproduccion_perdida']}" class="form-control" id="perdida${item['detproduccion_id']}" name="perdida${item['detproduccion_id']}" value="0" style="border: 1; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off" onchange="calcular(${item['detproduccion_id']})">
                                            </div>
                                        </div>
                                        <div class="form-group mb-2">
                                            <label for="perdida_observacion${item['detproduccion_id']}">Observación</label>
                                            <input type="text" min="0" max="255" class="form-control" id="perdida_observacion${item['detproduccion_id']}" name="perdida_observacion${item['detproduccion_id']}" style="border: 1; cursor: pointer" autocomplete="off">
                                        </div>
                                        <div class="form-group mb-12">
                                            <button class="btn btn-success btn-xs" onclick="actualizar_informacion(${item['detproduccion_id']})" title="Guardar información" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</button>
                                            <button class="btn btn-primary btn-xs" onclick="form_costo(${item['detproduccion_id']},${platabanda_id})" title="Agregar costo operativo" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-plus-square-o" aria-hidden="true"></i> Costo</button>
                                            <button class="btn btn-info btn-xs" onclick="volver_estado(${item['detproduccion_id']})"  title="Volver al estado anterior" ${ item['estado_id'] == '33' ? `disabled`:`` }><i class="fa fa-arrow-left" aria-hidden="true"></i> Estado anterior</button>
                                            <button class="btn btn-${item['estado_id'] != 35 ? `info`: `success`} btn-xs" ${ item['estado_id'] != 35 ? `onclick="pasar_etapa(${item['detproduccion_id']},${item['estado_id']},${item['produccion_id']})"`: `onclick="send_inventario(${item['detproduccion_id']},${item['producto_id']})"` }  title="${ item['estado_id'] != 35 ? `Pasar al siguiente estado` : `Mandar a ventas` }" ${ item['estado_id'] == '39' ? `disabled`:`` } ${ item['estado_id'] == 35 ? `style="display: none"`:``}>${ item['estado_id'] != 35 ? `<i class="fa fa-arrow-right" aria-hidden="true"></i> Siguiente estado` : `<i class="fa fa-shopping-cart" aria-hidden="true"></i> Enviar a Ventas`}</button>
                                            <button class="btn btn-danger btn-xs" onclick="cerrar_modal(${item['detproduccion_id']})" title="Cerrar" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-times-circle" aria-hidden="true"></i> Cerrar</button>
                                            ${ item['estado_id'] > 33 ? `<button class="btn btn-success btn-xs" onclick="vender_item(${item['detproduccion_id']},${item['controli_id']})" title="Cerrar"><i class="fa fa-shopping-cart" aria-hidden="true"></i> Vender</button>`:``}
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="formulario-costo-${item['detproduccion_id']}" style="display:none;"></div>
                                </article>
                                <article class="col-md-5">
                                    <table class="table table-striped table-condensed" style="font-size: 8pt;" id="mitabla">
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
                                <article class="col-md-5">
                                    <table class="table table-striped" style="font-size: 8pt;" id='mitabla'>
                                        <thead class="thead-light">
                                            <tr>
                                                <th style='padding: 2px'>#</th>
                                                <th style='padding: 2px'>Fecha</th>
                                                <th style='padding: 2px'>Perdida</th>
                                                <th style='padding: 2px's>Observación</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabla_perdida${ item['detproduccion_id'] }" style="font-size:8pt;">`
                    html += get_tabla_perdida(item['detproduccion_id'], perdidas);
                    html +=`            </tbody>
                                    </table>
                                </article>
                            </div>`;
                }
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
    var total = 0.00;
    let fecha;
    if (costos != "") {
        costos.forEach(costo => {
            costo.forEach(cost => {
                if(produccion == cost['produccion_id']){
                    fecha = cost['costoop_fecha'].split(" ")[0].split("-").reverse().join("-");
                    html += `<tr>
                                <td style="padding: 0; text-align: right">${i}</td>
                                <td style="padding: 0;">${cost['costodesc_descripcion']}</td>
                                <td style="padding: 0; text-align: center;">${cost['controli_id']}</td>
                                <td style="padding: 0; text-align: right;">${cost['costoop_costo']}</td>
                                <td style="padding: 0; text-align: center">${fecha}</td>
                            </tr>`;
                    i++;
                    total += Number(cost['costoop_costo']);
                }
            });
        });
        html += `<tr>
                    <th colspan="3" style="padding: 0; text-align: right;"><b>Total</b></th>
                    <th style="padding: 0; text-align: right;"><b>${parseFloat(total).toFixed(2)}</b></th>
                    <th style="padding: 0;"></th>
                </tr>`
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
                    fecha = cost['costoop_fecha'].split(" ")[0].split("-").reverse().join("-");
                    html += `<tr>
                                <td style="padding: 0;">${i}</td>
                                <td style="padding: 0;">${cost['costodesc_descripcion']}</td>
                                <td style="padding: 0;">${cost['controli_id']}</td>
                                <td style="padding: 0;">${cost['costoop_costo']}</td>
                                <td style="padding: 0;">${fecha}</td>
                            </tr>`;
                    total += Number(cost['costoop_costo']);
                    i++;
                });
                html += `<r>
                            <th colspan="3" style="padding: 0;text-align: right;"><b>Total</b></th>
                            <th xolspan="2" style="padding: 0;text-align: right;">${parseFloat(total).toFixed(2)}</th>
                            <th style="padding: 0;"></th>
                        </tr>`;
                $(`#tabla_costo${detproduccion_id}`).html('');
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

function actualizar_informacion(detproduccion_id){
    let controlador = `${base_url}detalle_produccion/update_detproduccion`;
    let perdida = document.getElementById(`perdida${detproduccion_id}`).value;
    let perdida_observacion = document.getElementById(`perdida_observacion${detproduccion_id}`).value;
    let observacion = $(`#observacion_${detproduccion_id}`).val();
    $.ajax({
        url: controlador,
        type: 'POST',
        cache: false,
        data: {
            detproduccion_id:detproduccion_id,
            perdida: perdida,
            perdida_observacion: perdida_observacion,
            observacion:observacion,
        },
        success:()=>{
            alert("Se guardo correctamente");
            get_tabla_perdida(detproduccion_id);
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

function pasar_etapa(detproduccion_id, estado_id, produccion_id){
    let controlador = `${base_url}detalle_produccion/pasar_siguiente_estado`
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data:{detproduccion_id:detproduccion_id, estado_id:estado_id},
        success:()=>{
            $("#modal_info_platabanda").modal('hide');
            get_platabandas(produccion_id);
        },
        error:()=>{
            alert("Ocurrio un error al cambiar de estado")
        }
    });
}

function volver_estado(detproduccion_id){
    let controlador = `${base_url}detalle_produccion/volver_estado_platabanda`;
    $.ajax({
        url: controlador,
        type: 'POST',
        cache: false,
        data: {
            detproduccion_id:detproduccion_id,
        },
        success:(respuesta)=>{
            let produccion = JSON.parse(respuesta);
            $("#modal_info_platabanda").modal('hide');
            get_platabandas(produccion);
        },
        error:()=>{
            alert("Error")
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
                            <div class="form-group mb-1">
                                <input type="number" min="0" class="form-control" id="costo${detproduccion_id}" name="costo${detproduccion_id}" value="" style=" cursor: pointer" placeholder="Costo" autocomplete="off" style="width:10vw !important;" required>
                            </div>
                            <div class="form-group mb-1">
                                <label for="cantidad"></label>
                                <select class="form-control" id="detcosto${detproduccion_id}">`;
            ress.forEach(r => {
                html +=             `<option value="${r['costodesc_id']}">${r['costodesc_descripcion']}</option>`;
            });
            html +=             `</select>
                            </div>
                            <div class="form-group mb-1">
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
    let mensaje = `Esta seguro que quiere enviar a ventas`
    if(confirm(mensaje)){
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
                alert("Se envio a inventario");
                $("#modal_info_platabanda").modal('hide');
                get_platabandas();
            },
            error:()=>{
                alert("Algo salio mal al mandar a inventario...")
            }
        });
    }
}

function cerrar_modal(){
    $('#modal_info_platabanda').modal('hide');
}

function vender_item(detproduccion_id, platabanda){
    cerrar_modal();
    $('#modal_form_venta').modal('show');
    $('#platabanda').val(platabanda);
    $('#det_produccion').val(detproduccion_id);
    let controlador = `${base_url}detalle_produccion/get_detproduccion_venta`
    $.ajax({
        url: controlador,
        type: 'POST',
        cache: false,
        data:{
            detproduccion_id:detproduccion_id,
            platabanda:platabanda,
        },
        success:(result) => {
            let ress = JSON.parse(result);
            $('#form_producto').val(ress[0]['producto_nombre']);
            $('#form_producto_id').val(ress[0]['producto_id']);
            document.getElementById('form_cantidad').setAttribute("max", ress[0]['detproduccion_cantidad']);
        },
        error:(error) => {
            alert('algo salio mal al obtener los datos');
        }

    })
}

function save_compra(){
    let controlador = `${base_url}compra/add_planta`;
    let form_producto_id = document.getElementById("form_producto_id").value;
    let form_cantidad = document.getElementById("form_cantidad").value;
    let platabanda = document.getElementById("platabanda").value;
    let det_produccion = document.getElementById("det_produccion").value;
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data:{
            form_producto_id:form_producto_id,
            form_cantidad:form_cantidad,
            platabanda:platabanda,
            det_produccion:det_produccion,
        },
        success:()=>{
            window.location =`${base_url}venta/ventas`;
        },
        error:()=>{
            alert("error")
        }
    })
}

/* obtiene las perdidas de una platabanda */
function get_tabla_perdida(detproduccion_id, perdidas="", id = ``){
    let totalperdida = Number(0);
    let html = ``;
    let i = 1;
    if (perdidas != "") {
        perdidas.forEach(perdida => {
            perdida.forEach(perd => {
                if(detproduccion_id == perd['detproduccion_id']){
                    totalperdida += Number(perd['perdida_cantidad']);
                    html += `<tr>
                                <td style='padding: 2px' class='text-center'>${i}</td>
                                <td style='padding: 2px' class='text-center'>${moment(perd["perdida_fecha"]).format("DD/MM/YYYY")}</td>
                                <td style='padding: 2px' class='text-right'>${perd['perdida_cantidad']}</td>
                                <td style='padding: 2px'>${perd['perdida_observacion']}</td>
                            </tr>`;
                    i++;
                }
            });
        });
        html += `<tr>
                    <th style='padding: 2px; font-size: 12px; text-align: right;' class='text-bold' colspan='2'>Total:</th>
                    <th style='padding: 2px; font-size: 12px; text-align: right;' class='text-bold'>${numberFormat(Number(totalperdida).toFixed(0))}</th>
                    <th></th>
                </tr>`;
    }else{
        let controlador = `${base_url}perdida/get_perdidas`;
        let totalperdida = Number(0);
        $.ajax({
            url: controlador,
            type: 'POST',
            cache: false,
            data: {detproduccion_id:detproduccion_id},
            success: (result)=>{
                let perdidas = JSON.parse(result);
                let html = ``;
                let i = 1;
                perdidas.forEach(perd => {
                    totalperdida += Number(perd['perdida_cantidad']);
                    html += `<tr>
                                <td style='padding: 2px' class='text-center'>${i}</td>
                                <td style='padding: 2px' class='text-center'>${moment(perd["perdida_fecha"]).format("DD/MM/YYYY")}</td>
                                <td style='padding: 2px' class='text-right'>${perd['perdida_cantidad']}</td>
                                <td style='padding: 2px'>${perd['perdida_observacion']}</td>
                            </tr>`;
                    i++;
                });
                html += `<tr>
                            <th style='padding: 2px; font-size: 12px' class='text-right text-bold' colspan='2'>Total:</th>
                            <th style='padding: 2px; font-size: 12px' class='text-right text-bold'>${numberFormat(Number(totalperdida).toFixed(0))}</th>
                            <th></th>
                        </tr>`;
                $(`#tabla_perdida${detproduccion_id}`).html('');
                $(`#tabla_perdida${detproduccion_id}`).html(html);
            },error: ()=>{
                alert('error algo salio mal en la consulta para obtener las perdidas')
            }
        });
    }
    if (id === ``) {
        return html;
    }
}
function numberFormat(numero){
    // Variable que contendra el resultado final
    var resultado = "";

    // Si el numero empieza por el valor "-" (numero negativo)
    if(numero[0]=="-")
    {
        // Cogemos el numero eliminando los posibles puntos que tenga, y sin
        // el signo negativo
        nuevoNumero=numero.replace(/\,/g,'').substring(1);
    }else{
        // Cogemos el numero eliminando los posibles puntos que tenga
        nuevoNumero=numero.replace(/\,/g,'');
    }

    // Si tiene decimales, se los quitamos al numero
    if(numero.indexOf(".")>=0)
        nuevoNumero=nuevoNumero.substring(0,nuevoNumero.indexOf("."));

    // Ponemos un punto cada 3 caracteres
    for (var j, i = nuevoNumero.length - 1, j = 0; i >= 0; i--, j++)
        resultado = nuevoNumero.charAt(i) + ((j > 0) && (j % 3 == 0)? ",": "") + resultado;

    // Si tiene decimales, se lo añadimos al numero una vez forateado con 
    // los separadores de miles
    if(numero.indexOf(".")>=0)
        resultado+=numero.substring(numero.indexOf("."));

    if(numero[0]=="-")
    {
        // Devolvemos el valor añadiendo al inicio el signo negativo
        return "-"+resultado;
    }else{
        return resultado;
    }
}