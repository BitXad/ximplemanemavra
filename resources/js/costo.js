$(document).on("ready",inicio);
function inicio(){
    mostrar_costos();
}
//mostrar costos
function mostrar_costos(){
    let catcosto_id = document.getElementById('categoriacosto').value;
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'costo/mostrarcosto';
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    
    $.ajax({url: controlador,
           type:"POST",
           data:{catcosto_id:catcosto_id},
           success:function(respuesta){
                $("#encontrados").html("0");
                var registros =  JSON.parse(respuesta);
                if (registros != null){
                    var n = registros.length; //tamaño del arreglo de la consulta
                    $("#encontrados").html(n);
                    var categoria_costos = JSON.parse(document.getElementById('categoria_costos').value);
                    var m = categoria_costos.length;
                    html = "";
                    for (var j = 0; j < m ; j++){
                        if(categoria_costos[j]["catcosto_id"] == catcosto_id){
                            html += "<tr>";
                            var porcentaje = Number(categoria_costos[j]['catcosto_porcentaje'])*(100);
                            html += "<th colspan='6' style='text-align: left'><b><span>"+categoria_costos[j]['catcosto_descripcion']+"</span></b> - <span>"+porcentaje+"%</span></th>";
                            html += "<th><button class='btn btn-xs btn-info' title='Editar porcentaje' onclick='show_form("+categoria_costos[j]['catcosto_id']+",`"+categoria_costos[j]['catcosto_descripcion']+"`,"+porcentaje+")'><i class='fa fa-pencil' aria-hidden='true'></i></button></th>";
                            html += "</tr>";
                            for (var i = 0; i < n ; i++){
                                html += "<tr>";
                                html += "    <td>"+(i+1)+"</td>";
                                html += "    <td>"+registros[i]['costo_descripcion']+"</td>";
                                html += "    <td>"+registros[i]['costo_unidad']+"</td>";
                                html += "    <td class='text-center'>"+registros[i]['costo_punitario']+"</td>";
                                html += "    <td>"+registros[i]['estado_descripcion']+"</td>";
                                html += "    <td class='text-center'>";
                                if(registros[i]["costo_fecha"] != null && registros[i]["costo_fecha"] != ""){
                                    html += moment(registros[i]["costo_fecha"]).format("DD/MM/YYYY");
                                }
                                html += "</td>";
                                html += "    <td class='no-print'>";
                                html += "        <a href='"+base_url+"costo/edit/"+registros[i]["costo_id"]+"' class='btn btn-info btn-xs' title='Editar'><span class='fa fa-pencil'></span></a>";
                                html += "    </td>";
                                html += "</tr>";
                           }
                       }
                   }
                   $("#tablacostos").html(html);
                   document.getElementById('loader').style.display = 'none';
            }
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader
        },
        error:function(respuesta){
           // alert("Algo salio mal...!!!");
           html = "";
           $("#tablacostos").html(html);
        },
        complete: function (jqXHR, textStatus) {
            document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader 
            //tabla_inventario();
        }
    });
}
