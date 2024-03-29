$(document).on("ready",inicio);
function inicio(){
    //imprimirdetalle()
    reportedetservicio();
}

function imprimirdetalle(){
    var estafh = new Date();
    $('#fhimpresion').html(formatofecha_hora_ampm(estafh));
    window.print();
}
/*aumenta un cero a un digito; es para las horas*/
function aumentar_cero(num){
    if (num < 10) {
        num = "0" + num;
    }
    return num;
}
/* recibe Date y devuelve en formato dd/mm/YYYY hh:mm:ss ampm */
function formatofecha_hora_ampm(string){
    var mifh = new Date(string);
    var info = "";
    var am_pm = mifh.getHours() >= 12 ? "p.m." : "a.m.";
    var hours = mifh.getHours() > 12 ? mifh.getHours() - 12 : mifh.getHours();
    if(string != null){
       info = aumentar_cero(mifh.getDate())+"/"+aumentar_cero((mifh.getMonth()+1))+"/"+mifh.getFullYear()+" "+aumentar_cero(hours)+":"+aumentar_cero(mifh.getMinutes())+":"+aumentar_cero(mifh.getSeconds())+" "+am_pm;
   }
    return info;
}

function convertDateFormat(string){
    var info = "";
    if(string != null){
       info = string.split('-').reverse().join('/');
   }
    return info;
}

function reportedetservicio(){
    var base_url       = document.getElementById('base_url').value;
    var controlador    = base_url+"servicio/buscardetalleserv_dia";
    /*
    var fecha_desde    = document.getElementById('fecha_desde').value;
    var fecha_hasta    = document.getElementById('fecha_hasta').value;
    var estado_id      = document.getElementById('busestado_id').value;
    var usuario_id     = document.getElementById('bususuario_id').value;
    var responsable_id = document.getElementById('busresponsable_id').value;
    var buscar_clie    = document.getElementById('buscar_cliente').value;
    var lasfechas     = " and date(s.servicio_fecharecepcion) >= '"+fecha_desde+"'  and  date(s.servicio_fecharecepcion) <='"+fecha_hasta+"' ";
    
    var esteestado_id = "";
    if(estado_id != 0){
        esteestado_id = "and ds.estado_id = "+estado_id+" ";
    }
    var esteusuario_id= "";
    if( usuario_id !=0){
        esteusuario_id = "and ds.usuario_id = "+usuario_id+" ";
    }
    var esteresponsable_id= "";
    if( responsable_id !=0){
        esteresponsable_id = "and ds.responsable_id = "+responsable_id+" ";
    }
    var estebuscar_cliente = "";
    var buscar_cliente = buscar_clie.trim();
    if(buscar_cliente != ""){
        estebuscar_cliente = "and (c.cliente_nombre like '%"+buscar_cliente+"%' or "+
                             "c.cliente_codigo like '%"+buscar_cliente+"%' or "+
                             "c.cliente_ci like '%"+buscar_cliente+"%') "
    }
    //alert(estebuscar_cliente);
    var filtro = lasfechas+esteestado_id+esteusuario_id+esteresponsable_id+estebuscar_cliente;
    */
    $.ajax({url: controlador,
           type:"POST",
           data:{},
          
           success:function(resul){     
              
                $("#resdetserv").val("- 0 -");
               var registros =  JSON.parse(resul);
           
               if (registros != null){
                 /*  if(registros.length === 0){
                       alert("No hay resultados de la busqueda.");
                   }
                    var fecha1 = "<b>DESDE: </b>"+convertDateFormat(fecha_desde);
                    var fecha2 = "<b>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;HASTA: </b>"+convertDateFormat(fecha_hasta);
                    var estado = $('#busestado_id option:selected').text(); 
                    if(estado_id !=0){
                        estado = estado+"S";
                    }
                    $('#esteestado').html(estado);
                    
                    var tecnico = "<b>TECNICO: </b>"+$('#busresponsable_id option:selected').text();
                    if(buscar_cliente !=0){
                        buscar_cliente = "<br><b>CLIENTE: </b>"+buscar_cliente;
                    }
                    $('#detalledebusqueda').html(tecnico+"<br>"+fecha1+fecha2+buscar_cliente);
                    */
                    var n = registros.length; //tamaño del arreglo de la consulta
                    $("#resdetserv").val("- "+n+" -");
                   
                    html = "";
                    var esinicio = 1;
                    var cont = 0;
                    var totaltotal   = 0;
                    var totalinsumo   = 0;
                    var totalacuenta = 0;
                    var totalutilidad = 0;
                    var totalsaldo   = 0;

                    for (var i = 0; i < n ; i++){
                        if(esinicio == 1){
                            if(registros[i]["estado_id"] == 5){
                                totalacuenta = Number(totalacuenta)   + Number(registros[i]['detalleserv_acuenta']);
                                totalutilidad = Number(totalutilidad)   + Number(registros[i]['detalleserv_acuenta']);
                            }else{
                                totalinsumo = Number(totalinsumo)   + Number(registros[i]['precioinsumo']);
                                totalsaldo   = Number(totalsaldo) + Number(registros[i]['detalleserv_saldo']);
                                totalutilidad   = Number(totalutilidad) + (Number(registros[i]['detalleserv_saldo'])-Number(registros[i]['precioinsumo']));
                            }
                            totaltotal   = Number(totaltotal)  + Number(registros[i]['detalleserv_total']);
                            html += "<tr>";

                            html += "<td>"+(cont+1)+"</td>";

                            html += "<td id='horizontal'>";
                            var nombrecliente = "";
                            if(registros[i]["cliente_nombre"] == null){ nombrecliente = "NO DEFINIDO"; }else{
                                nombrecliente = registros[i]["cliente_nombre"];
                            }
                            html += nombrecliente;
                            html += "</td>";
                            html += "<td class='text-center'>"+registros[i]["servicio_id"]+"</td>";
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+convertDateFormat(registros[i]["servicio_fecharecepcion"])+" "+registros[i]["servicio_horarecepcion"]+"</td>";
                            var fechater = "";
                            if(registros[i]['detalleserv_fechaterminado'] !=null){
                                fechater = convertDateFormat(registros[i]["detalleserv_fechaterminado"])+" "+registros[i]["detalleserv_horaterminado"]
                            }
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+fechater+"</td>";
                            var fechaentreg = "";
                            if(registros[i]['detalleserv_fechaentregado'] !=null){
                                fechaentreg = convertDateFormat(registros[i]["detalleserv_fechaentregado"])+" "+registros[i]["detalleserv_horaentregado"]
                            }
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+fechaentreg+"</td>";
                            if(registros[i]["estado_id"] == 7){
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                                html += "<td class='text-right'>0.00</td>";
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]- registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";

                            }else{
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'>0.00</td>";
                                html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</span></td>";

                            }
                            /*html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                            html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_total"]- registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                            */
                            html += "<td  class='text-center' style='background-color: #"+registros[i]["estado_color"]+"'>"+registros[i]["estado_descripcion"]+"</td>";
                            html += "<td class='text-center'>"+registros[i]["tiposerv_descripcion"]+"</td>";
                            html += "<td style='padding-left: 1px; padding-right: 1px;' >"+registros[i]["detalleserv_descripcion"]+"</td>";
                            html += "<td style='font-size: 8px; padding-left: 1px; padding-right: 1px;' >"+registros[i]["respnombre"]+"</td>";

                            html += "</tr>";
                            cont++;
                        }else if(registros[i-1]['detalleserv_id'] == registros[i]['detalleserv_id']){
                            processDatapreciosinsumos(registros[i]["detalleserv_id"], registros[i]["detalleserv_total"], registros[i]["estado_id"], registros[i]["detalleserv_saldo"]);
                            totalinsumo = Number(totalinsumo)   + Number(registros[i]['precioinsumo']);
                            if(registros[i]["estado_id"] == 7){
                                totalutilidad = Number(totalutilidad)   - Number(registros[i]['precioinsumo']);
                            }
                        }else{
                            if(registros[i]["estado_id"] == 5){
                                totalacuenta = Number(totalacuenta)   + Number(registros[i]['detalleserv_acuenta']);
                                totalutilidad = Number(totalutilidad)   + Number(registros[i]['detalleserv_acuenta']);
                            }else{
                                totalinsumo = Number(totalinsumo)   + Number(registros[i]['precioinsumo']);
                                totalsaldo   = Number(totalsaldo) + Number(registros[i]['detalleserv_saldo']);
                                totalutilidad   = Number(totalutilidad) + (Number(registros[i]['detalleserv_saldo'])-Number(registros[i]['precioinsumo']));
                            }
                            totaltotal   = Number(totaltotal)  + Number(registros[i]['detalleserv_total']);
                            html += "<tr>";

                            html += "<td>"+(cont+1)+"</td>";

                            html += "<td id='horizontal'>";
                             var nombrecliente = "";
                            if(registros[i]["cliente_nombre"] == null){ nombrecliente = "NO DEFINIDO"; }else{
                                nombrecliente = registros[i]["cliente_nombre"];
                            }
                            html += nombrecliente;
                            html += "</td>";
                            html += "<td class='text-center'>"+registros[i]["servicio_id"]+"</td>";
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+convertDateFormat(registros[i]["servicio_fecharecepcion"])+" "+registros[i]["servicio_horarecepcion"]+"</td>";
                            var fechater = "";
                            if(registros[i]['detalleserv_fechaterminado'] !=null){
                                fechater = convertDateFormat(registros[i]["detalleserv_fechaterminado"])+" "+registros[i]["detalleserv_horaterminado"]
                            }
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+fechater+"</td>";
                            var fechaentreg = "";
                            if(registros[i]['detalleserv_fechaentregado'] !=null){
                                fechaentreg = convertDateFormat(registros[i]["detalleserv_fechaentregado"])+" "+registros[i]["detalleserv_horaentregado"]
                            }
                            html += "<td style='font-size: 8px !important; padding-left: 1px; padding-right: 1px;' class='text-center'>"+fechaentreg+"</td>";
                            if(registros[i]["estado_id"] == 7){
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                                html += "<td class='text-right'>0.00</td>";
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]- registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";

                            }else{
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                                html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</td>";
                                html += "<td class='text-right'>0.00</td>";
                                html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</span></td>";

                            }
                            /*html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_total"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'><span id='esteprecioinsumo"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                            html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_acuenta"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'>"+numberFormat(Number(registros[i]["detalleserv_saldo"]).toFixed(2))+"</td>";
                            html += "<td class='text-right'><span id='totalutilidad"+registros[i]["detalleserv_id"]+"'>"+numberFormat(Number(registros[i]["detalleserv_total"]- registros[i]["precioinsumo"]).toFixed(2))+"</span></td>";
                            */
                            html += "<td  class='text-center' style='background-color: #"+registros[i]["estado_color"]+"'>"+registros[i]["estado_descripcion"]+"</td>";
                            html += "<td class='text-center'>"+registros[i]["tiposerv_descripcion"]+"</td>";
                            html += "<td style='padding-left: 1px; padding-right: 1px;' >"+registros[i]["detalleserv_descripcion"]+"</td>";
                            html += "<td style='font-size: 8px; padding-left: 1px; padding-right: 1px;' >"+registros[i]["respnombre"]+"</td>";

                            html += "</tr>";
                            cont++;
                        }
                       esinicio = 2;
                    }
                    var html1 ="<tr class='text-bold'>";
                    html1 += "<td colspan='6' class='text-right'>";
                    html1 += "TOTAL:";
                    html1 += "</td>";
                    html1 += "<td class='text-right'>"+numberFormat(Number(totaltotal).toFixed(2))+"</td>";
                    html1 += "<td></td>";
                    html1 += "<td class='text-right'>"+numberFormat(Number(totalacuenta).toFixed(2))+"</td>";
                    html1 += "<td class='text-right'>"+numberFormat(Number(totalsaldo).toFixed(2))+"</td>";
                    html1 += "<td class='text-right'>"+numberFormat(Number(totalutilidad).toFixed(2))+"</td>";
                    html1 += "</tr>";
                    /*$('#eltotal').html(numberFormat(Number(totaltotal).toFixed(2)));
                    $('#elacuenta').html(numberFormat(Number(totalacuenta).toFixed(2)));
                    $('#elsaldo').html(numberFormat(Number(totalsaldo).toFixed(2)));
                    */
                    //$("#tablaresultados").html(htmlc+html+htmls+"</table>");
                    $("#tablaresultados").html(html+html1);
                   
            }
            
        },
        error:function(resul){
          // alert("Algo salio mal...!!!");
           html = "";
           $("#resbusquedadetalleserv").html(html);
        }
        
    });   

}

async function processDatapreciosinsumos(detalleserv_id, detalleserv_total, estado_id, detalleserv_saldo) {
  try {
    const result = await precioinsumos_usado(detalleserv_id);
    
    $('#esteprecioinsumo'+detalleserv_id).html(result);
    if(estado_id == 7){
        $('#totalutilidad'+detalleserv_id).html(numberFormat(Number(detalleserv_saldo -result).toFixed(2)));
    }else{
        $('#totalutilidad'+detalleserv_id).html(numberFormat(Number(detalleserv_total -result).toFixed(2)));
    }
    return "";
  } catch (err) {
    return console.log(err.message);
  }
}

function precioinsumos_usado(detalleserv_id){
    const promise = new Promise(function (resolve, reject) {
    //var html = "";
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'servicio/obtener_preciosinsumosusados/'+detalleserv_id;
    $.ajax({url: controlador,
           type:"POST",
           data:{},
           success:function(respuesta){
               var res = "";
               var registros =  JSON.parse(respuesta);
               if (registros != null){
                    //var n = registros.length; //tamaño del arreglo de la consulta
                    /*for (var i = 0; i < n ; i++){
                        res += numberFormat(Number(registros[i]['detalleven_total']).toFixed(2));
                      //alert(html);  
                   }*/
                    res += numberFormat(Number(registros).toFixed(2));
               }
               resolve(res);
        },
        error:function(error){
            reject(error);
        }
        
    });
    });
  
  return promise;
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
