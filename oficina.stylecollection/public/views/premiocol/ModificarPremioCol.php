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
        <?php echo "Premios de colecciones"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " Premio de Colecciones"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios de Colecciones"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Premios";}else{echo "Premios";} ?></li>
      </ol>
    </section>
          <br>
            <?php if(empty($_GET['id'])){ ?>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Premios de Coleccion</a></div>
            <?php } ?>
            <?php if(!empty($_GET['id']) && $_GET['id']!=$_SESSION['id_cliente'] && ($_SESSION['nombre_rol']=="Superusuario"||$_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor")){ ?>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>&admin=1&id=<?=$_GET['id']?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Premios de Coleccion</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">






        <!-- left column -->
        <div class="col-xs-12" >
          <!-- general form elements -->
          <div class="box">
            <div class="box-header with-border">
              <h3 class="box-title">Editar <?php echo "Premios de colecciones"; ?></h3>
            </div>
            <!-- /.box-header -->
            <!-- form start -->
            <form action="" method="post" role="form" class="form_register">
              <div class="box-body">
                <?php
                  $planesss=[]; $i=0; $j=0;
                  foreach ($pagos_despacho as $keys) {
                    if(!empty($keys['id_despacho'])){
                      if($keys['asignacion_pago_despacho']=="seleccion_premios"){
                        $tipo_pago_despacho = $keys['tipo_pago_despacho'];
                  
                  foreach ($planesCol as $plan){ if(!empty($plan['id_tipo_coleccion'])){
                    $st = "";
                    if(strlen($plan['id_plan'])==1){ $st="0"; }
                    $plan['id_plan'] = $st.$plan['id_plan'];
                    foreach ($premios_planes as $premios){ if(!empty($premios['id_plan_campana'])){
                      if($plan['id_plan_campana'] == $premios['id_plan_campana']){
                        if($premios['tipo_premio']==$tipo_pago_despacho){
                          if($plan['cantidad_coleccion_plan']!=0){ ?>
                            <div class="row">
                              <div class="col-xs-12">
                                <label for="plan" style="font-size:1.3em;">Plan <?=$plan['nombre_plan']; ?> | <?=$plan['cantidad_coleccion_plan']?> Planes</label>
                                <input type="hidden" class="form-control" id="plan<?=$plan['id_plan']?>" name="plan[]" value="<?=$plan['nombre_plan'];?>" readonly style='font-size:1.3em'>
                                <span id="error_plan<?=$plan['id_plan']?>" class="errors"></span>
                                <br>
                                <label>Cantidad de Planes Disponibles</label>
                                <!-- <label for="cantidad_plan<?=$plan['id_plan']?>">Cantidad de Planes Disponibles</label> -->
                                <input type="number" step="1" min="0" class="form-control aprobado<?=$plan['id_plan']?>" id="<?=$plan['id_plan'];?>" name="cantidad_plan[]" readonly value="0">
                                <input type="hidden" class="max<?=$plan['id_plan']?>" value="<?=$plan['cantidad_coleccion_plan']?>">
                                <span id="error_max<?=$plan['id_plan']?>" class="errors"></span>
                              </div>

                              <div class="col-xs-12">
                                <?php
                                  foreach ($premioscol as $premiosPlan) {
                                    if(!empty($premiosPlan['id_plan_campana'])){
                                      $stp = "";
                                      if(strlen($premiosPlan['id_premio'])==1){ $stp="0"; }
                                      $premiosPlan['id_premio'] = $stp.$premiosPlan['id_premio'];
                                      
                                        // echo "<br>";
                                        // echo $plan['id_plan_campana']." | ";
                                        // echo $premiosPlan['id_plan_campana']." | ";
                                      if($plan['id_plan_campana'] == $premiosPlan['id_plan_campana']){
                                        if($premiosPlan['id_ppc']==$premios['id_ppc']){ ?>
                                          <div class="col-xs-12">
                                            <div class="form-group col-xs-12">
                                              <label for="<?=$plan['id_plan'].$premiosPlan['id_premio']?>">
                                                Cantidad del Premio | <span style="font-size:1.2em;">(<?=$premiosPlan['nombre_premio']?>)</span>
                                                <?php
                                                  $id_premios_busqueda = $premiosPlan['id_premio'];
                                                  $premiosinv = $lider->consultarQuery("SELECT * FROM premios_inventario WHERE estatus = 1 and id_premio = {$id_premios_busqueda}");
                                                  $iter = 1;
                                                  echo " => <small>[";
                                                  foreach($premiosinv as $pinv){
                                                    if(!empty($pinv['id_premio_inventario'])){
                                                      if($pinv['tipo_inventario']=="Productos"){
                                                        $queryMosInv = "SELECT *, productos.producto as elemento FROM premios_inventario, productos WHERE premios_inventario.id_inventario=productos.id_producto and productos.id_producto={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                                                      }
                                                      if($pinv['tipo_inventario']=="Mercancia"){
                                                        $queryMosInv = "SELECT *, mercancia.mercancia as elemento FROM premios_inventario, mercancia WHERE premios_inventario.id_inventario=mercancia.id_mercancia and mercancia.id_mercancia={$pinv['id_inventario']} and premios_inventario.id_premio={$id_premios_busqueda}";
                                                      }
                                                      $inventariosMos = $lider->consultarQuery($queryMosInv);
                                                      foreach ($inventariosMos as $invm) {
                                                        if(!empty($invm[0])){
                                                          echo $invm['unidades_inventario']." ".$invm['elemento'];
                                                          if($iter < (count($premiosinv)-1)){
                                                            echo " | ";
                                                          }

                                                        }
                                                      }
                                                    }
                                                    $iter++;
                                                  }
                                                  echo "]</small>";
                                                ?>
                                              </label>
                                              <!-- <label for="">Premio</label> -->
                                              <input type="hidden" class="form-control " id="" name="premios[]" value="<?=$premiosPlan['nombre_premio']?>" readonly>
                                              <span class="existenciaDisponible<?=$plan['id_plan'].$premiosPlan['id_premio']?> errors"></span>
                                              <?php
                                                foreach ($existencias as $exiss) {
                                                 if(!empty($exiss['id_premio'])){
                                                    if($exiss['id_premio'] == $premiosPlan['id_premio']){ ?>
                                                      <input type="hidden" name="id_existencia[]" value="<?=$exiss['id_existencia']?>">
                                                      <input type="hidden" id="existencia<?=$plan['id_plan'].$premiosPlan['id_premio']?>" name="existenciaAct[]" value="<?=$exiss['cantidad_existencia']+$premiosPlan['cantidad_premios_plan']?>">
                                                      <input type="hidden" name="existenciaAnt[]" value="<?=$exiss['cantidad_existencia']?>">
                                                      <input type="hidden" id="newexistencia<?=$plan['id_plan'].$premiosPlan['id_premio']?>" name="existenciaNew[]" value="<?=$exiss['cantidad_existencia']?>">
                                                    <?php }
                                                  }
                                                }
                                              ?>
                                              <input type="hidden" name="id_tipo_coleccion[]" value="<?=$plan['id_tipo_coleccion']?>">
                                              <input type="hidden" name="id_tppc[]" value="<?=$premiosPlan['id_tppc']?>">
                                              <input type="number" step="1" min="0" class="form-control cantidades cant<?=$plan['id_plan'].$premiosPlan['id_premio']?>" id="<?=$plan['id_plan'].$premiosPlan['id_premio'];?>" name="cantidad_premios_plan[]" <?php if($plan['cantidad_coleccion_plan']=="0"){echo "readonly value='0'";}else{ ?> value="<?=$premiosPlan['cantidad_premios_plan']?>" <?php } ?> >
                                              <input type="hidden" id="llenar<?=$plan['id_plan'].$premiosPlan['id_premio'];?>" <?php if($plan['cantidad_coleccion_plan']=="0"){echo " value='0'";}else{ ?> value="<?=$premiosPlan['cantidad_premios_plan']?>" <?php } ?>>
                                              <input type="hidden" name="id_premio_coleccion[]" value="<?=$premiosPlan['id_premio_coleccion']?>">
                                              <input type="hidden" name="id_plan_campana[]" value="<?=$plan['id_plan_campana']?>">
                                              <span id="error_cantidad_aprobado" class="errors"></span>
                                            </div>
                                          </div>
                                          
                                          <?php 
                                          $planesss[$j] = $plan['id_plan'].$premiosPlan['id_premio'];
                                          // $planesss3[$j] = $premiosPlan['id_premio'];
                                          $j++; 
                                        }
                                      }
                                    }
                                  }
                                ?>
                              </div>
                            </div>
                            <hr>
                            <?php
                            $planesss2[$i] = $plan['id_plan'];
                            $i++;
                            ?>
                            <?php if($plan['opcion_plan']==1){ 
                              ?>
                              <div class="row" style="background:#ecedef;width:100%;margin-left:.000005%;padding-top:5px;">
                                <div class="col-xs-12">
                                  <label for="plan" style="font-size:1.3em;">(<?=$opcionesSecondTxt; ?>) Plan <?=$plan['nombre_plan']; ?> | <?=$plan['cantidad_coleccion_plan']?> Planes</label>
                                  <input type="hidden" class="form-control" id="plan<?=$plan['opcion_plan'].$plan['id_plan']?>" name="plan<?=$plan['opcion_plan']; ?>[]" value="<?=$plan['nombre_plan'];?>" readonly style='font-size:1.3em'>
                                  <span id="error_plan<?=$plan['opcion_plan'].$plan['id_plan']?>" class="errors"></span>
                                  <br>
                                  <label>Cantidad de Planes Disponibles</label>
                                  <!-- <label for="cantidad_plan<?=$plan['id_plan']?>">Cantidad de Planes Disponibles</label> -->
                                  <input type="number" step="1" min="0" class="form-control aprobado<?=$plan['opcion_plan'].$plan['id_plan']?>" id="<?=$plan['opcion_plan'].$plan['id_plan'];?>" name="cantidad_plan<?=$plan['opcion_plan']; ?>[]" readonly value="0">
                                  <input type="hidden" class="max<?=$plan['opcion_plan'].$plan['id_plan']?>" value="<?=$plan['cantidad_coleccion_plan']?>">
                                  <span id="error_max<?=$plan['opcion_plan'].$plan['id_plan']?>" class="errors"></span>
                                </div>

                                <div class="col-xs-12">
                                  <?php
                                    foreach ($premioscol_opcion as $premiosPlan) {
                                      if(!empty($premiosPlan['id_plan_campana'])){
                                        $stp = "";
                                        if(strlen($premiosPlan['id_premio'])==1){ $stp="0"; }
                                        $premiosPlan['id_premio'] = $stp.$premiosPlan['id_premio'];
                                        
                                        if($plan['id_plan_campana'] == $premiosPlan['id_plan_campana']){
                                          if($premiosPlan['id_ppc']==$premios['id_ppc']){ ?>
                                            <div class="col-xs-12">
                                              <div class="form-group col-xs-12">
                                                <label for="<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio']?>">Cantidad del Premio | <span style="font-size:1.2em;">(<?=$premiosPlan['nombre_premio']?>)</span></label>
                                                <!-- <label for="">Premio</label> -->
                                                <input type="hidden" class="form-control " id="" name="premios<?=$plan['opcion_plan']; ?>[]" value="<?=$premiosPlan['nombre_premio']?>" readonly>
                                                <span class="existenciaDisponible<?=$plan['id_plan'].$premiosPlan['id_premio']?> errors"></span>
                                                <?php
                                                  foreach ($existencias as $exiss) {
                                                   if(!empty($exiss['id_premio'])){
                                                      if($exiss['id_premio'] == $premiosPlan['id_premio']){ ?>
                                                        <input type="hidden" name="id_existencia<?=$plan['opcion_plan']; ?>[]" value="<?=$exiss['id_existencia']?>">
                                                        <input type="hidden" id="existencia<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio']?>" name="existenciaAct<?=$plan['opcion_plan']; ?>[]" value="<?=$exiss['cantidad_existencia']+$premiosPlan['cantidad_premios_plan']?>">
                                                        <input type="hidden" name="existenciaAnt<?=$plan['opcion_plan']; ?>[]" value="<?=$exiss['cantidad_existencia']?>">
                                                        <input type="hidden" id="newexistencia<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio']?>" name="existenciaNew<?=$plan['opcion_plan']; ?>[]" value="<?=$exiss['cantidad_existencia']?>">
                                                      <?php }
                                                    }
                                                  }
                                                ?>
                                                <input type="hidden" name="id_tipo_coleccion<?=$plan['opcion_plan']; ?>[]" value="<?=$plan['id_tipo_coleccion']?>">
                                                <input type="hidden" name="id_tppc<?=$plan['opcion_plan']; ?>[]" value="<?=$premiosPlan['id_tppc']?>">
                                                <input type="number" step="1" min="0" class="form-control cantidades cant<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio']?>" id="<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio'];?>" name="cantidad_premios_plan<?=$plan['opcion_plan']; ?>[]" <?php if($plan['cantidad_coleccion_plan']=="0"){echo "readonly value='0'";}else{ ?> value="<?=$premiosPlan['cantidad_premios_plan']?>" <?php } ?> >
                                                <input type="hidden" id="llenar<?=$plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio'];?>" <?php if($plan['cantidad_coleccion_plan']=="0"){echo " value='0'";}else{ ?> value="<?=$premiosPlan['cantidad_premios_plan']?>" <?php } ?>>
                                                <input type="hidden" name="id_premio_coleccion<?=$plan['opcion_plan']; ?>[]" value="<?=$premiosPlan['id_premio_coleccion_opcion']?>">
                                                <input type="hidden" name="id_plan_campana<?=$plan['opcion_plan']; ?>[]" value="<?=$plan['id_plan_campana']?>">
                                                <span id="error_cantidad_aprobado" class="errors"></span>
                                              </div>
                                            </div>
                                            
                                            <?php 
                                            $planesss[$j] = $plan['opcion_plan'].$plan['id_plan'].$premiosPlan['id_premio'];
                                            // $planesss3[$j] = $premiosPlan['id_premio'];
                                            $j++; 
                                          }
                                        }
                                      }
                                    }
                                  ?>
                                </div>
                              </div>
                              <hr>
                              <?php
                              $planesss2[$i] = $plan['opcion_plan'].$plan['id_plan'];
                              $i++;
                              ?>
                              <?php
                            } ?>
                            <?php
                          }
                        }
                      }
                    }}
                  }}

                      }
                    }
                  }

                ?>

                <?php 
                  $planesss3 = []; $x = 0;
                  foreach ($tipo_premios_planespp as $keys3){ if (!empty($keys3['id_premio'])){
                    $stp = "";
                    if(strlen($keys3['id_premio'])==1){ $stp="0"; }
                    $planesss3[$x] = $stp.$keys3['id_premio'];
                    $x++;
                  } }
                ?>
              </div>
              <input type="hidden" name="id_pedido" value="<?=$pedido['id_pedido']?>">
              <!-- /.box-body --> 
              <span class="name_planes d-none"><?php echo json_encode($planesss)?></span>
              <br>
              <span class="name_planes2 d-none"><?php echo json_encode($planesss2)?></span>
              <br>
              <span class="name_planes3 d-none"><?php echo json_encode($planesss3)?></span>

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
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<input type="hidden" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>">
<input type="hidden" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>">
<input type="hidden" class="idAdmin" <?php if(!empty($_GET['id'])): ?> value="<?=$_GET['id']?>" <?php else: ?> value="0" <?php endif; ?>>

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
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremioCol";
        }
        if(idAdmin!=0){
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremioCol&admin=1&id="+idAdmin;
        }
        // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremioCol";
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
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremioCol&action=Modificar";
          window.location.href=menu;
      });
    }
    
  }

  // $(".cantidades").change(function(){
  //   var cantidad = parseInt($(this).val());
  //   var planesss = $(".name_planes").html();
  //   var planesss2 = $(".name_planes2").html();
  //   var planesss3 = $(".name_planes3").html();
  //   var planes3 = JSON.parse(planesss3);
  //   var planes2 = JSON.parse(planesss2);
  //   var planes1 = JSON.parse(planesss);
  //   for (var i = 0; i < planes2.length; i++) {
  //     var p2 = planes2[i];
  //     var aprob = parseInt($(".max"+p2).val());
  //     var resul = 0;
  //       for (var j = 0; j < planes1.length; j++) {
  //         var p1 = planes1[j];
  //         for (var k = 0; k < planes3.length; k++) {
  //           var p3 = planes3[k];
  //           if(p1==p2+p3){
  //             var values = parseInt($("#"+p1).val());
  //             resul += values;
  //           }
  //         }
  //       }
  //       if((aprob-resul)>=0){
  //         $(".aprobado"+p2).val(aprob-resul);
  //       }else{
  //         while(resul>aprob){      
  //           $(this).val($(this).val()-1);
  //           resul = 0;
  //           for (var j = 0; j < planes1.length; j++) {
  //             var p1 = planes1[j];
  //             for (var k = 0; k < planes3.length; k++) {
  //               var p3 = planes3[k];
  //               if(p1==p2+p3){
  //                 var values = parseInt($("#"+p1).val());
  //                 resul += values;
  //               }
  //             }
  //           }    
  //           if((aprob-resul)>=0){
  //             $(".aprobado"+p2).val(aprob-resul);
  //           }
  //         }
  //       }
  //   }
  // });

  $(".cantidades").change(function(){
    var cantidad = parseInt($(this).val());
    
    var pUNIC = $(this).attr('id');

    var planesss = $(".name_planes").html();
    var planesss2 = $(".name_planes2").html();
    var planesss3 = $(".name_planes3").html();
    var planes3 = JSON.parse(planesss3);
    var planes2 = JSON.parse(planesss2);
    var planes1 = JSON.parse(planesss);
    var pl = 0;
    for (var i = 0; i < planes2.length; i++) {
      var p2 = planes2[i];
      var aprob = parseInt($(".max"+p2).val());
      var resul = 0;


        for (var j = 0; j < planes1.length; j++) {
          var p1 = planes1[j];
          for (var k = 0; k < planes3.length; k++) {
            var p3 = planes3[k];
            if(p1==p2+p3){
                var values = parseInt($("#"+p1).val());

                      resul += values;
                    if(p1==pUNIC){
                      var existencia = parseInt($("#existencia"+pUNIC).val());
                      if(!isNaN(existencia)){

                        if(existencia-cantidad>=0){
                          $("#newexistencia"+pUNIC).val(existencia-cantidad);
                          if($("#newexistencia"+pUNIC).val()==0){
                            $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
                          }else{
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                        }else{
                          $(this).val($(this).val()-1);
                          resul--;
                          if($("#newexistencia"+pUNIC).val()==0){
                            $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
                          }
                          if($("#newexistencia"+pUNIC).val()!=0){
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                        }
                          $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                      }
                       $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                    }
            }
          }
        }


            if((aprob-resul)>=0){
              $(".aprobado"+p2).val(aprob-resul);
            }else{
              while(resul>aprob){      
                $(this).val($(this).val()-1);
                resul = 0;
                for (var j = 0; j < planes1.length; j++) {
                  var p1 = planes1[j];
                  for (var k = 0; k < planes3.length; k++) {
                    var p3 = planes3[k];
                    if(p1==p2+p3){
                      var values = parseInt($("#"+p1).val());
                      resul += values;
                    }
                  }
                }    
                if((aprob-resul)>=0){
                  $(".aprobado"+p2).val(aprob-resul);
                }
              }
            }


    }
  });

  // $(".cantidades").keyup(function(){
  //   var cantidad = parseInt($(this).val());
  //   var planesss = $(".name_planes").html();
  //   var planesss2 = $(".name_planes2").html();
  //   var planesss3 = $(".name_planes3").html();
  //   var planes3 = JSON.parse(planesss3);
  //   var planes2 = JSON.parse(planesss2);
  //   var planes1 = JSON.parse(planesss);
  //   for (var i = 0; i < planes2.length; i++) {
  //     var p2 = planes2[i];
  //     var aprob = parseInt($(".max"+p2).val());
  //     var resul = 0;
  //       for (var j = 0; j < planes1.length; j++) {
  //         var p1 = planes1[j];
  //         for (var k = 0; k < planes3.length; k++) {
  //           var p3 = planes3[k];
  //           if(p1==p2+p3){
  //             var values = parseInt($("#"+p1).val());
  //             resul += values;
  //           }
  //         }
  //       }
  //       if((aprob-resul)>=0){
  //         $(".aprobado"+p2).val(aprob-resul);
  //       }else{
  //         while(resul>aprob){      
  //           $(this).val($(this).val()-1);
  //           resul = 0;
  //           for (var j = 0; j < planes1.length; j++) {
  //             var p1 = planes1[j];
  //             for (var k = 0; k < planes3.length; k++) {
  //               var p3 = planes3[k];
  //               if(p1==p2+p3){
  //                 var values = parseInt($("#"+p1).val());
  //                 resul += values;
  //               }
  //             }
  //           }    
  //           if((aprob-resul)>=0){
  //             $(".aprobado"+p2).val(aprob-resul);
  //           }
  //         }
  //       }
  //   }
  // });
  $(".cantidades").keyup(function(){
    var cantidad = parseInt($(this).val());
      
    var pUNIC = $(this).attr('id');

    
    var planesss = $(".name_planes").html();
    var planesss2 = $(".name_planes2").html();
    var planesss3 = $(".name_planes3").html();
    var planes3 = JSON.parse(planesss3);
    var planes2 = JSON.parse(planesss2);
    var planes1 = JSON.parse(planesss);
    var pl = 0;
    for (var i = 0; i < planes2.length; i++) {
      var p2 = planes2[i];
      var aprob = parseInt($(".max"+p2).val());
      var resul = 0;


        for (var j = 0; j < planes1.length; j++) {
          var p1 = planes1[j];
          for (var k = 0; k < planes3.length; k++) {
            var p3 = planes3[k];
            if(p1==p2+p3){
                var values = parseInt($("#"+p1).val());
                      resul += values;
                    if(p1==pUNIC){
                      var existencia = parseInt($("#existencia"+pUNIC).val());
                      if(!isNaN(existencia)){

                        if(existencia-cantidad>=0){
                          $("#newexistencia"+pUNIC).val(existencia-cantidad);
                          if($("#newexistencia"+pUNIC).val()==0){
                            $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
                          }else{
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                        }else{
                      // alert(existencia-cantidad);  
                      // alert(resul);
                      // alert($("#llenar"+pUNIC).val());
                          // $(this).val($("#llenar"+pUNIC).val());
                          var r = parseInt($(".aprobado"+p2).val());
                          // alert(r)
                          // $(this).val(0);
                          var xd = $(this).val();
                              if(xd > existencia){
                                // alert("yes");
                                $(this).val(existencia);
                              }else{
                                $(this).val(0);
                              }
                          $(".aprobado"+p2).val(r+parseInt($("#llenar"+pUNIC).val()));
                          
                          resul--;
                          if($("#newexistencia"+pUNIC).val()==0){
                            $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
                          }
                          if($("#newexistencia"+pUNIC).val()!=0){
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                          $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                        }
                      }
                    // alert($(".cant"+pUNIC).val());
                      $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                    }
                    // $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
            }
          }
        }

            if((aprob-resul)>=0){
              $(".aprobado"+p2).val(aprob-resul);
            }else{
              while(resul>aprob){      
                $(this).val($(this).val()-1);
                resul = 0;
                for (var j = 0; j < planes1.length; j++) {
                  var p1 = planes1[j];
                  for (var k = 0; k < planes3.length; k++) {
                    var p3 = planes3[k];
                    if(p1==p2+p3){
                      var values = parseInt($("#"+p1).val());
                      resul += values;
                    }
                  }
                }    
                if((aprob-resul)>=0){
                  $(".aprobado"+p2).val(aprob-resul);
                  $("#newexistencia"+pUNIC).val(parseInt($("#existencia"+pUNIC).val())-resul);
                  if($("#newexistencia"+pUNIC).val()==0){
                    $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
                  }else{
                    $(".existenciaDisponible"+pUNIC).html("");
                  }
                }
              }
            }


    }
  });
  $(".cantidades").focusout(function(){
    var cantidad = $(this).val();
    if(cantidad==""){
      $(this).val(0);
    }

    cantidad = parseInt($(this).val());
      
    var pUNIC = $(this).attr('id');

    
    var planesss = $(".name_planes").html();
    var planesss2 = $(".name_planes2").html();
    var planesss3 = $(".name_planes3").html();
    var planes3 = JSON.parse(planesss3);
    var planes2 = JSON.parse(planesss2);
    var planes1 = JSON.parse(planesss);
    var pl = 0;
    for (var i = 0; i < planes2.length; i++) {
      var p2 = planes2[i];
      var aprob = parseInt($(".max"+p2).val());
      var resul = 0;


        for (var j = 0; j < planes1.length; j++) {
          var p1 = planes1[j];
          for (var k = 0; k < planes3.length; k++) {
            var p3 = planes3[k];
            if(p1==p2+p3){
                var values = parseInt($("#"+p1).val());
                      resul += values;
                    if(p1==pUNIC){
                      var existencia = parseInt($("#existencia"+pUNIC).val());
                      if(!isNaN(existencia)){

                        if(existencia-cantidad>=0){
                          $("#newexistencia"+pUNIC).val(existencia-cantidad);
                          if($("#newexistencia"+pUNIC).val()==0){
                            $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
                          }else{
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                        }else{
                      // alert(existencia-cantidad);  
                      // alert(resul);
                      // alert($("#llenar"+pUNIC).val());
                          // $(this).val($("#llenar"+pUNIC).val());
                          var r = parseInt($(".aprobado"+p2).val());
                          // alert(r)
                          // $(this).val(0);
                          var xd = $(this).val();
                              if(xd > existencia){
                                // alert("yes");
                                $(this).val(existencia);
                              }else{
                                $(this).val(0);
                              }
                          $(".aprobado"+p2).val(r+parseInt($("#llenar"+pUNIC).val()));
                          
                          resul--;
                          if($("#newexistencia"+pUNIC).val()==0){
                            $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
                          }
                          if($("#newexistencia"+pUNIC).val()!=0){
                            $(".existenciaDisponible"+pUNIC).html("");
                          }
                          $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                        }
                      }
                    // alert($(".cant"+pUNIC).val());
                      $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
                    }
                    // $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
            }
          }
        }

            if((aprob-resul)>=0){
              $(".aprobado"+p2).val(aprob-resul);
            }else{
              while(resul>aprob){      
                $(this).val($(this).val()-1);
                resul = 0;
                for (var j = 0; j < planes1.length; j++) {
                  var p1 = planes1[j];
                  for (var k = 0; k < planes3.length; k++) {
                    var p3 = planes3[k];
                    if(p1==p2+p3){
                      var values = parseInt($("#"+p1).val());
                      resul += values;
                    }
                  }
                }    
                if((aprob-resul)>=0){
                  $(".aprobado"+p2).val(aprob-resul);
                  $("#newexistencia"+pUNIC).val(parseInt($("#existencia"+pUNIC).val())-resul);
                  if($("#newexistencia"+pUNIC).val()==0){
                    $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
                  }else{
                    $(".existenciaDisponible"+pUNIC).html("");
                  }
                }
              }
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

  var planesss2 = $(".name_planes2").html();
  var planes2 = JSON.parse(planesss2);
  var res = 0;
  for (var i = 0; i < planes2.length; i++) {
    var p = planes2[i];
    /*===================================================================*/
    var aprobadas = $(".aprobado"+p).val();
    res += parseInt(aprobadas);
    var raprobadas = false;
    // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
      if( aprobadas == 0 ){
        $("#error_max"+p).html("");
        raprobadas = true;
      }else{
        raprobadas = false;
        $("#error_max"+p).html("Debe escoger las cantidad de premios para cada coleccion y alcanzar la cantidad de premios disponibles");
      }
    /*===================================================================*/
  }
  // alert(res);
  /*===================================================================*/
  var result = false;
  if( res==0){
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
