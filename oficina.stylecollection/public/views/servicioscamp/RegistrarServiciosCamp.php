<!DOCTYPE html>
<html>
<head>
  <title><?php echo SERVERURL; ?> | <?php if(!empty($action)){echo $action; } ?> <?php if(!empty($url)){echo $url;} ?></title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">

  <?php require_once 'public/views/assets/top-menu.php'; ?>

  <!-- Left side column. contains the logo and sidebar -->
  <?php require_once 'public/views/assets/menu.php'; ?>


  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <h1>
        <?php echo $modulo; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url; ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$modulo." de campaña"; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "".$modulo; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="servicio">Servicios para campaña <?php echo $n."/".$y ?></label>
                      <select class="form-control select2" id="servicio" name="servicio">
                        <option value=""></option>
                        <?php 
                          foreach ($servicioss as $data) {
                            if(!empty($data['id_servicioss'])){
                              ?>
                              <option 
                              value="<?php echo $data['id_servicioss'] ?>">
                                <?php echo $data['nombre_servicioss']; ?>
                              </option>
                              <?php
                          }
                        }
                        ?>
                      </select>
                      <span id="error_servicio" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12">
                      <hr>
                    </div>
                  </div>
                 
                  <div class="row">
                    <div class="form-group col-xs-12" style="padding:0px 30px;">
                      <?php
                        $limiteMinimoElementos=1;
                        $opcionsMostrar = 1;
                      ?>
                      <?php for($x=1; $x<=$limitesOpciones; $x++){ ?>
                        <div class="row box_opciones box_opciones<?=$x; ?> <?php if($x>$opcionsMostrar){ echo "d-none"; } ?>" id="box_opciones<?=$x; ?>">
                          <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                            <br>
                            <div style="width:14%;float:left;">
                              <label for="name_opcion<?=$x; ?>" style="font-size:1.3em;"><u>Opcion #<?=$x; ?></u></label>
                            </div>
                            <div style="width:65%;float:left;">
                              <input type="text" class="form-control" style="" id="name_opcion<?=$x; ?>" name="name_opcion[]" placeholder="Coloque nombre del servicio a la opcion #<?=$x; ?>"  value="<?php if(!empty($tppcs[($x-1)])){ echo $tppcs[($x-1)]['nombre_premio']; }; ?>">
                              <span id="error_name_opcion<?=$x; ?>" class="errors" style=""></span>
                            </div>
                            <div style="width:20%;float:left;">
                              <input type="number" class="form-control" step="0.01" style="" id="precio_opcion<?=$x; ?>" name="precio_opcion[]">
                              <span id="error_precio_opcion<?=$x; ?>" class="errors" style=""></span>
                            </div>
                            <div style="clear:both;"></div>
                            <br>
                          </div>
                          <br>
                          <div class="form-group col-xs-12 w-100 <?php if($adicionalesSoloPagoDeSeleccion){ echo "d-none"; } ?>">
                            <?php if($x<$limitesOpciones){ ?>
                              <span id="addMoreOp<?=$x; ?>" min="<?=$x; ?>" class="addMoreOp btn btn-success"><b>+</b></span>
                            <?php  } ?>
                            <?php if($x>=2){ ?>
                              <span id="addMenosOp<?=$x; ?>" min="<?=$x; ?>" class="addMenosOp btn btn-danger"><b>-</b></span>
                            <?php  } ?>
                          </div>
                        </div>
                      <?php } ?>
                      <input type="hidden" name="cantidad_opciones" id="cantidad_opciones" value="<?=$opcionsMostrar; ?>">

                    </div>
                  </div>




              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                <input type="hidden" id="limiteOpciones" value="<?=$limitesOpciones; ?>">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled="" >enviar</button>
              </div>
            </form>
          </div>

        </div>
        <!--/.col (left) -->

        
      </div>
      <!-- /.row -->
    </section>
    <!-- /.content -->
  </div>
  <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<?php endif; ?>

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
.addMore, .addMenos, .addMoreOp, .addMenosOp{
  border-radius:40px;
  border:1px solid #CCC;
}
.addMore, .addMenos{
  margin-top:15px;
}
.titleMayus{
  text-transform:uppercase;
}
</style>
<script>
$(document).ready(function(){

  var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=ServiciosCamp";
      });
    }
    if(response == "2"){
-      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
  }

  $(".box_inventario_tipo.d-none").hide();
  $(".box_inventario_tipo.d-none").removeClass("d-none");

  $(".box_opciones.d-none").hide();
  $(".box_opciones.d-none").removeClass("d-none");
  
  // $("#box_tipoinicial2").show();
  $(".addMoreOp").click(function(){
    var id = $(this).attr('id');
    var index = $(this).attr('min');
    // var num = $(this).attr('max');
    alimentarBoxTipo(index);
  });

  $(".addMenosOp").click(function(){
    var id = $(this).attr('id');
    var index = $(this).attr('min');
    var num = $(this).attr('max');
    retroalimentarBoxTipo(index, num);
  });

  function alimentarBoxTipo(){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_opciones").val());
    $("#addMoreOp"+cant).hide();
    $("#addMenosOp"+cant).hide();
    cant++;
    $("#box_opciones"+cant).show();
    $("#cantidad_opciones").val(cant);
  }

  function retroalimentarBoxTipo(){
    var cant = parseInt($("#cantidad_opciones").val());
    $("#box_opciones"+cant).hide();
    cant--;
    $("#addMoreOp"+cant).show();
    $("#addMenosOp"+cant).show();
    $("#cantidad_opciones").val(cant);
  }
  $(".addMore").click(function(){
      var id=$(this).attr('id');
    var index=$(this).attr('min');
    // var num=$(this).attr('max');
    alimentarFormInventario(index);
  });

  $(".addMenos").click(function(){
    var id=$(this).attr('id');
    var index=$(this).attr('min');
    // var num=$(this).attr('max');
    retroalimentarFormInventario(index);
  });

  function alimentarFormInventario(index){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementosOp"+index).val());
    $("#addMore"+index+cant).hide();
    $("#addMenos"+index+cant).hide();
    cant++;
    $("#box_tipo"+index+cant).show();
    $("#cantidad_elementosOp"+index).val(cant);
  }
  function retroalimentarFormInventario(index){
    var cant = parseInt($("#cantidad_elementosOp"+index).val());
    $("#box_tipo"+index+cant).hide();
    cant--;
    $("#addMore"+index+cant).show();
    $("#addMenos"+index+cant).show();
    $("#cantidad_elementosOp"+index).val(cant);
  }
  $(".seleccion_inventario").on('change', function(){
    var value = $(this).val();
    var index = $(this).attr('min');
    if(value!=""){
      var pos = value.indexOf('m');
      if(pos>=0){ //Mercancia
        $("#tipo"+index).val('Mercancia');
      }else if(pos < 0){ //Productos
        $("#tipo"+index).val('Productos');
      }
    }else{
      $("#tipo"+index).val('');
    }
    
  });

  $(".unidades").on('change keyup', function(){
    var index=$(this).attr("data-indexTwo");
    var cant = parseInt($("#cantidad_elementosOp"+index).val());
    var total = 0;
    for (let z=1; z <= cant; z++) {
      var stocks = $("#unidad"+index+z).val();
      if(stocks!=""){
        stocks = parseFloat(stocks);
      }
      var precios = $("#precio"+index+z).val();
      if(precios!=""){
        precios = parseFloat(precios);
      }
      if(stocks!="" && precios!=""){
        var operation = stocks*precios;
        total = total+operation;
      }
    }
    $("#precio_opcion"+index).val(total);
  });
  $(".precios").on('change keyup', function(){
    var index=$(this).attr("data-indexTwo");
    var cant = parseInt($("#cantidad_elementosOp"+index).val());
    var total = 0;
    for (let z=1; z <= cant; z++) {
      var stocks = $("#unidad"+index+z).val();
      if(stocks!=""){
        stocks = parseFloat(stocks);
      }
      var precios = $("#precio"+index+z).val();
      if(precios!=""){
        precios = parseFloat(precios);
      }
      if(stocks!="" && precios!=""){
        var operation = stocks*precios;
        total = total+operation;
      }
    }
    $("#precio_opcion"+index).val(total);
  });
  
  // $(".seleccion_inventario").on('change', function(){
  //   var value = $(this).val();
  //   var index = $(this).attr('min');
  //   if(value!=""){
  //     var pos = value.indexOf('m');
  //     if(pos>=0){ //Mercancia
  //       $("#tipo"+index).val('Mercancia');
  //     }else if(pos < 0){ //Productos
  //       $("#tipo"+index).val('Productos');
  //     }
  //   }else{
  //     $("#tipo"+index).val('');
  //   }
  // });
    
  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");

      swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
        }).then((isConfirm) => {
          if (isConfirm.value){
            // $(".btn-enviar").removeAttr("disabled");
            // $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         nombre: $("#nombre").val(),
              //         precio: $("#precio").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                //       }
                //       if (respuesta == "9"){
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Los datos ingresados estan repetidos!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //     }
                // });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });

    } //Fin condicion

  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var servicio = $("#servicio").val();
  // var rnombre = checkInput(nombre, alfanumericPattern2);
  // if( rnombre == false ){
  if(servicio==""){
    rservicio=false;
    $("#error_servicio").html("Debe seleccionar el servicio");      
  }else{
    rservicio=true;
    $("#error_servicio").html("");
  }
  
  // /*===================================================================*/
  var opciones = $("#cantidad_opciones").val();
  var errores = 0;
  for (let x=1; x<=opciones; x++) {
    var nombre = $("#name_opcion"+x).val();
    if(nombre==""){
      errores++;
      $("#error_name_opcion"+x).html("Debe agregar un nombre para la opción #"+x);
    }else{
      $("#error_name_opcion"+x).html("");
    }

    var precio = $("#precio_opcion"+x).val();
    if(precio=="" || precio==0){
      errores++;
      $("#error_precio_opcion"+x).html("Debe agregar un precio para la opción #"+x);
    }else{
      $("#error_precio_opcion"+x).html("");
    }

  }



  var roperaciones = false;
  if(errores==0){
    roperaciones = true;
  }


  /*===================================================================*/
  var result = false;
  if( rservicio==true && roperaciones==true ){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  // alert(result);
  return result;
}

</script>
</body>
</html>
