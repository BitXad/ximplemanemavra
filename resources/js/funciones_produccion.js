$(document).on("ready",inicio);
function inicio(){
    mostrarproduccion();
}

//muestra la tabla de producciones
function mostrarproduccion(){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'produccion/mostrarproduccion/';
    var parametro = document.getElementById('filtrar').value;
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{parametro:parametro},
            success:function(respuesta){
                $("#encontrados").val("- 0 -");
                var registros =  JSON.parse(respuesta);
                
                if (registros != null){
                    var n = registros.length; //tamaño del arreglo de la consulta
                    $("#encontrados").html("Registros Encontrados: "+n+" ");
                    html = "";
                    for (var i = 0; i < n ; i++){
                        html += "<tr>";
                        
                        html += "<td>"+(i+1)+"</td>";
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
                        html += "<td>"+moment(registros[i]["produccion_inicio"]).format("DD/MM/YYYY")+"</td>";
                        html += "<td>"+registros[i]["usuario_nombre"]+"</td>";
                        html += "<td class='no-print' style='background-color: #"+registros[i]["estado_color"]+"'>"+registros[i]["estado_descripcion"]+"</td>";
		        /*html += "<td class='no-print'>";
                        html += "<a href='"+base_url+"producto/edit/"+registros[i]["miprod_id"]+"' target='_blank' class='btn btn-info btn-xs' title='Modificar Información'><span class='fa fa-pencil'></span></a>";
                        html += "<a href='"+base_url+"imagen_producto/catalogoprod/"+registros[i]["miprod_id"]+"' class='btn btn-success btn-xs' title='Catálogo de Imagenes' ><span class='fa fa-image'></span></a>";
                        */
                        /*html += "<a class='btn btn-facebook btn-xs' onclick='buscarclasificador("+registros[i]["miprod_id"]+")' title='Ver Clasificador'><span class='fa fa-list-ol'></span></a>";
                        html += "<a href='"+base_url+"producto/productoasignado/"+registros[i]["miprod_id"]+"' class='btn btn-soundcloud btn-xs' title='Ver si esta asignado a subcategorias' target='_blank' ><span class='fa fa-list'></span></a>";
                        html += "<a class='btn btn-warning btn-xs' onclick='mostrarmodalcodigobarra("+registros[i]["miprod_id"]+", "+JSON.stringify(registros[i]["producto_nombre"])+", "+JSON.stringify(registros[i]["producto_codigobarra"])+")' title='Código de barras para impresión'><span class='fa fa-barcode'></span></a>";
                        html += "</td>";
                        */
                        html += "<td>";
                        html += "<a onclick='ponercursornuevodetalle("+JSON.stringify(registros[i])+")' class='btn btn-success btn-xs' data-toggle='modal' data-target='#modalnuevodetalle' title='Registrar detalle de producción'><span class='fa fa-sliders'></span></a>";
                        html += "<a onclick='ponercursordetalleproducion("+JSON.stringify(registros[i])+")' class='btn btn-info btn-xs' data-toggle='modal' data-target='#modaldetallesproduccion' title='Ver detalles de producción'><span class='fa fa-list'></span></a>";
                        html += "</td>";
                        html += "</tr>";

                   }
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
    $('#titulomostrardetalle').html(produccion["produccion_descripcion"]+"<br>");
    //$('#produccion_id').val(produccion["produccion_id"]);
    var produccion_id = produccion["produccion_id"];
    var controlador = base_url+'produccion/mostrardetalleproduccion/';
    document.getElementById('loader3').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{produccion_id:produccion_id},
            success:function(respuesta){
                //$("#encontrados").val("- 0 -");
                var registros =  JSON.parse(respuesta);
                if (registros != null){
                    var n = registros.length; //tamaño del arreglo de la consulta
                    //$("#encontrados").html("Registros Encontrados: "+n+" ");
                    html = "";
                    for (var i = 0; i < n ; i++){
                        html += "<tr>";
                        html += "<td>"+(i+1)+"</td>";
                        html += "<td>"+registros[i]["producto_nombre"]+"</td>";
                        html += "<td>"+registros[i]["detproduccion_cantidad"]+"</td>";
                        html += "<td>"+registros[i]["detproduccion_observacion"]+"</td>";
                        html += "<td>"+registros[i]["area_nombre"]+"</td>";
                        html += "<td>"+registros[i]["controli_id"]+"</td>";
                        html += "<td class='no-print' style='background-color: #"+registros[i]["estado_color"]+"'>"+registros[i]["estado_descripcion"]+"</td>";
                        html += "<td>";
                        html += "<a onclick='modificardetalleproduccion("+JSON.stringify(registros[i])+", "+JSON.stringify(produccion["produccion_descripcion"])+")' class='btn btn-info btn-xs' title='Modificar este detalle de producción'><span class='fa fa-pencil'></span></a>";
                        html += "</td>";
                        html += "</tr>";

                   }
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
    
    $('#modalmodificardetalle').modal('show');
    
    $("#modificartodo_eldetalle").html(html);
}