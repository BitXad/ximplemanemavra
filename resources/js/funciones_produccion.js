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
                        html += "<a class='btn btn-danger btn-xs' data-toggle='modal' data-target='#myModal"+i+"' title='Eliminar'><span class='fa fa-trash'></span></a>";
                        html += "<a class='btn btn-facebook btn-xs' onclick='buscarclasificador("+registros[i]["miprod_id"]+")' title='Ver Clasificador'><span class='fa fa-list-ol'></span></a>";
                        html += "<a href='"+base_url+"producto/productoasignado/"+registros[i]["miprod_id"]+"' class='btn btn-soundcloud btn-xs' title='Ver si esta asignado a subcategorias' target='_blank' ><span class='fa fa-list'></span></a>";
                        html += "<a class='btn btn-warning btn-xs' onclick='mostrarmodalcodigobarra("+registros[i]["miprod_id"]+", "+JSON.stringify(registros[i]["producto_nombre"])+", "+JSON.stringify(registros[i]["producto_codigobarra"])+")' title='Código de barras para impresión'><span class='fa fa-barcode'></span></a>";
                        html += "</td>";
                        */
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