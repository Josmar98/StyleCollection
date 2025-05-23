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
        <?php echo "Notas de entrega"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Notas de entrega personalizada"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Notas"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Notas de entrega personalizada";}else{echo "Notas de entrega personalizada";} ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?=$menu3; ?>route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Notas de entrega personalizada</a></div>
            <?php } ?>
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

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"): ?>
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        <?php endif; ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>



        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Notas de entrega Personalizada"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form action="" method="post" role="form" class="form_register"> -->
            <div class="box-body">

              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Líder</th>
                    <th>Fecha de Emision</th>
                    <th>Estado</th>
                    <th>---</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                foreach ($notas as $data){
                  if(!empty($data['id_nota_entrega_personalizada'])){
                    $permitido=0;
                    if($accesoBloqueo=="1"){
                      if(!empty($accesosEstructuras)){
                        foreach ($accesosEstructuras as $struct) {
                          if(!empty($struct['id_cliente'])){
                            if($struct['id_cliente']==$data['id_cliente']){
                              $permitido=1;
                            }
                          }
                        }
                      }
                    }else if($accesoBloqueo=="0"){
                      $permitido=1;
                    }
                    if($permitido==1){
                      $estado_nota = "";
                      if($data['estado_nota_personalizada']==1){
                        $estado_nota = "Abierta";
                      }
                      if($data['estado_nota_personalizada']==0){
                        $estado_nota = "Cerrada";
                      }
                      if(mb_strtolower($data['leyenda'])!="credito style"){
                        ?>
                        <tr >
                          <td style="width:5%">
                            <span class="contenido2">
                              <?php echo $num++; ?>
                            </span>
                          </td>
                          <td style="width:15%">
                            <?php if($estado_campana=="1" && $data['estado_nota_personalizada']==1){ ?>
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&nota=<?=$data['id_nota_entrega_personalizada']?>">
                                  <span class="fa fa-wrench"></span>
                                </button>
                                <?php if ($_SESSION['nombre_rol']!="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                  <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_pedido'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                  </button> -->
                                <?php endif; ?>
                            <?php } ?>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                              <br>
                              <?php 
                                switch (strlen($data['numero_nota_entrega'])) {
                                  case 1:
                                    $numero_nota_entrega = "000000".$data['numero_nota_entrega'];
                                    break;
                                  case 2:
                                    $numero_nota_entrega = "00000".$data['numero_nota_entrega'];
                                    break;
                                  case 3:
                                    $numero_nota_entrega = "0000".$data['numero_nota_entrega'];
                                    break;
                                  case 4:
                                    $numero_nota_entrega = "000".$data['numero_nota_entrega'];
                                    break;
                                  case 5:
                                    $numero_nota_entrega = "00".$data['numero_nota_entrega'];
                                    break;
                                  case 6:
                                    $numero_nota_entrega = "0".$data['numero_nota_entrega'];
                                    break;
                                  case 7:
                                    $numero_nota_entrega = "".$data['numero_nota_entrega'];
                                    break;
                                  default:
                                    $numero_nota_entrega = "".$data['numero_nota_entrega'];
                                    break; 
                                }
                              ?>
                              <?php echo $numero_nota_entrega; ?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?=$lider->formatFecha($data['fecha_emision']);?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?=$estado_nota; ?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <a href="?<?=$menu?>&route=<?=$url; ?>&action=Ver&nota=<?=$data['id_nota_entrega_personalizada']?>"> Ver nota de entrega</a>
                            </span>
                          </td>
                        </tr>
                        <?php
                      }
                    }
                  } }
                ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Líder</th>
                    <th>Fecha de Emision</th>
                    <th>Estado</th>
                    <th>---</th>
                  </tr>
                </tfoot>
              </table>

            </div>
              
          </div>

          <?php if(count($notasE)>1){ ?>
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title"><?php echo "Crédito Style"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form action="" method="post" role="form" class="form_register"> -->
            <div class="box-body">

              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Empleado</th>
                    <th>Fecha de Emision</th>
                    <th>Estado</th>
                    <th>---</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                foreach ($notasE as $data){
                  if(!empty($data['id_nota_entrega_personalizada'])){
                      $estado_nota = "";
                      if($data['estado_nota_personalizada']==1){
                        $estado_nota = "Abierta";
                      }
                      if($data['estado_nota_personalizada']==0){
                        $estado_nota = "Cerrada";
                      }
                      if(mb_strtolower($data['leyenda'])=="credito style"){
                        ?>
                        <tr >
                          <td style="width:5%">
                            <span class="contenido2">
                              <?php echo $num++; ?>
                            </span>
                          </td>
                          <td style="width:15%">
                            <?php if($estado_campana=="1" && $data['estado_nota_personalizada']==1){ ?>
                                <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&nota=<?=$data['id_nota_entrega_personalizada']?>">
                                  <span class="fa fa-wrench"></span>
                                </button>
                                <?php if ($_SESSION['nombre_rol']!="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
                                  <!-- <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&id=<?php echo $data['id_pedido'] ?>&permission=1">
                                      <span class="fa fa-trash"></span>
                                  </button> -->
                                <?php endif; ?>
                            <?php } ?>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?php echo $data['primer_nombre']." ".$data['primer_apellido']; ?>
                              <br>
                              <?php 
                                switch (strlen($data['numero_nota_entrega'])) {
                                  case 1:
                                    $numero_nota_entrega = "000000".$data['numero_nota_entrega'];
                                    break;
                                  case 2:
                                    $numero_nota_entrega = "00000".$data['numero_nota_entrega'];
                                    break;
                                  case 3:
                                    $numero_nota_entrega = "0000".$data['numero_nota_entrega'];
                                    break;
                                  case 4:
                                    $numero_nota_entrega = "000".$data['numero_nota_entrega'];
                                    break;
                                  case 5:
                                    $numero_nota_entrega = "00".$data['numero_nota_entrega'];
                                    break;
                                  case 6:
                                    $numero_nota_entrega = "0".$data['numero_nota_entrega'];
                                    break;
                                  case 7:
                                    $numero_nota_entrega = "".$data['numero_nota_entrega'];
                                    break;
                                  default:
                                    $numero_nota_entrega = "".$data['numero_nota_entrega'];
                                    break; 
                                }
                              ?>
                              <?php echo $numero_nota_entrega; ?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?=$lider->formatFecha($data['fecha_emision']);?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <?=$estado_nota; ?>
                            </span>
                          </td>
                          <td style="width:20%">
                            <span class="contenido2">
                              <a href="?<?=$menu?>&route=<?=$url; ?>&action=Ver&nota=<?=$data['id_nota_entrega_personalizada']?>"> Ver nota de entrega</a>
                            </span>
                          </td>
                        </tr>
                        <?php
                      }
                  } }
                ?>
                </tbody>
                <tfoot>
                  <tr>
                    <th>Nº</th>
                    <th>---</th>
                    <th>Líder</th>
                    <th>Fecha de Emision</th>
                    <th>Estado</th>
                    <th>---</th>
                  </tr>
                </tfoot>
              </table>

            </div>
              
          </div>
          <?php } ?>

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
