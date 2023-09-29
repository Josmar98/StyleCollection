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
        <?php echo $url; ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3 ?>route=<?php echo "Homing2" ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
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
          // print_r($accesosEstructuras);

        ?>
        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header">
              <!-- <h3 class="box-title">Editar Solicitud de Promoción</h3> -->
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <span style="color:#000;font-size:2em">Aprobacion de Pedidos</span>
                  </div>
                </div>

                <div class="post" style="padding:10px">
                  <br>
                  <div class="user-block">
                    <?php 
                      if($promociones['fotoPerfil']==""){
                        $promociones['fotoPerfil'] = "public/assets/img/profile/";
                        if($promociones['sexo']=="Femenino"){$promociones['fotoPerfil'] .= "Femenino.png";}
                        if($promociones['sexo']=="Masculino"){$promociones['fotoPerfil'] .= "Masculino.png";}
                      } 
                    ?>
                    <img class="img-circle img-bordered-sm" src="<?=$promociones['fotoPerfil']; ?>" alt="user image">
                        <span class="username">
                          <?php if($promociones['id_cliente']==$_SESSION['id_cliente']){ ?>
                          <a href="?route=Perfil">
                            <?php echo $promociones['primer_nombre']." ".$promociones['primer_apellido']; ?>  
                          </a>
                        <?php }else{ ?>
                          <a href="?route=Clientes&action=Detalles&id=<?php echo $promociones['id_cliente']; ?>">
                            <?php echo $promociones['primer_nombre']." ".$promociones['primer_apellido']; ?>  
                          </a>
                        <?php } ?>

                          <!-- <a href="#" class="pull-right btn-box-tool"><i class="fa fa-times"></i></a> -->
                        </span>
                    <span class="description">
                      Promociones solicitada - <?php echo $promociones['fecha_solicitada_promocion'] ?> a las <?php echo $promociones['hora_solicitada_promocion']; ?>
                      <?php if(strlen($promociones['fecha_aprobada_promocion'])>0){ ?>
                        |  Pedido aprobado - <?php echo $promociones['fecha_aprobada_promocion'] ?> a las <?php echo $promociones['hora_aprobada_promocion']; ?>
                      <?php } ?>
                      <br>
                      
                    </span>
                  </div>
                  <?php //if($promociones['cantidad_aprobada_promocion']==0){ ?>
                    <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                      <span style="color:#000;margin-left:15px;font-size:1.1em">
                        Ha solicitado una cantidad de <b style="color:<?php echo $color_btn_sweetalert ?>"><?php echo $promociones['cantidad_solicitada_promocion'] ?> Promociones</b> <b><?=$promociones['nombre_promocion']; ?></b> para esta campaña <?=$numero_campana."/".$anio_campana?>
                      </span>

                      <br><br>

                      <form action="" method="POST" role="form" class="form_register">
                        <?php
                          // $existencia['existencia_actual'] -= 235;
                          $inputCantidadMostrar = 0;
                          if(count($existencia)>0){
                            if($promociones['cantidad_solicitada_promocion']<$existencia['existencia_actual']){
                              $inputCantidadMostrar = $promociones['cantidad_solicitada_promocion'];
                            }else{
                              $inputCantidadMostrar = $existencia['existencia_actual'];
                            }
                            $actualExistencia = $existencia['existencia_actual'];
                          }else{
                            $inputCantidadMostrar = $promociones['cantidad_solicitada_promocion'];
                            $actualExistencia = null;
                          }
                        ?>
                        <div class="row">
                          <div class="col-xs-12">
                            <input class="form-control" id="cantidad" step="1" name="cantidad" type="number" value="<?=$inputCantidadMostrar; ?>" placeholder="Cantidad de coleccion para aprobar" <?php if( $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor" ){}else{ echo "readonly"; } ?> <?php if($estado_campana=="0"){ echo "disabled"; } ?> >
                            <span id="error_cantidad" class="errors"></span>
                          </div>
                        </div>
                        <?php if(count($existencia)>0){ ?>
                        <div class="row">
                          <div class="col-xs-12">
                            <span style="display:block;text-align:right;padding-right:5%;">
                              <b>
                                <?=$existencia['existencia_actual']." / ".$existencia['existencia_total']; ?>
                                <span style='width:10px;background:;height:10px;display:inline-block;'></span>
                                |
                                <span style='width:10px;background:;height:10px;display:inline-block;'></span>
                                <?=$promociones['nombre_promocion']; ?>
                              </b>
                            </span>
                          </div>
                        </div>
                        <?php } ?>

                        <br>
                        <div class="row">
                          <div class="col-xs-12">
                            <!-- <button class="form-control" style="background:<?php echo $color_btn_sweetalert ?>;color:#FFF;">Enviar</button> -->  
                            <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                              
                            <span type="submit" <?php if($estado_campana=="1"){ echo 'class="btn enviar"'; } ?>  <?php if($estado_campana=="0"){ echo "disabled class='btn enviar2'"; } ?>>Aprobar</span>
                            <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                            <button class="btn-enviar d-none" disabled="" >aprobar</button>

                            <?php } ?>
                          </div>
                        </div>
                      </form>

                    <?php } ?>
                  <?php //} ?>
                </div>

              </div>
 

          </div>

        </div>
        <input type="hidden" id="cantidad_max" value="<?=$promociones['cantidad_aprobado'];?>">
        <input type="hidden" id="existencia_max" value="<?=$actualExistencia;?>">
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
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>

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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Promociones";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response == "77"){
      swal.fire({
          type: 'warning',
          title: '¡La existencia de la promoción es menor a la cantidad seleccionada!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Promociones&action=Aprobar&id=<?=$_GET['id']; ?>";
      });
    }
  }
  $("#cliente").change(function(){
    // alert("asd");
    $(".formLiderSelect").submit();
  });

  $("#cantidad").change(function(){
    var max = parseInt($("#cantidad_max").val());
    var max2 = parseInt($("#existencia_max").val());
    var x = parseInt($(this).val());
    if(x<0){
      $(this).val(0);
    }else{
      // $(this).val(x);
      if( (x>max) || (x>max2) ){
        if(max>max2){
          $(this).val(max2);
        }else{
          $(this).val(max);
        }
      }else{
        $(this).val(x);
      }
    }
  });
  $("#cantidad").focusout(function(){
    var max = parseInt($("#cantidad_max").val());
    var max2 = parseInt($("#existencia_max").val());
    var x = parseInt($(this).val());
    if(x<0){
      $(this).val(0);
    }else{
      // $(this).val(x);
      if( (x>max) || (x>max2) ){
        if(max>max2){
          $(this).val(max2);
        }else{
          $(this).val(max);
        }
      }else{
        $(this).val(x);
      }
    }
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
            $(".btn-enviar").removeAttr("disabled");
            $(".btn-enviar").click();
              // $.ajax({
              //       url: '',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         // nombre: $("#nombre").val(),
              //         id_user: $("#cliente").val(),
              //         id_promocion: $("#promocion").val(),
              //       },
              //       success: function(respuesta){
              //           // alert(respuesta);
              //         if (respuesta == "1"){
              //             $(".btn-enviar").removeAttr("disabled");
              //             $(".btn-enviar").click();
              //         }
              //         if (respuesta == "9"){
              //           swal.fire({
              //               type: 'error',
              //               title: '¡Ya se cuenta con un pedido realizado!',
              //               text: 'Solo se puede realizar un pedido por cada despacho disponible',
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
  /*===================================================================*/
  var cantidad = $("#cantidad").val();
  var rcantidad = checkInput(cantidad, numberPattern);
  if( rcantidad == false ){
    if(cantidad.length != 0){
      $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
    }else{
      $("#error_cantidad").html("Debe llenar una cantidad de colecciones");
    }
  }else{
    $("#error_cantidad").html("");
  }
  /*===================================================================*/
  // var promocion = $("#promocion").val();
  // var rpromocion = checkInput(promocion, numberPattern);
  // if( promocion==0 ){
  //   $("#error_promocion").html("Debe seleccionar una Promoción");      
  //   rpromocion = false;
  // }else if( promocion > 0 ){
  //   $("#error_promocion").html("");
  //   rpromocion = true;
  // }
  /*===================================================================*/
  // var descripcion = $("#descripcion").val();
  // var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  // if( rdescripcion == false ){
  //   if(descripcion.length != 0){
  //     $("#error_descripcion").html("No debe contener caracteres especiales. Unicamente puede utilizar { . , ! ¡ ¿ ? }");      
  //   }else{
  //     $("#error_descripcion").html("Debe llenar la descripcion del permiso");      
  //   }
  // }else{
  //   $("#error_descripcion").html("");
  // }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;

  if( rcantidad==true){
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
