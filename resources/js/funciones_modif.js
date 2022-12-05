$(document).on("ready",inicio);
function inicio(){
    let la_comuna = $('#la_comuna').val();
    if(la_comuna != "" && la_comuna != null){
        mostrar_distritomodif()
    }
}

/* registra los distritos segun se elija la comuna */
function mostrar_distritomodif(){
    let la_comuna = $('#la_comuna').val();
    html = "";
    if(la_comuna == "TUNARI"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='1'>Distrito: 1 </option>";
        html += "    <option value='2'>Distrito: 2 </option>";
        html += "    <option value='13'>Distrito: 13 </option>";
        html += "</select>";
    }else if(la_comuna == "V. HERMOSO"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='6'>Distrito: 6 </option>";
        html += "    <option value='7'>Distrito: 7 </option>";
        html += "    <option value='14'>Distrito: 14 </option>";
        html += "</select>";
    }else if(la_comuna == "A. CALATAYUD"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='5'>Distrito: 5 </option>";
        html += "    <option value='8'>Distrito: 8 </option>";
        html += "</select>";
    }else if(la_comuna == "MOLLE"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='3'>Distrito: 3 </option>";
        html += "    <option value='4'>Distrito: 4 </option>";
        html += "</select>";
    }else if(la_comuna == "ITOCTA"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='9'>Distrito: 9 </option>";
        html += "    <option value='15'>Distrito: 15 </option>";
        html += "</select>";
    }else if(la_comuna == "A. ZAMUDIO"){
        html += "<select id='el_distrito' name='el_distrito' class='btn btn-default btn-xs' style='width: 120px;'>";
        html += "    <option value='10'>Distrito: 10 </option>";
        html += "    <option value='11'>Distrito: 11 </option>";
        html += "    <option value='12'>Distrito: 12 </option>";
        html += "</select>";
    }
    $('#distrito').html(html);
}