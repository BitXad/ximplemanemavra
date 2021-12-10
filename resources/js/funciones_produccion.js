$(document).on("ready",inicio);
function inicio(){
    mostrarproduccion();
}

//muestra la tabla de producciones
function mostrarproduccion(){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'produccion/mostrarproduccion/';
    var parametro   = document.getElementById('filtrar').value;
    var fecha_desde = document.getElementById('fecha_desde').value;
    var fecha_hasta = document.getElementById('fecha_hasta').value;
    var buscarestado_id = document.getElementById('buscarestado_id').value;
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{parametro:parametro, fecha_desde:fecha_desde, fecha_hasta:fecha_hasta,
                  buscarestado_id:buscarestado_id},
            success:function(respuesta){
                $("#encontrados").val("- 0 -");
                var registros =  JSON.parse(respuesta);
                
                if (registros != null){
                    var n = registros.length; //tamaño del arreglo de la consulta
                    $("#encontrados").html("Registros Encontrados: "+n+" ");
                    var costototal = Number(0);
                    html = "";
                    for (var i = 0; i < n ; i++){
                        html += "<tr>";
                        
                        html += "<td>"+(i+1)+"</td>";
                        html += "<td class='text-center text-bold' style='font-size: 12px'>"+registros[i]["produccion_numeroorden"]+"</td>";
                        html += "<td>";
                        html += "<div id='horizontal'>";
                        html += "<div style='padding-left: 4px'>";
                        var tamaniofont = 3;
                        if(registros[i]["produccion_descripcion"].length >50){
                            tamaniofont = 1;
                        }
                        html += "<b id='masgrande'><font size='"+tamaniofont+"' face='Arial'><b>"+registros[i]["produccion_descripcion"]+"</b></font></b><sub> ["+registros[i]["produccion_id"]+"]</sub><br>";
                        
                        html += "</div>";
                        html += "</div>";
                        html += "</td>";
                        html += "<td class='text-center'>"+moment(registros[i]["produccion_inicio"]).format("DD/MM/YYYY")+"</td>";
                        html += "<td class='text-center'>";
                        if(registros[i]["produccion_estimada"] != "" && registros[i]["produccion_estimada"] != null && registros[i]["produccion_estimada"] != "0000-00-00"){
                            html += moment(registros[i]["produccion_estimada"]).format("DD/MM/YYYY");
                        }
                        html += "</td>";
                        html += "<td class='text-center'>";
                        if(registros[i]["produccion_fin"] != "" && registros[i]["produccion_fin"] != null && registros[i]["produccion_fin"] != "0000-00-00"){
                            html += moment(registros[i]["produccion_fin"]).format("DD/MM/YYYY");
                        }
                        html += "</td>";
                        html += "<td class='text-right'>";
                        if(registros[i]["costo"] != null &&  registros[i]["costo"] !=""){
                            html += numberFormat(Number(registros[i]["costo"]).toFixed(2));
                            costototal += Number(registros[i]["costo"]);
                        }else{
                            html += "0.00";
                        }
                        html += "</td>";
                        html += "<td>"+registros[i]["usuario_nombre"]+"</td>";
                        //html += "<td class='no-print' style='background-color: #"+registros[i]["estado_color"]+"'>"+registros[i]["estado_descripcion"]+"</td>";
                        html += "<td>";
                        //html += "<a onclick='ponercursornuevodetalle("+JSON.stringify(registros[i])+")' class='btn btn-success btn-xs' data-toggle='modal' data-target='#modalnuevodetalle' title='Registrar detalle de producción'><span class='fa fa-sliders'></span></a>";
                        html += "<a onclick='ponercursordetalleproducion("+JSON.stringify(registros[i])+")' class='btn btn-info btn-xs' data-toggle='modal' data-target='#modaldetallesproduccion' title='Ver detalles de producción'><span class='fa fa-list'></span></a>";
                        html += "<a href='"+base_url+"produccion/reporte_produccion/"+registros[i]["produccion_id"]+"' class='btn btn-success btn-xs' title='Reporte'><span class='fa fa-print'></span></a>";
                        html += "<a href='"+base_url+"control_inventario/platabandas_produccion/"+registros[i]["produccion_id"]+"' class='btn btn-info btn-xs' title='Platabandas'><i class='fa fa-leaf' aria-hidden='true'></i></a>";
                        html += "</td>";
                        html += "</tr>";

                        
                   }
                   html += "<tr>";
                   html += "<th style='text-align: right !important; font-size: 12pt' colspan='6'>Total:</th>";
                   html += "<th style='text-align: right !important; font-size: 12pt' >"+numberFormat(Number(costototal).toFixed(2))+"</th>";
                   html += "<th colspan='2'></th>";
                   html += "</tr>";
                   $("#tablaproduccion").html(html);
                   document.getElementById('loader').style.display = 'none';
            }
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader
        },
        error:function(respuesta){
           // alert("Algo salio mal...!!!");
           html = "";
           $("#tablaresultados").html(html);
        },
        complete: function (jqXHR, textStatus) {
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader 
            //tabla_inventario();
        }
        
    });   

}

function registrarnuevaproduccion(){
    var base_url  = document.getElementById('base_url').value;
    let produccion_descripcion = document.getElementById('produccion_descripcion').value;
    let produccion_inicio = document.getElementById('produccion_inicio').value;
    var controlador = base_url+'produccion/nuevaproduccion';
    if(produccion_descripcion.trim() == ""){
        $("#mensajedescripcion").html("Este campo no debe estar vacio!.");
        $("#produccion_descripcion").val("");
    }else{
        $('#modalnuevaproduccion').modal('hide');
        $.ajax({url: controlador,
               type:"POST",
               data:{produccion_descripcion:produccion_descripcion, produccion_inicio:produccion_inicio},
               success:function(respuesta){
                   var registros =  JSON.parse(respuesta);
                   if (registros != null){
                        mostrarproduccion();
                }
            },
            error:function(respuesta){
               html = "";
               $("#costodesc_id").html(html);
            }
        });
    }
}
/* funcion que pone el cursor a un input cuando se abre el modal */
function ponercursor(){
    //document.getElementById('produccion_descripcion').value("");
    fecha = moment(new Date()).format("YYYY-MM-DD")
            $('#produccion_descripcion').val("");
            $('#produccion_inicio').val(fecha);
    $(function(){
        $('#modalnuevaproduccion').on('shown.bs.modal', function(e){
            
            $('#produccion_descripcion').focus();
        })
    });
}
/* funcion que pone el cursor a un input cuando se abre el modal */
function ponercursornuevodetalle(produccion){
    $('#titulodetalle').html(produccion["produccion_descripcion"]+"<br>");
    $('#produccion_id').val(produccion["produccion_id"]);
    $('#detproduccion_cantidad').val(0);
    $('#detproduccion_observacion').val("");
    $("#area_id").val($("#area_id option:first").val());
    $("#paraplatabanda").html("");
    $('#mensajenuevodetalle').html("");
    $(function(){
        $('#modalnuevodetalle').on('shown.bs.modal', function(e){
            
            $('#detalleprod_cant').focus();
        })
    });
}
/* buscar patabandas de un area especifica */
function buscar_platabanda(){
    var base_url  = document.getElementById('base_url').value;
    var area_id  = document.getElementById('area_id').value;
    var controlador = base_url+'produccion/buscar_platabanda';
    if(area_id == ""){
        $("#paraplatabanda").html("");
    }else{
        //$('#modalnuevaproduccion').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{area_id:area_id},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        html = "";
                        var n = registros.length; //tamaño del arreglo de la consulta
                        html += "<select name='controli_id' class='form-control' id='controli_id'>";
                        html += "<!--<option value=''>select produccion</option>-->";
                        for (var i = 0; i < n ; i++){
                        //$selected = ($produccion['produccion_id'] == $produccion['produccion_numeroorden']) ? ' selected="selected"' : "";
                            html += "<option value='"+registros[i]['controli_id']+"'>"+registros[i]['controli_id']+"</option>";
                        }
                        html += "</select>";
                        $("#paraplatabanda").html(html);
                        //mostrarproduccion();
                }
            },
            error:function(respuesta){
               html = "";
               $("#paraplatabanda").html(html);
            }
        });
    }
}
/* registra nuevodetalle a una producción!. */
function registrarnuevodetalle(){
    var base_url = document.getElementById('base_url').value;
    var produccion_id = document.getElementById('produccion_id').value;
    var producto_id = document.getElementById('producto_id').value;
    var area_id = document.getElementById('area_id').value;
    var controli_id  = document.getElementById('controli_id').value;
    let detproduccion_cantidad = document.getElementById('detproduccion_cantidad').value;
    let detproduccion_observacion = document.getElementById('detproduccion_observacion').value;
    var controlador = base_url+'produccion/nuevodetalle';
    if(detproduccion_cantidad == ""){
        $("#mensajenuevodetalle").html("Cantidad no debe estar vacio!.");
        $("#detproduccion_cantidad").val("");
    }else if(area_id == ""){
        $("#mensajenuevodetalle").html("Debe elegir un area para despues elegir una Platabanda");
        $("#detproduccion_cantidad").val("");
    }else{
        $('#modalnuevodetalle').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{produccion_id:produccion_id, producto_id:producto_id, controli_id:controli_id,
                    detproduccion_cantidad:detproduccion_cantidad,
                    detproduccion_observacion:detproduccion_observacion},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        //....
                    }
                },
                error:function(respuesta){
                    html = "";
                    $("#costodesc_id").html(html);
                }
        });
    }
}
/* funcion que muestra los detalles de una produción */
function ponercursordetalleproducion(produccion){
    var base_url = document.getElementById('base_url').value;
    $('#titulomostrardetalle').html("Producción Nro. "+produccion["produccion_numeroorden"]+"<br>"+produccion["produccion_descripcion"]+"<br>");
    //$('#produccion_id').val(produccion["produccion_id"]);
    var produccion_id = produccion["produccion_id"];
    var controlador = base_url+'produccion/mostrardetalleproduccion/';
    document.getElementById('loader3').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{produccion_id:produccion_id},
            success:function(respuesta){
                //$("#encontrados").val("- 0 -");
                var registrosa =  JSON.parse(respuesta);
                if (registrosa != null){
                    var n = registrosa.length; //tamaño del arreglo de la consulta
                    //$("#encontrados").html("Registros Encontrados: "+n+" ");
                    var totalcantidad = Number(0);
                    var totalcosto = Number(0);
                    html = "";
                    for (var i = 0; i < n ; i++){
                        totalcantidad += Number(registrosa[i]["detproduccion_cantidad"]);
                        totalcosto += Number(registrosa[i]["detproduccion_cantidad"])*Number(registrosa[i]["detproduccion_costo"]);
                        html += "<tr>";
                        html += "<td class='text-center'>"+(i+1)+"</td>";
                        html += "<td>"+registrosa[i]["producto_nombre"]+"</td>";
                        html += "<td class='text-right'>"+numberFormat(Number(registrosa[i]["detproduccion_cantidad"]).toFixed(0))+"</td>";
                        html += "<td class='text-right'>";
                        if(registrosa[i]["detproduccion_costo"] != null && registrosa[i]["detproduccion_costo"] != ""){
                            html += registrosa[i]["detproduccion_costo"];
                        }else{
                            html += "0.00"; 
                        }
                        html += "</td>";
                        html += "<td class='text-right'>"+numberFormat(Number(registrosa[i]["detproduccion_cantidad"]*registrosa[i]["detproduccion_costo"]).toFixed(0))+"</td>";
                        html += "<td>"+registrosa[i]["area_nombre"]+"</td>";
                        html += "<td class='text-center'>"+registrosa[i]["controli_id"]+"</td>";
                        html += "<td>"+registrosa[i]["detproduccion_observacion"]+"</td>";
                        html += "<td class='no-print' style='background-color: #"+registrosa[i]["estado_color"]+"'>"+registrosa[i]["estado_descripcion"]+"</td>";
                        html += "<td>";
                            html += "<a onclick='modificardetalleproduccion("+JSON.stringify(registrosa[i])+", "+JSON.stringify(produccion["produccion_descripcion"])+")' class='btn btn-info btn-xs' title='Modificar este detalle de producción'><span class='fa fa-pencil'></span></a>";
                        html += "</td>";
                        
                        html += "</tr>";

                   }
                   html += "<tr>";
                   html += "<th class='text-bold' style='font-size:12px; text-align: right' colspan='2'>Total:</th>";
                   html += "<th class='text-bold' style='font-size:12px; text-align: right'>"+numberFormat(Number(totalcantidad).toFixed(2))+"</th>";
                   html += "<th class='text-bold' style='font-size:12px; text-align: right'>"+numberFormat(Number(totalcosto/totalcantidad).toFixed(2))+"</th>";
                   html += "<th class='text-bold' style='font-size:12px; text-align: right'>"+numberFormat(Number(totalcosto).toFixed(2))+"</th>";
                   html += "</tr>";
                   $("#tabladetalleproduccion").html(html);
                   document.getElementById('loader3').style.display = 'none';
            }
            document.getElementById('loader3').style.display = 'none'; //ocultar el bloque del loader
        },
        error:function(respuesta){
           // alert("Algo salio mal...!!!");
           html = "";
           $("#tablaresultados").html(html);
        },
        complete: function (jqXHR, textStatus) {
            document.getElementById('loader3').style.display = 'none'; //ocultar el bloque del loader 
            //tabla_inventario();
        }
        
    });
}
/* funcion que muestra los detalles de una produción */
function modificardetalleproduccion(masproduccion, produccion_descripcion){
    var base_url = document.getElementById('base_url').value;
    $('#titulomodificardetalle').html(produccion_descripcion+"<br>");
    $('#modaldetallesproduccion').modal('hide');
    
    $('#produccion_id').val(masproduccion["produccion_id"]);
    $('#detproduccion_id').val(masproduccion["detproduccion_id"]);
    $('#ladetproduccion_cantidad').val(masproduccion["detproduccion_cantidad"]);
    $('#ladetproduccion_costo').val(masproduccion["detproduccion_costo"]);
    $('#ladetproduccion_observacion').val(masproduccion["detproduccion_observacion"]);
    var losproductos = JSON.parse(document.getElementById('losproductos').value);
    if (losproductos != null){
        var n = losproductos.length; //tamaño del arreglo de la consulta
        var html = "";
        html += "<select name='elproducto_id' class='form-control' id='elproducto_id'>";
        for (var i = 0; i < n; i++) {
            if(losproductos[i]['producto_id'] == masproduccion['producto_id']){
                selected = "selected='selected'";
            }else{
                selected = "";
            }
            html += "<option value='"+losproductos[i]['producto_id']+"'"+selected+">"+losproductos[i]['producto_nombre']+"</option>";
        }
        html += "</select>";
        
        $('#estosproductos').html(html);
    }
    var lasareas = JSON.parse(document.getElementById('lasareas').value);
    if (lasareas != null){
        var m = lasareas.length; //tamaño del arreglo de la consulta
        var htmla = "";
        htmla += "<select name='elarea_id' class='form-control' id='elarea_id' onchange='buscar_platabandamodif2()'>";
        for (var j = 0; j < m; j++) {
            if(lasareas[j]['area_id'] == masproduccion['area_id']){
                selecteda = "selected='selected'";
            }else{
                selecteda = "";
            }
            htmla += "<option value='"+lasareas[j]['area_id']+"'"+selecteda+">"+lasareas[j]['area_nombre']+"</option>";
        }
        htmla += "</select>";
        
        $('#estasareas').html(htmla);
    }
    
    $('#modalmodificardetalle').modal('show');
    buscar_platabandamodif(masproduccion['area_id'], masproduccion['controli_id']);
    
    //$("#modificartodo_eldetalle").html(html);
}
/* buscar patabandas de un area especifica para modificar */
function buscar_platabandamodif(area_id, controli_id){
    var base_url  = document.getElementById('base_url').value;
    //var area_id  = document.getElementById('elarea_id').value;
    var controlador = base_url+'produccion/buscar_platabanda';
    if(area_id == ""){
        $("#paraplatabandam").html("");
    }else{
        //$('#modalnuevaproduccion').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{area_id:area_id},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        html = "";
                        var n = registros.length; //tamaño del arreglo de la consulta
                        html += "<select name='controlim_id' class='form-control' id='controlim_id'>";
                        html += "<!--<option value=''>select produccion</option>-->";
                        for (var i = 0; i < n ; i++){
                            if(registros[i]['controli_id'] == controli_id){
                                selected = "selected='selected'";
                            }else{
                                selected = "";
                            }
                            html += "<option value='"+registros[i]['controli_id']+"' "+selected+">"+registros[i]['controli_id']+"</option>";
                        }
                        html += "</select>";
                        $("#paraplatabandam").html(html);
                        //mostrarproduccion();
                }
            },
            error:function(respuesta){
               html = "";
               $("#paraplatabandam").html(html);
            }
        });
    }
}
/* buscar patabandas de un area especifica y mpodificar */
function buscar_platabandamodif2(){
    var base_url  = document.getElementById('base_url').value;
    var area_id  = document.getElementById('elarea_id').value;
    var controlador = base_url+'produccion/buscar_platabanda';
    if(area_id == ""){
        $("#paraplatabandam").html("");
    }else{
        //$('#modalnuevaproduccion').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{area_id:area_id},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        html = "";
                        var n = registros.length; //tamaño del arreglo de la consulta
                        html += "<select name='controlim_id' class='form-control' id='controlim_id'>";
                        html += "<!--<option value=''>select produccion</option>-->";
                        for (var i = 0; i < n ; i++){
                            html += "<option value='"+registros[i]['controli_id']+"'>"+registros[i]['controli_id']+"</option>";
                        }
                        html += "</select>";
                        $("#paraplatabandam").html(html);
                        //mostrarproduccion();
                }
            },
            error:function(respuesta){
               html = "";
               $("#paraplatabandam").html(html);
            }
        });
    }
}
/* guarda detalle modificado de una producción!. */
function guardar_detallemodificado(){
    var base_url = document.getElementById('base_url').value;
    var produccion_id = document.getElementById('produccion_id').value;
    var detproduccion_id = document.getElementById('detproduccion_id').value;
    let detproduccion_cantidad = document.getElementById('ladetproduccion_cantidad').value;
    let detproduccion_costo = document.getElementById('ladetproduccion_costo').value;
    let detproduccion_observacion = document.getElementById('ladetproduccion_observacion').value;
    var producto_id = document.getElementById('elproducto_id').value;
    var area_id = document.getElementById('elarea_id').value;
    var controli_id  = document.getElementById('controlim_id').value;
    var controlador = base_url+'produccion/modificardetalle';
    if(detproduccion_cantidad == ""){
        $("#mensajemodifcardetalle").html("Cantidad no debe estar vacio!.");
        $("#ladetproduccion_cantidad").val("");
        $("#ladetproduccion_cantidad").focus();
    }else if(area_id == ""){
        $("#mensajemodifcardetalle").html("Debe elegir un area para despues elegir una Platabanda");
        //$("#detproduccion_cantidad").val("");
    }else{
        $('#modalmodificardetalle').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{produccion_id:produccion_id, detproduccion_id:detproduccion_id,
                      producto_id:producto_id, controli_id:controli_id,
                      detproduccion_cantidad:detproduccion_cantidad, detproduccion_costo:detproduccion_costo,
                      detproduccion_observacion:detproduccion_observacion},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        //alert(JSON.stringify(registros[0]));
                        ponercursordetalleproducion(registros[0]);
                        $('#modaldetallesproduccion').modal('show');
                    }
                },
                error:function(respuesta){
                    html = "";
                    $("#costodesc_id").html(html);
                }
        });
    }
}

function validar(e) {
  tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){
        let filtrar = document.getElementById('filtrar').value;
        if(filtrar.trim != ""&& filtrar != null){
            mostrarproduccion();
        }
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
    