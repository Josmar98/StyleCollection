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
        <?php echo "Desperfectos"; ?>
        <small><?php echo " Notificar Desperfectos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Desperfectos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Desperfectos";}else{echo "Desperfectos";} ?></li>
      </ol>
    </section>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Desperfectos</a></div>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Notificar <?php echo "Desperfectos"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                  <div class="row">
                    <div class="form-group col-sm-4">
                       <label for="cantidad_aprobado">Colecciones Disponibles</label>
                       <input type="number" class="form-control" id="cantidad_aprobado" value="<?=$pedido['cantidad_aprobado']?>" readonly>
                       <input type="hidden" id="cantidad_aprobado2" value="<?=$pedido['cantidad_aprobado']?>">
                    </div>
                    
                  </div>
                  <!-- <?php print_r($colecciones); ?> -->
                <!-- <table class="table table-hover table-striped">
                  <thead>
                    <th>Producto</th>
                    <th>Cantidad Por Coleccion</th>
                    <th>Cantidad</th>
                  </thead>
                  <tbody> -->

                  <!-- <div class="row">
                    <div class="col-xs-12 col-md-4"><b>Productos</b></div>
                    <div class="col-xs-12 col-md-4"><b>Unidades en la colección</b></div>
                    <div class="col-xs-12 col-md-4"><b>Unidades con desperfectos</b></div>
                  </div> -->

                  <div class="row">
                    
                    <?php foreach ($colecciones as $collss): if(!empty($collss['id_producto'])):?>
                      <div class="col-xs-12" style="margin:10px 1.5%;border-top:1px solid #CCC;width:97%;"></div>
                      <div class="col-xs-12 col-md-4">
                        <input type="hidden" value="<?=$collss['producto']." (".$collss['cantidad'].")"?>" class="form-control" name="" readonly>
                        <label for="cant<?php echo $collss['id_producto'] ?>"><?=$collss['producto']." (".$collss['cantidad'].")"?></label>
                        <input type="number" value="<?=$collss['cantidad_productos']?>" class="form-control cant<?php echo $collss['id_producto'] ?>" id="cant<?php echo $collss['id_producto'] ?>" name="" readonly="">
                      </div>
                      <div class="col-xs-12 col-sm-6 col-md-4">
                        <input type="hidden" value="<?=$collss['id_producto']?>" name="id_producto[]">
                        <label for="<?php echo $collss['id_producto'] ?>">Cantidad de Productos con desperfectos <small> (Max. <?=$collss['cantidad_productos']*$pedido['cantidad_aprobado'];?>) </small></label>
                        <input type="number" value="0" min="0" max="<?=$collss['cantidad_productos']*$pedido['cantidad_aprobado'] ?>" id="<?php echo $collss['id_producto'] ?>" class="form-control cantidades" name="cantidad_desperfectos[]">
                      </div>
                      <div class="col-xs-12 col-sm-6 col-md-4">
                        <label for="descripcion<?=$collss['id_producto']; ?>">Especifique el desperfecto en el/los producto/s</label>
                        <textarea class="form-control" name="descripcion_desperfectos[]" id="descripcion<?=$collss['id_producto']; ?>" style="min-width:100%;max-width:100%;min-height:35px;max-height:70px;" maxlength="250" placeholder="Describa a detalle el desperfecto encontrado"></textarea>
                      </div>
                    <?php endif; endforeach; ?>
                    <input type="hidden" name="id_desperfecto" value="<?=$desperfecto['id_desperfecto']?>">
                  </div>
                      
                    <span id="error_cantidad_desperfectos" class="errors"></span>
              </div>
              <input type="hidden" name="id_pedido" value="<?=$pedido['id_pedido']?>">
              <!-- /.box-body --> 
              <span class="coleccionesss d-none"><?php echo json_encode($colecciones)?></span>

              <div class="box-footer">
                
                <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                <button class="btn-enviar d-none" disabled="">enviar</button>
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
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=DesperfectosNotif";
        window.location.href=menu;
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
    if(response == "9"){
      swal.fire({
          type: 'error',
          title: '¡Reporte de Desperfectos Ya realizado!',
          text: 'Sugerimos dirigirse a Editar su Notificacion de Desperfectos',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "#ED2A77"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=DesperfectosNotif";
        window.location.href=menu;
      });
    }
    
  }

  $(".cantidades").change(function(){
    var cantidad = parseInt($(this).val());
    var colTotal = parseInt($("#cantidad_aprobado").val());
    var id = $(this).attr('id');
    var cantUnit = $(".cant"+id).val();
    // alert(cantUnit);
    var limlim = colTotal*cantUnit;
    if(cantidad > limlim){
      $(this).val(limlim);
    }
    if(cantidad < 0){
      $(this).val(0);
    }
  });
  $(".cantidades").keyup(function(){
    var cantidad = parseInt($(this).val());
    var colTotal = parseInt($("#cantidad_aprobado").val());
    var id = $(this).attr('id');
    var cantUnit = $(".cant"+id).val();
    // alert(cantUnit);
    var limlim = colTotal*cantUnit;
    if(cantidad > limlim){
      $(this).val(limlim);

    }
    if(cantidad < 0){
      $(this).val(0);
    }
  });


  $(".enviar").click(function(){
    var response = validarLiderazgos();

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
function validarLiderazgos(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var colecciones = $(".coleccionesss").html();
  var cols = JSON.parse(colecciones);
  var cantProductos = (Object.keys(cols).length-1);
  var cantidad = 0;
  for (var i = 0; i < cantProductos; i++) {
    var id = cols[i]['id_producto'];
    cantidad += parseInt($("#"+id).val());
  }

  var rcant = false;
  if(cantidad > 0){
    rcant = true;
    $("#error_cantidad_desperfectos").html("");
  }
  else{
    $("#error_cantidad_desperfectos").html("Debe llenar una cantidad de productos con desperfectos");
    rcant = false;
  }

  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rcant==true){
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
