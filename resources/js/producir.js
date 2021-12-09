$(document).on("ready",inicio);
function inicio(){
    mostrardetalleproducion_aux();
}

/* funcion que pone el cursor a un input cuando se abre el modal */
function ponercursornuevaplatabanda(){
    var producto_id = document.getElementById('producto_id').value;
    var produccion_costounidefectiva = document.getElementById('produccion_costounidefectiva').value;
    if(producto_id == ""){
        alert("Debe elegir un Producto!.");
        $('#producto_id').focus();
    }else if(produccion_costounidefectiva == ""){
        alert("Debe registrar el costo por unidad efectiva"); 
        $('#produccion_costounidefectiva').focus();
    }else{
        var producto_nombre = $('select[name="producto_id"] option:selected').text();
        $('#titulodetalle').html(producto_nombre+"<br>");
        //$('#produccion_id').val(produccion["produccion_id"]);
        $('#detproduccion_cantidad').val("");
        $('#detproduccion_costo').val(produccion_costounidefectiva);
        $('#detproduccion_observacion').val("");
        $("#area_id").val($("#area_id option:first").val());
        $("#paraplatabanda").html("");
        $('#mensajenuevodetalle').html("");
        $('#modalparaplatabanda').modal('show');
        $(function(){
            $('#modalparaplatabanda').on('shown.bs.modal', function(e){

                $('#detproduccion_cantidad').focus();
            })
        });
    }
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
                            html += "<option value='"+registros[i]['controli_id']+"'>Platabanda "+registros[i]['controli_id']+"</option>";
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
    var fecha_inicio = document.getElementById('fecha_inicio').value;
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
                      detproduccion_costo:detproduccion_costo, detproduccion_observacion:detproduccion_observacion,
                      fecha_inicio:fecha_inicio},
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
                    var cantidadtotal = Number(0);
                    var costototal = Number(0);
                    html = "";
                    for (var i = 0; i < n ; i++){
                        cantidadtotal += Number(registrosa[i]["detproduccion_cantidad"]);
                        costototal += Number(registrosa[i]["detproduccion_cantidad"])*Number(registrosa[i]["detproduccion_costo"]);
                        html += "<tr>";
                        html += "<td class='text-center'>"+(i+1)+"</td>";
                        html += "<td>"+registrosa[i]["producto_nombre"]+"</td>";
                        html += "<td class='text-right'>"+registrosa[i]["detproduccion_cantidad"]+"</td>";
                        html += "<td class='text-right'>"+registrosa[i]["detproduccion_costo"]+"</td>";
                        html += "<td class='text-right'>"+registrosa[i]["detproduccion_cantidad"]*registrosa[i]["detproduccion_costo"]+"</td>";
                        html += "<td>"+registrosa[i]["detproduccion_observacion"]+"</td>";
                        html += "<td>"+registrosa[i]["area_nombre"]+"</td>";
                        html += "<td>"+registrosa[i]["controli_id"]+"</td>";
                        html += "<td style='background-color: #"+registrosa[i]["estado_color"]+"'>"+registrosa[i]["estado_descripcion"]+"</td>";
                        html += "<td class='no-print'>";
                            html += "<a onclick='eliminardetalleproduccion_aux("+registrosa[i]["detproduccion_id"]+")' class='btn btn-danger btn-xs' title='Eliminar este detalle de producción'><span class='fa fa-trash'></span></a>";
                        html += "</td>";
                        html += "</tr>";

                   }
                   html += "<tr>";
                   html += "<th style='font-size: 12px; text-align: right' class='text-bold' colspan='2'>Total</th>";
                   html += "<th style='font-size: 12px; text-align: right' class='text-bold'>"+numberFormat(Number(cantidadtotal).toFixed(0))+"</th>";
                   html += "<th style='font-size: 12px; text-align: right' class='text-bold'>";
                   if(cantidadtotal > 0){
                       html += numberFormat(Number(costototal/cantidadtotal).toFixed(2));
                   }else{ html += "0.00"}
                   html += "</th>";
                   html += "<th style='font-size: 12px; text-align: right' class='text-bold'>"+numberFormat(Number(costototal).toFixed(2))+"</th>";
                   html += "</tr>";
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
    var fecha_inicio = document.getElementById('fecha_inicio').value;
    var descripcion = document.getElementById('descripcion').value;
    var producto_id = document.getElementById('producto_id').value;
    var acargode_id = document.getElementById('acargode_id').value;
    var produccion_metodoreproduccion = document.getElementById('produccion_metodoreproduccion').value;
    var produccion_semillaprecio = document.getElementById('produccion_semillaprecio').value;
    var produccion_tiempoestimadog = document.getElementById('produccion_tiempoestimadog').value;
    var produccion_cantidaesperada = document.getElementById('produccion_cantidaesperada').value;
    var produccion_cantidadobtenida = document.getElementById('produccion_cantidadobtenida').value;
    var produccion_costototalxgermin = document.getElementById('produccion_costototalxgermin').value;
    var produccion_costounidefectiva = document.getElementById('produccion_costounidefectiva').value;
    
    var controlador = base_url+'produccion/registrar_produccion';
    if(descripcion == ""){
        alert("Descripción no debe estar vacio!.");
        $('#descripcion').focus();
    }else if(producto_id == ""){
        alert("Debe elegir un producto");
        $('#producto_id').focus();
    }else if(produccion_semillaprecio == ""){
        alert("El precio total de la semilla no debe estar vacio");
        $('#produccion_semillaprecio').focus();
    }else if(produccion_tiempoestimadog == ""){
        alert("El tiempo estimado no debe ser vacio");
        $('#produccion_tiempoestimadog').focus();
    }else if(produccion_cantidaesperada == ""){
        alert("La cantidad esperada no debe estar vacio");
        $('#produccion_cantidaesperada').focus();
    }else if(produccion_cantidadobtenida == ""){
        alert("La cantidad obtenida no debe estar vacio");
        $('#produccion_cantidadobtenida').focus();
    }else if(produccion_costototalxgermin == ""){
        alert("El costo operativo total de germinación no debe estar vacio");
        $('#produccion_costototalxgermin').focus();
    }else if(produccion_costounidefectiva == ""){
        alert("El costo por unidad efectiva no debe estar vacio");
        $('#produccion_costounidefectiva').focus();
    }else {
        $.ajax({url: controlador,
                type:"POST",
                data:{fecha_inicio:fecha_inicio, descripcion:descripcion, acargode_id:acargode_id,
                      produccion_metodoreproduccion:produccion_metodoreproduccion, produccion_semillaprecio:produccion_semillaprecio,
                      produccion_tiempoestimadog:produccion_tiempoestimadog, produccion_cantidaesperada:produccion_cantidaesperada,
                      produccion_cantidadobtenida:produccion_cantidadobtenida, produccion_costototalxgermin:produccion_costototalxgermin,
                      produccion_costounidefectiva:produccion_costounidefectiva},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        alert("Producción realizada con éxito!");
                        //valores_pordefecto();
                        //mostrardetalleproducion_aux();
                        dir_url = base_url+"produccion";
                        //window.open(dir_url);
                        location.href =dir_url;
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

/* recupera el tiempo estiamdo de germinación de una especie.*/
function elegir_tiempoestimado(){
    var base_url = document.getElementById('base_url').value;
    var producto_id = document.getElementById('producto_id').value;
    var controlador = base_url+'produccion/tiempoestimado_germinacion';
    if(producto_id == ""){
        alert("Debe elegir un Producto");
        $('#produccion_tiempoestimadog').val(0);
        $('#producto_id').focus();
    }else{
        $.ajax({url: controlador,
                type:"POST",
                data:{producto_id:producto_id},
                success:function(respuesta){
                    var registros =  JSON.parse(respuesta);
                    if (registros != null){
                        $('#produccion_tiempoestimadog').val(registros);
                    }
                },
                error:function(respuesta){
                    alert("Hubo algunos inconvenientes en producción!.");
                    $('#produccion_tiempoestimadog').val(0);
                }
        });
    }
}

/* calcula el costo por unidad.*/
function calcular_costoxunidad(){
    var produccion_semillaprecio = document.getElementById('produccion_semillaprecio').value;
    var produccion_costototalxgermin = document.getElementById('produccion_costototalxgermin').value;
    var produccion_cantidadobtenida = document.getElementById('produccion_cantidadobtenida').value;
    var prod_total = Number(produccion_semillaprecio)+Number(produccion_costototalxgermin);
    var costoxunidad = Number(Number(prod_total)/Number(produccion_cantidadobtenida)).toFixed(2);
    $('#produccion_costounidefectiva').val(costoxunidad);
}