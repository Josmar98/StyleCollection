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
        <?php echo $url.""; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> <?=$modulo; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
      </ol>
    </section>
            <?php if($accesoPagosR){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?<?php echo $menu ?>&route=Pagos&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Pagos</a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
        <?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
      </div>
      <div class="row">
        
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box"> 

            <div class="box-header">
              <a onclick="regresarAtras()" id="link" class="btn" style="border-radius:50%;padding:10px 12.5px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>">
                <i class="fa fa-arrow-left" style="font-size:2em"></i>
              </a>
              &nbsp&nbsp&nbsp&nbsp
              <h3 class="box-title"><a href="?<?=$menu."&route=".$url?>"><?php echo "Filtro de Pagos"; ?></a></h3>
              
                <?php //if(!empty($_GET['admin']) && isset($_GET['select'])){ ?>
                <br><br>
                <!-- <div class="row">
                  <form action="" method="get">
                    <input type="hidden" value="<?=$id_campana;?>" name="campaing">
                    <input type="hidden" value="<?=$numero_campana;?>" name="n">
                    <input type="hidden" value="<?=$anio_campana;?>" name="y">
                    <input type="hidden" value="<?=$id_despacho;?>" name="dpid">
                    <input type="hidden" value="<?=$num_despacho;?>" name="dp">
                    <input type="hidden" value="Pagos" name="route">
                    <?php if(!empty($_GET['admin'])){ ?>
                        <input type="hidden" value="1" name="admin">
                        <?php } ?>
                        <?php if(!empty($_GET['lider'])){ ?>
                        <input type="hidden" value="<?=$_GET['lider']?>" name="lider">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoI'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoI']?>" name="rangoI">
                        <?php } ?>
                        <?php if(!empty($_GET['rangoF'])){ ?>
                        <input type="hidden" value="<?=$_GET['rangoF']?>" name="rangoF">
                        <?php } ?>
                        <?php if(!empty($_GET['Banco'])){ ?>
                        <input type="hidden" value="<?=$_GET['Banco']?>" name="Banco">
                        <?php } ?>
                        <?php if(!empty($_GET['Diferido'])){ ?>
                        <input type="hidden" value="<?=$_GET['Diferido']?>" name="Diferido">
                        <?php } ?>
                        <?php if(!empty($_GET['Abonado'])){ ?>
                        <input type="hidden" value="<?=$_GET['Abonado']?>" name="Abonado">
                        <?php } ?>

                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                    <div class="form-group col-xs-12 col-md-4">
                      <br>
                      <button class="btn enviar ">Enviar</button>
                    </div>
                  </form>
                </div>  -->
                <style>
                    .text-xs {
                      text-align:center;
                    }
                  @media (max-width: 768px) {
                    .text-xs {
                      text-align:right !important;
                    }
                  }
                </style>
                <div class="row">
                      <div class="col-xs-12 col-sm-4 text-xs" style="margin-bottom:15px">
                        <a href="?<?=$menu?>&route=Pagos&filtrar=Bancarios" class="btn" style="background:#099;color:#FFF;border-radius:7px !important;" ><b><u>Ver Solo Movimientos Bancarios<u></b></a>
                      </div>
                      <div class="col-xs-12 col-sm-4 text-xs" style="margin-bottom:15px">
                        <a href="?<?=$menu?>&route=Pagos" class="btn" style="background:#099;color:#FFF;border-radius:7px !important;" ><b><u>Ver Todos los Pagos<u></b></a>
                      </div>
                        
                      <div class="col-xs-12 col-sm-4 text-xs" style="margin-bottom:15px">
                        <a href="?<?=$menu?>&route=Pagos&filtrar=Divisas" class="btn" style="background:#0A0;color:#FFF;border-radius:7px !important;" ><b><u>Ver Solo Divisas<u></b></a>
                        <br><br>
                        <a href="?<?=$menu?>&route=Pagos&filtrar=Bolivares" class="btn" style="color:#0A0;" ><b><u>Ver Solo Bolivares<u></b></a>
                      </div>
                </div>
                <hr>
                <div class="row">
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                </div>
                <br>
                <div class="row">
                  <div class="form-group col-xs-12 col-sm-6">
                    <label for="lider">Seleccione al Lider</label>
                    <select class="form-control select2 selectLider" id="lider" name="lider" style="width:100%;">
                      <option></option>
                      <?php 
                        foreach ($lideres as $data){ if (!empty($data['id_cliente'])){
                          $permitido = "0";
                          if(!empty($accesosEstructuras)){
                            if(count($accesosEstructuras)>1){
                              foreach ($accesosEstructuras as $struct) {
                                if(!empty($struct['id_cliente'])){
                                  if($struct['id_cliente']==$lid['id_cliente']){
                                    $permitido = 1;
                                  }
                                }
                              }
                            }else if($personalInterno){
                              $permitido = 1;
                            }
                          }

                          if($permitido=="1"){
                            ?>
                            <option <?php if (!empty($_GET['lider'])): if($data['id_cliente']==$_GET['lider']): ?> selected="selected" <?php endif; endif; ?> value="<?=$data['id_cliente']?>"><?=$data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula']?></option>
                            <?php
                          }
                        } }
                      ?>
                    </select>
                  </div>

                  <div class="form-group col-xs-12 col-sm-6">
                    <label for="banco">Seleccione al banco</label>
                    <select class="form-control select2 selectbanco" id="banco" name="Banco" style="width:100%;">
                      <option></option>
                      <?php foreach ($bancos as $data){ if (!empty($data['id_banco'])){ ?>
                        <option value="<?=$data['id_banco']?>"><?=$data['nombre_banco']." - ".$data['nombre_propietario']." ".$data['cedula_cuenta']." (Cuenta ".$data['tipo_cuenta'].")";?></option>
                      <?php } } ?>
                    </select>
                  </div>

                </div>
                <hr>
                <div class="row">
                      <div class="col-xs-12 col-sm-4" style="text-align:center;margin-bottom:15px">
                        <a style="background:#099;color:#FFF;border-radius:7px !important" class="btn BancariosFiltro"><b><u>Ver Movimientos Bancarios con Filtros<u></b></a>
                      </div>
                      <div class="col-xs-12 col-sm-4" style="text-align:center;margin-bottom:15px">
                        <a style="background:#099;color:#FFF;border-radius:7px !important" class="btn PagosFiltro"><b><u>Ver Pagos con Filtros<u></b></a>
                      </div>
                      <div class="col-xs-12 col-sm-4" style="text-align:center;margin-bottom:15px">
                        <a style="background:#0A0;color:#FFF;border-radius:7px !important" class="btn DivisasFitro"><b><u>Ver Divisas con Filtros<u></b></a>
                        <br><br>
                        <a style="color:#0A0;" class="btn BolivaresFitro"><b><u>Ver Bolivares con Filtros<u></b></a>
                      </div>
                </div>
              <hr>
            </div>
            <!-- /.box-header -->

            <div class="box-body">

              <div class="row text-center" style="padding:10px 20px;">
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <!-- <a href="?<?=$menu."&route=".$ruta;?>"> -->
                    <b style="color:#000 !important">Reportado</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#0000FF !important"><b>$1.672,00</b></h4> -->
                    <h4 style="color:#0000FF !important"><b>$<?=number_format($reportado, 2, ",", ".")?></b></h4>
                  <!-- </a> -->
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <!-- <a href="?<?=$menu."&route=".$ruta."&Diferido=Diferido";?>"> -->
                    <b style="color:#000 !important">Diferido</b>
                    <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                    <!-- <h4 style="color:#FF0000 !important"><b>$56,00</b></h4> -->
                    <h4 style="color:#FF0000 !important"><b>$<?=number_format($diferido, 2, ",", ".")?></b></h4>
                  <!-- </a> -->
                </div>
                <div class="col-xs-4" style="padding:10px 0px;background:;border:1px solid #ccc">
                  <!-- <a href="?<?=$menu."&route=".$ruta."&Abonado=Abonado";?>"> -->
                      <b style="color:#000 !important">Abonado</b>
                      <hr style="margin:0px;padding:0px;border-bottom:1px solid #ccc">
                      <!-- <h4 style="color:#00FF00 !important"><b>$1.616,00</b></h4> -->
                      <h4 style="color:#00FF00 !important"><b>$<?=number_format($abonado, 2, ",", ".")?></b></h4>
                  <!-- </a> -->
                </div>
              </div>


                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">


            </div>
            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>
        <!-- /.col -->
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
<style>
.errors{
  color:red;
}
.d-none{
  display:none;
}
</style>

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<?php endif; ?>
<!-- 
  fa-calendar-times-o
  fa-calendar-check-o
-->
<script>
function Capitalizar(str){
  return str.replace(/\w\S*/g, function(txt){
    return txt.charAt(0).toUpperCase() + txt.substr(1).toLowerCase();
  });
}
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos guardados correctamente!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?<?=$menu; ?>&route=Pagos";
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  }
   
  $(".PagosFiltro").click(function(){
    var ruta = "Pagos";
    var menu = "<?=$menu?>";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var lider = $("#lider").val();
    var banco = $("#banco").val();

    var menuInicial = menu+"&route="+ruta;
    var menuFinal = menu+"&route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(lider!=""){
       menuFinal += "&admin=1&lider="+lider;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }
    if(menuInicial != menuFinal){
      swal.fire({ 
        title: "¿Buscar Pagos?",
        text: "Se Buscaran los pagos con las opciones seleccionadas, ¿Desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        confirmButtonText: "Buscar",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
      }).then((isConfirm) => {
        if (isConfirm.value){
          // window.location = $(this).val();
          // location.href = "?"+menuFinal;
          window.location = "?"+menuFinal;
        }else { 
          swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          });
        } 
      });
    }else{
      swal.fire({
          type: 'warning',
          title: '¡Debe seleccionar alguna opción para filtrar!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  });
  $(".BancariosFiltro").click(function(){
    var ruta = "Pagos&filtrar=Bancarios";
    var menu = "<?=$menu?>";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var lider = $("#lider").val();
    var banco = $("#banco").val();

    var menuInicial = menu+"&route="+ruta;
    var menuFinal = menu+"&route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(lider!=""){
       menuFinal += "&admin=1&lider="+lider;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }
    if(menuInicial != menuFinal){

      swal.fire({ 
        title: "¿Buscar Pagos de Movimientos Bancarios?",
        text: "Se Buscaran los pagos de movimientos bancarios con las opciones seleccionadas, ¿Desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        confirmButtonText: "Buscar",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
      }).then((isConfirm) => {
        if (isConfirm.value){
          // window.location = $(this).val();
          // location.href = "?"+menuFinal;
          window.location = "?"+menuFinal;
        }else { 
          swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          });
        } 
      });
    }else{
      swal.fire({
          type: 'warning',
          title: '¡Debe seleccionar alguna opción para filtrar!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  });
  $(".DivisasFitro").click(function(){
    var ruta = "Pagos&filtrar=Divisas";
    var menu = "<?=$menu?>";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var lider = $("#lider").val();
    var banco = $("#banco").val();

    var menuInicial = menu+"&route="+ruta;
    var menuFinal = menu+"&route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(lider!=""){
       menuFinal += "&admin=1&lider="+lider;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }
    if(menuInicial!=menuFinal){
      swal.fire({ 
        title: "¿Buscar Pagos en Divisas?",
        text: "Se Buscaran los pagos en divisas con las opciones seleccionadas, ¿Desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        confirmButtonText: "Buscar",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
      }).then((isConfirm) => {
        if (isConfirm.value){
          // window.location = $(this).val();
          // location.href = "?"+menuFinal;
          window.location = "?"+menuFinal;
        }else { 
          swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          });
        } 
      });
    }else{
      swal.fire({
          type: 'warning',
          title: '¡Debe seleccionar alguna opción para filtrar!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  });
  $(".BolivaresFitro").click(function(){
    var ruta = "Pagos&filtrar=Bolivares";
    var menu = "<?=$menu?>";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var lider = $("#lider").val();
    var banco = $("#banco").val();

    var menuInicial = menu+"&route="+ruta;
    var menuFinal = menu+"&route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(lider!=""){
       menuFinal += "&admin=1&lider="+lider;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }
    if(menuInicial!=menuFinal){
      swal.fire({ 
        title: "¿Buscar Pagos en Efectivo Bolivares?",
        text: "Se Buscaran los pagos en bolivares con las opciones seleccionadas, ¿Desea continuar?",
        type: "question",
        showCancelButton: true,
        confirmButtonColor: "<?=$colorPrimaryAll; ?>",
        confirmButtonText: "Buscar",
        cancelButtonText: "Cancelar", 
        closeOnConfirm: false,
        closeOnCancel: false 
      }).then((isConfirm) => {
        if (isConfirm.value){
          // window.location = $(this).val();
          // location.href = "?"+menuFinal;
          window.location = "?"+menuFinal;
        }else { 
          swal.fire({
              type: 'error',
              title: '¡Proceso cancelado!',
              confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          });
        } 
      });
    }else{
      swal.fire({
          type: 'warning',
          title: '¡Debe seleccionar alguna opción para filtrar!',
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
      });
    }
  });
  // DivisasFitro
  // BancariosFiltro
  // PagosFiltro

});  
</script>
</body>
</html>
