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
        <?php echo "Retos"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Retos de lideres"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Retos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Retos";}else{echo "Retos";} ?></li>
      </ol>
    </section>
              <?php if(Count($cols)>1 || Count($pedd)<2 || $limittteee=="0"){ ?>
          <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Retos</a></div>
              <?php }else{} ?>
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




        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Agregar <?php echo "Retos"; ?></h3>
              <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                    <?php if (empty($_GET['admin'])): ?>
                      
                      <div style="width:100%;margin:0;padding:0;text-align:right;">
                          <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Retos&action=Registrar&admin=1&select=0"><b>Registrar Retos por Lider</b></a>
                      </div>
                    <?php endif; ?>
              <?php } ?>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <div class="box-body">
              <?php if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>

                <div class="row">
                  <form action="" method="GET" class="form_select_lider">
                  <div class="form-group col-xs-12">
                    <label for="lider">Seleccione al Lider</label>
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="Retos" name="route">
                    <input type="hidden" value="Registrar" name="action">
                    <input type="hidden" value="1" name="admin">
                    <input type="hidden" value="1" name="select">
                    <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                      <option></option>
                        <?php foreach ($lideres as $data): ?>
                          <?php if (!empty($data['id_cliente'])): ?>
                            <?php
                              if($accesoBloqueo=="1"){
                                if(!empty($accesosEstructuras)){
                                  foreach ($accesosEstructuras as $struct) {
                                    if(!empty($struct['id_cliente'])){
                                      if($struct['id_cliente']==$data['id_cliente']){
                                        ?>
                                    <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"  <?php foreach ($liderRetos as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?> disabled <?php } } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                        <?php 
                                      }
                                    }
                                  }
                                }
                              }else if($accesoBloqueo=="0"){
                                ?>
                              <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"  <?php foreach ($liderRetos as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?> disabled <?php } } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                <?php
                              }
                            ?>
                          <?php endif ?>
                        <?php endforeach ?>
                    </select>
                  </div>
                  </form>
                </div>
                <br>
                <?php } ?>
              <form action="" method="post" role="form" class="form_register">
                <?php if(!empty($pedido) && count($pedido)>1){ ?>
                    <label>
                      <?php //$cantidad_colecciones = $pedido['cantidad_aprobado']; ?>
                      <h4>
                        <b>
                          
                        <?=$pedido['primer_nombre'];?> <?=$pedido['primer_apellido'];?> <?=$pedido['cedula'];?>
                        - 
                        ( <?=$coleccionesPuntualesRed;?> Colecciones Alcanzadas )
                        </b>
                      </h4>
                    </label>
                  <div class="row">
                    <div class="form-group col-sm-4">
                       <label for="cantidad_aprobado">Colecciones Disponibles</label>
                       <input type="number" class="form-control" id="cantidad_aprobado" value="<?=$coleccionesPuntualesRed;?>" readonly>
                       <input type="hidden" id="cantidad_aprobado2" value="<?=$coleccionesPuntualesRed;?>">
                       <span id="error_cantidad_aprobado" class="errors"></span>
                    </div>
                    
                  </div>
                  
                  <?php
                    $planesss=[]; $i=0;
                    foreach ($retos as $reto): if(!empty($reto['id_reto_campana'])): ?>
                    <hr>
                    <div class="row">
                      <div class="form-group col-sm-4">
                         <label for="premio"><?=$reto['nombre_premio']?></label>
                         <input type="text" class="form-control" id="premio<?=$reto['id_premio']?>" name="premio[]" value="<?=$reto['nombre_premio'];?>" readonly style='font-size:1.3em'>
                         <span id="error_premio<?=$reto['id_premio']?>" class="errors"></span>
                      </div>
                      <div class="form-group col-sm-4">
                         <label for="cantidad">Cantidad de colecciones</label>
                         <input type="text" class="form-control" id="cantidad<?=$reto['id_premio']?>" value="<?=$reto['cantidad_coleccion'];?>" readonly style='font-size:1.3em'>
                         <span id="error2_premio<?=$plan['id_premio']?>" class="errors"></span>
                      </div>
                      <div class="form-group col-sm-4">
                         <label for="cantidad_premio<?=$reto['nombre_premio']?>">Cantidad de retos</label>
                         <input type="number" step="1" min="0" class="form-control cantidades cant<?=$reto['id_premio']?>" id="<?=$reto['id_premio'];?>" name="cantidad_plan[]" value="0">
                         <input type="hidden" name="id_reto_campana[]" value="<?=$reto['id_reto_campana']?>">
                         <!-- <span id="error_cantidad_aprobado" class="errors"></span> -->
                      </div>
                    </div>
                    <?php
                      $planesss[$i] = $reto['id_premio']; 
                      $i++;
                    endif; endforeach; ?>
                    <input type="hidden" name="id_pedido" value="<?=$pedido['id_pedido']?>">
                    <input type="hidden" name="id_cliente" value="<?=$pedido['id_cliente']?>">
                    <!-- /.box-body --> 
                    <span class="name_planes d-none"><?php echo json_encode($planesss)?></span>

                <?php } ?>
                  <div class="box-footer">
                
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>

                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar d-none" disabled="">enviar</button>
                  </div>
              </form>
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
<input type="hidden" class="idAdmin" <?php if(!empty($_GET['lider'])): ?> value="<?=$_GET['lider']?>" <?php else: ?> value="0" <?php endif; ?>>

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
        var idAdmin = $(".idAdmin").val();
        if(idAdmin==0){
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Retoss";
        }
        if(idAdmin!=0){
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Retos";
        }
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

  $(".selectLider").change(function(){
    var select = $(this).val();
    // alert(select);
    if(select!=""){
      $(".form_select_lider").submit();
    }
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
  $(".cantidades").focusout(function(){
    var cantidad = $(this).val();
    if(cantidad==""){
      $(this).val(0);
    }
    cantidad = parseInt($(this).val());
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
  var aprobadas2 = $("#cantidad_aprobado2").val();
  var raprobadas = false;
  if(aprobadas!=aprobadas2){
    raprobadas = true;
    $("#error_cantidad_aprobado").html("");
  }else{
    raprobadas = false;
    $("#error_cantidad_aprobado").html("Debe seleccionar algun reto");
  }
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
  // alert(aprobadas);
  // var planesss = $(".name_planes").html();
    // var planes = JSON.parse(planesss);
    // if( aprobadas == 0 ){
    //   $("#error_cantidad_aprobado").html("");
    //   raprobadas = true;
    // }else{
    //   raprobadas = false;
    //   $("#error_cantidad_aprobado").html("Debe escoger las cantidad de colecciones para cada plan y alcanzar la cantidad de colecciones disponibles");
    // }
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
