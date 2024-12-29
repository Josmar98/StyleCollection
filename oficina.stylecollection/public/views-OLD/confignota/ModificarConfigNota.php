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
        <?php echo "Config. de nota"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Config. de nota"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Config. de nota"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Config. de nota";}else{echo "Config. de nota";} ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Planes de Coleccion</a></div> -->
               <div style="width:100%;text-align:center;"><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Config. de nota de entrega</a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Config. de nota"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                <br>
                  <div class="row">
                    <?php
                      foreach ($planesCol as $data2) { 
                        if(!empty($data2['id_plan'])){
                    ?>
                      <div class="form-group col-xs-12 col-sm-4">
                        <label for="opt<?=$data2['id_plan']?>">Plan <?=$data2['nombre_plan']?></label>
                        <input type="hidden" name="planes" id="planes<?=$data2['id_plan']?>" value="<?=$data2['id_plan']?>">
                        <select class="form-control" id="opt<?=$data2['id_plan']?>" name="opciones">
                          <option value="1" <?php if($data2['opcion']=="1"){ echo "selected"; } ?> >Habilitado</option>
                          <option value="0" <?php if($data2['opcion']=="0"){ echo "selected"; } ?> >inhabilitado</option>
                        </select>
                      </div>
                    <?php
                        }
                      } 
                    ?>
                  </div>
              </div>


              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
              </div>
            </form>
          </div>

        </div>

        
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">

<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">

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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        // var campaing = $(".campaing").val();
        // var n = $(".n").val();
        // var y = $(".y").val();
        // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=ConfigNota";
        // window.location.href=menu;

        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=ConfigNota";
        window.location = menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      });
    }

    if(response == "77"){
      swal.fire({
          type: 'warning',
          title: '¡No se lograron agregar los Premios!',
          text: "¡La Existecia de algunos premios se agoto antes de guardar los cambios!",
          confirmButtonText: "¡Aceptar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){

        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=ConfigNota";
        window.location = menu;
      });
    }
    
  }


  $(".enviar").click(function(){
    // var response = validadPerdidos();
    var response = true;

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



    
    }
  });




});
function validadPerdidos(){
  var planes = $(".name_planes").html();
  var data = JSON.parse(planes);
  var cod = "";
  var val = "";
  var clase = "";
  var cant = "";
  var results = [];
  for (var i = 0; i < data.length; i++) {
    // alert(data[i]['codigo']+"_"+data[i]['valor']);
    results[i] = false;
    cod = data[i]['codigo'];
    val = data[i]['valor'];
    clase = data[i]['codigo']+"_"+data[i]['valor'];
    cant = $("."+clase).val();
    // alert(cant);
    if(cant==""){
      results[i] = false;
      $(".error_"+clase).html("Debe llenar la cantidad de premios pedidos.");
    }else{
      results[i] = true;
      $(".error_"+clase).html("");
    }
  }
  var result = false;
  var number = 0;
  for (var i = 0; i < results.length; i++) {
    if(results[i]==false){
      number++;
    }
  }
  if(number==0){
    result = true;
  }else{
    result = false;    
  }
  return result;
}


</script>
</body>
</html>
