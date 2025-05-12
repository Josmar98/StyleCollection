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
        <?php echo $modulo ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$modulo; ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">



        <?php
          $configuraciones=$lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          $accesoBloqueo = "0";
          $superAnalistaBloqueo="1";
          $analistaBloqueo="1";
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=='Analistabloqueolideres'){
                $analistaBloqueo = $config['valor'];
              }
              if($config['clausula']=='Superanalistabloqueolideres'){
                $superAnalistaBloqueo = $config['valor'];
              }
            }
          }
          if($_SESSION['nombre_rol']=="Analista"){$accesoBloqueo = $analistaBloqueo;}
          if($_SESSION['nombre_rol']=="Analista Supervisor"){$accesoBloqueo = $superAnalistaBloqueo;}

          if($accesoBloqueo=="0"){
            // echo "Acceso Abierto";
          }
          if($accesoBloqueo=="1"){
            // echo "Acceso Restringido";
            $accesosEstructuras = $lider->consultarQuery("SELECT * FROM estructuras WHERE analista = {$_SESSION['id_usuario']}");
          }

        ?>


        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $modulo ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">

                  <div class="row">
                    <div class="form-group col-xs-12">
                       <label for="lideres">Lider</label>
                       <!-- <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ..."> -->
                       <select class="form-control select2 lideres" style="width:100%" name="lider" id="lideres">
                          <?php foreach ($lideres as $data): if (!empty($data['id_cliente'])): ?>
                            <option <?php if($premioAutorizado['id_cliente']==$data['id_cliente']){ echo "selected"; } ?> value="<?=$data['id_cliente']; ?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula'];?></option>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_lideres" class="errors"></span>
                    </div>

                  </div>
                  <div class="row" style="padding:0px 15px;">
                    <div class="col-xs-12" style="width:100%;border:1px solid #cdcdcd;padding:;">
                      <br>
                      <div class="row">
                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="cantidad">Cantidad</label>
                           <input type="number" step="1" class="form-control cantidad" id="cantidad" name="cantidad" placeholder="Cantidad de Premios" value="<?=$premioAutorizado['cantidad_PA'];?>">
                           <span id="error_cantidad" class="errors"></span>
                        </div>
    
                        <div class="form-group col-xs-12 col-sm-6">
                           <label for="descripcion">Descripcion</label>
                           <input type="text" step="1" class="form-control descripcion" id="descripcion" name="descripcion" placeholder="Descripcion" value="<?=$premioAutorizado['descripcion_PA'];?>">
                           <span id="error_descripcion" class="errors"></span>
                        </div>
                        
                      </div>
                      <br>
                      <label for="name_opcion" style="font-size:1.3em;width:15%;float:left;"><u>Nombre Premio</u></label>
                      <input type="text" class="form-control" style="width:84%;float:left;" id="name_opcion" name="name_opcion" placeholder="Coloque nombre de premio" value="<?=$premioAutorizado['nombre_premio'];?>">
                      <div style="clear:both;"></div>
                      <span id="error_name_opcion" class="errors" style="margin-left:16%;"></span>
                      <div style="clear:both;"></div>
                      <br>
                      <?php
                        $elementosMostrar=1;
                        // $retos_campana_premio
                        if(!empty($premioAutorizado['id_premio'])){
                          $premiosInv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus=1 and id_premio={$premioAutorizado['id_premio']}");
                          if(count($premiosInv)>1){
                            $elementosMostrar = count($premiosInv)-1;
                          }else{
                            $elementosMostrar=1;
                          }
                        }
                      ?>
                      <div class="" style="width:15%;float:left;">
                        <label for="unidad_inicial">Cantidad de Unidades</label>
                      </div>
                      <div class="" style="width:48%;float:left;">
                        <label for="seleccioninicial">Seleccionar de Inventarios</label>
                        <span id="error_seleccion" class="errors"></span>
                      </div>
                      <div class="" style="width:18%;float:left;">
                        <label for="precio">Precio de venta Unitario</label>
                      </div>
                      <div class="" style="width:18%;float:left;">
                        <label for="precio">Precio de notas Unitario</label>
                      </div>
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
                          <div class="" style="width:48%;float:left;">    
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
                                >Productos: <?php echo $data['producto']." - (".$data['cantidad'].")"; ?></option>
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
                                >Mercancia: <?php echo $data['mercancia']." - (".$data['medidas_mercancia'].")"; ?></option>
                              <?php } } ?>
                            </select>
                            <input type="hidden" id="tipo<?=$z; ?>" name="tipos[]" value="<?=$tipoInvOP; ?>">
                            <span id="error_inventario<?=$z; ?>" class="errors"></span>
                          </div>
                          <div class="" style="width:18%;float:left;">
                            <!-- <label for="precio">Precio de promoción</label> -->
                            <input type="number" class="form-control precios"  step="0.1" data-indexOne="<?=$z; ?>" id="precio<?=$z; ?>" name="precio[]" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['precio_inventario']); } ?>">
                            <span id="error_precio<?=$z; ?>" class="errors"></span>
                          </div>
                          <div class="" style="width:18%;float:left;">
                            <!-- <label for="precio">Precio de promoción</label> -->
                            <input type="number" class="form-control precios_nota"  step="0.1" data-indexOne="<?=$z; ?>" id="precio_nota<?=$z; ?>" name="precio_nota[]" value="<?php if(!empty($inventario[0])){ echo ($inventario[0]['precio_notas']); } ?>">
                            <span id="error_precio_nota<?=$z; ?>" class="errors"></span>
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
                
                <span type="submit" class="btn enviar2 enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

                <button class="btn-enviar d-none" disabled=""  >enviar</button>
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
        window.location = "?<?=$menu?>&route=PremiosAutorizados";
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
    
  // $(".enviarprimerform").click(function(){
  //   var response = validar();
  //   if(response == true){
  //     $(".btn-enviarprimerform").attr("disabled");
  //     $(".btn-enviarprimerform").removeAttr("disabled");
  //     $(".btn-enviarprimerform").click();
  //   } //Fin condicion

  // }); // Fin Evento


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
              //         // validarData: true,
              //         lider: $("#lideres").val(),
              //         liderazgo: $("#liderazgo").val(),
              //         campana: $("#campana").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
              //             swal.fire({
              //                 type: 'success',
              //                 title: '¡Datos guardados correctamente!',
              //                 confirmButtonColor: "#ED2A77",
              //             }).then(function(){
              //               window.location = "?route=Nombramientos";
              //             });
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
  // $(".clientes").change(function(){
  //   var clientes = $(this).val();
  //   var cantidad = clientes.length;
  //   var cant_corresp = parseFloat($("#cantidad_correspondiente").val());
  //   var condicion = $("#condicion").val();
  //   var gemas = 0;
  //   if(condicion=="Dividir"){
  //     gemas = cant_corresp / cantidad;
  //   }
  //   if(condicion=="Multiplicar"){
  //     gemas = cant_corresp * cantidad;
  //   }
  //   $("#cantidad_gemas").val(gemas);

  // });

});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var lider = $("#lideres").val();
  var rlider = false;
  if( lider==0 ){
    $("#error_lideres").html("Debe seleccionar un lider");      
    rlider = false;
  }else{
    $("#error_lideres").html("");
    rlider = true;
  }
  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("Debe llenar la cantidad de premios");
      rcantidad = false;
    }else{
      $("#error_cantidad").html("Debe llenar el campo de cantidad de premios");      
      rcantidad = false;
    }
  }else{
    if(cantidad < 1){
      $("#error_cantidad").html("La cantidad de premios debe ser mayor a 0");      
      rcantidad = false;
    }else{
      $("#error_cantidad").html("");
      rcantidad = true;
    }
  }
  
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

    var precio_nota = $("#precio_nota"+z).val();
    if(precio_nota==""){
      errores++;
      $("#error_precio_nota"+z).html("Debe agregar un precio por cada unidad #"+z);
    }else{
      $("#error_precio_nota"+z).html("");
    }
    
  }



  var rnombre = false;
  var runidades = false;
  var rinventarios = false;
  var rprecios = false;
  if(errores==0){
    rnombre = true;
    runidades = true;
    rinventarios = true;
    rprecios = true;
  }


  var result = false;
  // if( rlider==true && rpremio==true && rcantidad==true && rdescripcion==true){
  if( rlider==true && rcantidad==true && rnombre==true && runidades==true && rinventarios==true && rprecios==true){
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
