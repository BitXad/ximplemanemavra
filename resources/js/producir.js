$(document).on("ready",inicio);
function inicio(){
    mostrardetalleproducion_aux();
}

/* funcion que pone el cursor a un input cuando se abre el modal */
function ponercursornuevaplatabanda(){
    var base_url  = document.getElementById('base_url').value;
    var producto_nombre = $('select[name="producto_id"] option:selected').text();
    $('#titulodetalle').html(producto_nombre+"<br>");
    //$('#produccion_id').val(produccion["produccion_id"]);
    $('#detproduccion_cantidad').val("");
    $('#detproduccion_costo').val(0);
    $('#detproduccion_observacion').val("");
    $("#area_id").val($("#area_id option:first").val());
    $("#paraplatabanda").html("");
    $('#mensajenuevodetalle').html("");
    $(function(){
        $('#modalparaplatabanda').on('shown.bs.modal', function(e){
            
            $('#detproduccion_cantidad').focus();
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

/* registra nuevodetalle a una producción aux!... */
function registrarnuevodetalleaux(){
    var base_url = document.getElementById('base_url').value;
    //var produccion_id = document.getElementById('produccion_id').value;
    //var fecha_inicio = document.getElementById('fecha_inicio').value;
    //var fecha_fin = document.getElementById('fecha_fin').value;
    //var descripcion = document.getElementById('descripcion').value;
    var producto_id = document.getElementById('producto_id').value;
    //var acargode_id = document.getElementById('acargode_id').value;
    var detproduccion_cantidad = document.getElementById('detproduccion_cantidad').value;
    var detproduccion_costo = document.getElementById('detproduccion_costo').value;
    var detproduccion_observacion = document.getElementById('detproduccion_observacion').value;
    var area_id = document.getElementById('area_id').value;
    
    var controlador = base_url+'produccion/poner_adetalleaux';
    if(detproduccion_cantidad == ""){
        $("#mensajenuevodetalle").html("Cantidad no debe estar vacio!.");
        //$("#detproduccion_cantidad").val("");
    }else if(detproduccion_cantidad == 0){
        $("#mensajenuevodetalle").html("Cantidad no debe ser cero!.");
        //$("#detproduccion_cantidad").val("");
    }else if(area_id == ""){
        $("#mensajenuevodetalle").html("Debe elegir un area para despues elegir una Platabanda");
        //$("#detproduccion_cantidad").val("");
    }else{
        var controli_id  = document.getElementById('controli_id').value;
        $('#modalparaplatabanda').modal('hide');
        $.ajax({url: controlador,
                type:"POST",
                data:{producto_id:producto_id, controli_id:controli_id, detproduccion_cantidad:detproduccion_cantidad,
                      detproduccion_costo:detproduccion_costo, detproduccion_observacion:detproduccion_observacion},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        mostrardetalleproducion_aux();
                    }
                },
                error:function(respuesta){
                    html = "";
                    $("#costodesc_id").html(html);
                }
        });
    }
}
/* funcion que muestra los detalles de una produción aux */
function mostrardetalleproducion_aux(){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'produccion/mostrardetalleproduccion_aux/';
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{},
            success:function(respuesta){
                //$("#encontrados").val("- 0 -");
                var registrosa =  JSON.parse(respuesta);
                if (registrosa != null){
                    var n = registrosa.length; //tamaño del arreglo de la consulta
                    //$("#encontrados").html("Registros Encontrados: "+n+" ");
                    html = "";
                    for (var i = 0; i < n ; i++){
                        html += "<tr>";
                        html += "<td class='text-center'>"+(i+1)+"</td>";
                        html += "<td>"+registrosa[i]["producto_nombre"]+"</td>";
                        html += "<td class='text-right'>"+registrosa[i]["detproduccion_cantidad"]+"</td>";
                        html += "<td class='text-right'>"+registrosa[i]["detproduccion_costo"]+"</td>";
                        html += "<td>"+registrosa[i]["detproduccion_observacion"]+"</td>";
                        html += "<td>"+registrosa[i]["area_nombre"]+"</td>";
                        html += "<td>"+registrosa[i]["controli_id"]+"</td>";
                        html += "<td style='background-color: #"+registrosa[i]["estado_color"]+"'>"+registrosa[i]["estado_descripcion"]+"</td>";
                        html += "<td class='no-print'>";
                            html += "<a onclick='eliminardetalleproduccion_aux("+registrosa[i]["detproduccion_id"]+")' class='btn btn-danger btn-xs' title='Eliminar este detalle de producción'><span class='fa fa-trash'></span></a>";
                        html += "</td>";
                        html += "</tr>";

                   }
                   $("#tabladetalleproduccion_aux").html(html);
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

/* funcion que elimina un detalle especifico de detalle produción aux */
function eliminardetalleproduccion_aux(detproduccion_id){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'produccion/eliminardetalleproduccion_aux/';
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{detproduccion_id:detproduccion_id},
            success:function(respuesta){
                var registrosa =  JSON.parse(respuesta);
                if (registrosa != null){
                   document.getElementById('loader').style.display = 'none';
                    mostrardetalleproducion_aux();
            }
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader
        },
        error:function(respuesta){
           alert("No se pudo elimiar este detalle!.");
           mostrardetalleproducion_aux();
        },
        complete: function (jqXHR, textStatus) {
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader 
            //tabla_inventario();
        }
        
    });
}
/* funcion que elimina todo el detalle de detalle produción aux */
function eliminar_tododetalleproduccion_aux(){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'produccion/eliminar_tododetalleproduccion_aux/';
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    $.ajax({url: controlador,
            type:"POST",
            data:{},
            success:function(respuesta){
                var registrosa =  JSON.parse(respuesta);
                if (registrosa != null){
                   document.getElementById('loader').style.display = 'none';
                    mostrardetalleproducion_aux();
            }
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader
        },
        error:function(respuesta){
           alert("No se pudo elimiar los detalles de esta producción!.");
           mostrardetalleproducion_aux();
        },
        complete: function (jqXHR, textStatus) {
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader 
            //tabla_inventario();
        }
        
    });
}
/* realiza la producción!..*/
function producir(){
    var base_url = document.getElementById('base_url').value;
    //var produccion_id = document.getElementById('produccion_id').value;
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    //var fecha_fin = document.getElementById('fecha_fin').value;
    var descripcion = document.getElementById('descripcion').value;
    //var producto_id = document.getElementById('producto_id').value;
    var acargode_id = document.getElementById('acargode_id').value;
    //var detproduccion_cantidad = document.getElementById('detproduccion_cantidad').value;
    //var detproduccion_costo = document.getElementById('detproduccion_costo').value;
    //var detproduccion_observacion = document.getElementById('detproduccion_observacion').value;
    //var area_id = document.getElementById('area_id').value;
    
    var controlador = base_url+'produccion/registrar_produccion';
    if(descripcion == ""){
        alert("Descripción no debe estar vacio!.");
        $('#descripcion').focus();
    }else{
        $.ajax({url: controlador,
                type:"POST",
                data:{fecha_inicio:fecha_inicio, descripcion:descripcion, acargode_id:acargode_id},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        alert("Producción realizada con éxito!");
                        valores_pordefecto();
                        mostrardetalleproducion_aux();
                    }
                },
                error:function(respuesta){
                    alert("Hubo algunos inconvenientes en producción!.");
                    mostrardetalleproducion_aux();
                }
        });
    }
}
/* funcion que pone con valores por defecto!... */
function valores_pordefecto(){
    var fecha = new Date();
    dd   = fecha.getDate(),
    mm   = fecha.getMonth() + 1,
    yyyy = fecha.getFullYear()
    if(dd <10){
        dd = 0+dd;
    }
    if(mm <10){
        mm = 0+mm;
    }
    $('#fecha_inicio').val(yyyy+"-"+mm+"-"+dd);
    //alert($('#fecha_inicio').val());
    $('#descripcion').val("");
    $("#producto_id").val($("#producto_id option:first").val());
    $("#acargode_id").val($("#acargode_id option:first").val());
    $('#filtrar').val("");
}
