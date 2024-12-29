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
        <?php echo "Rutas de los lideres"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Rutas de los lideres"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo "Rutas de los lideres"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " Rutas de los lideres"; ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?php echo "Rutas de los lideres" ?></a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-md-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar Nuevas <?php echo "Rutas de los lideres"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="get">
              <div class="box-body">
                <div class="row">
                  <div class="form-group col-xs-12 col-sm-6">
                      <label for="cant">Cantidad</label>
                      <input type="hidden" value="RutasLideres" name="route">
                      <input type="hidden" value="Registrar" name="action">
                      <select class="form-control select2" id="cant" name="cant" style="width:100%;">
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "10"){ echo "selected"; } } ?> value="10">10</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "20"){ echo "selected"; } } ?> value="20">20</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "30"){ echo "selected"; } } ?> value="30">30</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "40"){ echo "selected"; } } ?> value="40">40</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "50"){ echo "selected"; } } ?> value="50">50</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "60"){ echo "selected"; } } ?> value="60">60</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "70"){ echo "selected"; } } ?> value="70">70</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "80"){ echo "selected"; } } ?> value="80">80</option>
                        <option <?php if(!empty($_GET['cant'])){ if($_GET['cant'] == "90"){ echo "selected"; } } ?> value="90">90</option>
                      </select>
                  </div>
                  <div class="form-group col-xs-12 col-sm-6">
                    <br>
                    <button class="btn enviar2">Enviar</button>
                  </div>
                </div>
              </div>
            </form>
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <?php
                    $posicion = 1;
                  ?>
                  <div class="row">
                    <div class="form-group col-xs-12">
                        <label for="rutas">Rutas</label>
                        <select class="form-control select2" id="rutas" name="ruta" style="width:100%;">
                          <option value="0"></option>
                          <?php foreach ($rutas as $ruta): if(!empty($ruta['id_ruta'])): ?>
                          <option value="<?=$ruta['id_ruta'];?>" <?php foreach ($rutasya as $ruta2){ if(!empty($ruta2['id_ruta'])){ if($ruta['id_ruta'] == $ruta2['id_ruta']){ echo "disabled"; } } } ?> ><?=$ruta['nombre_ruta'];?></option>
                          <?php endif; endforeach; ?>
                        </select>
                        <span id="error_ruta" class="errors"></span>
                    </div>
                  </div>
                  <div class="row">
                    <?php for ($i=0; $i < $cantidadMaxima; $i++) {  ?>
                      
                    <div class="form-group col-xs-12 col-sm-6">
                      <label for="lideres<?=$posicion;?>"><span style="margin-left:30px;"></span>Líder (Posicion #<?=$posicion;?>)</label>
                      <div class="input-group">
                        <span class="input-group-addon"><?=$posicion?></span>
                        <input type="hidden" class="posicion<?=$posicion;?>" name="posiciones[]" value="<?=$posicion;?>">
                        <select class="form-control select2 lideres" id="lideres<?=$posicion;?>" name="lideres[]" style="width:100%;">
                          <option value="0"></option>
                          <?php foreach ($lideres as $data): if (!empty($data['id_cliente'])): ?>
                          <option value="<?=$data['id_cliente']?>" <?php foreach($rutalider as $data2){ if(!empty($data2['id_cliente'])){ if($data['id_cliente']==$data2['id_cliente']){ echo "disabled"; } } } ?> >

                            <?=$data['primer_nombre']." ".$data['primer_apellido']." - ".$data['cedula']?><?php foreach($rutalider as $data2){ if(!empty($data2['id_cliente'])){ if($data['id_cliente']==$data2['id_cliente']){ echo " | Ruta (".$data2['nombre_ruta'].")"; } } } ?>
                            
                          </option>
                          <?php endif; endforeach; ?>
                        </select>
                      </div>
                    </div>
                    <?php 
                          $posicion++;
                          } 
                    ?>
                       <!-- <input type="text" class="form-control" id="nombre" name="nombre" maxlength="30" placeholder="Ingresar nombre de la ruta"> -->
                       <!-- <span id="error_lideres" class="errors"></span> -->
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
        window.location = "?route=RutasLideres";
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
    // var response = true;

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
  var ruta = $("#rutas").val();
  var rruta = checkInput(ruta, alfanumericPattern2);
  if(ruta > 0){
    rruta = true;
    $(".error_selected_pedido").html("");
  }else{
    rruta = false;
    $("#error_ruta").html("Debe llenar el campo de la ruta");      
  }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rruta==true){
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
