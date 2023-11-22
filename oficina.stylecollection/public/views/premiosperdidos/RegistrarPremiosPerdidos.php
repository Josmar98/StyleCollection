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
        <?php echo "Premios perdidos"; ?>
        <small><?php if(!empty($action)){echo $action;} echo " premios perdidos"; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Premios perdidos"; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action." Premios";}else{echo "Premios";} ?></li>
      </ol>
    </section>
          <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?<?php echo $menu3; ?>route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver Planes de Coleccion</a></div> -->
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
              <h3 class="box-title">Agregar <?php echo "Premios Perdidos"; ?></h3>
              <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                    <?php if (empty($_GET['admin'])): ?>
                      
                      <div style="width:100%;margin:0;padding:0;text-align:right;">
                          <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=PremiosPerdidos&action=Registrar&admin=1&select=0"><b>Registrar Premios Perdidos por Lider</b></a>
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
                      <input type="hidden" value="PremiosPerdidos" name="route">
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
                                      <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>" <?php foreach ($premios_perdidos_usados as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?> disabled="" <?php } } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                          <?php 
                                        }
                                      }
                                    }
                                  }
                                }else if($accesoBloqueo=="0"){
                                  ?>
                                <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>" <?php foreach ($premios_perdidos_usados as $pclientes) { if(!empty($pclientes['id_cliente'])){ if($pclientes['id_cliente']==$data['id_cliente']){ ?> disabled="" <?php } } } ?> ><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                                  <?php
                                }
                              ?>
                            <?php endif ?>
                          <?php endforeach ?>
                      </select>
                    </div>
                    </form>
                  </div>
                <?php } ?>
                <br>

                <form action="" method="post" role="form" class="form_register">
                  <?php
                    $cantidad_colecciones = 0;
                    $planess = [];
                    $num = 0;
                    foreach ($pedidos as $data){
                      if(!empty($data['id_pedido'])){
                        ?>
                        <div class="row">
                          <div class="form-group col-xs-12">
                            <label>
                              <?php $cantidad_colecciones = $data['cantidad_aprobado']; ?>
                              <h4>
                                <b>
                                  
                                <?=$data['primer_nombre'];?> <?=$data['primer_apellido'];?> <?=$data['cedula'];?>
                                - 
                                ( <?=$cantidad_colecciones;?> Colecciones Aprobadas )
                                </b>
                              </h4>
                            </label>
                          </div>
                        </div>
                        <?php foreach ($pagosRecorridos as $pagosR): ?>

                          <?php if (!empty($pagosR['asignacion']) && $pagosR['asignacion']=="seleccion_premios"){ ?>
                            <input type="hidden" id="seleccion_premios" value="<?=$pagosR['id']; ?>">
                            <div class="form-group col-xs-12">
                              <br>
                                <b style="font-size:1.3em;">
                                  Premios de <?=$pagosR['name'] ?> Alcanzados: <?=$totalPremiosGanados[$pagosR['id']];?>
                                  <br>
                                  Premios de <?=$pagosR['name']; ?> Perdidos: <?=$data['cantidad_aprobado']-$totalPremiosGanados[$pagosR['id']];?>
                                </b>
                              <br>
                              <label>
                                Premios Perdidos de <?=$pagosR['name']; ?>
                              </label>
                              <input type="hidden" name="" class="maximosHidden<?=$pagosR['id']; ?>" value="<?=$data['cantidad_aprobado']-$totalPremiosGanados[$pagosR['id']];?>" readonly>
                              <input type="number" name="" class="form-control maximos<?=$pagosR['id']; ?>" value="<?=$data['cantidad_aprobado']-$totalPremiosGanados[$pagosR['id']];?>" readonly>
                              <span class="error_maximos errors"></span>
                              <br>
                            </div>
                            <hr>

                            <?php
                              foreach ($planesCol as $data2) {
                                if($data['id_pedido'] == $data2['id_pedido']){
                                  if($data2['cantidad_coleccion_plan']>0){
                                    // print_r($pagosR);
                                    // echo $pagosR['name'];
                                      // print_r($data2);
                                      ?>
                                    <div class="row">
                                      <div class="form-group col-xs-12">
                                        <label>
                                          <u style="font-size:1.2em;">
                                          <?php $colecciones = $data2['cantidad_coleccion']*$data2['cantidad_coleccion_plan']; ?>
                                          <?=$colecciones;?> Colecciones de (<?=$data2['cantidad_coleccion_plan'];?>) Plan <?=$data2['nombre_plan'];?>
                                          </u>
                                        </label>
                                      <?php
                                      $sql0 = "SELECT DISTINCT * FROM tipos_premios_planes_campana, premios_planes_campana, planes_campana, despachos, planes WHERE premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes.id_plan = planes_campana.id_plan and planes_campana.id_campana = despachos.id_campana and despachos.id_despacho = $id_despacho and planes_campana.id_despacho = {$id_despacho} and planes_campana.id_despacho = {$id_despacho} and planes.id_plan={$data2['id_plan']} and premios_planes_campana.tipo_premio='{$pagosR['name']}'";
                                      $tempPlanes = $lider->consultarQuery($sql0);
                                      $nameTPlanesTemp = $tempPlanes[0]['tipo_premio_producto'];
                                      $idPlanesTemp = $data2['id_plan'];
                                      $namePlanesTemp = $data2['nombre_plan'];
                                      // echo "<br>".$nameTPlanesTemp." de plan ".$namePlanesTemp."<br>";

                                      // if(mb_strtolower($data2['nombre_plan'])==mb_strtolower($namePlanesTemp)){
                                      if(mb_strtolower($nameTPlanesTemp)==mb_strtolower("Productos")){ ?>
                                        <div class="form-group col-xs-12">
                                          <label>Premios <?=$namePlanesTemp; ?></label>
                                          <div class="input-group">
                                            <span class="input-group-addon"><?=$data2['cantidad_coleccion_plan'];?></span>

                                            <input type="hidden" name="dataoculta[]" value="<?="nombreid*".$idPlanesTemp."*".$data2['id_tipo_coleccion']."*0*".$data2['cantidad_coleccion_plan']."*".$data2['id_pedido']."*".$data['id_cliente']; ?>">
                                            <?php
                                              $planess[$num] = ['codigo'=>'nombreid', 'valor'=>$idPlanesTemp]; 
                                              $num++;
                                            ?>
                                            <input type="number" class="nombreid_<?=$idPlanesTemp; ?> form-control cantidadPerdidas" id="<?=$data2['cantidad_coleccion_plan'];?>" name="cantidadesPedidas[]" title="<?=$pagosR['id']; ?>" src="1">
                                          </div>
                                          <span class="error_nombreid_<?=$idPlanesTemp; ?> errors"></span>
                                        </div>
                                      <?php 
                                      }else{
                                          foreach ($premioscol as $data3) {
                                            if(!empty($data3['id_premio'])){
                                              if($data2['id_plan']==$data3['id_plan']){
                                                if($data['id_pedido']==$data3['id_pedido']){
                                                  if($data3['cantidad_premios_plan']>0){  
                                                    ?>
                                                    <div class="form-group col-xs-12">
                                                      <label><?=$data3['nombre_premio'];?></label>
                                                      <div class="input-group">
                                                        <span class="input-group-addon"><?=$data3['cantidad_premios_plan'];?></span>

                                                        <input type="hidden" name="dataoculta[]" value="<?="id"."*".$data3['id_premio']."*".$data3['id_tipo_coleccion']."*".$data3['id_tppc']."*".$data3['cantidad_premios_plan']."*".$data['id_pedido']."*".$data['id_cliente']; ?>">
                                                        <?php
                                                          $planess[$num] = ['codigo'=>'id', 'valor'=>$data3['id_premio']]; 
                                                          $num++;
                                                        ?>
                                                        <input type="number" class="<?='id'.'_'.$data3['id_premio']?> form-control cantidadPerdidas" id="<?=$data3['cantidad_premios_plan'];?>"  name="cantidadesPedidas[]" title="<?=$pagosR['id']; ?>" src="<?=$data3['cantidad_coleccion']?>">
                                                      </div>
                                                      <span class="error_<?='id'.'_'.$data3['id_premio']?> errors"></span>
                                                    </div>
                                          <?php   }
                                                }
                                              }
                                            }
                                          }
                                      }

                                      ?>
                                      </div>

                                    </div>
                                    <?php
                                  }
                                }
                              }
                            ?>
                          <?php } else { ?>
                            <div class="form-group col-xs-12">
                              <br>
                                <b style="font-size:1.3em;">
                                  Premios de <?=$pagosR['name']; ?> Alcanzados <?=$totalPremiosGanados[$pagosR['id']];?>
                                  <br>
                                  Premios de <?=$pagosR['name']; ?> Perdidos <?=$data['cantidad_aprobado']-$totalPremiosGanados[$pagosR['id']];?>
                                </b>
                              <br>
                              <br>
                              <label>Premios de <?=$pagosR['name']; ?></label>
                              <div class="input-group">
                                <span class="input-group-addon"><?=$data['cantidad_aprobado'];?></span>
                                  
                                    <input type="hidden" name="dataoculta[]" value="<?="nombre*".$pagosR['id']."*0*0*".$data['cantidad_aprobado']."*".$data['id_pedido']."*".$data['id_cliente']; ?>">
                                    <?php
                                      $planess[$num] = ['codigo'=>'nombre', 'valor'=>$pagosR['id']]; 
                                      $num++;
                                    ?>
                                    <input type="number" class="nombre_<?=$pagosR['id']; ?> form-control cantidadPerdidas" id="<?=$cantidad_colecciones;?>" name="cantidadesPedidas[]" value="<?=$data['cantidad_aprobado']-$totalPremiosGanados[$pagosR['id']]; ?>" title="<?=$pagosR['id']; ?>" readonly>
                              </div>
                              <span class="error_nombre_<?=$pagosR['id']; ?> errors"></span>
                            </div>
                          <?php } ?>
                          <hr>
                          
                        <?php endforeach ?>
                        <?php
                      }
                    }
                  ?>
                    <input type="hidden" name="id_pedido" value="<?=$pedido['id_pedido']?>">
                    <br>
                    <br>
                  <span class="name_planes d-none"><?php echo json_encode($planess)?></span>
                  <div class="box-footer">
                    <span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
                    <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar d-none" disabled="">enviar</button>
                  </div>
                </form>
              </div>
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
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosPerdidoss";
        }
        if(idAdmin!=0){
          // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosPerdidos&admin=1&lider="+idAdmin;
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremiosPerdidos";
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
          var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=PremioCol&action=Registrar";
          window.location.href=menu;
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


  $(".cantidadPerdidas").keyup(function(){
    var seleccion_premios = $("#seleccion_premios").val();
    var limite = parseInt($(this).attr("id"));
    var maximoshidden = parseInt($(".maximosHidden"+seleccion_premios).val());
    var maximos = parseInt($(".maximos"+seleccion_premios).val());
    var val = $(this).val();
    // if(val==""){
      // $(this).val(limite);
    // }
    var cant = parseInt($(this).val());
    
    if(cant < 0){
      $(this).val(0);
    }
    if(cant > limite){
      $(this).val(limite);
    }

    var titulo = $(this).attr("title");
    var colss = $(this).attr("src");

    if(titulo == seleccion_premios){

      cant = parseInt($(this).val());
      if(cant > maximos){
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(maximos);
      }

      var name_planes = $(".name_planes").html();
      var planes = JSON.parse(name_planes);
      // console.log(planes);
      var acumPP = 0;
      for (var i = 0; i < planes.length; i++) {
        var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
        if($("."+claseTemp).attr("title") == seleccion_premios){
          var values = $("."+claseTemp).val();
          // alert(values);
          // alert('asdasd');
          var cols = $("."+claseTemp).attr("src");
          if(values==""){
            values = 0;
          }else{
            values = parseInt(values) * cols;
            // values = parseInt(values);
          }
          acumPP += values;
        }
      }
      
      if(acumPP <= maximoshidden){
        $(this).val(cant);
        var acumPP = 0;
        for (var i = 0; i < planes.length; i++) {
          var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
          if($("."+claseTemp).attr("title") == seleccion_premios){
            var values = $("."+claseTemp).val();
            var cols = $("."+claseTemp).attr("src");
            if(values==""){
              values = 0;
            }else{
              values = parseInt(values) * cols;
            }
            acumPP += values;
            // console.log(claseTemp+': '+values);
          }
        } 
      }

      $(".maximos"+seleccion_premios).val(maximoshidden-acumPP);
      
      if(acumPP > maximoshidden){
        var newvalmin = parseInt($(".maximos"+seleccion_premios).val()) / colss;
        // console.log("NUEVO VALOR DE MINIMOOOOOO "+newvalmin);
        newvalmin = Math.ceil(newvalmin);
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(cant-(newvalmin*(-1)));
        // console.log(cant);
        // console.log(newvalmin*(-1));
      }
      // console.log("Maximos: "+maximoshidden);
      // console.log("Acumulado: "+acumPP);
      // console.log("Cantidad: "+cant);
    }


  });

  $(".cantidadPerdidas").change(function(){
    var seleccion_premios = $("#seleccion_premios").val();
    var limite = parseInt($(this).attr("id"));
    var maximoshidden = parseInt($(".maximosHidden"+seleccion_premios).val());
    var maximos = parseInt($(".maximos"+seleccion_premios).val());
    var val = $(this).val();
    // if(val==""){
      // $(this).val(limite);
    // }
    var cant = parseInt($(this).val());
    
    if(cant < 0){
      $(this).val(0);
    }
    if(cant > limite){
      $(this).val(limite);
    }

    var titulo = $(this).attr("title");
    var colss = $(this).attr("src");

    if(titulo == seleccion_premios){

      cant = parseInt($(this).val());
      if(cant > maximos){
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(maximos);
      }

      var name_planes = $(".name_planes").html();
      var planes = JSON.parse(name_planes);
      // console.log(planes);
      var acumPP = 0;
      for (var i = 0; i < planes.length; i++) {
        var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
        if($("."+claseTemp).attr("title") == seleccion_premios){
          var values = $("."+claseTemp).val();
          // alert(values);
          // alert('asdasd');
          var cols = $("."+claseTemp).attr("src");
          if(values==""){
            values = 0;
          }else{
            values = parseInt(values) * cols;
            // values = parseInt(values);
          }
          acumPP += values;
        }
      }
      
      if(acumPP <= maximoshidden){
        $(this).val(cant);
        var acumPP = 0;
        for (var i = 0; i < planes.length; i++) {
          var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
          if($("."+claseTemp).attr("title") == seleccion_premios){
            var values = $("."+claseTemp).val();
            var cols = $("."+claseTemp).attr("src");
            if(values==""){
              values = 0;
            }else{
              values = parseInt(values) * cols;
            }
            acumPP += values;
            // console.log(claseTemp+': '+values);
          }
        } 
      }

      $(".maximos"+seleccion_premios).val(maximoshidden-acumPP);
      
      if(acumPP > maximoshidden){
        var newvalmin = parseInt($(".maximos"+seleccion_premios).val()) / colss;
        // console.log("NUEVO VALOR DE MINIMOOOOOO "+newvalmin);
        newvalmin = Math.ceil(newvalmin);
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(cant-(newvalmin*(-1)));
        // console.log(cant);
        // console.log(newvalmin*(-1));
      }
      // console.log("Maximos: "+maximoshidden);
      // console.log("Acumulado: "+acumPP);
      // console.log("Cantidad: "+cant);
    }


  });

  $(".cantidadPerdidas").focusout(function(){
    var seleccion_premios = $("#seleccion_premios").val();
    var limite = parseInt($(this).attr("id"));
    var maximoshidden = parseInt($(".maximosHidden"+seleccion_premios).val());
    var maximos = parseInt($(".maximos"+seleccion_premios).val());
    var val = $(this).val();
    if(val==""){
      $(this).val(limite);
    }
    var cant = parseInt($(this).val());
    if(cant < 0){
      $(this).val(0);
    }
    if(cant > limite){
      $(this).val(limite);
    }

    var titulo = $(this).attr("title");
    var colss = $(this).attr("src");
    if(titulo == seleccion_premios){

      cant = parseInt($(this).val());
      if(cant > maximos){
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(maximos);
      }

      var name_planes = $(".name_planes").html();
      var planes = JSON.parse(name_planes);

      var acumPP = 0;
      for (var i = 0; i < planes.length; i++) {
        var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
        if($("."+claseTemp).attr("title") == seleccion_premios){
          var values = $("."+claseTemp).val();
          var cols = $("."+claseTemp).attr("src");
          if(values==""){
            values = 0;
          }else{
            values = parseInt(values) * cols;
            // values = parseInt(values);
          }
          acumPP += values;
        }
      }

      // alert(acumPP+ " | " + maximoshidden);

      if(acumPP <= maximoshidden){
        $(this).val(cant);
        var acumPP = 0;
        for (var i = 0; i < planes.length; i++) {
          var claseTemp = planes[i]['codigo']+'_'+planes[i]['valor'];
          if($("."+claseTemp).attr("title") == seleccion_premios){
            var values = $("."+claseTemp).val();
            var cols = $("."+claseTemp).attr("src");
            if(values==""){
              values = 0;
            }else{
              values = parseInt(values) * cols;
            }
            acumPP += values;
            // console.log(claseTemp+': '+values);
          }
        } 
      }

      $(".maximos"+seleccion_premios).val(maximoshidden-acumPP);
      
      if(acumPP > maximoshidden){
        var newvalmin = parseInt($(".maximos"+seleccion_premios).val()) / colss;
        // console.log("NUEVO VALOR DE MINIMOOOOOO "+newvalmin);
        newvalmin = Math.ceil(newvalmin);
        $(".maximos"+seleccion_premios).val(0);
        $(this).val(cant-(newvalmin*(-1)));
        // console.log(cant);
        // console.log(newvalmin*(-1));
      }
      // console.log("Maximos: "+maximoshidden);
      // console.log("Acumulado: "+acumPP);
      // console.log("Cantidad: "+cant);
    }


  });

  

  // $(".cantidades").change(function(){
  //   var cantidad = parseInt($(this).val());
  //   var pUNIC = $(this).attr('id');
  //   var planesss = $(".name_planes").html();
  //   var planesss2 = $(".name_planes2").html();
  //   var planesss3 = $(".name_planes3").html();
  //   var planes3 = JSON.parse(planesss3);
  //   var planes2 = JSON.parse(planesss2);
  //   var planes1 = JSON.parse(planesss);
  //   var pl = 0;
  //   for (var i = 0; i < planes2.length; i++) {
  //     var p2 = planes2[i];
  //     var aprob = parseInt($(".max"+p2).val());
  //     var resul = 0;


  //         for (var k = 0; k < planes3.length; k++) {
  //           var p3 = planes3[k];
  //       for (var j = 0; j < planes1.length; j++) {
  //         var p1 = planes1[j];
  //           if(p1==p2+p3){
  //             // alert(p1);
  //             // alert(p2);
  //               var values = parseInt($("#"+p1).val());

  //                     resul += values;
  //                   if(p1==pUNIC){
                      
  //                     var existencia = parseInt($("#existencia"+pUNIC).val());
  //                     if(!isNaN(existencia)){

  //                       if(existencia-cantidad>=0){
  //                         $("#newexistencia"+pUNIC).val(existencia-cantidad);
  //                         if($("#newexistencia"+pUNIC).val()==0){
  //                           $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
  //                         }else{
  //                           $(".existenciaDisponible"+pUNIC).html("");
  //                         }
  //                       }else{
  //                         $(this).val($(this).val()-1);
  //                         resul--;
  //                         if($("#newexistencia"+pUNIC).val()==0){
  //                           $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
  //                         }
  //                         if($("#newexistencia"+pUNIC).val()!=0){
  //                           $(".existenciaDisponible"+pUNIC).html("");
  //                         }
  //                       }
  //                         $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                     }
  //                      $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                   }
  //           }
  //         }
  //       }

  //           if((aprob-resul)>=0){
  //             $(".aprobado"+p2).val(aprob-resul);
  //           }else{
  //             while(resul>aprob){      
  //               $(this).val($(this).val()-1);
  //               resul = 0;
  //               for (var j = 0; j < planes1.length; j++) {
  //                 var p1 = planes1[j];
  //                 for (var k = 0; k < planes3.length; k++) {
  //                   var p3 = planes3[k];
  //                   if(p1==p2+p3){
  //                     var values = parseInt($("#"+p1).val());
  //                     resul += values;
  //                   }
  //                 }
  //               }    
  //               if((aprob-resul)>=0){
  //                 $(".aprobado"+p2).val(aprob-resul);
  //               }
  //             }
  //           }


  //   }
  // });

  // $(".cantidades").keyup(function(){
  //   var cantidad = parseInt($(this).val());
      
  //   var pUNIC = $(this).attr('id');

    
  //   var planesss = $(".name_planes").html();
  //   var planesss2 = $(".name_planes2").html();
  //   var planesss3 = $(".name_planes3").html();
  //   var planes3 = JSON.parse(planesss3);
  //   var planes2 = JSON.parse(planesss2);
  //   var planes1 = JSON.parse(planesss);
  //   var pl = 0;

  //   for (var i = 0; i < planes2.length; i++) {
  //     var p2 = planes2[i];
  //     var aprob = parseInt($(".max"+p2).val());
  //     var resul = 0;


  //       for (var j = 0; j < planes1.length; j++) {
  //         var p1 = planes1[j];
  //         for (var k = 0; k < planes3.length; k++) {
  //           var p3 = planes3[k];
  //           if(p1==p2+p3){
  //               var values = parseInt($("#"+p1).val());
  //                     resul += values;
  //                   if(p1==pUNIC){
  //                     var existencia = parseInt($("#existencia"+pUNIC).val());
  //                     if(!isNaN(existencia)){
  //                           if(existencia-cantidad>=0){
  //                             $("#newexistencia"+pUNIC).val(existencia-cantidad);
  //                             if($("#newexistencia"+pUNIC).val()==0){
  //                               $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
  //                             }else{
  //                               $(".existenciaDisponible"+pUNIC).html("");
  //                             }
  //                           }else{
  //                             var xd = $(this).val();
  //                             if(xd > existencia){
  //                               // alert("yes");
  //                               $(this).val(existencia);
  //                             }else{
  //                               $(this).val(0);
  //                             }
  //                             // alert($("#llenar"+pUNIC).val());
  //                             resul--;
  //                             if($("#newexistencia"+pUNIC).val()==0){
  //                               $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
  //                             }
  //                             if($("#newexistencia"+pUNIC).val()!=0){
  //                               $(".existenciaDisponible"+pUNIC).html("");
  //                             }
  //                             $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                           }
  //                         }
  //                       // alert($(".cant"+pUNIC).val());
  //                         $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                   }
  //                   // $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //           }
  //         }
  //       }

  //           if((aprob-resul)>=0){
  //             $(".aprobado"+p2).val(aprob-resul);
  //           }else{
  //             while(resul>aprob){      
  //               $(this).val($(this).val()-1);
  //               resul = 0;
  //               for (var j = 0; j < planes1.length; j++) {
  //                 var p1 = planes1[j];
  //                 for (var k = 0; k < planes3.length; k++) {
  //                   var p3 = planes3[k];
  //                   if(p1==p2+p3){
  //                     var values = parseInt($("#"+p1).val());
  //                     resul += values;
  //                   }
  //                 }
  //               }    
  //               // alert(aprobado-resul);
  //               if((aprob-resul)>=0){
  //                 $(".aprobado"+p2).val(aprob-resul);
  //                 $("#newexistencia"+pUNIC).val(parseInt($("#existencia"+pUNIC).val())-resul);
  //                 if($("#newexistencia"+pUNIC).val()==0){
  //                   $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
  //                 }else{
  //                   $(".existenciaDisponible"+pUNIC).html("");
  //                 }
  //               }
  //             }
  //           }


  //   }
  // });

  // $(".cantidades").focusout(function(){
  //   var cantidad = $(this).val();
  //   if(cantidad==""){
  //     $(this).val(0);
  //   }

  //   cantidad = parseInt($(this).val());
      
  //   var pUNIC = $(this).attr('id');

    
  //   var planesss = $(".name_planes").html();
  //   var planesss2 = $(".name_planes2").html();
  //   var planesss3 = $(".name_planes3").html();
  //   var planes3 = JSON.parse(planesss3);
  //   var planes2 = JSON.parse(planesss2);
  //   var planes1 = JSON.parse(planesss);
  //   var pl = 0;
  //   for (var i = 0; i < planes2.length; i++) {
  //     var p2 = planes2[i];
  //     var aprob = parseInt($(".max"+p2).val());
  //     var resul = 0;


  //       for (var j = 0; j < planes1.length; j++) {
  //         var p1 = planes1[j];
  //         for (var k = 0; k < planes3.length; k++) {
  //           var p3 = planes3[k];
  //           if(p1==p2+p3){
  //               var values = parseInt($("#"+p1).val());
  //                     resul += values;
  //                   if(p1==pUNIC){
  //                     var existencia = parseInt($("#existencia"+pUNIC).val());
  //                     if(!isNaN(existencia)){

  //                       if(existencia-cantidad>=0){
  //                         $("#newexistencia"+pUNIC).val(existencia-cantidad);
  //                         if($("#newexistencia"+pUNIC).val()==0){
  //                           $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
  //                         }else{
  //                           $(".existenciaDisponible"+pUNIC).html("");
  //                         }
  //                       }else{
  //                     // alert(existencia-cantidad);  
  //                     // alert(resul);
  //                     // alert($("#llenar"+pUNIC).val());
  //                         // $(this).val($("#llenar"+pUNIC).val());
  //                         var r = parseInt($(".aprobado"+p2).val());
  //                         // alert(r)
  //                         // $(this).val(0);
  //                         var xd = $(this).val();
  //                             if(xd > existencia){
  //                               // alert("yes");
  //                               $(this).val(existencia);
  //                             }else{
  //                               $(this).val(0);
  //                             }
  //                         $(".aprobado"+p2).val(r+parseInt($("#llenar"+pUNIC).val()));
                          
  //                         resul--;
  //                         if($("#newexistencia"+pUNIC).val()==0){
  //                           $("#newexistencia"+pUNIC).val(parseInt($("#newexistencia"+pUNIC).val())+1);
  //                         }
  //                         if($("#newexistencia"+pUNIC).val()!=0){
  //                           $(".existenciaDisponible"+pUNIC).html("");
  //                         }
  //                         $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                       }
  //                     }
  //                   // alert($(".cant"+pUNIC).val());
  //                     $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //                   }
  //                   // $("#llenar"+pUNIC).val($(".cant"+pUNIC).val());
  //           }
  //         }
  //       }

  //           if((aprob-resul)>=0){
  //             $(".aprobado"+p2).val(aprob-resul);
  //           }else{
  //             while(resul>aprob){      
  //               $(this).val($(this).val()-1);
  //               resul = 0;
  //               for (var j = 0; j < planes1.length; j++) {
  //                 var p1 = planes1[j];
  //                 for (var k = 0; k < planes3.length; k++) {
  //                   var p3 = planes3[k];
  //                   if(p1==p2+p3){
  //                     var values = parseInt($("#"+p1).val());
  //                     resul += values;
  //                   }
  //                 }
  //               }    
  //               if((aprob-resul)>=0){
  //                 $(".aprobado"+p2).val(aprob-resul);
  //                 $("#newexistencia"+pUNIC).val(parseInt($("#existencia"+pUNIC).val())-resul);
  //                 if($("#newexistencia"+pUNIC).val()==0){
  //                   $(".existenciaDisponible"+pUNIC).html("Premio Agotado");
  //                 }else{
  //                   $(".existenciaDisponible"+pUNIC).html("");
  //                 }
  //               }
  //             }
  //           }


  //   }
  // });




  $(".enviar").click(function(){
    var response = validadPerdidos();

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
  var seleccion_premios = $("#seleccion_premios").val();
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
  

  var maximos = parseInt($(".maximos"+seleccion_premios).val());
  var rmaximos = false;
  if(maximos == 0){
    rmaximos = true;
    $(".error_maximos").html("");
  }else{
    rmaximos = false;
    $(".error_maximos").html("Debe seleccionar la cantidad de premios perdidos del pago marcado");
  }

  if(number==0 && rmaximos==true){
    result = true;
  }else{
    result = false;    
  }
  // alert(result);
  return result;
}
function cambiarPremiosCantidad(){
  
}
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
