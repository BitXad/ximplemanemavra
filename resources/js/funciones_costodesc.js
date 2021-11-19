function registrarnuevadescripcion(){
    var base_url  = document.getElementById('base_url').value;
    let parametro = document.getElementById('nueva_descripcion').value;
    var controlador = base_url+'costo_descripcion/aniadirdescripcion/';
    if(parametro.trim() == ""){
        $("#mensajemodal").html("Este campo no debe estar vacio!.");
        $("#nueva_descripcion").val("");
    }else{
        $('#modaldescripcion').modal('hide');
        $.ajax({url: controlador,
               type:"POST",
               data:{parametro:parametro},
               success:function(respuesta){
                   var registros =  JSON.parse(respuesta);

                   if (registros != null){
                        html = "";
                        html += "<option value='"+registros["costodesc_id"]+"' selected >";
                        html += registros["costodesc_descripcion"];
                        html += "</option>";
                        $("#costodesc_id").append(html);
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
    $('#nueva_descripcion').val("");
    $("#mensajemodal").html("");
    $(function () {
      $('#modaldescripcion').on('shown.bs.modal', function (e) {
        $('#nueva_descripcion').focus();
      })
    });
}