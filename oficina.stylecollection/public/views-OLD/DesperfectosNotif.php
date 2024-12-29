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
        <?php echo "Ver Desperfectos"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Desperfectos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Desperfectos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Plan";}else{echo "Desperfectos";} ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Planes de Coleccion</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Desperfectos Notificados"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form action="" method="post" role="form" class="form_register"> -->
            <div class="box-body">
                    <table style="background:none;text-align:right;width:100%;margin-bottom:30px">
                      <tr>
                        <td style="width:50%">
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&id=<?=$desper['id_notificar_desperfecto']?>">
                            Editar<span class="fa fa-wrench"></span>
                          </button>
                          
                          <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&permission=1">
                            Borrar<span class="fa fa-trash"></span>
                          </button> -->
                        </td>
                      </tr>
                    </table>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Descripción</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // echo Count($planesCol);
                foreach ($desperfectos as $data):
                  if(!empty($data['id_notificar_desperfecto'])):  
                ?>
                <tr>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php //print_r($data); ?>
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['producto']." (".$data['cantidad'].")"; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "".$data['cantidad_desperfectos']." Unid."; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "".$data['descripcion_desperfectos']." Unid."; ?>
                    </span>
                  </td>
                  <!-- <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "$".number_format($data['descuento_directo'],2,',','.'); ?>
                      <?php echo " | $".number_format($data['primer_descuento'],2,',','.'); ?>
                      <?php echo " | $".number_format($data['segundo_descuento'],2,',','.'); ?>
                    </span>
                  </td> -->
                  <!-- <td style="width:20%">
                    <span class="contenido2">
                      <?php echo "".$data['cantidad_coleccion_plan']." Col"; ?>
                    </span>
                  </td> -->
                    
                      
                      
                </tr>
                <?php
                  endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Producto</th>
                  <th>Cantidad</th>
                  <th>Descripción</th>
                </tr>
                </tfoot>
              </table>

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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
<?php endif; ?>
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
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
        var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PlanCol";
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
    
  }

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

  $(".cantidades").change(function(){
    var cantidad = parseInt($(this).val());
    var aprob = parseInt($("#cantidad_aprobado2").val());
    var planesss = $(".name_planes").html();
    var planes = JSON.parse(planesss);
    var resul = 0;
    for (var i = 0; i < planes.length; i++) {
      var p = planes[i];
      var values = parseInt($("#"+p).val());
      var cant = parseInt($("#cantidad"+p).val());
      resul += values*cant;
    }
    if((aprob-resul)>=0){
      $("#cantidad_aprobado").val(aprob-resul);
    }else{
      while(resul>aprob){      
        $(this).val($(this).val()-1);
        resul = 0;
        for (var i = 0; i < planes.length; i++) {
          var p = planes[i];
          var values = parseInt($("#"+p).val());
          var cant = parseInt($("#cantidad"+p).val());
          resul += values*cant;
        }
      }
      if((aprob-resul)>=0){
        $("#cantidad_aprobado").val(aprob-resul);
      }
    }
  });
  $(".cantidades").keyup(function(){
    var cantidad = parseInt($(this).val());
    var aprob = parseInt($("#cantidad_aprobado2").val());
    var planesss = $(".name_planes").html();
    var planes = JSON.parse(planesss);
    var resul = 0;
    for (var i = 0; i < planes.length; i++) {
      var p = planes[i];
      var values = parseInt($("#"+p).val());
      var cant = parseInt($("#cantidad"+p).val());
      resul += values*cant;
    }
    if((aprob-resul)>=0){
      $("#cantidad_aprobado").val(aprob-resul);
    }else{
      while(resul>aprob){      
        $(this).val($(this).val()-1);
        resul = 0;
        for (var i = 0; i < planes.length; i++) {
          var p = planes[i];
          var values = parseInt($("#"+p).val());
          var cant = parseInt($("#cantidad"+p).val());
          resul += values*cant;
        }
      }
      if((aprob-resul)>=0){
        $("#cantidad_aprobado").val(aprob-resul);
      }
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
  var aprobadas = $("#cantidad_aprobado").val();
  var raprobadas = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( aprobadas == 0 ){
      $("#error_cantidad_aprobado").html("");
      raprobadas = true;
    }else{
      raprobadas = false;
      $("#error_cantidad_aprobado").html("Debe escoger las cantidad de colecciones para cada plan y alcanzar la cantidad de colecciones disponibles");
    }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( raprobadas==true){
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
