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
        <?php echo "Campaña ".$n; ?>
        <small><?php echo "Campaña ".$n."/".$y;; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Homing" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Homing2" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Pedidos"; ?></a></li>
        <li class="active"><?php echo "Pedidos"; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
        <?php 
          $fecha = date('Y-m-d');
          $tasas = $lider->consultarQuery("SELECT * FROM tasa WHERE estatus = 1 and fecha_tasa = '$fecha'");
          if(Count($tasas)>1){ $tasa = $tasas[0];
        ?>
          <div class="row">
            <div class="col-xs-12 col-md-6">
              <div class="box">
                <div class="box-header">
                  <h3 class="box-title" style="margin-left:15%"><u><b>Tasa del dia</b></u></h3>
                  <?php $fechaHoy = $lider->formatFecha($tasa['fecha_tasa']); ?>
                  <?php 
                    $dd = substr($fechaHoy, 0, 2);
                    $mm = substr($fechaHoy, 3, 2);
                    $yy = substr($fechaHoy, 6, 4);
                    if($mm=="01"){$mm="Enero";}
                    if($mm=="02"){$mm="Fecbrero";}
                    if($mm=="03"){$mm="Marzo";}
                    if($mm=="04"){$mm="Abril";}
                    if($mm=="05"){$mm="Mayo";}
                    if($mm=="06"){$mm="Junio";}
                    if($mm=="07"){$mm="Julio";}
                    if($mm=="08"){$mm="Agosto";}
                    if($mm=="09"){$mm="Septiembre";}
                    if($mm=="10"){$mm="Octubre";}
                    if($mm=="11"){$mm="Noviembre";}
                    if($mm=="12"){$mm="Diciembre";}
                  ?>
                  <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>Bs. ".number_format($tasa['monto_tasa'],2,',','.')."</b> al ".$dd." de ".strtolower($mm)." del ".$yy; ?></h4>
                  <!-- <h4 style="font-size:1.2em;"><?php echo "El precio del <b>Dolar</b> es <b style='font-size:1.4em;color:#0B0;'>$".number_format($tasa['monto_tasa'],2,',','.')."</b> a la fecha ".$fechaHoy; ?></h4> -->
                </div>
              </div>
            </div>
          </div>
        <?php } ?>

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

      <div class="row">

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Estado de cuentas - Campaña ".$numero_campana."/".$anio_campana; ?></h3>
                  <?php if($estado_campana=="1"): ?>
                        <?php  if($_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                            <br>
                            <a class="btn" style="float:right;margin-right:20px;margin-top:10px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pedidos&action=Registrar&admin=1"><b>Realizar solicitud de Pedido de Lider</b></a>
                            <br><br>
                        <?php } ?>
                  <?php endif; ?>
              <span style="clear:both;"></span>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
                  <?php
              if(Count($pedidos)>1){
                  $pedido = $pedidos[0];
                  if($pedido['cantidad_aprobado']>0){ ?>
              
                          <table id="" class="datatablee table table-bordered table-striped" style="text-align:center;width:100%;">
                            <thead>
                              <?php if(Count($cols)>1 || Count($pedd)<2 || $limittteee=="0"){}else{ ?>
                                <tr>
                                  <th colspan="4" style="font-size:1em;"><a href="?<?=$menu?>&route=PlanCol&action=Registrar" class="btn enviar">Seleccionar Planes</a></th>
                                </tr>
                              <?php } ?>
                              <?php  if(Count($prems)>1 || Count($cols)<2 || $limittteee=="0"){}else{ ?>
                                <tr>
                                  <th colspan="4" style="font-size:1em;"><a href="?<?=$menu?>&route=PremioCol&action=Registrar" class="btn enviar">Seleccionar premios</a></th>
                                </tr>
                              <?php } ?>
                            <tr>
                              <!-- <th>---</th> -->
                              <th>Nombre Apellido y Cedula</th>
                              <!-- <th></th> -->
                              <th>Colecciones Solicitadas</th>
                              <th>Colecciones Confirmadas</th>
                              <!-- <th>---</th> -->
                            </tr>
                            </thead>
                            <tbody>
                             <?php 
                            $num = 1;
                            if(Count($pedidos)>1){
                              foreach ($pedidos as $data):
                                if(!empty($data['id_pedido'])):  
                              ?>
                              <tr>
                                <!-- <td style="width:20%">
                                  <span class="contenido2">
                                    <a class="btn" href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>">
                                      <button class="btn bg-fucsia">Ver</button>
                                    </a>
                                  </span>
                                </td> -->
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                      <?php echo $data['primer_nombre']; ?>
                                      <?php echo $data['primer_apellido']; ?>
                                      <?php echo $data['cedula']; ?>
                                    <!-- </a>   -->
                                  </span>
                                </td>
                                <!-- <td style="width:20%">
                                  <span class="contenido2">
                                    <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>">
                                    </a>
                                  </span>
                                </td> -->
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                      <?php echo $data['cantidad_pedido']." Col Solicitadas" ?>
                                    <!-- </a> -->
                                  </span>
                                </td>                  
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                      <span style="color:#0d0;">
                                        <?php echo $data['cantidad_aprobado']. " Col Aprobadas"; ?>

                                      </span>
                                    <!-- </a> -->
                                  </span>
                                </td>
                                <!-- <td style="width:10%">
                                  <table style="background:none;text-align:center;width:100%">
                                    <tr>
                                      <td style="width:50%">
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_campana'] ?>">
                                          <span class="fa fa-wrench">
                                            
                                          </span>
                                        </button>
                                      </td>
                                      <td style="width:50%">
                                        <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_campana'] ?>&permission=1">
                                          <span class="fa fa-trash"></span>
                                        </button>
                                      </td>
                                    </tr>
                                  </table>
                                    
                                    
                                </td> -->
                                </tr>
                                <?php $href=$menu."&route=Pedidos&id=".$data['id_pedido'] ?>

                                <?php
                                endif; endforeach;
                            }else{
                              ?>
                              <tr><td colspan='7'>Ningún dato disponible en esta tabla</td></tr>
                              <?php 
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                              <!-- <th>---</th>
                              <th>Nombre Apellido y Cedula</th> -->
                              <!-- <th></th> -->
                              <!-- <th>Colecciones Solicitadas</th> -->
                              <!-- <th>Colecciones Confirmadas</th> -->
                              <!-- <th>---</th> -->
                          <?php 
                            if(Count($pedidos)>1){
                              $pedido = $pedidos[0];
                              if($pedido['cantidad_aprobado']>0){

                              }
                            } ?>
                              <th colspan="4" style="font-size:1em;"><a href="?<?=$href?>">Ver Estado de cuentas</a></th>
                            </tr>
                                 

                            </tfoot>
                          </table>

                  <?php }else{ ?>

                          <div style="margin-left:3%;font-size:1.1em;">
                          <b><i>
                            <!-- <br> -->
                                <?php $limite = date('Y-m-d'); if($limite <= $despacho['limite_pedido']){ ?>
                                  <b style="float:right;margin-right:25px;"><u><a href="?<?php echo $menu ?>&route=Pedidos&action=Modificar&id=<?php echo $pedido['id_pedido'] ?>"><i>Editar Pedido</i></a></u></b>
                                <?php } ?>
                                <br><br>
                              <span style="color:red;margin-left:1%">Importante: </span>
                              Ya se solicito su pedido por <u><?php echo $pedido['cantidad_pedido'] ?> colecciones</u> para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> - debera esperar a ser confirmado por el / la Gerente. Gracias.
                            </i></b>  
                          </div>
                  <?php } ?>
                        <br><br>
                <?php 
              }else{
                ?>
                      <?php 
                      $limite = date('Y-m-d');
                      // $limite = "2021-10-14";
                        if($limite <= $despacho['limite_pedido']){
                      ?>
                          <div style="margin-left:3%;font-size:1.1em;">
                            <b><i>
                              <span style="color:red;margin-left:1%;" >Importante: </span>
                              Podra solicitar su pedido para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> hasta la fecha <u><?php echo $lider->formatFecha($despacho['limite_pedido']); ?></u>. de lo contrario la opcion para solicitar su pedido ya no estara disponible. Gracias.
                            </i></b> 
                          </div>
                          <?php if($_SESSION['cuenta']['estatus'] == 1){ ?>
                            <center>
                              <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Pedidos&action=Registrar">
                                <b>Realizar Solicitud de Pedido</b>    
                              </a>
                            </center>
                          <?php } ?>
                      <?php
                        }else{
                      ?>
                            <div style="margin-left:3%;font-size:1.1em;">
                              <b><i>
                                <span style="color:red;margin-left:1%">Importante: </span>
                                Usted alcanzo la fecha limite para solicitar su pedido para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> - debera esperar a un proximo pedido para realizar su pedido. Gracias.
                              </i></b>  
                            </div>
                      <?php
                        }
                      ?>
                  <br><br>
                <?php 
              }
                ?>

            </div>

            <!-- /.box-body -->
          </div>
          <?php if($_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Pedidos Realizados en la <?php echo " Campaña ".$numero_campana."/".$anio_campana; ?> </h3>
            </div>
            <div class="box-body">
                    <table id="" class="datatable table table-bordered table-striped" style="text-align:center;width:100%;">
                            <thead>
                            <tr>
                              <th>---</th>
                              <th>Nombre Apellido y Cedula</th>
                              <!-- <th></th> -->
                              <th>Colecciones Solicitadas</th>
                              <th>Colecciones Confirmadas</th>
                              <!-- <th>---</th> -->
                            </tr>
                            </thead>
                            <tbody>
                             <?php 
                            $num = 1;
                            if(Count($pedidosFull)>1){
                              foreach ($pedidosFull as $data):
                                if(!empty($data['id_pedido'])):  
                              ?>
                              <tr>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <?php if($_SESSION['nombre_rol'] == "Analista" || $_SESSION['nombre_rol'] == "Analista Supervisor"){ ?>
                                        
                                        <?php if ($data['cantidad_aprobado']==0): ?>
                                            <b style="color:#898989">* Ver Pedido</b>
                                        <?php else: ?>
                                          <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>">
                                            <b>Ver Estado de cuentas</b>
                                          </a>
                                        <?php endif; ?>

                                    <?php } else { ?>

                                      <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>">
                                        <?php if ($data['cantidad_aprobado']>0): ?>
                                          <b>Ver Estado de cuentas</b>
                                        <?php else: ?>
                                          <b>* Ver Pedido</b>
                                        <?php endif; ?>
                                      </a>

                                    <?php } ?>

                                  </span>
                                </td>
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                      <?php echo $data['primer_nombre']; ?>
                                      <?php echo $data['primer_apellido']; ?>
                                      <?php echo $data['cedula']; ?>
                                    <!-- </a>   -->
                                  </span>
                                </td>
                                <!-- <td style="width:20%">
                                  <span class="contenido2">
                                    <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>">
                                    </a>
                                  </span>
                                </td> -->
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                      <?php echo $data['cantidad_pedido']." Col Solicitadas" ?>
                                    <!-- </a> -->
                                  </span>
                                </td>                  
                                <td style="width:20%">
                                  <span class="contenido2">
                                    <!-- <a href="?<?php echo $menu ?>&route=Pedidos&id=<?php echo $data['id_pedido'] ?>"> -->
                                    <?php if($data['cantidad_aprobado']!="0"){ ?>
                                      <span style="color:#0d0;">
                                       <?php echo $data['cantidad_aprobado']. " Col Aprobadas";?> 
                                      </span>
                                     <?php } else { ?>
                                       <?php echo $data['cantidad_aprobado']. " Col Aprobadas";?> 
                                     <?php } ?>

                                    <!-- </a> -->
                                  </span>
                                </td>
                                <!-- <td style="width:10%">
                                  <table style="background:none;text-align:center;width:100%">
                                    <tr>
                                      <td style="width:50%">
                                        <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?php echo $url; ?>&action=Modificar&id=<?php echo $data['id_campana'] ?>">
                                          <span class="fa fa-wrench">
                                            
                                          </span>
                                        </button>
                                      </td>
                                      <td style="width:50%">
                                        <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data['id_campana'] ?>&permission=1">
                                          <span class="fa fa-trash"></span>
                                        </button>
                                      </td>
                                    </tr>
                                  </table>
                                    
                                    
                                </td> -->
                                </tr>
                                <?php
                                
                                endif; endforeach;
                            }else{
                              ?>
                              <tr><td colspan='7'>Ningún dato disponible en esta tabla</td></tr>
                              <?php 
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                              <th>---</th>
                              <th>Nombre Apellido y Cedula</th>
                              <!-- <th></th> -->
                              <th>Colecciones Solicitadas</th>
                              <th>Colecciones Confirmadas</th>
                              <!-- <th>---</th> -->
                            </tr>
                            </tfoot>
                    </table>
            </div>
            
          </div>
          <?php } ?>
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
<input type="hidden" class="campaing" value="<?php echo $id_campana ?>">
<input type="hidden" class="n" value="<?php echo $numero_campana ?>">
<input type="hidden" class="y" value="<?php echo $anio_campana ?>">
<input type="hidden" class="dpid" value="<?php echo $id_despacho ?>">
<input type="hidden" class="dp" value="<?php echo $num_despacho ?>">
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
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&dpid="+dpid+"&dp="+dp+"&route=Homing2";
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

  var filter = $(".filter").val();
  $("."+filter).hide(); 
  $(".title_ocultar").hide();
  $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
  $(".siempre").show();
  $(".filter").change(function(){
    $("#table_colecciones tr").show();
    var filter = $(".filter").val();
    $("."+filter).hide(); 
    $(".title_ocultar").hide();
    $("#table_colecciones tr:not(:contains('Despacho "+filter+"'))").hide();
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
