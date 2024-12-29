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
        <?php echo "Ver Premios de colecciones"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Premios de Colecciones"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios de Colecciones"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Plan";}else{echo "Premios";} ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Planes de Coleccion</a></div> -->
    <!-- Main content -->
    <section class="content">
      <div class="row">

        <?php 
          $supervisorPlanesYPremiosPermitidos = 0;
          $administrativoPlanesYPremiosPermitidos = 0;
          $analistaPlanesYPremiosPermitidos = 0;
          $configuraciones = $lider->consultarQuery("SELECT * FROM configuraciones WHERE estatus = 1");
          foreach ($configuraciones as $config) {
            if(!empty($config['id_configuracion'])){
              if($config['clausula']=="Supervisorplanesypremiospermitidos"){
                $supervisorPlanesYPremiosPermitidos = $config['valor'];
              }
              if($config['clausula']=="Administrativoplanesypremiospermitidos"){
                $administrativoPlanesYPremiosPermitidos = $config['valor'];
              }
              if($config['clausula']=="Analistasplanesypremiospermitidos"){
                $analistaPlanesYPremiosPermitidos = $config['valor'];
              }
            }
          }
        ?>
        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->

        <?php
          $estado_campana2 = $lider->consultarQuery("SELECT estado_campana FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
          $estado_campana = $estado_campana2[0]['estado_campana'];
        ?>
        <?php if($estado_campana=="0"): ?>
        <div class="row">
          <div class="col-xs-12 col-md-12">
            <div class="box">
              <div class="box-header">
                <h3 class="box-title">
                  Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
                </h3>
              </div>
            </div>
          </div>  
        </div>
        <?php endif; ?>
        <?php
          if ($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){
            $estado_campana = "1";
          }
        ?>

          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">
                <?php echo "Premios Seleccionados para los planes de sus Colecciones"; ?>
                
                <?php 
                if(!empty($_GET['admin']) && !empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"  || $_SESSION['nombre_rol']=="Administrativo")){
                  echo "<br><br>";
                  echo "<b>Líder ".$pedido['primer_nombre']." ".$pedido['primer_apellido']." (".$pedido['cantidad_aprobado']." Colecciones)</b>";
                }
                 ?>
                
              </h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <!-- <form action="" method="post" role="form" class="form_register"> -->
            <div class="box-body">
                    <table style="background:none;text-align:right;width:100%;margin-bottom:30px">
                      <tr>
                        <?php //echo "Limite: ".$limittteee; ?>
                        <td style="width:50%">
                          <?php if($estado_campana=="1"){ ?>
                      <?php 
                        if((date('Y-m-d') > $desp['limite_seleccion_plan'])){}else{ if(empty($_GET['id']) && empty($_GET['admin'])){ ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar">
                            Editar<span class="fa fa-wrench"></span>
                          </button>
                      <?php }} 
                          }
                        if(!empty($_GET['id']) && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador"|| $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"  || $_SESSION['nombre_rol']=="Administrativo")){ ?>

                            <?php if($_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"): ?>
                                <?php if($limittteee=="1" || ($_SESSION['nombre_rol']=="Analista Supervisor" && $supervisorPlanesYPremiosPermitidos=="1") || ($_SESSION['nombre_rol']=="Analista" && $analistaPlanesYPremiosPermitidos=="1") || ($_SESSION['nombre_rol']=="Administrativo" && $administrativoPlanesYPremiosPermitidos=="1")  ): ?>
                                <div class="row">
                                    <div class="col-xs-12 col-sm-6" style="text-align:left;">
                                        <u>
                                          <a href="?<?=$menu?>&route=PlanCol&admin=1&id=<?=$_GET['id']?>" class="">Ver planes</a>
                                        </u>
                                      
                                    </div>
                                    <div class="col-xs-12 col-sm-6" style="text-align:right;">

                                      <?php if($estado_campana=="1"){ ?>
                                      
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&admin=1&id=<?=$_GET['id']?>">
                                          Editar<span class="fa fa-wrench"></span>
                                        </button>
                                      <?php } ?>
                                    </div>
                                </div>      
                              <?php endif; ?>  
                            <?php else: ?>
                              <div class="row">
                                  <div class="col-xs-12 col-sm-6" style="text-align:left;">
                                      <u>
                                        <a href="?<?=$menu?>&route=PlanCol&admin=1&id=<?=$_GET['id']?>" class="">Ver planes</a>
                                      </u>
                                    
                                  </div>
                                  <div class="col-xs-12 col-sm-6" style="text-align:right;">

                                    <?php if($estado_campana=="1"){ ?>
                                    
                                      <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?<?php echo $menu ?>&route=<?php echo $url; ?>&action=Modificar&admin=1&id=<?=$_GET['id']?>">
                                        Editar<span class="fa fa-wrench"></span>
                                      </button>
                                    <?php } ?>
                                  </div>
                              </div>

                            <?php endif; ?>

                      <?php  
                        }
                      ?>

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
                  <th>Plan</th>
                  <!-- <th>Coleccion</th> -->
                  <th>Premios</th>
                  </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                $x = 0;
                // print_r($planesCol);
                // echo Count($planesCol);
                foreach ($pagos_despacho as $pDesp){ if(!empty($pDesp['id_despacho'])){ if($pDesp['asignacion_pago_despacho']=="seleccion_premios"){
                foreach ($planesCol as $data){ if(!empty($data['id_tipo_coleccion'])){
                    foreach ($premios_planes as $premios){ if(!empty($premios['id_plan_campana'])){
                      if($premios['tipo_premio']==$pDesp['tipo_pago_despacho']){
                        if($opStandard==0){
                          if($data['nombre_plan']=="Standard"){
                            if($data['cantidad_coleccion_plan']>0){
                              if($x == 0){
                                  ?>
                              <tr style="background:<?=$data['color_plan']?>77">
                                <td style="width:5%;" >
                                  <span class="contenido2">
                                    <?php echo $num++; ?>
                                  </span>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <h4>
                                      <?php 
                                        echo "<span style='font-size:.9em;'>(".$data['cantidad_coleccion_plan'];
                                        if ($data['cantidad_coleccion_plan'] == 1){
                                          echo " Plan) </span>";
                                        }else{
                                          echo " Planes) </span>";
                                        }
                                        echo $data['nombre_plan'];
                                      ?>
                                    </h4>
                                  </span>
                                </td>

                                <td style="width:20%">
                                  <?php foreach ($premios_planes_strandar as $key0){ if(!empty($key0['producto'])){ ?>
                                    <?php if ($pDesp['tipo_pago_despacho']==$key0['tipo_premio']): ?>
                                      
                                      <span class="contenido2">
                                        <?=$data['cantidad_coleccion_plan']." ".$key0['producto']?>
                                        <br>
                                      </span>
                                    <?php endif; ?>
                                  <?php }} ?>
                                </td>
                              </tr>

                                  <?php 
                              $x++;
                              }
                            }
                          }
                        }

                        if($data['id_plan_campana'] == $premios['id_plan_campana']){
                          if($data['cantidad_coleccion_plan']!=0){
                            ?>
                            <tr style="background:<?=$data['color_plan']?>77">
                              <td style="width:5%;" >
                                <span class="contenido2">
                                  <?php //print_r($data); ?>
                                  <?php echo $num++; ?>
                                </span>
                              </td>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <h4>
                                    <?php 
                                      echo "<span style='font-size:.9em;'>(".$data['cantidad_coleccion_plan'];
                                      if ($data['cantidad_coleccion_plan'] == 1){
                                        echo " Plan) </span>";
                                      }else{
                                        echo " Planes) </span>";
                                      }
                                      echo $data['nombre_plan'];
                                    ?>
                                  </h4>
                                </span>
                              </td>

                              <td style="width:20%">
                                <?php
                                  foreach ($premioscol as $key1){ if(!empty($key1['id_plan_campana'])){
                                    if($key1['id_plan_campana'] == $premios['id_plan_campana']){
                                      if ($key1['cantidad_premios_plan'] > 0){ ?>
                                        <span class="contenido2">
                                          <?=$key1['cantidad_premios_plan']." ".$key1['nombre_premio']."<br>"; ?>
                                        </span>
                                      <?php }
                                    }
                                  }}
                                ?>
                              </td>
                            </tr>
                            <?php
                          }
                        }
                      }
                    }}
                }}
                }}}
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>Plan</th>
                  <!-- <th>Coleccion</th> -->
                  <th>Premios</th>
                  <!-- <th>Premios Seleccionados</th> -->
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
