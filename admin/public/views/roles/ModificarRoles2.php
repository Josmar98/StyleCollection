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
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo $url ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo $url; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">

                    <div class="form-group col-sm-11">
                       <label for="nombre">Nombre</label>

                       <input type="text" class="form-control" id="nombre" name="nombre" value="<?php echo $data['nombre_rol'] ?>" maxlength="30" placeholder="Ingresar nombre del rol">
                       <span id="error_nombre" class="errors"></span>
                    </div>

                  </div>

                  <div class="row">
                    <div class="form-group col-sm-12">
                    <?php $porcen = Count($permisos)-1; ?>
                        <table style="text-align:center;" class="table table-bordered table-striped">
                          <tr style="width:100%;background:#444;color:#fff;">
                            <td>
                              <label for="all">Seleccionar Todos</label>
                              <!-- <br> -->
                              <input type="checkbox" name="all" id="all">
                            </td>

                            <?php
                            $dataAcceso = [];
                              foreach ($permisos as $p): if(!empty($p['id_permiso'])):
                            ?>  

                            <td style="width:<?php echo $porcen."% !important"; ?>; ">
                              <?php echo $p['nombre_permiso'] ?>
                            </td>

                            <?php
                              endif; endforeach;
                            ?>
                          </tr>
                          <?php 
                          foreach ($modulos as $m): if(!empty($m['id_modulo'])):
                          ?>
                          <tr style="width:100%">
                            <td style="background:#444;color:#fff;width:<?php echo $porcen."% !important"; ?>; ">
                              <?php echo $m['nombre_modulo'] ?>
                            </td>
                            

                            <?php
                              foreach ($permisos as $p): if(!empty($p['id_permiso'])):
                            ?>  

                              <td style="width:<?php echo $porcen."% !important"; ?>; ">
                                <?php 
                                if(($m['nombre_modulo']=="Bitácora" && $p['nombre_permiso']!="Ver") || ($m['nombre_modulo']=="Reportes" && $p['nombre_permiso']!="Ver")){
                                }else{
                                  $code = "p".$p['id_permiso']."-m".$m['id_modulo']; 
                                  $code2 = $p['id_permiso']."-".$m['id_modulo']; 
                                  $dataAcceso += [$code2 => array('id_permiso'=>$p['id_permiso'], 'id_modulo'=>$m['id_modulo'])];
                                ?>
                                  <label for="<?php echo $code; ?>">
                                    <?php echo $p['nombre_permiso']." ".$m['nombre_modulo'] ?>
                                  </label>
                                  <br>
                                  <input type="checkbox" <?php foreach ($accesoss as $acss) {
                                    if(!empty($acss['id_acceso'])){
                                      if($acss['id_permiso']."-".$acss['id_modulo'] == $code2){
                                        echo "checked='1'";
                                      }
                                    }
                                  } ?>  name="accesos[]" id="<?php echo $code; ?>" class="accesos" value="<?php echo $code2; ?>">
                                  <input type="hidden" name="<?php echo "permiso".$code2 ?>" value="<?php echo $p['id_permiso']; ?>">
                                  <input type="hidden" name="<?php echo "modulo".$code2 ?>" value="<?php echo $m['id_modulo']; ?>">

                              <?php } // Cierra el ELSE de cuando no es BITACORA ?>


                              </td>

                            <?php
                              endif; endforeach;
                            ?>


                          </tr>
                          <?php endif; endforeach; ?>
                        

                        </table>

                      
                    </div>
                  </div>
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

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
        window.location = "?route=Roles";
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
                      validarData: true,
                      nombre: $("#nombre").val(),
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
  $("#all").click(function(){
    if($(this).prop('checked')){
      $(".accesos").attr("checked","1");
    }else{
      $(".accesos").removeAttr("checked","0");
    }
  });



});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, textPattern2);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre del rol no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo de nombre del rol");      
    }
  }else{
    $("#error_nombre").html("");
  }
  /*===================================================================*/

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rnombre==true){
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
