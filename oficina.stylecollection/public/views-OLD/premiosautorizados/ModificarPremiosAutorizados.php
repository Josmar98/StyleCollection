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
        <?php echo $url ?>
        <small><?php if(!empty($action)){echo $action;} echo " ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$url; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$url; ?></a></div>
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
              <h3 class="box-title">Editar <?php echo $url ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">

                  <div class="row">
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="lideres">Lider</label>
                       <!-- <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ..."> -->
                       <select class="form-control select2 lideres" style="width:100%" name="lider" id="lideres">
                          <?php foreach ($lideres as $data): if (!empty($data['id_cliente'])): ?>
                            <option value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula'];?></option>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_lideres" class="errors"></span>
                    </div>
                    <div class="form-group col-xs-12 col-sm-6">
                       <label for="premio">Premios</label>
                       <select class="form-control select2 premio" style="width:100%" name="premio" id="premio">
                        <option value="0"></option>
                          <?php foreach ($premios as $data): if (!empty($data['id_premio'])): ?>
                            <option <?php if($premioAutorizado['id_premio']==$data['id_premio']){ echo "selected"; } ?> value="<?=$data['id_premio'];?>"><?=$data['nombre_premio']; ?></option>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_premio" class="errors"></span>
                    </div>

                  </div>
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
  var premio = $("#premio").val();
  var rpremio = false;
  if( premio==0 ){
    $("#error_premio").html("Debe seleccionar un premio");      
    rpremio = false;
  }else{
    $("#error_premio").html("");
    rpremio = true;
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

  /*===================================================================*/

  /*===================================================================*/
  
  // var descripcion = $("#descripcion").val();
  // var rdescripcion = checkInput(descripcion, alfanumericPattern2);
  // if( rdescripcion == false ){
  //   if(descripcion.length != 0){
  //     $("#error_descripcion").html("Debe llenar el campo de descripcion");
  //       rdescripcion = false;
  //   }else{
  //       $("#error_descripcion").html("Debe llenar el campo de descripcion");      
  //       rdescripcion = false;
  //   }
  // }else{
  //     if(descripcion.trim().length < 1){
  //       $("#error_descripcion").html("Debe llenar el campo de descripcion");      
  //       rdescripcion = false;
  //     }else{
  //       $("#error_descripcion").html("");
  //       rdescripcion = true;
  //     }
  // }

  /*===================================================================*/


  var result = false;
  // if( rlider==true && rpremio==true && rcantidad==true && rdescripcion==true){
  if( rlider==true && rpremio==true && rcantidad==true){
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
