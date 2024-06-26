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
        <?php echo "Planes de Campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Planes"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " Planes de Campaña"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Planes"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Planes de Campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Planes de campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                <span class="d-none json_pagos"><?php echo json_encode($cantidadPagosDespachosFild); ?></span>
                
                <?php foreach ($planes_campana as $data) { if(!empty($data['id_plan_campana'])){ ?>
                  <div class="row">
                    <?php //echo $data['id_plan_campana']; ?>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="planes">Plan para campaña <?php echo $n ?></label>
                       <select class="form-control select2" id="planes" name="planes">
                        <!-- <option value=""></option> -->
                        <option value="<?php echo $data['id_plan'] ?>"><?php echo $data['nombre_plan']; ?></option>
                       </select>
                       <span id="error_planes" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="colorPlan">Color de Plan</label>
                      <input type="color" class="form-control" name="color_plan" value="<?=$data['color_plan']?>">
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12">
                       <label for="opcion_plan">Opción adicional de Plan</label>
                       <select id="opcion_plan" name="opcion_plan" class="form-control select2" style="width:100%">
                         <?php foreach ($opcionesSeconds as $key){ ?>
                           <option value="<?=$key['id']; ?>" id="<?=$key['id']; ?>" <?php if($data['opcion_plan']==$key['id']){ echo "selected"; } ?> ><?=$key['name']; ?></option>
                         <?php } ?>
                       </select>
                       <span id="error_opcion_plan" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <div class="form-group col-xs-12">
                       <label for="descuento_directo">Descuento directo</label>
                       <div class="input-group">
                        <span class="input-group-addon">$</span> 
                        <input type="number" class="form-control" step=".1"  value="<?php echo $data['descuento_directo'] ?>" id="descuento_directo" name="descuento_directo" maxlength="30" placeholder="Descuento directo de coleccion">
                       </div>
                       <span id="error_descuento_directo" class="errors"></span>
                    </div>
                  </div>

                  <div class="row">
                    <?php foreach ($cantidadPagosDespachosFild as $cpfill){ if(!empty($cpfill['name'])){ ?>
                      <div class="form-group col-xs-6" style="margin-bottom:35px;">
                        <label for="descuento_<?=$cpfill['id']; ?>">
                          Descuento de <?=mb_strtolower($cpfill['name']); ?> puntual
                        </label>
                        
                        <?php 
                          $valInputtemp = 0;
                          foreach ($pagos_planes_campana as $pagosPC){ if(!empty($pagosPC['id_plan_campana'])){
                            if($pagosPC['id_plan_campana']==$data['id_plan_campana']){
                              if($pagosPC['tipo_pago_plan_campana']==$cpfill['name']){ 
                                $valInputtemp = $pagosPC["descuento_pago_plan_campana"];
                              }
                            }
                          } } 
                        ?>
                        <div class="input-group">
                          <span class="input-group-addon">$</span>
                          <input type="number" class="form-control" step=".1" maxlength="30" id="descuento_<?=$cpfill['id']; ?>" name="descuentos[<?=$cpfill['id']; ?>]" placeholder="Descuento de <?=mb_strtolower($cpfill['name']); ?> puntual" value="<?=$valInputtemp; ?>">
                        </div>
                        <span id="error_descuento_<?=$cpfill['id']; ?>" class="errors" style="position:absolute;"></span>
                      </div>
                    <?php } } ?>
                  </div>
                <?php } } ?>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <a style="margin-left:5%" href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>

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
<?php endif; ?>
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">

<style>
.errors{
  color:red;
}
.d-none{
  display:none;
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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PlanesCamp";
        window.location = menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
  }
    
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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         nombre_plan: $("#nombre_plan").val(),
              //       },
              //       success: function(respuesta){
              //         alert(respuesta);
              //         if (respuesta == "1"){
              //             $(".btn-enviar").removeAttr("disabled");
              //             $(".btn-enviar").click();
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Los datos ingresados estan repetidos!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //         if (respuesta == "5"){ 
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Error de conexion con la base de datos, contacte con el soporte!',
              //               confirmButtonColor: "#ED2A77",
              //           });
              //         }
              //       }
              //   });
              
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
// function validar(){
//   $(".btn-enviar").attr("disabled");
//   /*===================================================================*/
//   var planes = $("#planes").val();
//   var rplanes = false;
//   if(planes == ""){
//     rplanes = false;
//     $("#error_planes").html("Debe seleccionar los planes para esta campaña");
//   }else{
//     rplanes = true;
//     $("#error_planes").html("");
//   }
//   /*===================================================================*/

//     /*===================================================================*/
//   var descuento_directo = $("#descuento_directo").val();
//   var rdescuento_directo = checkInput(descuento_directo, numberPattern2);
//   if( rdescuento_directo == false ){
//     if(descuento_directo.length != 0){
//       $("#error_descuento_directo").html("El descuento directo solo debe contener numero");
//     }else{
//       $("#error_descuento_directo").html("Debe llenar el campo de descuento directo para el producto");      
//     }
//   }else{
//     $("#error_descuento_directo").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var descuento_primer = $("#descuento_primer").val();
//   var rdescuento_primer = checkInput(descuento_primer, numberPattern2);
//   if( rdescuento_primer == false ){
//     if(descuento_primer.length != 0){
//       $("#error_descuento_primer").html("El descuento de primer pago solo debe contener numero");
//     }else{
//       $("#error_descuento_primer").html("Debe llenar el campo de descuento directo para el producto");      
//     }
//   }else{
//     $("#error_descuento_primer").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var descuento_segundo = $("#descuento_segundo").val();
//   var rdescuento_segundo = checkInput(descuento_segundo, numberPattern2);
//   if( rdescuento_segundo == false ){
//     if(descuento_segundo.length != 0){
//       $("#error_descuento_segundo").html("El descuento de segundo pago solo debe contener numero");
//     }else{
//       $("#error_descuento_segundo").html("Debe llenar el campo de descuento directo para el producto");      
//     }
//   }else{
//     $("#error_descuento_segundo").html("");
//   }
//   /*===================================================================*/
//   /*===================================================================*/
//   var result = false;
//   if( rplanes==true &&  rdescuento_directo==true &&  rdescuento_primer==true &&  rdescuento_segundo==true){
//     result = true;
//   }else{
//     result = false;
//   }
//   /*===================================================================*/
//   // alert(result);
//   return result;
// }
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var planes = $("#planes").val();
  // alert(planes);
  var rplanes = false;
  if(planes == ""){
    rplanes = false;
    $("#error_planes").html("Debe seleccionar los planes para esta campaña");
  }else{
    rplanes = true;
    $("#error_planes").html("");
  }
  /*===================================================================*/

    /*===================================================================*/
  var descuento_directo = $("#descuento_directo").val();
  var rdescuento_directo = checkInput(descuento_directo, numberPattern2);
  if( rdescuento_directo == false ){
    if(descuento_directo.length != 0){
      $("#error_descuento_directo").html("El descuento directo solo debe contener numero");
    }else{
      $("#error_descuento_directo").html("Debe llenar el campo de descuento directo del plan");      
    }
  }else{
    $("#error_descuento_directo").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var pagos_descuentos = $(".json_pagos").html();
  var json_pagos = JSON.parse(pagos_descuentos);

  var rdescuentos = false;
  var descuentos = Array();
  var rdescuentosArr = Array();
  var erroresDescuentos = 0;
  for (var i = 0; i < json_pagos.length; i++) {
    var id = json_pagos[i]['id'];
    var name = json_pagos[i]['name'];
    descuentos[i] = $("#descuento_"+id).val();
    rdescuentosArr[i] = checkInput(descuentos[i], numberPattern2);
    if( rdescuentosArr[i] == false ){
      if(descuentos[i].length != 0){
        $("#error_descuento_"+id).html("El descuento de "+name.toLowerCase()+" solo debe contener numero");
      }else{
        $("#error_descuento_"+id).html("Debe llenar el campo de descuento de "+name.toLowerCase());      
      }
      erroresDescuentos++;
    }else{
      $("#error_descuento_"+id).html("");
    }
  }
  rdescuentos = erroresDescuentos==0 ? true : false;

  /*===================================================================*/


  /*===================================================================*/
  var result = false;
  // if( rplanes==true &&  rdescuento_directo==true &&  rdescuento_primer==true &&  rdescuento_segundo==true){
  if( rplanes==true &&  rdescuento_directo==true && rdescuentos==true){
    result = true;
  }else{
    result = false;
  }
  /*===================================================================*/
  return result;
}

</script>
</body>
</html>
