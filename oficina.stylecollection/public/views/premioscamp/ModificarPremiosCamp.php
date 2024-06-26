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
        <?php echo "Premios de la campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Premios"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Premios"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Premios de la campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Premios a la campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <input type="hidden" id="opInicial" value="<?=$despacho['opcion_inicial']; ?>">
                  <input type="hidden" id="cantPagos" value="<?=$despacho['cantidad_pagos']; ?>">
                  <input type="hidden" id="cantPagosMax" value="<?=count($cantidadPagosDespachos); ?>">
                  <span class="d-none json_pagos"><?php echo json_encode($cantidadPagosDespachosFild); ?></span>.

                  <div class="row">
                    <div class="col-sm-12">
                      <h3 class="box-title">
                        <div class="row col-xs-12">
                          <div class="form-group col-xs-12">
                            <label>Plan</label>
                            <br>
                            <select name="plan" id="plan" class="select2" style="width:100%">
                              <option value=""></option>
                              <?php   foreach ($planes as $data): if(!empty($data['id_plan_campana'])): ?>
                                <option value="<?php echo $data['id_plan_campana'] ?>" <?php if($data['id_plan']==$plan){echo "selected=''";} ?> ><?php echo $data['nombre_plan']; ?></option>
                              <?php endif; endforeach; ?>
                            </select>
                            <span id="error_plan" class="errors" style="font-size:0.7em;"></span>
                          </div>
                        </div>
                      </h3>
                    </div>
                  </div>

                  <?php if ($despacho['opcion_inicial']=="Y"){ ?>
                    <div class="row col-xs-12">
                      <hr>
                      <div class="form-group col-xs-12">
                        <?php
                          foreach ($tipos_premios as $data){ if(!empty($data['tipo_premio'])){ 
                            if($data['tipo_premio'] == "Inicial" && $data['tipo_premio_producto']=="Productos"){
                              $tipo_premioAct = "Productos"; 
                            } else if($data['tipo_premio'] == "Inicial" && $data['tipo_premio_producto']=="Premios"){
                              $tipo_premioAct = "Premios"; 
                            }
                          }} 
                        ?>
                        <div>
                          <label for="seleccion_inicial">Inicial</label>                      
                          <select class="form-control select2 tipos_seleccion" style="width:100%;" name="tipos[inicial]" id="tipo_inicial">
                            <option value=""></option>
                            <option <?php if($tipo_premioAct=="Productos"){ echo "selected='selected'"; } ?>>Productos</option>
                            <!-- <option <?php if($tipo_premioAct=="Premios"){ echo "selected='selected'"; } ?>>Premios</option> -->
                          </select>
                          <span id="error_tipo_inicial" class="errors"></span>
                        </div>

                        <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="Inicial" name="tipos_premios[inicial]" id="tipos_premios_inicial">
                        <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="inicial" name="tipos_premios_id[inicial]" id="tipos_premios_inicial">

                        <div class="box_tipo_inicial box_productos_tipo_inicial <?php if($tipo_premioAct!="Productos"){ echo "d-none"; } ?>">    
                          <label for="seleccion_productos_inicial">Seleccionar Productos</label>                      
                          <select class="select2" style="width:100%" id="seleccion_productos_inicial" multiple="multiple" placeholder="" name="productos_inicial[]">
                            <option value=""></option>
                            <option value="0">Ninguna</option>
                            <?php foreach ($productos as $data): if( !empty($data['id_producto']) ): ?>
                              <!-- <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option> -->
                              <option value="<?php echo $data['id_producto'] ?>" <?php foreach ($tpremios as $data2){if(!empty($data2['id_premio'])){if($data2['tipo_premio'] == "Inicial" && $data['id_producto']==$data2['id_premio']){echo "selected=''";}}} ?>><?php echo $data['producto'] ?></option>
                            <?php endif; endforeach; ?>
                          </select>
                          <span id="error_seleccion_productos_inicial" class="errors"></span>
                        </div>

                        <div class="box_tipo_inicial box_premios_tipo_inicial  <?php if($tipo_premioAct!="Premios"){ echo "d-none"; } ?>">
                          <label for="seleccion_premios_inicial">Seleccionar Premios</label>                      
                          <select class="select2" style="width:100%" id="seleccion_premios_inicial" multiple="multiple" placeholder="" name="premios_inicial[]">
                            <option value=""></option>
                            <option value="0">Ninguna</option>
                            <?php foreach ($premios as $data): if( !empty($data['id_premio']) ): ?>
                              <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option>
                            <?php endif; endforeach; ?>
                          </select>
                          <span id="error_seleccion_premios_inicial" class="errors"></span>
                        </div>

                      </div>
                    </div>
                  <?php } ?>

                  <?php
                    foreach ($cantidadPagosDespachosFild as $pagosDFill){
                      foreach ($pagos_despacho as $pagosD){
                        if ($pagosDFill['name']==$pagosD['tipo_pago_despacho']){ 
                          foreach ($tipos_premios as $data){ if(!empty($data['tipo_premio'])){ 
                            if($data['tipo_premio'] == $pagosDFill['name'] && $data['tipo_premio_producto']=="Productos"){
                              $tipo_premioAct = "Productos"; 
                            } else if($data['tipo_premio'] == $pagosDFill['name'] && $data['tipo_premio_producto']=="Premios"){
                              $tipo_premioAct = "Premios"; 
                            }
                          }}
                          ?>
                          <div class="row col-xs-12">
                            <hr>
                            <div class="form-group col-xs-12">
                              <div>
                                <label for="seleccion_<?=$pagosDFill['id'];?>"><?=$pagosDFill['name']; ?></label>
                                <select class="form-control select2 tipos_seleccion" style="width:100%;" name="tipos[<?=$pagosDFill['id']; ?>]" id="tipo_<?=$pagosDFill['id']; ?>">
                                  <option value=""></option>
                                  <option <?php if($tipo_premioAct=="Productos"){ echo "selected='selected'"; } ?>>Productos</option>
                                  <?php
                                  foreach ($pagos_despacho as $key) {
                                    if($key['tipo_pago_despacho']==$pagosDFill['name']){
                                      if($key['asignacion_pago_despacho']=="seleccion_premios"){ ?>
                                        <option <?php if($tipo_premioAct=="Premios"){ echo "selected='selected'"; } ?>>Premios</option>
                                      <?php }
                                    }
                                  }
                                  ?>
                                </select>
                                <span id="error_tipo_<?=$pagosDFill['id']; ?>" class="errors"></span>
                              </div>

                              <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['name']; ?>" name="tipos_premios[<?=$pagosDFill['id']; ?>]" id="tipos_premios_<?=$pagosDFill['id']; ?>">
                              <input type="hidden" class="form-control" readonly style="width:100%;background:none;" value="<?=$pagosDFill['id']; ?>" name="tipos_premios_id[<?=$pagosDFill['id']; ?>]" id="tipos_premios_<?=$pagosDFill['id']; ?>">

                              <div class="box_tipo_<?=$pagosDFill['id']; ?> box_productos_tipo_<?=$pagosDFill['id']; ?> <?php if($tipo_premioAct!="Productos"){ echo "d-none"; } ?>">
                                <label for="seleccion_productos_<?=$pagosDFill['id'];?>">Seleccionar Productos</label>
                                <select class="select2" style="width:100%" id="seleccion_productos_<?=$pagosDFill['id'];?>" placeholder="" multiple="multiple" name="productos_<?=$pagosDFill['id'];?>[]">
                                  <option value=""></option>
                                  <option value="0">Ninguna</option>
                                  <?php foreach ($productos as $data): if( !empty($data['id_producto']) ): ?>
                                    <!-- <option value="<?php echo $data['id_producto'] ?>"><?php echo $data['producto'] ?></option> -->
                                    <option value="<?php echo $data['id_producto'] ?>" <?php foreach ($tpremios as $data2){if(!empty($data2['id_premio'])){if($data2['tipo_premio'] == $pagosDFill['name'] && $data['id_producto']==$data2['id_premio']){echo "selected=''";}}} ?> ><?php echo $data['producto'] ?></option>
                                  <?php endif; endforeach; ?>
                                </select>
                                <span id="error_seleccion_productos_<?=$pagosDFill['id'];?>" class="errors"></span>
                              </div>

                              <div class="box_tipo_<?=$pagosDFill['id']; ?> box_premios_tipo_<?=$pagosDFill['id']; ?> <?php if($tipo_premioAct!="Premios"){ echo "d-none"; } ?>">
                                <label for="seleccion_premios_<?=$pagosDFill['id'];?>">Seleccionar Premios</label>
                                <select class="select2" style="width:100%" id="seleccion_premios_<?=$pagosDFill['id'];?>" placeholder="premios" multiple="multiple" name="premios_<?=$pagosDFill['id'];?>[]">
                                  <option value=""></option>
                                  <option value="0">Ninguna</option>
                                  <?php foreach ($premios as $data): if( !empty($data['id_premio']) ): ?>
                                    <!-- <option value="<?php echo $data['id_premio'] ?>"><?php echo $data['nombre_premio'] ?></option> -->
                                    <option value="<?php echo $data['id_premio'] ?>" <?php foreach ($tpremios as $data2){if(!empty($data2['id_premio'])){if($data2['tipo_premio'] == $pagosDFill['name'] && $data['id_premio']==$data2['id_premio']){echo "selected=''";}}} ?> ><?php echo $data['nombre_premio'] ?></option>
                                  <?php endif; endforeach; ?>
                                </select>
                                <span id="error_seleccion_premios_<?=$pagosDFill['id'];?>" class="errors"></span>
                              </div>                        

                            </div>
                          </div>
                        <?php }
                      }
                    }
                  ?>

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
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosCamp";
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
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      plan: $("#plan").val(),
                      // nombre_producto: $("#nombre_producto").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                      }
                      if (respuesta == "9"){
                        swal.fire({
                            type: 'error',
                            title: '¡No se han encontrado los datos!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                            type: 'error',
                            title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
                    }
                });
              
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

  $(".box-productosInicial").hide();
  $(".box-productosInicial").removeClass("d-none");
  $(".box-premiosInicial").hide();
  $(".box-premiosInicial").removeClass("d-none");

  var tInicial = $(".tInicial").val();
  if(tInicial=="Productos"){ $(".box-productosInicial").show(); }
  if(tInicial=="Premios"){ $(".box-premiosInicial").show(); }

  

  $("#tipoInicial").change(function(){
    $("#error_productos_inicial").html("");
    $("#error_premios_inicial").html("");

    var tipoInicial = $(this).val();
    if(tipoInicial == ""){
      $(".box-premiosInicial").hide();
      $(".box-productosInicial").hide();      
    }
    if(tipoInicial == "Productos"){
      $(".box-premiosInicial").hide();
      $(".box-productosInicial").show();
    }
    if(tipoInicial == "Premios"){
      $(".box-productosInicial").hide();
      $(".box-premiosInicial").show();
    }
  });

  $(".box-productosPrimer").hide();
  $(".box-productosPrimer").removeClass("d-none");
  $(".box-premiosPrimer").hide();
  $(".box-premiosPrimer").removeClass("d-none");

  var tPrimer = $(".tPrimer").val();
  if(tPrimer=="Productos"){ $(".box-productosPrimer").show(); }
  if(tPrimer=="Premios"){ $(".box-premiosPrimer").show(); }

  $("#tipoPrimer").change(function(){
    $("#error_productos_primer").html("");
    $("#error_premios_primer").html("");

    var tipoPrimer = $(this).val();
    if(tipoPrimer == ""){
      $(".box-premiosPrimer").hide();
      $(".box-productosPrimer").hide();      
    }
    if(tipoPrimer == "Productos"){
      $(".box-premiosPrimer").hide();
      $(".box-productosPrimer").show();
    }
    if(tipoPrimer == "Premios"){
      $(".box-productosPrimer").hide();
      $(".box-premiosPrimer").show();
    }
  });

  $(".box-productosSegundo").hide();
  $(".box-productosSegundo").removeClass("d-none");
  $(".box-premiosSegundo").hide();
  $(".box-premiosSegundo").removeClass("d-none");

  var tSegundo = $(".tSegundo").val();
  if(tSegundo=="Productos"){ $(".box-productosSegundo").show(); }
  if(tSegundo=="Premios"){ $(".box-premiosSegundo").show(); }

  $("#tipoSegundo").change(function(){
    $("#error_productos_segundo").html("");
    $("#error_premios_segundo").html("");

    var tipoSegundo = $(this).val();
    if(tipoSegundo == ""){
      $(".box-premiosSegundo").hide();
      $(".box-productosSegundo").hide();      
    }
    if(tipoSegundo == "Productos"){
      $(".box-premiosSegundo").hide();
      $(".box-productosSegundo").show();
    }
    if(tipoSegundo == "Premios"){
      $(".box-productosSegundo").hide();
      $(".box-premiosSegundo").show();
    }
  });
  // $("body").hide(500);


  $(".tipos_seleccion").change(function(){
    var id = $(this).attr("id");
    var value = $(this).val();
    $(".box_"+id).slideUp();
    if(value != ""){
      var idAct = ".box_"+value.toLowerCase()+"_"+id;
      $("#error_"+id).html("");
      $(idAct).slideDown();
    }else{
      $("#error_"+id).html("Debe seleccionar el tipo de premio");
    }
  });

});
// function validar(){
//   $(".btn-enviar").attr("disabled");
//   /*===================================================================*/
//   var plan = $("#plan").val();
//   var rplan = false;
//   if(plan == ""){
//     rplan = false;
//     $("#error_plan").html("Debe seleccionar el plan para seleccionar los premios");
//   }else{
//     rplan = true;
//     $("#error_plan").html("");
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//     // Inicial
//   /*===================================================================*/
//   var tipoInicial = $("#tipoInicial").val();
//   var rtipoInicial = false;
//   if(tipoInicial == ""){
//     rtipoInicial = false;
//     $("#error_tipo_inicial").html("Debe seleccionar el tipo premio para la inicial");
//   }else{
//     rtipoInicial = true;
//     $("#error_tipo_inicial").html("");
//   }
//   /*===================================================================*/
//   var premioIncial;
//   var rpremioInicial = false;

//   if(tipoInicial == "Productos"){
//     premioIncial = $("#productosInicial").val();
//     if(premioIncial == ""){
//       rpremioInicial = false;
//       $("#error_productos_inicial").html("Debe seleccionar los premios de inicial");
//     }else{
//       rpremioInicial = true;
//       $("#error_productos_inicial").html("");
//     }
//   }
//   if(tipoInicial == "Premios"){
//     premioIncial = $("#premiosInicial").val();
//     if(premioIncial == ""){
//       rpremioInicial = false;
//       $("#error_premios_inicial").html("Debe seleccionar los premios de inicial");
//     }else{
//       rpremioInicial = true;
//       $("#error_premios_inicial").html("");
//     }
//   }
//   /*===================================================================*/


//   /*===================================================================*/
//   var tipoPrimer = $("#tipoPrimer").val();
//   var rtipoPrimer = false;
//   if(tipoPrimer == ""){
//     rtipoPrimer = false;
//     $("#error_tipo_primer").html("Debe seleccionar el tipo premio para el primer pago");
//   }else{
//     rtipoPrimer = true;
//     $("#error_tipo_primer").html("");
//   }
//   /*===================================================================*/
//   var premioPrimer;
//   var rpremioPrimer = false;

//   if(tipoPrimer == "Productos"){
//     premioPrimer = $("#productosPrimer").val();
//     if(premioPrimer == ""){
//       rpremioPrimer = false;
//       $("#error_productos_primer").html("Debe seleccionar los premios de primer pago");
//     }else{
//       rpremioPrimer = true;
//       $("#error_productos_primer").html("");
//     }
//   }
//   if(tipoPrimer == "Premios"){
//     premioPrimer = $("#premiosPrimer").val();
//     if(premioPrimer == ""){
//       rpremioPrimer = false;
//       $("#error_premios_primer").html("Debe seleccionar los premios de primer pago");
//     }else{
//       rpremioPrimer = true;
//       $("#error_premios_primer").html("");
//     }
//   }
//   /*===================================================================*/

//   /*===================================================================*/
//   var tipoSegundo = $("#tipoSegundo").val();
//   var rtipoSegundo = false;
//   if(tipoSegundo == ""){
//     rtipoSegundo = false;
//     $("#error_tipo_segundo").html("Debe seleccionar el tipo premio para el segundo pago");
//   }else{
//     rtipoSegundo = true;
//     $("#error_tipo_segundo").html("");
//   }
//   /*===================================================================*/
//   var premioSegundo;
//   var rpremioSegundo = false;

//   if(tipoSegundo == "Productos"){
//     premioSegundo = $("#productosSegundo").val();
//     if(premioSegundo == ""){
//       rpremioSegundo = false;
//       $("#error_productos_segundo").html("Debe seleccionar los premios de segundo pago");
//     }else{
//       rpremioSegundo = true;
//       $("#error_productos_segundo").html("");
//     }
//   }
//   if(tipoSegundo == "Premios"){
//     premioSegundo = $("#premiosSegundo").val();
//     if(premioSegundo == ""){
//       rpremioSegundo = false;
//       $("#error_premios_primer").html("Debe seleccionar los premios de segundo pago");
//     }else{
//       rpremioSegundo = true;
//       $("#error_premios_primer").html("");
//     }
//   }
//   /*===================================================================*/

//   /*===================================================================*/

//   /*===================================================================*/
//   var result = false;
//   if( rplan==true && rtipoInicial==true && rpremioInicial==true && rtipoPrimer==true && rpremioPrimer==true && rtipoSegundo==true && rpremioSegundo==true){
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
  var plan = $("#plan").val();
  var rplan = false;
  if(plan == ""){
    rplan = false;
    $("#error_plan").html("Debe seleccionar el plan para seleccionar los premios");
  }else{
    rplan = true;
    $("#error_plan").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
    // Inicial
  /*===================================================================*/
  var opInicial = $("#opInicial").val();
  if(opInicial=="Y"){
    var id = "inicial";
    var name = "Inicial";
    var rInicial = false;
    var tipoInicial = $("#tipo_"+id).val();
    if(tipoInicial!=""){
      $("#error_tipo_"+id).html("");
      var idAct = "seleccion_"+tipoInicial.toLowerCase()+"_"+id;
      $("#error_"+idAct).html("");
      var seleccionInicial = $("#"+idAct).val();
      var asig = $("#"+idAct).attr("placeholder");
      if(seleccionInicial == ""){
        // if(asig==""){
        //   $("#error_seleccion_"+id).html("Debe seleccionar los productos de "+name.toLowerCase());
        // }else{
        // }
        $("#error_"+idAct).html("Debe seleccionar los premios de "+name.toLowerCase());
        rInicial = false;
      }else{
        $("#error_"+idAct).html("");
        rInicial = true;
      }
    }else{
      $("#error_tipo_"+id).html("Debe seleccionar el tipo de premio");
      rInicial = false;
    }
  }else{
    var rInicial = true;
  }
  /*===================================================================*/

  /*===================================================================*/
      // Premios de los PAGOS
  /*===================================================================*/
  var pagos_despachos = $(".json_pagos").html();
  // alert(pagos_despachos);
  var json_pagos = JSON.parse(pagos_despachos);
  var rPremios = false;
  var tipoPremios = Array();
  var seleccionPremios = Array();
  var asigPremios = Array();
  var rpremiosArr = Array();
  var erroresPremios = 0;
  for (var i = 0; i < json_pagos.length; i++) {
    var id = json_pagos[i]['id'];
    var name = json_pagos[i]['name'];
    tipoPremios[i] = $("#tipo_"+id).val();
    if(tipoPremios[i]!=""){
      var idAct = "seleccion_"+tipoPremios[i].toLowerCase()+"_"+id;
      seleccionPremios[i] = $("#"+idAct).val();
      asigPremios[i] = $("#"+idAct).attr("placeholder");
      // alert(seleccionPremios[i]);
      // alert(asigPremios[i]);
      if(seleccionPremios[i] == ""){
        // if(asig==""){
        //   $("#error_seleccion_"+id).html("Debe seleccionar los productos de "+name.toLowerCase());
        // }else{
        // }
          $("#error_"+idAct).html("Debe seleccionar los premios de "+name.toLowerCase());
          rpremiosArr[i] = false;
          erroresPremios++;
      }else{
        $("#error_"+idAct).html("");
        rpremiosArr[i] = true;
      }
    }else{
      $("#error_tipo_"+id).html("Debe seleccionar el tipo de premio");
    }
  }
  rPremios = erroresPremios==0 ? true : false;
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/

  var result = false;
  if( rplan==true && rInicial==true && rPremios==true){
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
