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
              <h3 class="box-title">
                Asignar Premios Canjeados
                <br>
                <br>
                <b>
                  Líder <?php echo $cliente['primer_nombre']." ".$cliente['primer_apellido']." - ".number_format($cliente['cedula'],0, '.', '.'); ?>
                </b>
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
              <div class="box-body">
                  
                  <?php
                    foreach ($canjeos as $data) {
                      if(!empty($data['id_canjeo'])){
                  ?>

                  <div class="row" <?php if($data['estado_canjeo']=="Asignado"){ ?> style='color:#999;' <?php } ?>>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4" style="text-align:center;">

                      <img src="<?=$data['imagen_catalogo'];?>" style='height:200px;'>
                       <!-- <label for="nombre">Nombre</label> -->
                       <!-- <input type="text" class="form-control" id="nombre" name="nombre" maxlength="50" placeholder="Ingresar nombre de la ruta"> -->
                       <!-- <span id="error_nombre" class="errors"></span> -->
                    </div>
                    <div class="form-group col-xs-12 col-sm-6 col-md-4">
                      <?php
                        echo "<h4>(".$data['unidades']." Unds) | <b>".$data['nombre_catalogo']."</b></h4>";
                        echo "<b>Cantidad de Gemas: </b>".$data['cantidad_gemas']."<img style='width:20px;margin-left:2px;' src='".$fotoGema."'>"."<br>";
                        if($data['codigo_catalogo']!=""){
                          echo "<b>Codigo: </b>".$data['codigo_catalogo']."<br>";
                        }
                        if($data['marca_catalogo']!=""){
                          echo "<b>Marca: </b>".$data['marca_catalogo']."<br>";
                        }
                        if($data['color_catalogo']!=""){
                          echo "<b>Color: </b>".$data['color_catalogo']."<br>";
                        }
                        if($data['voltaje_catalogo']!=""){
                          echo "<b>Voltaje: </b>".$data['voltaje_catalogo']."<br>";
                        }
                        if($data['caracteristicas_catalogo']!=""){
                          echo "<b>Caracteristicas: </b>".$data['caracteristicas_catalogo']."<br>";
                        }
                        if($data['puestos_catalogo']!=""){
                          echo "<b>Puestos: </b>".$data['puestos_catalogo']."<br>";
                        }

                      ?>
                    </div>
                    <form action="" method="post" role="form" class="form_register">
                      <div class="form-group col-xs-12 col-sm-6 col-md-4">
                        <?php if($data['estado_canjeo']=="Asignado"){ ?>
                        <label for="campana">Asignado a: </label>
                        <?php }else{ ?>
                        <label for="campana">Seleccionar Campaña</label>
                        <?php } ?>
                        <select name="id_despacho" id="campana" class="form-control select2" style="width:100%;">
                          <?php foreach ($campanas as $camp){ if(!empty($camp['id_despacho'])){ ?>
                            <option value="<?=$camp['id_despacho']?>" <?php if($camp['id_despacho']==$data['id_despacho']){ echo "selected"; } ?> >
                                <?php
                                  $ndp = "";
                                  if($camp['numero_despacho']=="1"){ $ndp = "1er"; }
                                  if($camp['numero_despacho']=="2"){ $ndp = "2do"; }
                                  if($camp['numero_despacho']=="3"){ $ndp = "3er"; }
                                  if($camp['numero_despacho']=="4"){ $ndp = "4to"; }
                                  if($camp['numero_despacho']=="5"){ $ndp = "5to"; }
                                  if($camp['numero_despacho']=="6"){ $ndp = "6to"; }
                                  if($camp['numero_despacho']=="7"){ $ndp = "7mo"; }
                                  if($camp['numero_despacho']=="8"){ $ndp = "8vo"; }
                                  if($camp['numero_despacho']=="9"){ $ndp = "9no"; }

                                  if($camp['numero_despacho']>1){
                                    echo $ndp; 
                                  }
                                ?>
                                Pedido de Campaña <?=$camp['numero_campana']."/".$camp['anio_campana']." - ".$camp['nombre_campana']?>
                                
                              </option>
                          <?php } } ?> 
                        </select>
                        <input type="hidden" name="id_canjeo" value="<?=$data['id_canjeo']?>">
                        <br><br>
                        <span class="btn enviar" id="<?=$data['id_canjeo']?>">Asignar</span>
                        <button class="btn btn-enviar<?=$data['id_canjeo']?>" style="display:none;"></button>
                      </div>
                    </form>
                  </div>

                  <?php 
                      }
                    }
                  ?>
                  <!-- <div class="row">
                    <div class="form-group">
                      
                    </div>
                  </div> -->

              </div>
              <!-- /.box-body -->

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
<input type="hidden" class="id_lider" value="<?=$id?>">
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
        var id = $(".id_lider").val();
        window.location = "?route=Canjeados&action=Asignar&id="+id;
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
      var id = $(this).attr('id');
      $(".btn-enviar"+id).attr("disabled");
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
    
                          $(".btn-enviar"+id).removeAttr("disabled");
                          $(".btn-enviar"+id).click();
    
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });


  }); // Fin Evento


  // $("body").hide(500);


});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var nombre = $("#nombre").val();
  var rnombre = checkInput(nombre, alfanumericPattern2);
  if( rnombre == false ){
    if(nombre.length != 0){
      $("#error_nombre").html("El nombre de la ruta no debe contener numeros o caracteres especiales");
    }else{
      $("#error_nombre").html("Debe llenar el campo de nombre de la ruta");      
    }
  }else{
    $("#error_nombre").html("");
  }
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
