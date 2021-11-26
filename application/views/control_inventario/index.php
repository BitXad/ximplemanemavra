<input type="hidden" name="base_url" id="base_url" value="<?php echo base_url(); ?>" />
<!----------------------------- script buscador --------------------------------------->
<script type="text/javascript">
        $(document).ready(function () {
            (function ($) {
                $('#filtrar').keyup(function () {
                    var rex = new RegExp($(this).val(), 'i');
                    $('.buscar tr').hide();
                    $('.buscar tr').filter(function () {
                        return rex.test($(this).text());
                    }).show();
                })
            }(jQuery));
        });
</script>
<link href="<?php echo base_url('resources/css/mitabla.css'); ?>" rel="stylesheet">
<!-------------------------------------------------------->
<style>
 .button_add{
    position: static;
    right: 20vw;
    height: 13vh;
    top: -15px;
    /* z-index: 0; */
    font-size: 60px;
    /* color: rgba(0, 0, 0, 0.15); */
}
.small-box{
    color: black !important;
    font-family: Arial, Helvetica, sans-serif;
    font-size: 10pt;
}
.icon{
    font-size: 70px !important;
    right: 40px !important;
}

.cuadro_fondo{
    margin: 10px;
    width: 50em;
    display: inline-block;;
}

.forma{
    clip-path: polygon(66%   0%, 100% 0%, 66% 100%, 33% 100%);
}
</style>
<div class="box-header">
    <font size='4' face='Arial'><b>Control de producción</b></font>    
    <!-- <button class="btn btn-success btn-sm" style="float: right;">+ Añadir producci&oacute;n</button>  -->
</div>
<div class="row">
    <div class="col-md-12">
        <div class="box-tools">
            <div class="col-md-12">
                <div class="col-md-2">
                    &Aacute;reas: 
                    <select id="area_id" class="btn btn-primary" name="select_estado" id="select_estado" onchange="get_platabandas()">
                        <!-- <option value="0">Escoge una &aacute;rea</option> -->
                        <?php foreach ($areas as $a){ ?>
                            <option value="<?= $a['area_id'] ?>"><?= $a['area_nombre'] ?></option>
                        <?php } ?>
                    </select>
                </div> 
            </div>
        </div>

        <div><br><br></div>
        <div class="box">
            <div class="box-body">
                <section id="platabandas" class="row"></section>
                <!-- <div class="center">
                    <div class="imgBox">
                        <div class="container">
                            <div class="content">
                                <h1>Lorem ipsum facilis!</h1>
                                <p>Lorem ipsum dolor sit amet consectetur adipisicing elit. Obcaecati dolorum aliquid error nobis ratione nemo ad odio modi ducimus pariatur, molestias maiores excepturi explicabo ipsum animi sed dolor non id?</p>
                            </div>
                        </div>
                        <div class="content-img">

                            <img class="forma" src="https://s1.significados.com/foto/rosa-roja_bg.jpg" alt="">
                            <img class="forma" src="https://s1.significados.com/foto/rosa-roja_bg.jpg" alt="">
                        </div>
                    </div>
                </div> -->

                
                
            </div>
        </div>
        <div class="modal fade" id="modal_info_platabanda" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: inline;">Platabanda: <span id="platabanda_number"></span></h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">
                            <span aria-hidden="true" style="padding-right: 10px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="modal_infor_platabanda"></div>
                        
                    </div>            
                </div>
            </div>
        </div>
        <div class="modal fade" id="modal_info_platabanda2" tabindex="-1" role="dialog" aria-labelledby="modal_ubicacion" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" style="display: inline;">Platabanda #1</h4>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close" style="color: red">
                            <span aria-hidden="true" style="padding-right: 10px;">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="row" id="modal_infor_platabanda"></div>  
                    </div>            
                </div>
            </div>
        </div>
    </div>
</div>
<script src="<?php echo base_url('resources/js/jquery-2.2.3.min.js'); ?>" type="text/javascript(){}"></script>
<script src="<?php echo base_url('resources/js/platabanda.js'); ?>"></script>