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
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Estructura de Líderes asignados</h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                      <h3 style="margin-left:5%;"><b>Líderes asignados</b></h3>
                    <label for="analista" style="padding:0;margin:0;margin-left:5%;font-size:1.6em;">
                      <span> <i>Analista: </i> <?php echo $analistas[0]['primer_nombre']." ".$analistas[0]['primer_apellido']; ?></span>
                    </label>                      
                  </div>
                </div>

                <div class="row">
                  <div class="col-xs-12">
                    <hr>
                  </div>
                </div>
                <style> .labellider:hover{ cursor:pointer; } </style>
                <div class="box-body">
                  <table class="datatable table table-bordered table-striped" style="text-align:center; width:100%;">
                    <thead>
                      <tr>
                        <th>N°</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php $num = 1; ?>
                      <?php foreach ($clientes as $data): ?>
                        <?php if (!empty($data['id_cliente'])): ?>
                            <?php foreach ($estructuras as $data2): ?>
                              <?php if (!empty($data2['id_cliente'])): ?>
                                <?php if ($data['id_cliente']==$data2['id_cliente']): ?>
                                  <?php if ($data2['analista']==$id): ?>
                        <tr class="elementTR">
                          <td>
                            <?php echo $num++; ?>
                          </td>
                          <td>
                              <span class="labellider">
                                <?=number_format($data['cedula'],0,'','.'); ?>
                              </span>
                          </td>
                          <td>
                              <span class="labellider">
                                <?=$data['primer_nombre']." ".$data['segundo_nombre']; ?>
                              </span>
                          </td>
                          <td>
                              <span class="labellider">
                                <?=$data['primer_apellido']." ".$data['segundo_apellido']; ?>
                              </span>
                          </td>
                          <!-- <td style="text-align:right;"> -->
                            
                            <!-- <input type="checkbox" class="form-control2 lideres" style="float:right;" id="<?=$data['id_cliente']; ?>" name="lideres[]" maxlength="30" placeholder="Ingresar nombre de usuario" value="<?=$data['id_cliente']; ?>" checked="checked"> -->
                          
                          <!-- </td> -->
                        </tr>
                                  <?php endif; ?>
                                <?php endif; ?>
                              <?php endif; ?>
                            <?php endforeach; ?>
                        <?php endif; ?>
                      <?php endforeach; ?>
                    </tbody>
                    <tfoot>
                      <tr>
                        <th>N°</th>
                        <th>Cedula</th>
                        <th>Nombre</th>
                        <th>Apellido</th>
                      </tr>
                    </tfoot>
                  </table>
                </div>

            </div>
            <!-- /.box-body -->

            <div class="box-footer">
              
            </div>
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
        window.location = "?route=Estructuras";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "#ED2A77",
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Analista ya tiene una estructura!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Estructuras";
      });
    }
  }
  // $(".lideres").change(function(){
  //   var val = $(this).val();
  //   if(val == "on"){
  //     $(this).val("off");
  //     // $(this)[0].checked = false;
  //   }
  //   if(val == "off"){
  //     $(this).val("on");
  //     // $(this)[0].checked = true;
  //   }
  //   alert($(this).attr("id"));
  // });
  $("#buscando").keyup(function(){
    $(".elementTR").show();
    var buscar = $(this).val();
    buscar = Capitalizar(buscar);
    if($.trim(buscar) != ""){
      $(".elementTR:not(:contains('"+buscar+"'))").hide();
    }
  });
  function Capitalizar(str){
    return str.replace(/\w\S*/g, function(txt){
      return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
    });
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
                      analista: $("#analista").val(),
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


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/

  /*===================================================================*/
  var analista = $("#analista").val();
  var ranalista = false;
  if(analista == ""){
    ranalista = false;
    $("#error_analista").html("Debe seleccionar un analista para la estructura");
  }else{
    ranalista = true;
    $("#error_analista").html("");
  }
  /*===================================================================*/

  /*===================================================================*/
  // var rol = $("#rol").val();
  // var rrol = false;
  // if(rol == ""){
  //   rrol = false;
  //   $("#error_rol").html("Debe seleccionar un rol para el usuario");
  // }else{
  //   rrol = true;
  //   $("#error_rol").html("");
  // }
  /*===================================================================*/

  // /*===================================================================*/
  var result = false;
  if( ranalista==true){
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
