var base_url;
var costo_total_op;
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
        cache: false,
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
                            let fecha_registro = p['produccion_inicio'];
                            let pfecha1 = p['aproducto_dias'];
                            let pfecha2 = p['aproducto_dias2'];
                            let dias;
                            let aviso = false;
                            console.log(p['estado_id']);
                            if (p['estado_id'] == '33') {
                                dias = parseInt(pfecha1);
                                console.log(dias);
                            } else if(p['estado_id'] == '34') {
                                dias =  parseInt(pfecha1) + parseInt(pfecha2);
                                console.log(dias);
                            }
                            let fecha_aviso = (moment(fecha_registro).add(dias, 'days')).toJSON().slice(0,10).replace(/-/g,'/');
                            var hoy = new Date().toJSON().slice(0,10).replace(/-/g,'/');
                            console.log(fecha_registro)
                            console.log(hoy)
                            console.log(fecha_aviso);
                            aviso = (hoy >= fecha_aviso ? true : false);
                            // let fecha_aviso = fecha_registro.setDate(fecha_registro.getDate() + dias);
                            let suma = parseInt(p['cant_perdida']) + parseInt(p['cant_compra']);
                            if (e['controli_id'] == p['controli_id']) {
                                if (p['estado_id'] != '39'){
                                    info += `<a onclick="show_modal_info(${e['controli_id']},${produccion_id})" title="Mostar información" style="cursor:pointer; text-decoration: none; color: black;">
                                                <div class="col-md-10 bg-success" style="border-radius: 10px; color:black; margin: 1px; background:#${p['estado_color']}; ${ aviso ? `border: red 3px solid;`: ``}">
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
                                    <span style="font-size: 8pt;"><b>${e['area_nombre']}</b>: <b>Platabanda: </b>${e['controli_id']}<a style="float:right; cursor:pointer; color:${e['estado_id'] == 38 ? "":"#00019E"}" onclick="cambiar_estado_platabanda(${e['controli_id']},${e['estado_id']})"><i class="fa fa-toggle-${estado}" aria-hidden="true"></i></a></span><br>
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
            let ancho_boton = 65;
            let alto_boton = 60;
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
                                            <label for="planta_nombre">Inicio de producción: </label>
                                            <span id="fecha${item['detproduccion_id']}">${moment(item["produccion_registro"]).format("DD/MM/YYYY")}</span>
                                        </div>
                                        <div class="form-inline">
                                            <div class="form-group mb-2">
                                                <label for="cantidad${item['detproduccion_id']}">Cantidad</label>
                                                <input type="number" min="0" class="form-control" id="cantidad${item['detproduccion_id']}" name="cantidad${item['detproduccion_id']}" value="${item['detproduccion_cantidad']}" style="border: 0; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off" disabled>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="laperdida${item['detproduccion_id']}" title='Perdida total de plantas'>Perdida</label>
                                                <input type="number" min="0" class="form-control" id="laperdida${item['detproduccion_id']}" name="laperdida${item['detproduccion_id']}" style="border: 0; cursor: pointer; background-color: #fff" autocomplete="off" value="${item['cant_perdida']}" readonly>
                                            </div>
                                            <div class="form-group mb-2">
                                                <label for="lasalida${item['detproduccion_id']}" title='Salida(Venta) de plantas'>Ventas</label>
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
                                        
                                        <div class="form-group mb-12 text-center" style="padding-top:10px;">
                                            <a style="widht:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" class="btn btn-success btn-sq-lg" onclick="form_perdida(${item['detproduccion_id']},${platabanda_id})" title="Guardar información" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-long-arrow-down fa-2x" aria-hidden="true"></i> <br> Perdida</a>
                                            <a style="width:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" class="btn btn-primary btn-sq-lg" onclick="form_costo(${item['detproduccion_id']},${platabanda_id})" title="Agregar costo operativo" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-usd fa-2x" aria-hidden="true"></i> <br> Costo</a>
                                            <a style="width:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" class="btn btn-info btn-sq-lg" onclick="volver_estado(${item['detproduccion_id']})"  title="Volver al estado anterior" ${ item['estado_id'] == '33' ? `disabled`:`` }><i class="fa fa-arrow-left fa-2x" aria-hidden="true"></i> <br> Anterior</a>
                                            <a style="width:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" class="btn btn-${item['estado_id'] != 35 ? `info`: `success`} btn-sq-lg" ${ item['estado_id'] != 35 ? `onclick="pasar_etapa(${item['detproduccion_id']},${item['estado_id']},${item['produccion_id']})"`: `onclick="send_inventario(${item['detproduccion_id']},${item['producto_id']})"` }  title="${ item['estado_id'] != 35 ? `Pasar al siguiente estado` : `Mandar a ventas` }" ${ item['estado_id'] == '39' ? `disabled`:`` } ${ item['estado_id'] == 35 ? `style="display: none"`:``}>${ item['estado_id'] != 35 ? `<i class="fa fa-arrow-right fa-2x" aria-hidden="true"></i> <br> Siguiente` : `<i class="fa fa-shopping-cart" aria-hidden="true"></i> <br> Enviar a Ventas`}</a>
                                            ${ item['estado_id'] > 33 ? `<a class="btn btn-success btn-sq-lg" style="width:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" onclick="vender_item(${item['detproduccion_id']},${item['controli_id']})" title="Cerrar"><i class="fa fa-shopping-cart fa-2x" aria-hidden="true"></i> <br> Vender</a>`:``}
                                            <a style="width:${ancho_boton}px !important; height:${alto_boton}px !important; font-size:11px;" class="btn btn-danger btn-sq-lg" onclick="cerrar_modal(${item['detproduccion_id']})" title="Cerrar" ${ item['estado_id'] == '39' ? `disabled`:`` }><i class="fa fa-times-circle fa-2x" aria-hidden="true"></i><br> Cerrar</a>
                                        </div>
                                    </div>
                                    <div class="col-md-12" id="formulario-costo-${item['detproduccion_id']}" style="display:none;"></div>
                                    <div class="col-md-12" id="formulario-perdida-${item['detproduccion_id']}" style="display:none;"></div>
                                </article>
                                <article class="col-md-5">
                                    <span class='text-bold'>Costos iniciales:</span>
                                    <table class="table table-striped table-condensed" style="font-size: 8pt;" id="mitabla">
                                        <thead class="thead-light">
                                                <tr>
                                                    <th style="padding: 0;">Costo Ini.(Bs)</th>
                                                    <th style="padding: 0;">Costo Op.(Bs)</th>
                                                    <th style="padding: 0;">Costo total(Bs)</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>`
                    html += get_costos_produccion(item['producto_costo'], item['detproduccion_cantidad'], costos,item['produccion_id'],item['detproduccion_id']);
                    html +=                     `</tr>
                                            </tbody>
                                    </table>
                                    <span class='text-bold'>Costos:</span>
                                    <table class="table table-striped table-condensed" style="font-size: 8pt;" id="mitabla">
                                        <thead class="thead-light">
                                            <tr>
                                                <th style="padding: 0">#</th>
                                                <th style="padding: 0">Detalle</th>
                                                <!--<th style="padding: 0"># Pb.</th>-->
                                                <th style="padding: 0">Costo</th>
                                                <th style="padding: 0">Fecha</th>
                                            </tr>
                                        </thead>
                                        <tbody id="tabla_costo${ item['detproduccion_id'] }" style="font-size:8pt;">`
                    html += get_tabla_costo(item['detproduccion_id'],costos,item['produccion_id']);
                    html +=`            </tbody>
                                    </table>
                                </article>
                                <article class="col-md-5">
                                    <span class='text-bold'>Perdidas:</span>
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
                                <td style="padding: 0;">${cost['costoop_descripcion']}</td>
                                <!--<td style="padding: 0; text-align: center;">${cost['controli_id']}</td>-->
                                <td style="padding: 0; text-align: right;">${cost['costoop_costo']}</td>
                                <td style="padding: 0; text-align: center">${moment(cost["costoop_fecha"]).format("DD/MM/YYYY")}</td>
                            </tr>`;
                    i++;
                    total += Number(cost['costoop_costo']);
                }
            });
        });
        html += `<tr>
                    <th colspan="2" style="padding: 0; text-align: right;"><b>Total</b></th>
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
                                <td style="padding: 0;">${moment(cost["costoop_fecha"]).format("DD/MM/YYYY")}</td>
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
    let saldo = $(`#elsaldo${detproduccion_id}`).val();
    let perdida = document.getElementById(`perdida${detproduccion_id}`).value;
    let perdida_observacion = document.getElementById(`perdida_razon${detproduccion_id}`).value;
    let observacion = $(`#perdida_razon${detproduccion_id}`).val();
    if(perdida >= 0 && perdida != "" && perdida <= saldo){
        if (observacion != "") {
            console.log(perdida)
            console.log(observacion)
            let msj = `Esta realizando una perdida de ${perdida}, ¿Quiere continuar con la perdida?`;
            if (confirm(msj)) {
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
                        calcular(detproduccion_id,perdida,0);
                        show_close_form(`formulario-perdida-${detproduccion_id}`);
                    },
                    error:()=>{
                        alert("Algo salio mal...!!!");
                    }
                });
            }
        }else{
            alert(`- El campo motivo es obligatorio`);
            $(`#perdida_razon${detproduccion_id}`).focus();
        }
    }else{
        alert(`- El campo perdida es obligatorio  \n- La perdida no puede ser un número negativo\n- La perdida no puede sobrepasar el saldo de ${saldo}`);
        $(`#perdida${detproduccion_id}`).focus();
    }
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
    let id = `formulario-costo-${detproduccion_id}`;
    show_close_form(id);

    let controlador = `${base_url}costo_descripcion/get_costo_descripcion`
    $.ajax({
        url: controlador,
        type: "POST",
        data:{},
        success:(result)=>{
            let ress = JSON.parse(result);
            html = `<div class="col-md-12 mb-2" style="border: 2px solid #AEAEAE; border-radius: 15px;">
                        <div class="form-inline">
                            <label for="planta_nombre">Agregar costo operativo: </label>
                        </div>
                        <div class="form-group row">
                            <label class="col-md-2" for="costo${detproduccion_id}"><span style="color:red;">*</span>Costo Bs.</label>
                            <div class="col-md-4">
                                <input type="number" min="0" class="form-control" id="costo${detproduccion_id}" name="costo${detproduccion_id}" value="" style=" cursor: pointer" placeholder="Costo" autocomplete="off" style="width:10vw !important;" required>
                            </div>
                            <div class="col-md-6"></div>
                        </div>
                        <div class="form-group row">    
                            <label class="col-md-2" for="cantidad">Motivo</label>
                            <div class="col-md-5">
                                <select class="form-control" id="detcosto${detproduccion_id}">`;
            ress.forEach(r => {
                html +=             `<option value="${r['costodesc_id']}">${r['costodesc_descripcion']}</option>`;
            });
            html +=             `</select>
                            </div>
                            <div class="col-md-5">
                                
                            </div>
                        </div>
                        <div class="form-group row">
                            <div class="col-md-12 text-center">
                                <a class="btn btn-sm btn-success" title="Guardar" onclick="add_form(${detproduccion_id},${platabanda})"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
                                <a class="btn btn-sm btn-danger" title="Cancelar" onclick="show_close_form('${id}')"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>
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

function show_close_form(id) {
    let form = document.getElementById(id);
    if (form.style.display == "none") {
        form.style.display = "block";
    } else {
        form.style.display = "none";
    }
}

function add_form(detproduccion_id,platabanda){
    let controlador = `${base_url}costo_operativo/save_costo`
    let id = `formulario-costo-${detproduccion_id}`;
    let costo = document.getElementById(`costo${detproduccion_id}`).value;
    let detcosto = document.getElementById(`detcosto${detproduccion_id}`).value;
    let msj = `Esta agregando un costo operativo de Bs ${parseFloat(costo)},¿Desea continuar?`
    if(costo != "" && costo >= 0){
        if (confirm(msj)){
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
                    show_close_form(id);
                    get_tabla_costo(detproduccion_id);
                },
                errocr:()=>{
                    alert("Ha ocurrido un error al guardar el costo");
                }
            });
        }
    }else{
        alert(`- El campo costo es obligarotio \n- El costo no puede ser un número negativo`);
        document.getElementById(`costo${detproduccion_id}`).style.border = "1px solid red";
        $(`#costo${detproduccion_id}`).focus();
    }
}

function calcular(detproduccion_id, cant_perdida = 0, cant_compra = 0){
    let cantidad = document.getElementById(`cantidad${detproduccion_id}`).value;
    let perdida = document.getElementById(`laperdida${detproduccion_id}`).value;
    console.log(perdida)
    perdida  = parseInt(perdida) + parseInt(cant_perdida);
    let compra = document.getElementById(`lasalida${detproduccion_id}`).value;
    compra = parseInt(compra) + parseInt(cant_compra);
    console.log(compra)
    let aux = parseInt(perdida) + parseInt(compra); 
    let saldo = parseInt(cantidad) - parseInt(aux);
    
    $(`#laperdida${detproduccion_id}`).val(perdida);
    $(`#lasalida${detproduccion_id}`).val(compra);
    $(`#elsaldo${detproduccion_id}`).val(saldo);
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
    let costo_total = document.getElementById(`costo_total${detproduccion_id}`).value;
    console.log(detproduccion_id)
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

            let costo = getCosto();
            $(`#form_costo`).val(costo_total)
            $(`#form_precio`).val(ress[0]['producto_precio'])
            
            $(`#form_total`).val()

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

function form_perdida(detproduccion_id, platabanda){
    let form = document.getElementById(`formulario-perdida-${detproduccion_id}`);
    let id = `formulario-perdida-${detproduccion_id}`
    show_close_form(id);

    let html = `<div class="col-md-12 mb-2" style="border-radius: 15px;border: 2px solid #AEAEAE; ">
                    <div class="form-inline">
                        <label for="planta_nombre">Registrar perdida</label>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-2" for="perdida${detproduccion_id}"><span style="color: red;">*</span>Perdida</label>   
                        <div class="col-sm-6">
                            <input type="number" min="1" max="" class="form-control" id="perdida${detproduccion_id}" name="perdida${detproduccion_id}" value="" style="border: 1; cursor: pointer" placeholder="Cantidad de plantas" autocomplete="off">
                        </div>
                        <div class="col-sm-6"></div>
                    </div>
                    <div class="form-group row">
                        <label for="perdida_razon${detproduccion_id}" class="col-sm-2 col-form-label"><span style="color: red;">*</span>Motivo</label>
                        <div class="col-sm-10">
                            <input type="text" class="form-control" id="perdida_razon${detproduccion_id}" name="perdida_razon${detproduccion_id}" placeholder="Motivo de la perdida">
                        </div>
                    </div>
                    <div class="form-group row">
                        <div class="col-md-12 text-center">
                            <a class="btn btn-sm btn-success" title="Guardar" onclick="actualizar_informacion(${detproduccion_id})"><i class="fa fa-floppy-o" aria-hidden="true"></i> Guardar</a>
                            <a class="btn btn-sm btn-danger" title="Cancelar" onclick="show_close_form('${id}')"><i class="fa fa-times" aria-hidden="true"></i> Cancelar</a>
                        </div>
                    </div>
                </div>`;
    form.innerHTML = html;    
    $(`#perdida${detproduccion_id}`).focus();
}

function get_costos_produccion(costo_inicial, cantidad, costos,produccion,detproduccion_id,bandera = 0){
    let total = 0;
    costos.forEach(costo => {
        costo.forEach(cost => {
            if(produccion == cost['produccion_id']){
                total += Number(cost['costoop_costo']);
            }
        });
    });
    let costo_operativo = parseFloat(total)/parseFloat(cantidad);
    let costo_total = parseFloat(costo_inicial)+parseFloat(costo_operativo)
    let html = `
        <td style="padding:0; text-align:center"><span id="costo_inicial${detproduccion_id}">${parseFloat(costo_inicial).toFixed(2)}</span></td>
        <td style="padding:0; text-align:center"><span id="costo_operativo${detproduccion_id}">${parseFloat(costo_operativo).toFixed(2)}</span></td>
        <td style="padding:0; text-align:center"><span id="costo_total${detproduccion_id}">${parseFloat(costo_total).toFixed(2)}</span></td>
    `;
    if(bandera == 0){
        return html;
    }else{
        setCosto(costo_total);
    }
}

function setCosto(costo){
    costo_total_op = costo;
}

function getCosto(){
    return costo_total_op;
}