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
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "".$url; ?></a></div>
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
                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="lideres">Lider</label>
                       <!-- <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ..."> -->
                       <select class="form-control select2 lideres" style="width:100%" name="lideres" id="lideres">
                        <option value="0"></option>
                          <?php foreach ($lideres as $data): if (!empty($data['id_cliente'])): ?>
                            <?php
                              $permitido = 0;
                              if($accesoBloqueo=="1"){
                                if(!empty($accesosEstructuras)){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$data['id_cliente']){
                                        $permitido = 1;
                                      }
                                    }
                                  }
                                }
                              } else if($accesoBloqueo=="0"){
                                $permitido = 1;
                              }
                              if($permitido==1){
                            ?>
                              <option value="<?=$data['id_cliente']?>" <?php foreach($nombramientos as $nomb){ if(!empty($nomb['id_nombramiento'])){ if($nomb['id_cliente']==$data['id_cliente']){ echo "selected=''"; } } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']?></option>
                              <?php } ?>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_lideres" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="liderazgo">Liderazgo</label>
                       <!-- <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ..."> -->
                       <select class="form-control select2 liderazgo" style="width:100%" name="liderazgo" id="liderazgo">
                        <option value="0"></option>
                          <?php foreach ($liderazgos as $data): if (!empty($data['id_confignombramientos'])): ?>
                        <option value="<?=$data['id_confignombramientos']?>" <?php foreach($nombramientos as $nomb){ if(!empty($nomb['id_nombramiento'])){ if($nomb['id_confignombramientos']==$data['id_confignombramientos']){ echo "selected=''"; } } } ?> ><?=$data['nombre_liderazgo']." - (".$data['cantidad_correspondiente']; if($data['cantidad_correspondiente']==1){echo " Gema)";}else{echo " Gemas)";} ?></option>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_liderazgo" class="errors"></span>
                    </div>

                    <div class="form-group col-xs-12 col-sm-4">
                       <label for="campana">Campaña</label>
                       <!-- <input type="text" class="form-control nombreConfig" id="nombreConfig" name="nombreConfig" placeholder="por ..."> -->
                       <select class="form-control select2 campana" style="width:100%" name="campana" id="campana">
                        <option value="0"></option>
                          <?php foreach ($campanas as $data): if (!empty($data['id_campana'])): ?>
                        <option value="<?=$data['id_campana']?>" <?php foreach($nombramientos as $nomb){ if(!empty($nomb['id_nombramiento'])){ if($nomb['id_campana']==$data['id_campana']){ echo "selected=''"; } } } ?> >Campaña <?=$data['numero_campana']."/".$data['anio_campana']."-".$data['nombre_campana']; ?></option>
                          <?php endif; endforeach; ?>
                       </select>
                       <span id="error_campana" class="errors"></span>
                    </div>
                    
                  </div>
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
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
        window.location = "?route=Nombramientos";
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

    var lideres = $("#lideres").val();
    var liderazgo = $("#liderazgo").val();

    if(response == true){
      $(".btn-enviar").attr("disabled");

      swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "warning",
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
                      // validarData: true,
                      lider: $("#lideres").val(),
                      liderazgo: $("#liderazgo").val(),
                      campana: $("#campana").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          swal.fire({
                              type: 'success',
                              title: '¡Datos guardados correctamente!',
                              confirmButtonColor: "#ED2A77",
                          }).then(function(){
                            window.location = "?route=Nombramientos";
                          });
                          // $(".btn-enviar").removeAttr("disabled");
                          // $(".btn-enviar").click();
                      }
                      if (respuesta == "9"){
                        swal.fire({
                            type: 'error',
                            title: '¡Los datos ingresados estan repetidos!',
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


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var lider = $("#lideres").val();
  var rlider = false;
  if( lider==0 ){
    $("#error_lideres").html("Debe seleccionar un lider");      
    rlider = false;
  }else if( lider > 0 ){
    $("#error_lideres").html("");
    rlider = true;
  }
  /*===================================================================*/
  var liderazgo = $("#liderazgo").val();
  var rliderazgo = false;
  if( liderazgo==0 ){
    $("#error_liderazgo").html("Debe seleccionar un liderazgo");      
    rliderazgo = false;
  }else if( liderazgo > 0 ){
    $("#error_liderazgo").html("");
    rliderazgo = true;
  }
  var campana = $("#campana").val();
  var rcampana = false;
  if( campana==0 ){
    $("#error_campana").html("Debe seleccionar una campana");      
    rcampana = false;
  }else if( campana > 0 ){
    $("#error_campana").html("");
    rcampana = true;
  }
  /*===================================================================*/

  // var cantidad = $("#cantidad").val();
  // var rcantidad = checkInput(cantidad, numberPattern2);
  // if( rcantidad == false ){
  //   if(cantidad.length != 0){
  //     $("#error_cantidad").html("La cantidad de colecciones solo debe contener numeros");
  //   }else{
  //       $("#error_cantidad").html("Debe llenar el campo de cantidad de colecciones del plan");      
  //   }
  // }else{
  //     if(cantidad < 1){
  //       $("#error_cantidad").html("La cantidad de gemas debe ser mayor a 0");      
  //     }else{
  //       $("#error_cantidad").html("");
  //       rcantidad = true;
  //     }
  // }

  /*===================================================================*/
  var result = false;
  if( rlider==true && rliderazgo==true && rcampana==true){
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
