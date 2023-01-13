$(document).on("ready",inicio);
function inicio(){
      //  tabla_inventario();
}

function tabla_inventario(){
    var base_url = document.getElementById("base_url").value;
    var parametro = document.getElementById("filtrar").value;
    var fecha_desde = document.getElementById("fecha_desde").value;
    var fecha_hasta = document.getElementById("fecha_hasta").value;
    var controlador = base_url+"inventario/mostrar_fvaloradope";
    
    document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    var nombre_moneda = document.getElementById('nombre_moneda').value;
    var lamoneda_id = document.getElementById('lamoneda_id').value;
    var lamoneda = JSON.parse(document.getElementById('lamoneda').value);
    var total_otramoneda = Number(0);
    var total_otram = Number(0);
    var tipo_reporte = 2;
   //*********************** tipo_reporte 2 ************************************** 
    if (tipo_reporte == 2){
        
    $.ajax({
        url: controlador,
        type:"POST",
        data:{parametro:parametro, fecha_desde:fecha_desde, fecha_hasta:fecha_hasta},
        success: function(resultado){
            
            var inv = JSON.parse(resultado);
            var tamanio = inv.length;
            //alert(tamanio);
            
            html = "";
            html2 = "";
            html2 += "<table class='table table-striped table-bordered' id='mitabla'>";
                        html2 += "<tr>";
                            html2 += "<th style='padding: 1px;' colspan='2' class='text-center'></th>";
                            html2 += "<th style='padding: 1px;' colspan='5' class='text-center'>INGRESOS</th>";
                            html2 += "<th style='padding: 1px;' colspan='11' class='text-center'>EGRESOS</th>";
                            html2 += "<th style='padding: 1px;' colspan='2' class='text-center'>SALDOS</th>";
                        html2 += "</tr>";
                        html2 += "<tr>";
                            html2 += "<th style='padding: 1px;' colspan='2' class='text-center'></th>";
                            html2 += "<th style='padding: 1px;' colspan='3' class='text-center'>FISICO</th>";
                            html2 += "<th style='padding: 1px;' colspan='2' class='text-center'>VALORADO</th>";
                            html2 += "<th style='padding: 1px;' colspan='8' class='text-center'>FISICO</th>";
                            html2 += "<th style='padding: 1px;'></th>";
                            html2 += "<th style='padding: 1px;' colspan='2'>VALORADO</th>";
                            html2 += "<th style='padding: 1px;'>FISICO</th>";
                            html2 += "<th style='padding: 1px;'>VALORADO</th>";
                        html2 += "</tr>";
                        html2 += "<tr>";
                            html2 += "<th>N°</th>";
                            html2 += "<th>ESPECIES</th>";
                            html2 += "<th>SALDO</th>";
                            html2 += "<th style='writing-mode: sideways-lr;'>PRODUCCION</th>";
                            html2 += "<th>TOTAL</th>";
                            html2 += "<th>COSTO DE PRODUCCION(BS)</th>";
                            html2 += "<th>IMPORTE TOTAL Bs PROD.</th>";
                            html2 += "<th>MANTENIMIENTO</th>";
                            html2 += "<th>PROYECTOS</th>";
                            html2 += "<th>PARQUES</th>";
                            html2 += "<th>VENTA</th>";
                            html2 += "<th>TRASPASO V. PILI HUACHANA</th>";
                            html2 += "<th>MORTANDAD</th>";
                            html2 += "<th>CAMBIO PORTE</th>";
                            html2 += "<th>TOTAL</th>";
                            html2 += "<th>IMPORTE TOTAL Bs EGRESOS(Bs)</th>";
                            html2 += "<th>COSTO UNITARIO (Bs)</th>";
                            html2 += "<th>IMPORTE TOTAL Bs PROD. (Bs)</th>";
                            html2 += "<th>FISICO</th>";
                            html2 += "<th>VALORADO</th>";
                        html2 += "</tr>";
                    html += html2;                   
                    html += "<tbody class='buscar'>";
            var totalfinal_saldoinicial = Number(0);
            var totalfinal_produccion = Number(0);
            var totalfinal_ingresototal = Number(0);
            var totalfinal_importetotal = Number(0);
            var totalfinal_mantenimiento = Number(0);
            var totalfinal_proyectos = Number(0);
            var totalfinal_parques = Number(0);
            var totalfinal_venta = Number(0);
            var totalfinal_traspaso = Number(0);
            var totalfinal_mortandad = Number(0);
            var totalfinal_cambioporte = Number(0);
            var totalfinal_egresototal = Number(0);
            var totalfinal_importeegreso = Number(0);
            var totalfinal_importetotalvalorado = Number(0);
            var totalfinal_saldofisico = Number(0);
            var totalfinal_saldovalorado = Number(0);               

            if (inv != null){
                const myString = JSON.stringify(inv);
                $("#resinventario").val(myString);
                    var total = 0;
                    var total_final = 0;
                    var existencia = 0;
                    var inicial = 0;
                    var margen = " style='padding:0'";
                    var categoria = "";
                    
                for (var i = 0; i < tamanio ; i++){
                    //alert('dentra aqui: '+i+"/"+tamanio);
                    if (categoria != inv[i]["categoria_nombre"]){
                        html += "<tr style='background-color: #bcc2c4;'><td colspan='20' style='padding: 1px'><b>"+inv[i]["categoria_nombre"]+"<b></tr>";
                    }
                        html += "<tr "+margen+">";
                                    total = inv[i]["producto_costo"]*inv[i]["existencia"]; 
                                    total_final += total;
                                    existencia = parseFloat(inv[i]["existencia"]);
                        inicial =  Number(Number(inv[i]["cantidad_compraant"])-Number(inv[i]["cantidad_ventaant"]));
                        producto_total = Number(Number(inicial)+Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]));
                        
                        totalfinal_saldoinicial += Number(inicial);
                        totalfinal_produccion += Number(Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]));
                        totalfinal_ingresototal += Number(producto_total);
                        totalfinal_importetotal += Number(Number(inv[i]["producto_costo"])*Number(producto_total));
                        totalfinal_mantenimiento += Number(inv[i]["cantidad_mantenimiento"]);
                        totalfinal_proyectos += Number(inv[i]["cantidad_proyecto"]);
                        totalfinal_parques += Number(inv[i]["cantidad_parque"]);
                        totalfinal_venta += Number(inv[i]["cantidad_venta"]);
                        totalfinal_traspaso += Number(inv[i]["cantidad_traspaso"]);
                        totalfinal_mortandad += Number(Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"]));
                        totalfinal_cambioporte += Number(inv[i]["cantidad_cambioporte"]);
                        //total_egreso = Number(Number(inv[i]["cantidad_mantenimiento"])+Number(inv[i]["cantidad_proyecto"])+Number(inv[i]["cantidad_parque"])+Number(inv[i]["cantidad_venta"])+Number(inv[i]["cantidad_traspaso"])+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])).toFixed(0);
                        total_egreso = Number(Number(inv[i]["cantidad_mantenimiento"])+Number(inv[i]["cantidad_proyecto"])+Number(inv[i]["cantidad_parque"])+Number(inv[i]["cantidad_venta"])+Number(inv[i]["cantidad_traspaso"])+Number(inv[i]["cantidad_cambioporte"])+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])).toFixed(0);
                        total_egresomoney = Number(Number(inv[i]["total_ventamantenimiento"])+Number(inv[i]["total_ventaproyecto"])+Number(inv[i]["total_ventaparque"])+Number(inv[i]["total_ventavarios"])+Number(inv[i]["total_ventatraspaso"])+Number(inv[i]["total_ventacambioporte"])+Number(inv[i]["total_ventamortandad"]));
                        totalfinal_egresototal += Number(total_egreso);
                        totalfinal_importeegreso += Number(total_egresomoney);
                        totalfinal_importetotalvalorado += Number(Number(total_egreso)*Number(inv[i]["producto_costo"]));
                        totalfinal_saldofisico += Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])));
                        totalfinal_saldovalorado += Number(Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])))*Number(inv[i]["producto_costo"]));
                                    
                        html += "             	<td "+margen+">"+(i+1)+"</td>";
                        html += "             	<td "+margen+"><font size='0.5'>"+ inv[i]["producto_nombre"]+"</font>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ inicial+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>";
                                                html += Number(Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]));
                                        html += "</b></font></td>";
                                        
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ producto_total+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ inv[i]["producto_costo"]+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(Number(inv[i]["producto_costo"])*Number(producto_total)).toFixed(2)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_mantenimiento"]).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_proyecto"]).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_parque"]).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_venta"]).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_traspaso"]).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])).toFixed(0)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+ Number(inv[i]["cantidad_cambioporte"]).toFixed(0)+"</b></font></td>";
                        
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+total_egreso+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+Number(total_egresomoney).toFixed(2)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+Number(inv[i]["producto_costo"])+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+Number(Number(total_egreso)*Number(inv[i]["producto_costo"])).toFixed(2)+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])))+"</b></font></td>";
                        html += "             	<td "+margen+" class='text-right'><font size='1'><b>"+Number(Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])))*Number(inv[i]["producto_costo"])).toFixed(2)+"</b></font></td>";
                        
                        html += "</tr>";
                        
                   categoria = inv[i]["categoria_nombre"];     
                } // end for (i = 0 ....)
            } //end if (inv != null){
                html += "</tbody>";
                html += "<tr>";
                            html += "<th style='padding: 1px;' colspan='2' class='text-center'>TOTALES</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_saldoinicial.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_produccion.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_ingresototal.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px;'></th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_importetotal.toFixed(2))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_mantenimiento.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_proyectos.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_parques.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_venta.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_traspaso.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_mortandad.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_cambioporte.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_egresototal.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_importeegreso.toFixed(2))+"</th>";
                            html += "<th style='padding: 1px;'></th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_importetotalvalorado.toFixed(2))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_saldofisico.toFixed(0))+"</th>";
                            html += "<th style='padding: 1px; text-align: right'>"+numberFormat(totalfinal_saldovalorado.toFixed(2))+"</th>";
                        html += "</tr>";
                html += "</table>";            
                $("#tabla_inventario").html(html);
                
            }, // end succes: function(resultados){
            error:function(resultado){
                //alert('ocurrio un error..!!');
            },
            complete: function (jqXHR, textStatus) {
                document.getElementById('loader').style.display = 'none'; //muestra el bloque del loader 
            }
         }); // close ajax        
    } 
    //  document.getElementById('loader').style.display = 'none'; //muestra el bloque del loader
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
function validar(e,opcion) {
  tecla = (document.all) ? e.keyCode : e.which;
    if (tecla==13){ 
        if (opcion == 1){   //Si la accecion proviene de la casilla de parametro de busqueda de inventario
            tabla_inventario();
        }
    }
}

function generarexcel(){
    var base_url = document.getElementById('base_url').value;
    var controlador = base_url+'inventario/generar_excel';    
    var showLabel = true;
    var reportitle = moment(Date.now()).format("DD/MM/YYYY H_m_s");
    //document.getElementById('loader').style.display = 'block'; //muestra el bloque del loader
    var respuesta = document.getElementById('resinventario').value;
    var inv =  JSON.parse(respuesta);
    var tam = inv.length;
    var nombre_moneda = document.getElementById('nombre_moneda').value;
    var lamoneda_id = document.getElementById('lamoneda_id').value;
    var lamoneda = JSON.parse(document.getElementById('lamoneda').value);
    var otramoneda_nombre = "";
    var total_otram = Number(0);
    var totalfinal_saldoinicial = Number(0);
    var totalfinal_produccion = Number(0);
    var totalfinal_ingresototal = Number(0);
    var totalfinal_importetotal = Number(0);
    var totalfinal_mantenimiento = Number(0);
    var totalfinal_proyectos = Number(0);
    var totalfinal_parques = Number(0);
    var totalfinal_venta = Number(0);
    var totalfinal_traspaso = Number(0);
    var totalfinal_mortandad = Number(0);
    var totalfinal_cambioporte = Number(0);
    var totalfinal_egresototal = Number(0);
    var totalfinal_importeegreso = Number(0);
    var totalfinal_importetotalvalorado = Number(0);
    var totalfinal_saldofisico = Number(0);
    var totalfinal_saldovalorado = Number(0);
    var total = 0;
    var total_final = 0;
    var existencia = 0;
    var inicial = 0;
    html = "";
    if(tam>0){
      /* **************INICIO Generar Excel JavaScript************** */
        var CSV = 'sep=,' + '\r\n\n';
        //This condition will generate the Label/Header
        if(showLabel){
            var row = "";
            //This loop will extract the label from 1st index of on array
                //Now convert each value to string and comma-seprated
                row += 'N°,';
                row += 'ESPECIES,';
                row += 'SALDO,';
                row += 'PRODUCCION,';
                row += 'TOTAL,';
                row += 'COSTO DE PRODUCCION,';
                row += 'IMPORTE TOTAL Bs PROD.,';
                row += 'MATENIMIENTO,';
                row += 'PROYECTOS,';
                row += 'PARQUES,';
                row += 'VENTA,';
                row += 'TRASPASO V. PILI HUACHANA,';
                row += 'MORTANDAD,';
                row += 'CAMBIO PORTE,';
                row += 'TOTAL,';
                row += 'IMPORTE TOTAL Bs EGRESO,';
                row += 'COSTO UNITARIO,';
                row += 'IMPORTE TOTAL Bs PROD.,';
                row += 'FISICO,';
                row += 'VALORADO,';
            row = row.slice(0, -1);

            //append Label row with line break
            CSV += row + '\r\n';
        }
        var categoria = "";
        var cont = 0;
        //1st loop is to extract each row
        for (var i = 0; i < tam; i++) {
            var row = "";
            if(categoria != inv[i]["categoria_nombre"]){
                row += '"' +inv[i]["categoria_nombre"]+ '",';
                row += '\r\n';
                cont = 0;
            }
            //2nd loop will extract each column and convert it in string comma-seprated
            total = inv[i]["producto_costo"]*inv[i]["existencia"]; 
            total_final += total;
            existencia = parseFloat(inv[i]["existencia"]);
            inicial =  Number(Number(inv[i]["cantidad_compraant"])-Number(inv[i]["cantidad_ventaant"]));
            producto_total = Number(Number(inicial)+Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]));

            totalfinal_saldoinicial += Number(inicial);
            totalfinal_produccion += Number(Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]));
            totalfinal_ingresototal += Number(producto_total);
            totalfinal_importetotal += Number(Number(inv[i]["producto_costo"])*Number(producto_total));
            totalfinal_mantenimiento += Number(inv[i]["cantidad_mantenimiento"]);
            totalfinal_proyectos += Number(inv[i]["cantidad_proyecto"]);
            totalfinal_parques += Number(inv[i]["cantidad_parque"]);
            totalfinal_venta += Number(inv[i]["cantidad_venta"]);
            totalfinal_traspaso += Number(inv[i]["cantidad_traspaso"]);
            totalfinal_mortandad += Number(Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"]));
            totalfinal_cambioporte += Number(inv[i]["cantidad_cambioporte"]);
            //total_egreso = Number(Number(inv[i]["cantidad_mantenimiento"])+Number(inv[i]["cantidad_proyecto"])+Number(inv[i]["cantidad_parque"])+Number(inv[i]["cantidad_venta"])+Number(inv[i]["cantidad_traspaso"])+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])).toFixed(0);
            total_egreso = Number(Number(inv[i]["cantidad_mantenimiento"])+Number(inv[i]["cantidad_proyecto"])+Number(inv[i]["cantidad_parque"])+Number(inv[i]["cantidad_venta"])+Number(inv[i]["cantidad_traspaso"])).toFixed(0);
            total_egresomoney = Number(Number(inv[i]["total_ventamantenimiento"])+Number(inv[i]["total_ventaproyecto"])+Number(inv[i]["total_ventaparque"])+Number(inv[i]["total_ventavarios"])+Number(inv[i]["total_ventatraspaso"]));
            totalfinal_egresototal += Number(total_egreso);
            totalfinal_importeegreso += Number(total_egresomoney);
            totalfinal_importetotalvalorado += Number(Number(total_egreso)*Number(inv[i]["producto_costo"]));
            totalfinal_saldofisico += Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])+Number(inv[i]["cantidad_cambioporte"])));
            totalfinal_saldovalorado += Number(Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])+Number(inv[i]["cantidad_cambioporte"])))*Number(inv[i]["producto_costo"]));
            row += '"' +(cont+1)+ '",';
            row += '"' +inv[i]["producto_nombre"]+ '",';
            row += '"' +inicial+ '",';
            row += '"' +Number(Number(inv[i]["cantidad"])+Number(inv[i]["cantidad_compra"]))+ '",';
            row += '"' +producto_total+ '",';
            row += '"' +inv[i]["producto_costo"]+ '",';
            row += '"' +Number(Number(inv[i]["producto_costo"])*Number(producto_total)).toFixed(2)+ '",';
            row += '"' +Number(inv[i]["cantidad_mantenimiento"]).toFixed(0)+ '",';
            row += '"' +Number(inv[i]["cantidad_proyecto"]).toFixed(0)+ '",';
            row += '"' +Number(inv[i]["cantidad_parque"]).toFixed(0)+ '",';
            row += '"' +Number(inv[i]["cantidad_venta"]).toFixed(0)+ '",';
            row += '"' +Number(inv[i]["cantidad_traspaso"]).toFixed(0)+ '",';
            row += '"' +Number(Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])).toFixed(0)+ '",';
            row += '"' +Number(inv[i]["cantidad_cambioporte"]).toFixed(0)+ '",';
            row += '"' +total_egreso+ '",';
            row += '"' +Number(total_egresomoney).toFixed(2)+ '",';
            row += '"' +Number(inv[i]["producto_costo"])+ '",';
            row += '"' +Number(Number(total_egreso)*Number(inv[i]["producto_costo"])).toFixed(2)+ '",';
            row += '"' +Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])+Number(inv[i]["cantidad_cambioporte"])))+ '",';
            row += '"' +Number(Number(Number(producto_total)-Number(Number(total_egreso)+Number(inv[i]["cantidad_mortandad"])+Number(inv[i]["cantidad_perdida"])+Number(inv[i]["cantidad_cambioporte"])))*Number(inv[i]["producto_costo"])).toFixed(2)+ '",';
            row.slice(0, row.length - 1);
            //add a line break after each row
            CSV += row + '\r\n';
            categoria = inv[i]["categoria_nombre"];
            cont++;
        }
        
        row = '\r\n';
        row += '\r\n';
        row += ',';
        row += '"TOTALES",';
        row += '"' +numberFormat(totalfinal_saldoinicial.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_produccion.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_ingresototal.toFixed(0))+ '",';
        row += ',';
        row += '"' +numberFormat(totalfinal_importetotal.toFixed(2))+ '",';
        row += '"' +numberFormat(totalfinal_mantenimiento.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_proyectos.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_parques.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_venta.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_traspaso.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_mortandad.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_cambioporte.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_egresototal.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_importeegreso.toFixed(2))+ '",';
        row += ',';
        row += '"' +numberFormat(totalfinal_importetotalvalorado.toFixed(2))+ '",';
        row += '"' +numberFormat(totalfinal_saldofisico.toFixed(0))+ '",';
        row += '"' +numberFormat(totalfinal_saldovalorado.toFixed(2))+ '",';
        row += '\r\n';
        CSV += row + '\r\n';
        if (CSV == '') {        
            alert("Invalid data");
            return;
        }

        //Generate a file name
        var fileName = "Inventario_";
        //this will remove the blank-spaces from the title and replace it with an underscore
        fileName += reportitle.replace(/ /g,"_");   

        //Initialize file format you want csv or xls
        var uri = 'data:text/csv;charset=utf-8,' + escape(CSV);

        // Now the little tricky part.
        // you can use either>> window.open(uri);
        // but this will not work in some browsers
        // or you will not get the correct file extension    

        //this trick will generate a temp <a /> tag
        var link = document.createElement("a");    
        link.href = uri;

        //set the visibility hidden so it will not effect on your web-layout
        link.style = "visibility:hidden";
        link.download = fileName + ".csv";

        //this part will append the anchor tag and remove it after automatic click
        document.body.appendChild(link);
        link.click();
        document.body.removeChild(link);
        /* **************F I N  Generar Excel JavaScript************** */
       //document.getElementById('loader').style.display = 'none';
    }
    //document.getElementById('loader').style.display = 'none'; //ocultar el bloque del loader
}

/* imprimir */
function imprimir_fv(){
    var parametro = document.getElementById("filtrar").value;
    var fecha_desde = document.getElementById("fecha_desde").value;
    var a = moment(fecha_desde).format("DD/MM/YYYY");
    var fecha_hasta = document.getElementById("fecha_hasta").value;
    var b = moment(fecha_hasta).format("DD/MM/YYYY");
    $("#esdesde").html(a);
    $("#eshasta").html(b);
    if(parametro != ""){
        $("#esparametro").html("<br><span class='text-bold'>Producto: </span>"+parametro);
    }
    $("#lafecha").css("display", "block");
    window.print();
    $("#lafecha").css("display", "none");
}
