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
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" style="text-decoration-line:underline;color:#04a7c9">Registrar Fragancia</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-sm-12 col-md-7 ">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="mini-datatable" data-page-length='5' paginatorAlwaysVisible="true" rowsPerPageTemplate="5,10,15" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                <?php if($amFraganciasE==1 || $amFraganciasB==1): ?>
                  <th>---</th>
                <?php endif; ?>
                  <th>Nombres</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              // print_r($clientes);
              foreach ($fragancias as $data):
                if(!empty($data['id_fragancia'])):  
            ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                <?php if($amFraganciasE==1 || $amFraganciasB==1): ?>
                  <td style="width:10%">
                        <?php if($amFraganciasE==1): ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&operation=Modificar&id=<?php echo $data['id_fragancia'] ?>">
                            <span class="fa fa-wrench">
                            </span>
                          </button>
                        <?php endif; ?>

                        <?php if($amFraganciasB==1): ?>
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_fragancia'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                        <?php endif; ?>
                  </td>
                <?php endif; ?>
                
                  <td style="width:20%">
                    <span class="contenido2">
                    <?php echo $data['fragancia']; ?>
                    </span>
                  </td>

                </tr>
          <?php
              endif; endforeach;
          ?>
                </tbody>
                <tfoot>
               <tr>
                  <th>Nº</th>
                <?php if($amFraganciasE==1 || $amFraganciasB==1): ?>
                  <th>---</th>
                <?php endif; ?>
                  <th>Nombres</th>
                </tr>
                </tfoot>
              </table>

            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>

        <?php if(($amFraganciasE==1&&!empty($_GET['operation'])) || $amFraganciasR==1 && empty($_GET['operation'])): ?>

        <div class="col-sm-10 col-md-5">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">
              <?php
                if(empty($_GET['operation'])){ 
                  echo "Agregar ".$url.""; 
                }else{ 
                  echo "Modificar ".$url."";
                }
              ?>
                
              </h3>
            </div>
            <!-- /.box-header -->

            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                    
                  <div class="row">
                    <div class="form-group col-sm-12">
                       <label for="fragancia">Nombre de Fragancia</label>
                      <?php if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){ ?>
                        <input type="text" class="form-control" id="fragancia" value="<?php echo $datas['fragancia'] ?>" name="fragancia" placeholder="Ingresar nombre de fragancia">
                      <?php }else{ ?>
                       <input type="text" class="form-control" id="fragancia" name="fragancia" placeholder="Ingresar nombre de fragancia">
                      <?php } ?>
                       <span id="error_fragancia" class="errors"></span>
                    </div>
                  </div>
                
              </div>
              <!-- /.box-body -->

              <div class="box-footer">
                
                <span type="submit" class="btn enviar">Enviar</span>
                <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <?php if(!empty($_GET['operation']) && $_GET['operation'] == "Modificar"){ ?>

                <a style="margin-left:5%" href="?route=<?php echo $url ?>" class="btn btn-default">Cancelar</a>
                <?php } ?>

                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>
            </form>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <?php endif; ?>
        <!-- /.col -->
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
<?php if(!empty($response2)): ?>
<input type="hidden" class="responses2" value="<?php echo $response2 ?>">
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
        window.location = "?route=Fragancias";
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
  var response2 = $(".responses2").val();
  if(response2==undefined){

  }else{
    if(response2 == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Fragancias";
      });
    }
    if(response2 == "2"){
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
          closeOnCancel: false, 
      }).then((isConfirm) => {
          if (isConfirm.value){
              $.ajax({
                    url: '',
                    type: 'POST',
                    data: {
                      validarData: true,
                      fragancia: $("#fragancia").val(),
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
    
    }


  });

  $(".modificarBtn").click(function(){
    swal.fire({ 
          title: "¿Desea modificar los datos?",
          text: "Se movera al formulario para modificar los datos, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
            window.location = $(this).val();
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });



  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
                    showCancelButton: true,
                    confirmButtonColor: "#ED2A77",
                    confirmButtonText: "¡Si!",
                    cancelButtonText: "No", 
                    closeOnConfirm: false,
                    closeOnCancel: false 
                }).then((isConfirm) => {
                    if (isConfirm.value){                      
                        window.location = $(this).val();
                    }else { 
                        swal.fire({
                            type: 'error',
                            title: '¡Proceso cancelado!',
                            confirmButtonColor: "#ED2A77",
                        });
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
  });



});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var fragancia = $("#fragancia").val();
  var rfragancia = checkInput(fragancia, textPattern2);
  if( rfragancia == false ){
    if(fragancia.length != 0){
      $("#error_fragancia").html("La fragancia no debe contener numeros o caracteres especiales");
    }else{
      $("#error_fragancia").html("Debe llenar el campo de fragancia");      
    }
  }else{
    $("#error_fragancia").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rfragancia==true ){
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
