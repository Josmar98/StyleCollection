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
        <li><a href="?<?php echo $menu2 ?>&route=<?php echo "Promociones" ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo "Promociones" ?>"><?php echo "Pedido"; ?></a></li>
        <!-- <li><a href="?<?php echo $menu ?>&route=<?php echo "Promociones" ?>"><?php echo "Despacho ".$num_despacho; ?></a></li> -->
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Home"; ?></a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Promociones"; ?></a></li>
        <li class="active"><?php echo "Promociones"; ?></li>
      </ol>
    </section>

              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>

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

        <div class="col-md-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Promociones - Campaña ".$numero_campana."/".$anio_campana; ?></h3>
                  <?php if($estado_campana=="1"): ?>
                        <?php  if($_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Analista"){ ?>
                            <br>
                            <a class="btn" style="float:right;margin-right:20px;margin-top:10px;color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Promociones&action=Registrar&admin=1"><b>Realizar solicitud de promoción de Lider</b></a>
                            <br><br>
                        <?php } ?>
                  <?php endif; ?>
              <span style="clear:both;"></span>
            </div>

            <!-- /.box-header -->
            <div class="box-body">
                <?php
                $limiteSeleccionPromocion = $fechasPromo['fecha_cierre_promocion'];
                //$promociones=[]; $despacho['limite_pedido']=date('Y-m-d'); $infoCamp['restoFactura']=5;
              if(Count($promociones)>1){
                  $promocion = $promociones[0];
                  if($promocion['cantidad_aprobada_promocion']>0){ ?>
              
                          <table id="" class="datatablee table table-bordered table-striped" style="text-align:center;width:100%;">
                            <thead>
                            <tr>
                              <th>Nombre, Apellido y Cedula</th>
                              <th>Nombre Promoción</th>
                              <th>Promociones Solicitadas</th>
                              <th>Promociones Aprobadas</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php 
                            $num = 1;
                            if(Count($promociones)>1){
                              foreach ($promociones as $data){
                                if(!empty($data['id_promociones'])){
                                  ?>
                                  <tr>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php 
                                          echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula'];
                                        ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php 
                                          echo $data['nombre_promocion'];
                                        ?>
                                      </span>
                                    </td>
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <?php
                                          echo $data['cantidad_solicitada_promocion']." Prom. Solicitadas";
                                        ?>
                                      </span>
                                    </td>                  
                                    <td style="width:20%">
                                      <span class="contenido2">
                                        <span style="color:#0d0;">
                                          <?php
                                            echo $data['cantidad_aprobada_promocion']. " Prom. Aprobadas";
                                          ?>
                                        </span>
                                      </span>
                                    </td>
                                  </tr>
                                  <?php
                                  $href=$menu3."&route=Pedidos&id=".$data['id_pedido'];
                                }
                              }
                            }else{
                              ?>
                              <tr><td colspan='7'>Ningún dato disponible en esta tabla</td></tr>
                              <?php 
                            }
                            ?>
                            </tbody>
                            <tfoot>
                            <tr>
                              <th colspan="5" style="font-size:1em;"><a href="?<?=$href?>">Ir al Estado de cuentas</a></th>
                            </tr>
                            </tfoot>
                          </table>
                          <?php 
                          ?>
                  <?php }else{ ?>
                          <div style="margin-left:3%;font-size:1.1em;">
                          <b><i>
                            <!-- <br> -->
                                <?php 
                                  $limite = date('Y-m-d'); 
                                  if($limite <= $limiteSeleccionPromocion){ ?>
                                  <b style="float:right;margin-right:25px;"><u><a href="?<?php echo $menu ?>&route=Promociones&action=Modificar&id=<?php echo $promocion['id_promociones'] ?>"><i>Editar Solicitud</i></a></u></b>
                                <?php } ?>
                                <br><br>
                              <span style="color:red;margin-left:1%">Importante: </span>
                              Ya se solicitaron sus <u><?php if(!empty($promocion)){ echo $promocion['cantidad_solicitada_promocion']; } ?> promociones</u> para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> - debera esperar a ser confirmado por el / la Gerente. Gracias.
                            </i></b>  
                          </div>
                  <?php } ?>
                        <br><br>
                <?php 
              }else{
                
                // $limiteSeleccionPromocion = "2023-05-02";
                $limite = date('Y-m-d');
                //echo "<br>Limite: ".$limiteSeleccionPromocion."<br>";
                // $limite = "2021-10-14";
                  if($limite <= $limiteSeleccionPromocion){

                    if(!empty($infoCamp['restoFactura']) && $infoCamp['restoFactura']>0 && $opcionFacturasCerradas==1){
                      ?>
                        <div style="margin-left:3%;font-size:1.1em;">
                          <b><i>
                            <span style="color:red;margin-left:1%;" >Importante: </span>
                            Actualmente usted cuenta con factura pendiente por cerrar en la <?=$infoCamp[0]['info']; ?>.

                            Podra solicitar su pedido para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> una vez haya cerrado su factura pendiente <u>a tiempo</u>, tiene disponibilidad hasta la fecha <u><?php echo $lider->formatFecha($despacho['limite_pedido']); ?></u>. de lo contrario la opcion para solicitar su pedido ya no estara disponible. 
                            <br><br>
                            Una vez haya solicitado su pedido, podrá solicitar las promociones deseadas.
                            Gracias.

                            <br><br>El monto pendiente en la <?=$infoCamp[0]['info']; ?> es $<?=number_format($infoCamp['restoFactura'],2,',','.'); ?>
                          </i></b> 
                        </div>
                      <?php
                    } else {
                      if(count($pedidos)>1){
                        ?>
                        <div style="margin-left:3%;font-size:1.1em;">
                          <b><i>
                            <span style="color:red;margin-left:1%;" >Importante: </span>
                            Podra solicitar sus promociones para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> hasta la fecha <u><?php echo $lider->formatFecha($limiteSeleccionPromocion); ?></u>. de lo contrario la opcion para solicitar sus promociones ya no estara disponible. Gracias.
                          </i></b> 
                        </div>
                        <?php 
                        if($_SESSION['cuenta']['estatus'] == 1){ ?>
                          <center>
                            <a class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>" href="?<?php echo $menu3; ?>route=Promociones&action=Registrar">
                              <b>Realizar Solicitud de Promociones</b>    
                            </a>
                          </center>
                          <?php 
                        } 
                      } else {
                        ?>
                          <div style="margin-left:3%;font-size:1.1em;">
                            <b><i>
                              <span style="color:red;margin-left:1%;" >Importante: </span>
                              Realice la solicitud de pedidos de colecciones para está campaña <?=$numero_campana."/".$anio_campana; ?> Para solicitar las promociones deseadas. Gracias.
                            </i></b> 
                          </div>
                        <?php
                      }
                    }
                  }else{
                ?>
                      <div style="margin-left:3%;font-size:1.1em;">
                        <b><i>
                          <span style="color:red;margin-left:1%">Importante: </span>
                          Usted alcanzo la fecha limite para solicitar sus promociones para esta Campaña <?php echo $numero_campana."/".$anio_campana; ?> - debera esperar a una proxima oportunidad para solicitar sus promociones. Gracias.
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


          <?php if($_SESSION['nombre_rol'] == "Administrativo" || $_SESSION['nombre_rol'] == "Administrador" || $_SESSION['nombre_rol'] == "Superusuario" || $_SESSION['nombre_rol'] == "Analista" || $_SESSION['nombre_rol']=="Analista Supervisor" || $_SESSION['nombre_rol']=="Contable"){ ?>

          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Promociones en la <?php echo " Campaña ".$numero_campana."/".$anio_campana; ?> </h3>
            </div>
            <div class="box-body">
              <table id="" class="datatable table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                  <tr>
                    <th>---</th>
                    <th></th>
                    <th>Nombre, Apellido y Cedula</th>
                    <th>Nombre Promoción</th>
                    <th>Promociones Solicitadas</th>
                    <th>Promociones Aoprobadas</th>
                  </tr>
                </thead>
                <tbody>
                  <?php 
                    $num = 1;
                    $totalSolicitadas = 0;
                    $totalAprobadas = 0;
                    $totalPromos = [];
                    if(Count($promocionesFull)>1){
                      foreach ($promocionesFull as $data){ if(!empty($data['id_promociones'])){
                        ?>
                        <?php
                          $permitido = 0;
                          if($accesoBloqueo=="1"){
                            if(!empty($accesosEstructuras)){
                              foreach ($accesosEstructuras as $struct) {
                                if(!empty($struct['id_cliente'])){
                                  if($struct['id_cliente']==$data['id_cliente']){
                                    $permitido = 1;
                                  }
                                }
                              }
                            }
                          } else if($accesoBloqueo=="0"){
                            $permitido = 1;
                          }
                        ?>
                          <?php if ($permitido == 1){ 
                            if(!empty($totalPromos[$data['nombre_promocion']])){
                              $totalPromos[$data['nombre_promocion']]+=$data['cantidad_aprobada_promocion'];
                            }else{
                              $totalPromos[$data['nombre_promocion']]=$data['cantidad_aprobada_promocion'];
                            }
                            ?>
                            <tr>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php if($_SESSION['nombre_rol'] == "Administrativo" || $_SESSION['nombre_rol'] == "Analista" || $_SESSION['nombre_rol'] == "Analista Supervisor"){ ?>
                                      <?php if ($data['cantidad_aprobada_promocion']==0){ ?>
                                        <a>
                                          <b style="color:#898989">Promoción Solicitada</b>
                                        </a>
                                      <?php } else { ?>
                                        <a><b>Promoción Aprobada</b></a>
                                      <?php } ?>
                                  <?php } else { ?>
                                      <?php if ($data['cantidad_aprobada_promocion']>0){ ?>
                                        <a><b>Promoción Aprobada</b></a>
                                      <?php } else { ?>
                                      <a href="?<?php echo $menu; ?>&route=Promociones&action=Aprobar&id=<?php echo $data['id_promociones'] ?>">
                                        <b>Ver Promociones</b>
                                      </a>
                                      <?php } ?>
                                  <?php } ?>
                                </span>
                              </td>
                              <td style="width:5%;">
                                <?php if($data['cantidad_aprobada_promocion'] < 1){ ?>

                                  <?php if($_SESSION['nombre_rol']!="Vendedor"){ ?>
                                    <span><i class="fa fa-wrench editarPromosLideres" id="<?php echo $menu; ?>&route=Promociones&action=Modificar&id=<?php echo $data['id_promociones']; ?>&lider=<?=$data['id_cliente']; ?>" style="color:#04a7c9;"></i></span>
                                  <?php } ?>

                                <?php }else{ ?>
  
                                  <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"||$_SESSION['nombre_rol']=="Administrativo" || $_SESSION['nombre_rol']=="Analista Supervisor"){ ?>
                                    <span><i class="fa fa-wrench editarPromosLideres" id="<?php echo $menu; ?>&route=Promociones&action=Aprobar&id=<?php echo $data['id_promociones']; ?>&lider=<?=$data['id_cliente']; ?>" style="color:#c904a7;"></i></span>
                                  <?php } ?>

                                <?php } ?>
                              </td>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php 
                                    echo $data['primer_nombre']." ".$data['primer_apellido']." ".$data['cedula'];
                                  ?>
                                </span>
                              </td>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php 
                                    echo $data['nombre_promocion'];
                                  ?>
                                </span>
                              </td>
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php
                                    echo $data['cantidad_solicitada_promocion']." Prom. Solicitadas";
                                    $totalSolicitadas += $data['cantidad_solicitada_promocion'];
                                  ?>
                                </span>
                              </td>                  
                              <td style="width:20%">
                                <span class="contenido2">
                                  <?php
                                    $colorTextCell = "";
                                    if($data['cantidad_aprobada_promocion']!="0"){
                                      $colorTextCell = "#0D0";
                                    }else{
                                    }
                                  ?>
                                  <span style="color:<?=$colorTextCell; ?>;">
                                    <?php 
                                      echo $data['cantidad_aprobada_promocion']. " Prom. Aprobadas";
                                      $totalAprobadas += $data['cantidad_aprobada_promocion'];
                                    ?> 
                                  </span>
                                </span>
                              </td>
                            </tr>
                          <?php } ?>

                        <?php
                          $num++;  
                      } }
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
                    <th></th>
                    <th>Nombre, Apellido y Cedula</th>
                    <th>Nombre Promoción</th>
                    <th>Promociones Solicitadas</th>
                    <th>Promociones Aprobadas</th>
                  </tr>
                  <tr style="background:#CCC;font-size:1.2em;">
                    <th>
                      <?php 
                        if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo2" || $_SESSION['nombre_rol']=="Analista Supervisor2"){

                        }
                      ?>
                    </th>
                    <th></th>
                    <th></th>
                    <th colspan="">
                      <?php
                        // print_r($totalPromos);
                        foreach ($totalPromos as $key => $value){ if(!empty($key)){
                          echo "(".$value.") ".$key."<br>";
                        } }
                      ?>
                    </th>
                    <th><?=$totalSolicitadas; ?> Promos Solicitadas</th>
                    <th style="color:#0B0;"><?=$totalAprobadas; ?> Promos Aprobadas</th>
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

            <!-- // <table style="width:;text-align:left;">
              //foreach ($pedidos_historicos as $hist){ if(!empty($hist['id_pedidos_historicos'])){
                //if ($hist['id_pedido']==$data['id_pedido']){ ?>
                  // <tr>
                    // <td>
                      // Aprobadas: <b style="color:#0D0"><?=$hist['cantidad_aprobado']; ?> Cols.</b>
                      // Por <b><?=$hist['primer_nombre']." ".$hist['primer_apellido']; ?></b>
                      // <small>(<?=$hist['fecha_aprobado']." ".$hist['hora_aprobado']; ?>)</small>
                    // </td>
                  // </tr>
                //} 
              //} }
            // </table> -->

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

  $(".editarPromosLideres").click(function(){
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
            var rutaId = $(this).attr("id");
            window.location = "?"+rutaId;
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "#ED2A77",
              });
          } 
      });
  });
  $(".modalHistorico").click(function(){
    var id = $(this).attr('id');
    var show = $(".modalHistorico"+id).attr("placeholder");
    $(".modalesHistorico").slideUp();
    $(".modalesHistorico").attr("placeholder","0");
    if(show==0){
      var carga = $(".carga"+id).val();
      // alert(carga);
      if(carga==0){
        $.ajax({
          url: '',
          type: 'POST',
          data: {
            pedidos_historicos: true,
            id_pedido: id,
          },
          success: function(respuesta){
            // alert(respuesta);
            var json = JSON.parse(respuesta);
            if(json['msj']=="Good"){
              var data = json['data'];
              var html = "";
              html += '<table style="width:;text-align:left;">';
                for (var i = 0; i < data.length; i++) {
                  html += '<tr>';
                    html += '<td>';
                      html += 'Aprobadas: <b style="color:#0D0">'+data[i]['cantidad_aprobado']+' Cols.</b>';
                      html += 'Por: <b>'+data[i]['primer_nombre']+' '+data[i]['primer_apellido']+'</b>';
                      html += '<small>('+data[i]['fecha_aprobado']+' '+data[i]['hora_aprobado']+')</small>';
                    html += '</td>';
                  html += '</tr>';
                }
              html += '</table>';
              $(".contentHistorico"+id).html(html);
              $(".carga"+id).val(1);
            }
          }
        });
      }
      $(".modalHistorico"+id).attr("placeholder","1");
      $(".modalHistorico"+id).slideDown();
    }
    if(show==1){
      $(".modalHistorico"+id).attr("placeholder","0");
      $(".modalHistorico"+id).slideUp();
    }
    // alert(show);
    // alert(id);
    // $(".modalHistorico"+id).slideToggle();
  });

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
