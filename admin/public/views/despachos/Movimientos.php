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


          <!-- $amMovimientosR -->


        <?php echo $url; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Home </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
            <?php if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario"){ ?>
              <br>
              <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar <?php echo $url; ?></a></div>
            <?php } ?>
    <!-- Main content -->
    <section class="content">

      <?php if($amMovimientosR=="1"){ ?>
        <a href="?route=Movimientos&action=Registrar" style="position:fixed;bottom:2%;right:2%;z-index:300;" class="btn enviar2"><span class="fa fa-arrow-up"></span> <span class="hidden-xs hidden-sm"><u>Registrar Movimiento</u></span></a>
      <?php } ?>

      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url." Bancarios"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
                <div class="row">
                  <!-- <form action="" method="get"> -->
                      <input type="hidden" name="route" value="<?=$_GET['route']?>">
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoI">Desde: </label>
                         <input type="date" <?php if(!empty($_GET['rangoI'])){ ?> value="<?=$_GET['rangoI']?>" <?php } ?> class="form-control" id="rangoI" name="rangoI">
                    </div>
                    <div class="form-group col-xs-12 col-md-6">
                         <label for="rangoF">Hasta: </label>
                         <input type="date" <?php if(!empty($_GET['rangoF'])){ ?> value="<?=$_GET['rangoF']?>" <?php } ?> class="form-control" id="rangoF" name="rangoF" >
                    </div>
                    <?php if (!empty($_GET['Banco'])): ?>
                      <input type="hidden" name="Banco" value="<?=$_GET['Banco']?>">
                    <?php endif; ?>
                  <!-- </form> -->
                </div>
                <br>
                <div class="row">
                  <!-- <form action="" method="get" class="form_select_banco"> -->
                      <!-- <input type="hidden" name="route" value="<?=$_GET['route']?>">
                      <?php if (!empty($_GET['rangoI']) && !empty($_GET['rangoF'])): ?>
                        <input type="hidden" name="rangoI" value="<?=$_GET['rangoI']?>">
                        <input type="hidden" name="rangoF" value="<?=$_GET['rangoF']?>">
                      <?php endif ?> -->
                      <div class="form-group col-xs-12">
                        <label for="banco">Seleccione al banco</label>
                        <select class="form-control select2 selectbanco" id="banco" name="Banco" style="width:100%;">
                          <option></option>
                          <?php foreach ($bancos as $data): ?>
                            <?php if (!empty($data['id_banco'])): ?>
                            <option <?php if (!empty($_GET['Banco'])): if($data['id_banco']==$_GET['Banco']): ?>
                                selected="selected"
                            <?php endif; endif; ?> value="<?=$data['id_banco']?>"><?=$data['nombre_banco']." - ".$data['nombre_propietario']." ".$data['cedula_cuenta']." (Cuenta ".$data['tipo_cuenta'].")";?></option>
                            <?php endif; ?>
                          <?php endforeach; ?>
                        </select>
                      </div>
                  <!-- </form> -->
                </div>
                  
                <div class="row">
                    <div class="form-group col-xs-12 col-md-4">
                      <br>
                      <button class="btn enviar2 FiltroMovimientos">Enviar</button>
                    </div>
                </div>

                <hr>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Fecha</th>
                  <th>Banco</th>
                  <th>Nº Movimiento</th>
                  <th>Monto</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                // print_r($clientes);
                foreach ($movimientos as $data):
                if(!empty($data['id_movimiento'])):  
                ?>
                <tr <?php if($data['estado_movimiento']=="Firmado"){ ?> style="background:#9F9;" <?php } ?>>
                  <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td>
                  <td style="width:10%">
                    <!-- <table style="background:none;text-align:center;width:100%"> -->
                      <!-- <tr> -->
                        <!-- <td style="width:50%"> -->

                      <?php if ($data['estado_movimiento']!="Firmado"): ?>
                          <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_movimiento'] ?>">
                            <span class="fa fa-wrench">
                              
                            </span>
                          </button>
                        <!-- </td> -->
                        <!-- <td style="width:50%"> -->
                          <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_movimiento'] ?>&permission=1">
                            <span class="fa fa-trash"></span>
                          </button>
                      <?php else: ?>
                          <button class="btn btnFichaDetalle" style="border:0;background:none;color:#9904a7" value="<?=$data['id_pago']?>"><span class="fa fa-file-text"></span></button>
  <div class="box-modalFichaDetalle box-modalFichaDetalle<?=$data['id_pago']?>" style="display:;background:rgba(0,0,0,.7);position:fixed;top:0;left:0;z-index:9050;width:100%;height:100vh;padding-top:50px;">
      <div class="content">
        <div class="row">
          <div class="col-xs-12 col-md-8 col-md-offset-2">
            <div class="container-fluid">
              <div class="box">
                <?php foreach ($firmas as $firm):
                  if (!empty($firm['id_pago'])):
                    if ($firm['id_pago']==$data['id_pago']): ?>

                <form action="" method="POST" class="form">
                  <div class="box-header with-border">
                    <div style="text-align:right;"><span class="btn cerrarModalFichaDetalle" id="<?=$data['id_pago']?>" style="background:#CCC"><b>X</b></span></div>
                    <div class="user-block">
                      <?php if ($firm['fotoPerfil']!=""): ?>
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$firm['fotoPerfil']?>" alt="user image">
                      <?php else: ?>
                        <?php $fotoPerfilMov = ""; ?>
                        <?php if ($firm['sexo']=="Femenino"): ?>
                          <?php $fotoPerfilMov = "public/assets/img/profile/Femenino.png"; ?>
                        <?php endif; ?>
                        <?php if ($firm['sexo']=="Masculino"): ?>
                          <?php $fotoPerfilMov = "public/assets/img/profile/Masculino.png"; ?>
                        <?php endif; ?>
                          
                        <!-- $fotoPerfilMov -->
                      <img style="width:50px;height:50px;margin-left:5px;margin-right:5px;" class="img-circle img-bordered-sm modal-img" src="<?=$fotoPerfilMov?>" alt="user image">
                      <?php endif; ?>
                      <span class="username" style="text-align:left;margin-left:50px;margin-top:0px">
                        <h4><span class="nameUserPago"><?=$firm['primer_nombre']." ".$firm['primer_apellido']?></span></h4>
                      </span>
                    </div>
                      <br>
                      <!-- <h3 class="box-title">Fecha de pago <span class="fecha_pago_modal"></span></h3> -->
                  </div>
                  <!-- <div class="linear_estado" style="text-align:right;padding-right:25px;">
                    <b><span class="name_estado" style="color:#FFF;font-size:1.3em"></span></b>
                  </div>
                  <div style="text-align:right;padding-right:25px">
                    <i><span class="name_observacion"></span></i>
                  </div>
                  <br> -->
                  <div class="box-body" style="padding-left:20px;padding-right:20px;">
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <?php if (!empty($data['fecha_movimiento'])): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_fecha"><i><b>Fecha: </b></i><?=str_replace("-","/",$lider->formatFecha($data['fecha_movimiento']))?></span>
                        <?php endif; ?>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <?php if ($firm['tasa_pago']!=""): ?>
                        <span style="font-size:1.3em" class="ficha_detalle_tasa"><i><b>Tasa: </b></i> Bs.<?=number_format($firm['tasa_pago'],2,',','.')?></span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <?php if ($firm['forma_pago']!=""): ?>
                        <span style="font-size:1.3em" class="ficha_detalle_forma"><?=$firm['forma_pago']?></span>
                        <?php endif; ?>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <?php if (!empty($data['nombre_banco'])): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_banco">Banco <?=$data['nombre_banco']?> <small>(<?=$data['nombre_propietario']?>)</small></span>
                        <?php endif; ?>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <?php if ($firm['referencia_pago']!=""): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_referencia"><i><b>Ref. </b></i> <?=$firm['referencia_pago']?></span>
                        <?php endif ?>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <?php if ($firm['tipo_pago']!=""): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_concepto"><i><b>Concepto: </b></i> <?=$firm['tipo_pago']?></span>
                        <?php endif ?>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12 col-sm-6" style="text-align:left;"> 
                        <?php if ($firm['monto_pago']!=""): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_monto"><i><b>Monto = </b></i> Bs. <?=number_format($firm['monto_pago'],2,',','.')?></span>
                        <?php endif ?>
                      </div>
                      <div class="col-xs-12 col-sm-6" style="text-align:right;"> 
                        <?php if ($firm['equivalente_pago']!=""): ?>
                          
                        <span style="font-size:1.3em" class="ficha_detalle_equivalente"><i><b>Eqv = </b></i> $<?=number_format($firm['equivalente_pago'],2,',','.')?></span>
                        <?php endif ?>
                      </div>
                    </div>
                  </div>
                  <br>
                    <!-- <div class="row">
                        <div class="form-group col-xs-12">
                          <label for="fecha_pago">Fecha de Pago</label>
                          <input type="date" id="fecha_pago" name="fecha_pago" class="form-control fecha_pago_modal2">
                          <span id="error_fechaPagoModal2" class="errors"></span>
                        </div>
                    </div>
                    <input type="hidden" name="rol" value="Conciliador">
                    <input type="hidden" class="id_pago_modal" name="id_pago_modal"> -->
       

                  <!-- <div class="container">
                    <span class="text-ficha-detalle"></span>
                  </div> -->
                  <!-- <div class="box-footer">
                    <span type="submit" class="btn enviar enviarModalFichaDetalle  ">Enviar</span>
                    <input type="color" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">
                    <button class="btn-enviar-modalConciliador   d-none" disabled="" >enviar</button>
                  </div> -->
                </form>
                <?php endif;
                  endif;
                endforeach; ?>
              </div>
            </div>
          </div>
        </div>
      </div>
  </div>

                      <?php endif; ?>
                        <!-- </td> -->
                      <!-- </tr> -->
                    <!-- </table> -->
                      
                      
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $lider->formatFecha($data['fecha_movimiento']); ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php echo $data['nombre_banco']."<br><small>".$data['nombre_propietario']." (".$data['tipo_cuenta'].")</small>"; ?>
                    </span>
                  </td>
                  
                  <td style="width:20%">
                    <span class="contenido2" style="font-size:.9em;">
                      <?php echo $data['num_movimiento']; ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <?php 
                        $myfloat = (float) $data['monto_movimiento'];
                        echo number_format($myfloat,2,',','.'); 
                       ?>
                    </span>
                  </td>
                </tr>
                <?php
               endif; endforeach;
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <th>---</th>
                  <th>Fecha</th>
                  <th>Banco</th>
                  <th>Nº Movimiento</th>
                  <th>Monto</th>
                </tr>
                </tfoot>
              </table>

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


  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<script>
$(document).ready(function(){ 
    var response = $(".responses").val();
  if(response==undefined){

  }else{
    if(response == "1"){
      swal.fire({
          type: 'success',
          title: '¡Datos borrados correctamente!',
          confirmButtonColor: "#ED2A77",
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        window.location = "?route=Movimientos";
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

  // $(".selectbanco").change(function(){
  //   var select = $(this).val();
  //   if(select!=""){
  //     $(".form_select_banco").submit();
  //   }
  // });
  $(".btnFichaDetalle").click(function(){
    var id_pago = $(this).val();
    // alert(id_pago);
    $(".box-modalFichaDetalle"+id_pago).fadeIn();
  });

  $(".cerrarModalFichaDetalle").click(function(){
    var id_pago = $(this).attr("id");
    // alert(id_pago);
    $(".box-modalFichaDetalle"+id_pago).fadeOut();
  });

  $(".FiltroMovimientos").click(function(){
    var ruta = "Movimientos";
    var rangoI = $("#rangoI").val();
    var rangoF = $("#rangoF").val();
    var banco = $("#banco").val();

    var menuInicial = "route="+ruta;
    var menuFinal = "route="+ruta;
    if(rangoI!=""){
       menuFinal += "&rangoI="+rangoI;
    }
    if(rangoF!=""){
       menuFinal += "&rangoF="+rangoF;
    }
    if(banco!=""){
       menuFinal += "&Banco="+banco;
    }

    // alert(menuInicial);
    // alert(rangoI);
    // alert(rangoF);
    // alert(banco);
    // alert(menuFinal);

    location.href = "?"+menuFinal;
    // if(menuInicial != menuFinal){
    //   swal.fire({ 
    //     title: "¿Filtrar Movimientos Bancarios?",
    //     text: "Se Buscaran los movimientos con las opciones seleccionadas, ¿Desea continuar?",
    //     type: "question",
    //     showCancelButton: true,
    //     confirmButtonColor: "#ED2A77",
    //     confirmButtonText: "Buscar",
    //     cancelButtonText: "Cancelar", 
    //     closeOnConfirm: false,
    //     closeOnCancel: false 
    //   }).then((isConfirm) => {
    //     if (isConfirm.value){            
    //       // window.location = $(this).val();
    //       location.href = "?"+menuFinal;
    //     }else { 
    //       swal.fire({
    //           type: 'error',
    //           title: '¡Proceso cancelado!',
    //           confirmButtonColor: "#ED2A77",
    //       });
    //     } 
    //   });
    // }else{
    //   swal.fire({
    //       type: 'warning',
    //       title: '¡Debe seleccionar alguna opción para filtrar!',
    //       confirmButtonColor: "#ED2A77",
    //   });
    // }
  });

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
            // alert($(this).val());         
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

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
                  confirmButtonColor: "#ED2A77",
          confirmButtonText: "¡Si!",
          cancelButtonText: "No", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){            
      
                swal.fire({ 
                    title: "¿Esta seguro de borrar los datos?",
                    text: "Se borraran los datos, esta opcion no se puede deshacer, ¿desea continuar?",
                    type: "error",
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

          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });
});  
</script>
</body>
</html>
