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
        <?php echo "Promoción de Campaña"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Promoción"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=Homing"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=Homing"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " Promoción de Campaña"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Promoción"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Promoción de campaña" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Promoción de campaña"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-xs-12">
                      <label for="promo">Promocion para campaña <?php echo $n."/".$y ?></label>
                      <select class="form-control select2" id="promo" name="promo">
                        <option value=""></option>
                        <?php 
                          
                          foreach ($promocionesinv as $data) {
                            if(!empty($data['id_promocioninv'])){
                              if($promocion['id_promocioninv']==$data['id_promocioninv']){
                              ?>
                              <option value="<?php echo $data['id_promocioninv'] ?>" selected>
                                <?php echo $data['nombre_promocioninv']; ?>
                              </option>
                              <?php
                              }
                          }
                        }
                        ?>
                      </select>
                      <span id="error_promo" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12">
                      <hr>
                    </div>
                  </div>
                  <div class="row" style="padding:0px 15px;">
                    <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                      <br>
                      <label for="name_opcion" style="font-size:1.3em;width:15%;float:left;"><u>Nombre Premio</u></label>
                      <input type="text" class="form-control" style="width:64%;float:left;" id="name_opcion" name="name_opcion" placeholder="Coloque nombre de premio"  value="<?php if(!empty($promocion['nombre_premio'])){ echo $promocion['nombre_premio']; } ?>">
                      <input type="number" class="form-control" style="width:20%;float:left;" id="precio_opcion" name="precio_opcion" readonly value="<?=$promocion['precio_promocion']; ?>">
                      <div style="clear:both;"></div>
                      <span id="error_name_opcion" class="errors" style="margin-left:16%;"></span>
                      <div style="clear:both;"></div>
                      <br>
                      <?php
                        $elementosMostrar=1;
                        // $retos_campana_premio
                        if(!empty($promocion)){
                          $premiosInv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$promocion['id_premio']}");
                          if(count($premiosInv)>1){
                            $elementosMostrar = count($premiosInv)-1;
                          }else{
                            $elementosMostrar=1;
                          }
                        }
                      ?>
                      <?php for($z=1; $z<=$limitesElementos; $z++){ ?>
                        <div style="width:100%;" id="box_tipo<?=$z; ?>" class="box_inventario_tipo box_inventario_tipo<?=$z; ?> <?php if($z>$elementosMostrar){ echo "d-none"; } ?>">
                          <?php
                            if(!empty($premiosInv[($z-1)])){
                              // echo $premiosInv[($z-1)]['tipo_inventario'];
                              // echo $premiosInv[($z-1)]['id_premio_inventario'];
                              if($premiosInv[($z-1)]['tipo_inventario']=="Productos"){
                                $nameTabla = "productos";
                                $idTabla = "id_producto";
                              }
                              if($premiosInv[($z-1)]['tipo_inventario']=="Mercancia"){
                                $nameTabla = "mercancia";
                                $idTabla = "id_mercancia";
                              }
                              $inventario = $lider->consultarQuery("SELECT * FROM premios_inventario, {$nameTabla} WHERE premios_inventario.estatus=1 and premios_inventario.id_premio={$premiosInv[($z-1)]['id_premio']} and premios_inventario.id_premio_inventario={$premiosInv[($z-1)]['id_premio_inventario']} and {$nameTabla}.{$idTabla} = premios_inventario.id_inventario");
                            }else{
                              $inventario = [];
                            }
                          ?>
                          <div class="" style="width:15%;float:left;">
                            <!-- <label for="unidad_inicial<?=$x.$z; ?>">Cantidad de Unidades #<?=$z; ?></label>                       -->
                            <input type="number" class="form-control unidades" data-indexOne="<?=$z; ?>" id="unidad<?=$z; ?>" name="unidades[]" value="<?php if(!empty($inventario[0])){ echo $inventario[0]['unidades_inventario']; } ?>">
                            <span id="error_unidad<?=$z; ?>" class="errors"></span>
                          </div>
                          <div class="" style="width:64%;float:left;">    
                            <!-- <label for="seleccioninicial<?=$$z; ?>">Seleccionar de Inventarios #<?=$z; ?></label>                       -->
                            <select class="select2 seleccion_inventario" min="<?=$z; ?>" style="width:100%;" id="inventario<?=$z; ?>" name="inventarios[]">
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
                                >Productos: <?php echo "(".$data['codigo_producto'].") ".$data['producto']." - (".$data['cantidad'].") ".$data['marca_producto']; ?></option>
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
                                >Mercancia: <?php echo "(".$data['codigo_mercancia'].") ".$data['mercancia']." - (".$data['medidas_mercancia'].") ".$data['marca_mercancia']; ?></option>
                              <?php } } ?>
                            </select>
                            <input type="hidden" id="tipo<?=$z; ?>" name="tipos[]" value="<?=$tipoInvOP; ?>">
                            <span id="error_inventario<?=$z; ?>" class="errors"></span>
                          </div>
                          <div class="" style="width:20%;float:left;">
                            <!-- <label for="precio">Precio de promoción</label> -->
                            <input type="number" class="form-control precios" step="0.01" data-indexOne="<?=$z; ?>" id="precio<?=$z; ?>" name="precio[]" value="<?php if(!empty($inventario[0])){ echo $inventario[0]['precio_inventario']; } ?>">
                            <span id="error_precio<?=$z; ?>" class="errors"></span>
                          </div>
                          <div style="clear:both;"></div>
                          <div class="form-group col-xs-12 w-100" style="position:relative;margin-top:-10px;margin-left:90%;">
                            <?php if($z<$limitesElementos){ ?>
                              <span id="addMore<?=$z; ?>" min="<?=$z; ?>" class="addMore btn btn-success" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>+</b></span>
                            <?php  } ?>
                            <?php if($z>=2){ ?>
                              <span id="addMenos<?=$z; ?>" min="<?=$z; ?>" class="addMenos btn btn-danger" <?php if($z<$elementosMostrar){ ?> style="display:none;" <?php } ?>><b>-</b></span>
                            <?php  } ?>
                          </div>
                        </div>
                      <?php } ?>
                      <input type="hidden" name="cantidad_elementos" id="cantidad_elementosOp" value="<?=$elementosMostrar; ?>">
                    </div>

                  </div>

              </div>
              <!-- /.box-body -->

              <div class="box-footer">
              <input type="hidden" id="limiteElementos" value="<?=$limitesElementos; ?>">
                
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
.addMore, .addMenos{
  border-radius:40px;
  border:1px solid #CCC;
  margin-top:15px;
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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=PromocionCamp";
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

  $(".box_inventario_tipo.d-none").hide();
  $(".box_inventario_tipo.d-none").removeClass("d-none");
  $(".addMore").click(function(){
    var id=$(this).attr('id');
    // var index=$(this).attr('min');
    // var num=$(this).attr('max');
    alimentarFormInventario();
  });

  $(".addMenos").click(function(){
    var id=$(this).attr('id');
    // var index=$(this).attr('min');
    retroalimentarFormInventario();
  });

  function alimentarFormInventario(){
    var limite = parseInt($("#limiteElementos").val());
    var cant = parseInt($("#cantidad_elementosOp").val());
    $("#addMore"+cant).hide();
    $("#addMenos"+cant).hide();
    cant++;
    $("#box_tipo"+cant).show();
    $("#cantidad_elementosOp").val(cant);
  }
  function retroalimentarFormInventario(){
    var cant = parseInt($("#cantidad_elementosOp").val());
    $("#box_tipo"+cant).hide();
    cant--;
    $("#addMore"+cant).show();
    $("#addMenos"+cant).show();
    $("#cantidad_elementosOp").val(cant);
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
    var cant = parseInt($("#cantidad_elementosOp").val());
    var total = 0;
    for (let z=1; z <= cant; z++) {
      var stocks = $("#unidad"+z).val();
      if(stocks!=""){
        stocks = parseFloat(stocks);
      }
      var precios = $("#precio"+z).val();
      if(precios!=""){
        precios = parseFloat(precios);
      }
      if(stocks!="" && precios!=""){
        var operation = stocks*precios;
        total = total+operation;
      }
    }
    total = parseFloat(total.toFixed(2));
    $("#precio_opcion").val(total);
  });
  $(".precios").on('change keyup', function(){
    var cant = parseInt($("#cantidad_elementosOp").val());
    var total = 0;
    for (let z=1; z <= cant; z++) {
      var stocks = $("#unidad"+z).val();
      if(stocks!=""){
        stocks = parseFloat(stocks);
      }
      var precios = $("#precio"+z).val();
      if(precios!=""){
        precios = parseFloat(precios);
      }
      if(stocks!="" && precios!=""){
        var operation = stocks*precios;
        total = total+operation;
      }
    }
    total = parseFloat(total.toFixed(2));
    $("#precio_opcion").val(total);
  });

    
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
  var promo = $("#promo").val();
  // var rnombre = checkInput(nombre, alfanumericPattern2);
  // if( rnombre == false ){
  if(promo==""){
    rpromo=false;
    $("#error_promo").html("Debe seleccionar la promoción");      
  }else{
    rpromo=true;
    $("#error_promo").html("");
  }
  
  // /*===================================================================*/
  var errores = 0;
  var nombre = $("#name_opcion").val();
  if(nombre==""){
    errores++;
    $("#error_name_opcion").html("Debe agregar un nombre para el premio");
  }else{
    $("#error_name_opcion").html("");
  }

  var elementos = $("#cantidad_elementosOp").val();
  for (let z=1; z<=elementos; z++) {
    var stock = $("#unidad"+z).val();
    if(stock==""){
      errores++;
      $("#error_unidad"+z).html("Debe agregar las unidades #"+z+" del inventario");
    }else{
      $("#error_unidad"+z).html("");
    }
    var inventario = $("#inventario"+z).val();
    if(inventario==""){
      errores++;
      $("#error_inventario"+z).html("Debe seleccionar el elemento del inventario #"+z);
    }else{
      $("#error_inventario"+z).html("");
    }

    var precio = $("#precio"+z).val();
    if(precio==""){
      errores++;
      $("#error_precio"+z).html("Debe agregar un precio por cada unidad #"+z);
    }else{
      $("#error_precio"+z).html("");
    }
  }



  var runidades = false;
  var rinventarios = false;
  var rprecios = false;
  if(errores==0){
    runidades = true;
    rinventarios = true;
    rprecios = true;
  }


  /*===================================================================*/
  var result = false;
  if( rpromo==true && runidades==true && rinventarios==true && rprecios==true){
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
