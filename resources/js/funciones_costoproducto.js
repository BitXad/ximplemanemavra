const base_url = document.getElementById("base_url").value;
const modal_info = "costo_producto_modal";
const modal_add = "form_costo_producto_modal";
function mostrar_costos_producto(producto){
    let modal = "costo_producto_modal"; 
    let tabla = "costos_producto";
    let controlador = `${base_url}costo_producto/get_costos_producto`
    let html = ``;
    $("#producto_costo").val(producto);
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data: {
            producto:producto,
        },
        success:(result) => {
            let resultado = JSON.parse(result);
            let i = 1;
            let ress = resultado['result'];
            let categorias = resultado['categoria_costos'];
            
            let totalMaterial = 0.00;
            let totalManoObra = 0.00;
            let totalHerramientaEquipo = 0.00;
            let totalAdmin = 0.00;
            let total = 0.00;
            categorias.forEach(cat => {
                total = 0.00;
                html += `<tr>
                            <th style="padding: 0;" colspan="7">${cat['catcosto_descripcion']}</th>
                        </tr>`
                ress.forEach(costo => {
                    if(cat['catcosto_id'] == costo['catcosto_id']){
                        html += `<tr>
                                    <td style="text-align:center; padding: 0">${i}</td>
                                    <td style="padding: 0">${costo['cproducto_descripcion']}</td>
                                    <td style="text-align:center;padding: 0;">${costo['cproducto_unidad']}</td>
                                    <td style="text-align:center;padding: 0;">${costo['cproducto_cantidad']}</td>
                                    <td style="text-align:center;padding: 0;">${costo['cproducto_costo']}</td>
                                    <td style="text-align:center;padding: 0;">${costo['cproducto_costoparcial']}</td>
                                    <td style="padding: 0">
                                        <button class="btn btn-xs btn-info" onclick="form_costo_producto(${costo['cproducto_id']})" title="Editar"><i class="fa fa-pencil" aria-hidden="true"></i></button>
                                    </td>
                                </tr>`;
                        i++;
                        total = parseFloat(total) + parseFloat(costo['cproducto_costoparcial']);
                    }
                });
                
                
                switch (cat['catcosto_id']){
                    case '1':
                        html += `<tr>
                                    <th style="padding: 0; text-align:left;" colspan="5"><b>TOTAL MATERIALES</b></th>
                                    <th colspan="1" style="padding: 0; text-align:center">${parseFloat(total * parseFloat(cat['catcosto_porcentaje'])).toFixed(3)}</th>
                                    <th style="padding: 0" colspan="1"></th>
                                </tr>`
                        totalMaterial = total;
                        break;
                    case '2':
                        html += `<tr>
                                    <td style="padding: 0"></td>
                                    <td style="padding: 0">CARGAS SOCIALES</td>
                                    <td style="padding: 0" ></td>
                                    <td style="text-align:center; padding: 0;">${ parseFloat(100*cat['catcosto_porcentaje']).toFixed(3) }%</td>
                                    <td style="padding: 0" ></td>
                                    <td colspan="1" style="padding: 0;text-align:center">${parseFloat(total * parseFloat(cat['catcosto_porcentaje'])).toFixed(3)}</td>
                                    <td style="padding: 0" ></td>
                                </tr>`
                        html += `<tr>
                                    <th style="padding: 0; text-align:left;" colspan="5"><b>TOTAL MANO DE OBRA</b></th>
                                    <th colspan="1" style="padding: 0; text-align:center">${parseFloat(total + (total * parseFloat(cat['catcosto_porcentaje']))).toFixed(3)}</th>
                                    <th style="padding: 0" colspan="1"></th>
                                </tr>`
                        totalManoObra = parseFloat(total + (total * parseFloat(cat['catcosto_porcentaje']))).toFixed(3);
                        break;
                    case '3':
                        total = parseFloat(totalManoObra) * parseFloat(cat['catcosto_porcentaje']);
                        html += `<tr>
                                    <td style="padding: 0"></td>
                                    <td style="padding: 0">HERRAMIENTAS MENORES</td>
                                    <td style="padding: 0" ></td>
                                    <td style="text-align:center; padding: 0">${ parseFloat(100*cat['catcosto_porcentaje']).toFixed(3) }%</td>
                                    <td style="padding: 0" ></td>
                                    <td colspan="1" style="text-align:center; padding: 0">${parseFloat(total).toFixed(3)}</td>
                                    <td style="padding: 0" ></td>
                                </tr>`
                        html += `<tr>
                                    <th style="padding: 0; text-align:left;" colspan="5"><b>TOTAL HERRAMIENTAS Y EQUIPOS</b></th>
                                    <th colspan="1" style="padding: 0;text-align:center;">${parseFloat(total).toFixed(3)}</th>
                                    <th colspan="1" style="padding: 0"></th>
                                </tr>`
                        totalHerramientaEquipo = total;
                        break;
                    case '4':
                        total = parseFloat(totalMaterial) + parseFloat(totalManoObra) + parseFloat(totalHerramientaEquipo);
                        html += `<tr>
                                    <th style="padding: 0; text-align:left;" colspan="5"><b>SUB TOTAL</b></th>
                                    <th colspan="1" style="padding: 0; text-align:center">${parseFloat(total).toFixed(3)}</th>
                                    <th colspan="1" style="padding: 0"></th>
                                </tr>`
                        let sub_total = parseFloat(total * cat['catcosto_porcentaje']).toFixed(3);
                        html += `<tr>
                                    <td style="padding: 0;"></td>
                                    <td style="padding: 0;">GASTOS GENERALES Y ADMINISTRATIVO</td>
                                    <td style="padding: 0;" ></td>
                                    <td style="padding: 0; text-align:center">${ parseFloat(100*cat['catcosto_porcentaje']).toFixed(3) }%</td>
                                    <td style="padding: 0;" ></td>
                                    <td colspan="1" style="padding: 0; text-align:center">${sub_total}</td>
                                    <td style="padding: 0;" ></td>
                                </tr>`
                        totalAdmin = parseFloat(total)+parseFloat(sub_total);
                        html += `<tr>
                                    <th style="padding: 0; text-align:left;" colspan="5"><b>PARCIAL</b></th>
                                    <th colspan="1" style="padding: 0; text-align:center"><b>${parseFloat(totalAdmin).toFixed(3)}</b></th>
                                    <th colspan="1" style="padding: 0"></th>
                                </tr>`
                        break;
                    default:
                        alert("Algo salio mal");
                }
            });
            let total_producto = totalAdmin;
            html += `<tr>
                        <th style="padding: 0; font-size:14px; text-align:left;" colspan="5">TOTAL PRECIO UNITARIO:</th>
                        <th colspan="2" style="padding: 0;text-align:center;font-size:14px;font-weight:bold">${parseFloat(total_producto).toFixed(3)}</th>
                    </tr>`
            $(`#${tabla}`).html(html);
            document.getElementById('update_costo_producto').setAttribute('onclick',`update_costo_producto(${producto}, ${parseFloat(total_producto).toFixed(3)})`)
            // update_costo_producto(producto, parseFloat(total_producto).toFixed(3));
            modal_show_hidden(modal);
        },
        error:() => {
            aler("Ocurrio un error al obtener los costos de este producto");
        }
    });
}

function form_costo_producto(costop_id = 0){
    let producto_costo = $("#producto_costo").val();
    let controlador;
    controlador = `${base_url}categoria_costo/get_all_costos`;
    $.ajax({
        url: controlador,
        type: "POST",
        cache: false,
        data:{
            costop_id:costop_id,
        },
        success: (result)=>{
            ress = JSON.parse(result);
            limpiar_campos()
            $('#form_insumo').css('border','2px solid #d5d9e0');
            let html = ``;
            let html2 = ``;
            if(costop_id != 0){
                let item = ress['costo_producto'][0];
                html2 += `<option value="${item['catcosto_id']}">${item['catcosto_descripcion']}</option>`;
                $('#form_unidad').val(item['cproducto_unidad']);
                $('#form_insumo').val(item['cproducto_descripcion']);
                $('#form_producto').val(item['producto_id']);
                $('#form_cantidad').val(item['cproducto_cantidad']);
                $('#form_punitario').val(item['cproducto_costo']);
                $('#form_pparcial').val(item['cproducto_costoparcial']);

                document.getElementById('button_save_costo').setAttribute('onclick',`guardar_costo(${item['cproducto_id']})`);
            }else{
                document.getElementById('button_save_costo').setAttribute('onclick',`guardar_costo()`);
            }
            
            
            ress['unidades'].forEach(unidad => {
                html += `<option value="${unidad['unidad_id']}">${unidad['unidad_nombre']}</option>`
            });
            $("#form_unidad").html(html);
            
            ress['categorias'].forEach(categoria => {
                html2 += `<option value="${categoria['catcosto_id']}">${categoria['catcosto_descripcion']}</option>`;
            });
            if(costop_id == 0){
                $('#form_cantidad').val(0);
                $('#form_punitario').val(0);
                $('#form_pparcial').val(0);
            }
            $('#form_producto').val(producto_costo);    
            $("#form_catcosto").html(html2);
            modal_show_hidden(modal_info);
            modal_show_hidden(modal_add);
        },
        error:()=>{
            alert("Ocurrio un error al obtener las categorias");
        }
    });
}

function modal_show_hidden(modal){
    if ($(`#${ modal }`).is(':visible')){
        $(`#${modal}`).modal('hide');
    } else {
        $(`#${modal}`).modal('show');
    }
}

function limpiar_campos(){
    $('#form_insumo').val('');
    $('#form_producto').val('');
    $('#form_cantidad').val('');
    $('#form_punitario').val('');
    $('#form_pparcial').val('');
}

function guardar_costo(cproducto_id = 0){
    let form_insumo = document.getElementById('form_insumo').value;
    let form_producto = document.getElementById('form_producto').value;
    let form_catcosto = document.getElementById('form_catcosto').value;
    let form_unidad = document.getElementById('form_unidad').value;
    let form_cantidad = document.getElementById('form_cantidad').value;
    let form_punitario = document.getElementById('form_punitario').value;
    let form_pparcial = document.getElementById('form_pparcial').value;
    let controlador = `${base_url}costo_producto/add_costo`
    if(form_insumo != ""){
        $.ajax({
            url: controlador,
            type: 'POST',
            cache: false,
            data:{
                form_insumo:form_insumo,
                form_producto:form_producto,
                form_catcosto:form_catcosto,
                form_unidad:form_unidad,
                form_cantidad:form_cantidad,
                form_punitario:form_punitario,
                form_pparcial:form_pparcial,
                cproducto_id:cproducto_id,
            },
            success:()=>{
                modal_show_hidden(modal_add);
                mostrar_costos_producto(form_producto);
                modal_show_hidden(modal_info);
            },
            error:()=>{
                alert("Ocurrio un error al guardar");
            }
        })
    }else{
        $('#form_insumo').css('border','2px solid red');
        $('#form_insumo').focus();
    }
}

function calcular_costoParcial(){
    let form_cantidad = document.getElementById('form_cantidad').value; 
    let form_punitario = document.getElementById('form_punitario').value; 
    let form_pparcial = parseFloat(form_cantidad).toFixed(3) * parseFloat(form_punitario).toFixed(3);
    $("#form_pparcial").val((parseFloat(form_pparcial).toFixed(3)));
} 

function volver(){
    modal_show_hidden(modal_add);
    modal_show_hidden(modal_info);
}

function update_costo_producto(producto_id, precio_costo){
    let msj = `¿Está seguo que quiere cambiar el COSTO de este produccto a Bs ${precio_costo}?`
    if (confirm(msj)) {
        let controlador =  `${base_url}producto/update_costo`;
        $.ajax({
            url: controlador,
            type: 'POST',
            cache:false,
            data:{
                producto_id: producto_id,
                precio_costo: precio_costo,
            },
            success:()=>{
                modal_show_hidden(modal_info);
                location.reload();
            },
            error:()=>{
                alert("Error: Algo salio mal al actualizar el precio del producto");
            }
        })
    }
}