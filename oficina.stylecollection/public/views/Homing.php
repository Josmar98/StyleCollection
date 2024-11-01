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
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><i class="fa fa-dashboard"></i> Campaña <?php echo $n."/".$y; ?> </a></li>
        <li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo "Home"; ?></a></li>
        <li class="active"><?php echo "Home"; ?></li>
      </ol>
    </section>
              <br>
              <!-- <div style="width:100%;text-align:center;"><a href="?route=<?php echo $url ?>&action=Registrar" class="color_btn_sweetalert" style="text-decoration-line:underline;">Registrar Campaña</a></div> -->
    <!-- Main content -->
    <section class="content">

      <div class="row">
        <?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>

        <?php 
              $amCampanas = 0;
              $amCampanasR = 0;
              $amCampanasC = 0;
              foreach ($accesos as $access) {
                if(!empty($access['id_acceso'])){
                  if($access['nombre_modulo'] == "Campañas"){
                    $amCampanas = 1;
                    if($access['nombre_permiso'] == "Registrar"){
                      $amCampanasR = 1;
                    }
                    if($access['nombre_permiso'] == "Ver"){
                      $amCampanasC = 1;
                    }
                  }
                }
              }
              if($amCampanas == 1){
                if($amCampanasR==1){
          ?>
        <div class="col-xs-12 col-md-6">
          <div class="box">
            <div class="box-header">
              <h3 class="box-title">Visibilidad</h3>
              <select class="form-control" id="visibilidadCamp" name="visibilidadCamp">
                <option value="0" <?php if($visibilidad == "0"){echo "selected=''";} ?>>Oculto</option>
                <option value="1" <?php if($visibilidad == "1"){echo "selected=''";} ?>>Visible</option>
              </select>
              <button class="btn enviar enviarVisibilidadCamp" style="">Enviar</button>
            </div>
          </div>
        </div>
        <?php }} ?>

      <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador"): ?>
        <div class="col-xs-12 col-md-12">
          <div class="box">
            <div style="width:100%;text-align:right;position:absolute;z-index:1">
              <button class="btnBoxEstado" style="margin-top:0%;margin-right:1%;background:none;border:none;">
                <span id="fasEstado" class="fa fa-chevron-down" ></span>
              </button>
            </div>
            <div class="box-header">
              <h3 class="box-title">
                Estado de Campaña ~ <?php if($estado_campana=="1"){ echo "Abierta"; } if($estado_campana=="0"){ echo "Cerrada"; } ?> ~
              </h3>
              <div class="box_Estados" style="display:none;">
              <select class="form-control" id="estadoCamp" name="estado_campanaCamp">
                <option value="0" <?php if($estado_campana == "0"){echo "selected=''";} ?>>Cerrada</option>
                <option value="1" <?php if($estado_campana == "1"){echo "selected=''";} ?>>Abierta</option>
              </select>
              <button class="btn enviar enviarEstadoCamp" style="">Enviar</button>
              </div>
            </div>
          </div>
        </div>
      <?php else: ?>
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
      <?php endif; ?>



      </div>

      <div class="row">
        <div class="col-md-6 col-sm-10">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Mi Pedido"; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <table id="" class="datatablee table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <!-- <th>Nº</th> -->
                  <th>Pedido</th>
                  <th>Fechas de Pago</th>
                  <th>Precio Coleccion</th>
                  <!-- <th>---</th> -->
                </tr>
                </thead>
                <tbody>
             <?php 
              $num = 1;
              // print_r($clientes);
              if(Count($despachos)>1){
              foreach ($despachos as $data):
                if(!empty($data['id_despacho'])):  
              ?>
                <tr>
                  <!-- <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td> -->
                  <td style="width:20%;">
                    <span class="contenido2">
                      <a href="?<?php echo $menu ?>&dpid=<?php echo $data['id_despacho'] ?>&dp=<?php echo $data['numero_despacho'] ?>&route=Homing2">
                        <?php
                          $ndp = "";
                          if($data['numero_despacho']=="1"){ $ndp = "1er"; }
                          if($data['numero_despacho']=="2"){ $ndp = "2do"; }
                          if($data['numero_despacho']=="3"){ $ndp = "3er"; }
                          if($data['numero_despacho']=="4"){ $ndp = "4to"; }
                          if($data['numero_despacho']=="5"){ $ndp = "5to"; }
                          if($data['numero_despacho']=="6"){ $ndp = "6to"; }
                          if($data['numero_despacho']=="7"){ $ndp = "7mo"; }
                          if($data['numero_despacho']=="8"){ $ndp = "8vo"; }
                          if($data['numero_despacho']=="9"){ $ndp = "9no"; }
                        ?>
                        <?php 
                          echo $ndp;
                          // if($data['numero_despacho']!="1"){
                          //   // echo $data['numero_despacho'];
                          //   echo $ndp;
                          // }
                          echo " Pedido ";
                          if( $data['nombre_despacho']!="" ){
                            echo " - ".$data['nombre_despacho'];
                          }else{
                            echo " - Campaña ".$numero_campana."/".$anio_campana;
                          }
                        ?>
                      </a>
                    </span>
                  </td>                  
                  <td style="width:40%;">
                    <span class="contenido2">
                      <table style="width:100%;">
                        <?php 
                          foreach ($pagos_despacho as $dataPD){ if (!empty($dataPD['id_despacho'])){
                              if($data['id_despacho'] == $dataPD['id_despacho']){ ?>
                                <tr>
                                  <td style="text-align:center;"><?php echo $dataPD['tipo_pago_despacho']; ?></td>
                                  <!-- <td style="text-align:right;"><?php echo $dataPD['tipo_pago_despacho']; ?></td> -->
                                  <!-- <td>:</td> -->
                                  <!-- <td style="color:#FFFFFFFF;"><?php echo $lider->formatFecha($dataPD['fecha_pago_despacho_senior']); ?></td> -->
                                </tr>
                              <?php }
                          } }
                        ?>
                      </table>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&dpid=<?php echo $data['id_despacho'] ?>&dp=<?php echo $data['numero_despacho'] ?>&route=Homing2"> -->
                        <?php echo "$".number_format($data['precio_coleccion'],2,',','.'); ?>
                      <!-- </a>   -->
                    </span>
                  </td>
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
                  <!-- <th>Nº</th> -->
                  <th>Pedido</th>
                  <th>Fechas de Pago</th>
                  <th>Precio Coleccion</th>
                  <!-- <th>---</th> -->
                </tr>
                </tfoot>
              </table>

            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>





        <div class="col-md-6 col-sm-10">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Estructura de la coleccion"; ?></h3>
            </div>
            <!-- /.box-header -->
            <div class="box-body">
              <!-- <br> -->
              <select class="form-control filter col-xs-offset-1"  style="width:85%">
                <!-- <option value=""></option> -->
                <?php 
                foreach ($despachos as $dataa) {
                  if(!empty($dataa['id_despacho'])){
                ?>
                  <!-- <option value="<?php echo $dataa['numero_despacho'] ?>">Pedido <?php echo $dataa['numero_despacho'] ?></option> -->
                  <option value="<?php echo $dataa['numero_despacho'] ?>">
                    <?php
                      $ndp = "";
                      if($dataa['numero_despacho']=="1"){ $ndp = "1er"; }
                      if($dataa['numero_despacho']=="2"){ $ndp = "2do"; }
                      if($dataa['numero_despacho']=="3"){ $ndp = "3er"; }
                      if($dataa['numero_despacho']=="4"){ $ndp = "4to"; }
                      if($dataa['numero_despacho']=="5"){ $ndp = "5to"; }
                      if($dataa['numero_despacho']=="6"){ $ndp = "6to"; }
                      if($dataa['numero_despacho']=="7"){ $ndp = "7mo"; }
                      if($dataa['numero_despacho']=="8"){ $ndp = "8vo"; }
                      if($dataa['numero_despacho']=="9"){ $ndp = "9no"; }
                    ?>
                    <?php 
                      if($dataa['numero_despacho']!="1"){
                        // echo $dataa['numero_despacho'];
                        echo $ndp;
                      }
                    ?> 
                    Pedido 
                    de Campaña <?php echo $numero_campana."/".$anio_campana; ?>
                  </option>
                <?php
                  }
                } 
                ?>
              </select>
              <br>
              <br>
              <table id="" class="datatablee table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Nombre Producto</th>
                  <th>Cantidad</th>
                  <th>Precio</th>
                  <!-- <th>---</th> -->
                </tr>
                </thead>
                <tbody id="table_colecciones">
             <?php 
              $num = 1;
              $totalPrecio = 0;
              $totalCantidad = 0;
              $totalPrecio1 = 0;
              $totalCantidad1 = 0;
              $totalPrecio2 = 0;
              $totalCantidad2 = 0;
              $totalPrecio3 = 0;
              $totalCantidad3 = 0;
              $totalPrecio4 = 0;
              $totalCantidad4 = 0;
              $totalPrecio5 = 0;
              $totalCantidad5 = 0;
              if(Count($colecciones)>1){
              foreach ($colecciones as $data):
                if(!empty($data['id_coleccion'])):  
                  if($data['numero_despacho']==1){
                    $totalPrecio1 += $data['precio_producto']*$data['cantidad_productos'];
                    $totalCantidad1 += $data['cantidad_productos'];
                  }
                  if($data['numero_despacho']==2){
                    $totalPrecio2 += $data['precio_producto']*$data['cantidad_productos'];
                    $totalCantidad2 += $data['cantidad_productos'];
                  }
                  if($data['numero_despacho']==3){
                    $totalPrecio3 += $data['precio_producto']*$data['cantidad_productos'];
                    $totalCantidad3 += $data['cantidad_productos'];
                  }
                  if($data['numero_despacho']==4){
                    $totalPrecio4 += $data['precio_producto']*$data['cantidad_productos'];
                    $totalCantidad4 += $data['cantidad_productos'];
                  }
                  if($data['numero_despacho']==5){
                    $totalPrecio5 += $data['precio_producto']*$data['cantidad_productos'];
                    $totalCantidad5 += $data['cantidad_productos'];
                  }
                  $totalPrecio += $data['precio_producto']*$data['cantidad_productos'];
                  $totalCantidad += $data['cantidad_productos'];
              ?>
                <tr>
                  <!-- <td style="width:5%">
                    <span class="contenido2">
                      <?php echo $num++; ?>
                    </span>
                  </td> -->
                  <td style="width:20%" class="<?php echo $data['numero_despacho'] ?>">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&route=Despachos">
                      </a> -->
                        <?php echo "Pedido ".$data['numero_despacho'] ?>
                    </span>
                  </td>
                  <td style="width:60%">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&route=Despachos">
                      </a> -->
                        <?php echo $data['producto']." <small>".$data['cantidad']."</small>"; ?>
                    </span>
                  </td>                  
                  <td style="width:20%">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&route=Despachos">
                      </a> -->
                        <?php echo $data['cantidad_productos'] ?>
                    </span>
                  </td>
                  <td style="width:20%">
                    <span class="contenido2">
                      <!-- <a href="?<?php echo $menu ?>&route=Despachos">
                      </a> -->
                        <?php echo "$".number_format($data['precio_producto'],2,',','.'); ?>
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
              <tr class="siempre">
                <td colspan='4'>Ningún dato disponible en esta tabla</td>
              </tr>

              <?php 
            }
              ?>
                </tbody>
<style>
.d-none{
  display:none;
}
.btnBoxEstado:hover{
  background:rgba(240,240,240,1) !important;
}
.btnBoxEstado:active{
  border:1px solid #DDD !important;
}
</style>
                <tfoot>
                <tr class="totales total1" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad1; ?></th>
                  <th><?php echo "$".number_format($totalPrecio1,2,',','.'); ?></th>
                  <!-- <th>---</th> -->
                </tr>
                <tr class="totales total2 d-none" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad2; ?></th>
                  <th><?php echo "$".number_format($totalPrecio2,2,',','.'); ?></th>
                  <!-- <th>---</th> -->
                </tr>
                <tr class="totales total3 d-none" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad3; ?></th>
                  <th><?php echo "$".number_format($totalPrecio3,2,',','.'); ?></th>
                  <!-- <th>---</th> -->
                </tr>
                <tr class="totales total4 d-none" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad4; ?></th>
                  <th><?php echo "$".number_format($totalPrecio4,2,',','.'); ?></th>
                  <!-- <th>---</th> -->
                </tr>
                <tr class="totales total5 d-none" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad5; ?></th>
                  <th><?php echo "$".number_format($totalPrecio4,2,',','.');; ?></th>
                  <!-- <th>---</th> -->
                </tr>
                <tr class="totales total d-none" style="background:#eee">
                  <!-- <th>Nº</th> -->
                  <th class="title_ocultar">Pedido</th>
                  <th>Total: </th>
                  <th><?php echo $totalCantidad ?></th>
                  <th><?php echo "$".number_format($totalPrecio,2,',','.');; ?></th>
                  <!-- <th>---</th> -->
                </tr>
                </tfoot>
              </table>

            </div>

            <!-- /.box-body -->
          </div>
          <!-- /.box -->
        </div>  
        <input type="hidden" id="id_camp" value="<?php echo $id_campana ?>">





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
        window.location = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=Homing";
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

  $(".btnBoxEstado").click(function(){
    var clase = $("#fasEstado").attr("class");
    if(clase=="fa fa-chevron-up"){
      $("#fasEstado").attr("class","fa fa-chevron-down");
      $(".box_Estados").slideUp();
    }
    if(clase=="fa fa-chevron-down"){
      $("#fasEstado").attr("class","fa fa-chevron-up");
      $(".box_Estados").slideDown();
    }
  });

  var filter = $(".filter").val();
  $("."+filter).hide(); 
  $(".title_ocultar").hide();
  $("#table_colecciones tr:not(:contains('Pedido "+filter+"'))").hide();
  $(".siempre").show();

  $(".totales").hide();
  $(".total1").show();
  $(".totales").removeClass('d-none');

  $(".filter").change(function(){
    $("#table_colecciones tr").show();
    var filter = $(".filter").val();
    $("."+filter).hide(); 
    $(".title_ocultar").hide();
    $("#table_colecciones tr:not(:contains('Pedido "+filter+"'))").hide();
    $(".totales").hide();
    $(".total"+filter).show();
  });

  $(".enviarVisibilidadCamp").click(function(){
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
              $.ajax({
                    url: '?route=Campanas',
                    type: 'POST',
                    data: {
                      validarVisibilidad: true,
                      visibilidad: $("#visibilidadCamp").val(),
                      id_camp: $("#id_camp").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          swal.fire({
                              type: 'success',
                              title: '¡Datos guardados correctamente!',
                              confirmButtonColor: "#ED2A77",
                          }).then(function(){
                            window.location = "";
                          });
                      }
                      if (respuesta == "9"){
                        swal.fire({
                            type: 'error',
                            title: '¡Los datos ingresados estan repetidos!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                            type: 'error',
                            title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
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

  $(".enviarEstadoCamp").click(function(){
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
              $.ajax({
                    url: '?route=Campanas',
                    type: 'POST',
                    data: {
                      validarEstadoCamp: true,
                      estadoCamp: $("#estadoCamp").val(),
                      id_camp: $("#id_camp").val(),
                    },
                    success: function(respuesta){
                      // alert(respuesta);
                      if (respuesta == "1"){
                          swal.fire({
                              type: 'success',
                              title: '¡Datos guardados correctamente!',
                              confirmButtonColor: "#ED2A77",
                          }).then(function(){
                            window.location = "";
                          });
                      }
                      if (respuesta == "9"){
                        swal.fire({
                            type: 'error',
                            title: '¡Los datos ingresados estan repetidos!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
                      if (respuesta == "5"){ 
                        swal.fire({
                            type: 'error',
                            title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                            confirmButtonColor: "#ED2A77",
                        });
                      }
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
                //   $.ajax({
                //     url: '?route=RegistrarCampanas',
                //     type: 'POST',
                //     data: {
                //       validarVisibilidad: true,
                //       visibilidad: $("#visibilidadCamp").val(),
                //     },
                //     success: function(respuesta){
                //       alert(respuesta);
                //       if (respuesta == "1"){
                //           // $(".btn-enviar").removeAttr("disabled");
                //           // $(".btn-enviar").click();
                //           // window.location = "?route=Home";
                //       }
                //       if (respuesta == "9"){
                //         // swal.fire({
                //         //     type: 'error',
                //         //     title: '¡Los datos ingresados estan repetidos!',
                //         //     confirmButtonColor: "#ED2A77",
                //         // });
                //         // $("#error_acceso").html("<b>Nombre de usuario o Contraseña invalidos<b>");
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "#ED2A77",
                //         });
                //       }
                //     }
                // });


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
