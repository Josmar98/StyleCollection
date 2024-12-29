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
        <?php echo "Retos de Campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Retos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " Retos de Campaña"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Retos"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Retos de campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Retos de campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-xs-12">
                      <label for="reto">Retos para campaña <?php echo $n."/".$y ?></label>
                      <select class="form-control select2" id="reto" name="reto">
                        <option value=""></option>
                        <?php 
                          foreach ($retosInv as $data) {
                            if(!empty($data['id_retoinv'])){
                              ?>
                              <option 
                              <?php
                              // foreach ($retos_campana as $data2){
                              //   if(!empty($data2['id_reto_campana'])){
                              //     if($data['id_retoinv']==$data2['id_retoinv']){
                              //       echo "disabled";
                              //     }
                              //   }
                              // } 
                              ?>
                              value="<?php echo $data['id_retoinv'] ?>">
                                <?php echo $data['nombre_retoinv']; ?>
                              </option>
                              <?php
                          }
                        }
                        ?>
                      </select>
                      <span id="error_reto" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <div class="form-group col-xs-12" style="padding:0px 30px;">
                      <?php
                        // $planes_de_campana = $lider->consultarQuery("SELECT * FROM planes_campana WHERE estatus = 1 and id_campana={$id_campana} and id_despacho={$id_despacho} ORDER BY id_plan_campana ASC;");
                        // $coleccionesXDefault = 1;
                        // if(count($planes_de_campana)>1){
                        //   $planOne = $lider->consultarQuery("SELECT * FROM planes WHERE id_plan = {$planes_de_campana[0]['id_plan']}");
                        //   if(!empty($planOne[0])){
                        //     $coleccionesXDefault = $planOne[0]['cantidad_coleccion'];
                        //   }
                        //   $id_plan_campana = $planes_de_campana[0]['id_plan_campana'];
                        //   $tppcs = $lider->consultarQuery("SELECT * FROM premios_planes_campana, tipos_premios_planes_campana, premios WHERE premios.id_premio=tipos_premios_planes_campana.id_premio and premios_planes_campana.id_plan_campana = {$id_plan_campana} and tipos_premios_planes_campana.id_ppc = premios_planes_campana.id_ppc and premios_planes_campana.tipo_premio='Inicial'"); 
                        // }
                        $limiteMinimoElementos=1;
                        $opcionsMostrar = 1;
                        // if((count($tppcs)>1)){
                        //   $opcionsMostrar = (count($tppcs)-1);
                        // }else{
                        //   $opcionsMostrar = 1;
                        // }
                      ?>
                      <?php for($x=1; $x<=$limitesOpciones; $x++){ ?>
                        <div class="row box_opciones box_opciones<?=$x; ?> <?php if($x>$opcionsMostrar){ echo "d-none"; } ?>" id="box_opciones<?=$x; ?>">
                          <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                            <br>
                            <label for="name_opcion<?=$x; ?>" style="font-size:1.3em;width:14%;float:left;"><u>Opcion #<?=$x; ?></u></label>
                            <input type="text" class="form-control" style="width:84%;float:right;" id="name_opcion<?=$x; ?>" name="name_opcion[]" placeholder="Coloque nombre de premio a la opcion #<?=$x; ?>"  value="<?php if(!empty($tppcs[($x-1)])){ echo $tppcs[($x-1)]['nombre_premio']; }; ?>">
                            <div style="clear:both;"></div>
                            <span id="error_name_opcion<?=$x; ?>" class="errors" style="margin-left:16%;"></span>
                            <br>
                            <?php
                              $elementosMostrar=1;
                              // if(!empty($tppcs[($x-1)])){
                              //   // echo $tppcs[($x-1)]['id_premio'];
                              //   // echo $tppcs[($x-1)]['nombre_premio'];
                              //   $premiosInv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$tppcs[($x-1)]['id_premio']}");
                              //   // print_r($premiosInv);
                              //   if(count($premiosInv)>1){
                              //     $elementosMostrar = count($premiosInv)-1;
                              //   }else{
                              //     $elementosMostrar=1;
                              //   }
                              // }
                            ?>
                            <?php for($z=1; $z<=$limitesElementos; $z++){ ?>
                              <div style="width:100%;" id="box_tipo<?=$x.$z; ?>" class="box_inventario_tipo box_inventario_tipo <?php if($z>$elementosMostrar){ echo "d-none"; } ?>">
                                <?php
                                  // if(!empty($premiosInv[($z-1)])){
                                  //   // echo $premiosInv[($z-1)]['tipo_inventario'];
                                  //   // echo $premiosInv[($z-1)]['id_premio_inventario'];
                                  //   if($premiosInv[($z-1)]['tipo_inventario']=="Productos"){
                                  //     $nameTabla = "Productos";
                                  //     $idTabla = "id_producto";
                                  //   }
                                  //   if($premiosInv[($z-1)]['tipo_inventario']=="Mercancia"){
                                  //     $nameTabla = "Mercancia";
                                  //     $idTabla = "id_mercancia";
                                  //   }
                                  //   $inventario = $lider->consultarQuery("SELECT * FROM premios_inventario, {$nameTabla} WHERE premios_inventario.estatus=1 and premios_inventario.id_premio={$premiosInv[($z-1)]['id_premio']} and premios_inventario.id_premio_inventario={$premiosInv[($z-1)]['id_premio_inventario']} and {$nameTabla}.{$idTabla} = premios_inventario.id_inventario");
                                  //   // print_r($inventario);
                                  // }else{
                                  //   $inventario = [];
                                  // }
                                ?>
                                <div class="" style="width:15%;float:left;">
                                  <!-- <label for="unidad_inicial<?=$x.$z; ?>">Cantidad de Unidades #<?=$z; ?></label>                       -->
                                  <input type="number" class="form-control unidades"  id="unidad<?=$x.$z; ?>" name="unidades[<?=($x-1); ?>][]">
                                  <span id="error_unidad<?=$x.$z; ?>" class="errors"></span>
                                </div>
                                <div class="" style="width:84%;float:right;">    
                                  <!-- <label for="seleccioninicial<?=$x.$z; ?>">Seleccionar de Inventarios #<?=$z; ?></label>                       -->
                                  <select class="select2 seleccion_inventario" min="<?=$x.$z; ?>" style="width:100%;" id="seleccion<?=$x.$z; ?>" name="inventarios[<?=($x-1); ?>][]">
                                    <option value=""></option>
                                    <?php $tipoInvOP=""; ?>
                                    <?php foreach ($productos as $data){ if( !empty($data['id_producto']) ){ ?>
                                      <option value="<?=$data['id_producto'] ?>"
                                      <?php
                                        if(!empty($inventario[0])){
                                          if($inventario[0]['tipo_inventario']=="Productos"){
                                            if($inventario[0]['id_producto']==$data['id_producto']){
                                              echo "selected";
                                              $tipoInvOP="Productos";
                                            }
                                          }
                                        }
                                      ?>
                                      ><?php echo $data['producto']." - (".$data['cantidad'].")"; ?></option>
                                      <!-- Productos:  -->
                                    <?php } } ?>
                                    <?php foreach ($mercancia as $data){ if( !empty($data['id_mercancia']) ){ ?>
                                      <option value="m<?=$data['id_mercancia'] ?>"
                                      <?php
                                        if(!empty($inventario[0])){
                                          if($inventario[0]['tipo_inventario']=="Mercancia"){
                                            if($inventario[0]['id_mercancia']==$data['id_mercancia']){
                                              echo "selected";
                                              $tipoInvOP="Mercancia";
                                            }
                                          }
                                        }
                                      ?>
                                      ><?php echo $data['mercancia']." - (".$data['medidas_mercancia'].")"; ?></option>
                                      <!-- Mercancia:  -->
                                    <?php } } ?>
                                  </select>
                                  <input type="hidden" id="tipo<?=$x.$z; ?>" name="tipos[<?=($x-1); ?>][]" value="<?=$tipoInvOP; ?>">
                                  <span id="error_seleccion<?=$x.$z; ?>" class="errors"></span>
                                </div>
                                <div style="clear:both;"></div>
                                <div class="form-group col-xs-12 w-100" style="position:relative;margin-top:-10px;margin-left:90%;">
                                  <?php if($z<$limitesElementos){ ?>
                                    <span id="addMore<?=$x.$z; ?>" min="<?=$x; ?>" class="addMore btn btn-success" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>+</b></span>
                                  <?php  } ?>
                                  <?php if($z>=2){ ?>
                                    <span id="addMenos<?=$x.$z; ?>" min="<?=$x; ?>" class="addMenos btn btn-danger" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>-</b></span>
                                  <?php  } ?>
                                </div>
                              </div>
                            <?php } ?>
                            <input type="hidden" name="cantidad_elementos[]" id="cantidad_elementosOp<?=$x; ?>" value="<?=$elementosMostrar; ?>">
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
                <input type="hidden" id="limiteElementos" value="<?=$limitesElementos; ?>">
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=RetosCamp";
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

  // $(".box_inventario_tipo.d-none").hide();
  // $(".box_inventario_tipo.d-none").removeClass("d-none");
  // $(".addMore").click(function(){
  //   var id=$(this).attr('id');
  //   // var index=$(this).attr('min');
  //   // var num=$(this).attr('max');
  //   alimentarFormInventario();
  // });

  // $(".addMenos").click(function(){
  //   var id=$(this).attr('id');
  //   // var index=$(this).attr('min');
  //   retroalimentarFormInventario();
  // });

  // function alimentarFormInventario(){
  //   var limite = parseInt($("#limiteElementos").val());
  //   var cant = parseInt($("#cantidad_elementosOp").val());
  //   $("#addMore"+cant).hide();
  //   $("#addMenos"+cant).hide();
  //   cant++;
  //   $("#box_tipo"+cant).show();
  //   $("#cantidad_elementosOp").val(cant);
  // }
  // function retroalimentarFormInventario(){
  //   var cant = parseInt($("#cantidad_elementosOp").val());
  //   $("#box_tipo"+cant).hide();
  //   cant--;
  //   $("#addMore"+cant).show();
  //   $("#addMenos"+cant).show();
  //   $("#cantidad_elementosOp").val(cant);
  // }

  
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
function validar(){
  $(".btn-enviar").attr("disabled");
  // /*===================================================================*/
  var reto = $("#reto").val();
  // alert(reto);
  var rreto = false;
  if(reto == ""){
    rreto = false;
    $("#error_reto").html("Debe seleccionar el reto para esta campaña");
  }else{
    rreto = true;
    $("#error_reto").html("");
  }
  // /*===================================================================*/
  var name_opcion = $("#name_opcion").val();
  var rname_opcion = false;
  if(name_opcion == ""){
    rname_opcion = false;
    $("#error_name_opcion").html("Debe agregar un nombre para el premio");
  }else{
    rname_opcion = true;
    $("#error_name_opcion").html("");
  }
  // /*===================================================================*/
  // var cantidad_elementos = $("#cantidad_elementosOp").val();
  // var erroresStock=0;
  // var erroresInventario=0;
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

    var elementos = $("#cantidad_elementosOp"+x).val();
    for (let z=1; z<=elementos; z++) {
      var stock = $("#unidad"+x+z).val();
      if(stock==""){
        errores++;
        $("#error_unidad"+x+z).html("Debe agregar la cantidad de unidades #"+z+" del inventario");
      }else{
        $("#error_unidad"+x+z).html("");
      }
      var inventario = $("#seleccion"+x+z).val();
      if(inventario==""){
        errores++;
        $("#error_seleccion"+x+z).html("Debe seleccionar el elemento del inventario #"+z);
      }else{
        $("#error_seleccion"+x+z).html("");
      }
    }
  }



  var runidades = false;
  var rinventarios = false;
  if(errores==0){
    runidades = true;
    rinventarios = true;
  }

  /*===================================================================*/
  var result = false;
  if( rreto==true && rname_opcion==true && runidades==true && rinventarios==true){
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
