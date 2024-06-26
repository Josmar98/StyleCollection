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
        <?php echo $url; ?>
        <small><?php echo "Ver ".$url; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $url; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $url; ?></li>
      </ol>
    </section>
            
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$url.""; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="" method="GET" class="form submitFormFiltrar">
                  <input type="hidden" name="route" id="route" value="<?=$_GET['route']; ?>">
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Campañas - Despachos</label>
                      <select class="form-control select2" style="width:100%;" name="camp" id="camp">
                        <option value=""></option>
                        <?php 
                          if(count($pedidos)>1){
                            foreach ($pedidos as $key){ if(!empty($key['id_campana'])){ ?>
                              <option value="<?=$key['id_despacho']?>"  <?php if(!empty($_GET['camp']) && $_GET['camp']==$key['id_despacho']){ echo "selected"; } ?>>
                                <?php
                                  $ndp = "";
                                  if($key['numero_despacho']=="1"){ $ndp = "1er"; }
                                  if($key['numero_despacho']=="2"){ $ndp = "2do"; }
                                  if($key['numero_despacho']=="3"){ $ndp = "3er"; }
                                  if($key['numero_despacho']=="4"){ $ndp = "4to"; }
                                  if($key['numero_despacho']=="5"){ $ndp = "5to"; }
                                  if($key['numero_despacho']=="6"){ $ndp = "6to"; }
                                  if($key['numero_despacho']=="7"){ $ndp = "7mo"; }
                                  if($key['numero_despacho']=="8"){ $ndp = "8vo"; }
                                  if($key['numero_despacho']=="9"){ $ndp = "9no"; }
                                  if($key['numero_despacho']!="1"){ echo $ndp; }
                                  echo " Pedido ";
                                  echo " de Campaña ".$key['numero_campana']."/".$key['anio_campana']."-".$key['nombre_campana'];
                                ?>
                              </option>
                              <?php 
                            } }
                          }
                        ?>
                      </select>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-xs-12 col-sm-6">
                      <label>Fecha de Inicio</label>
                      <input type="date" class="form-control" name="rangoI" id="rangoI" <?php if(!empty($_GET['rI'])){ echo "value='".$_GET['rI']."'"; } ?>>
                    </div>
                    <div class="col-xs-12 col-sm-6">
                      <label>Fecha de Cierre</label>
                      <input type="date" class="form-control" name="rangoC" id="rangoC" <?php if(!empty($_GET['rC'])){ echo "value='".$_GET['rC']."'"; } ?>>
                    </div>
                  </div>
                  <br>
                  <div class="row">
                    <div class="col-xs-12">
                      <label>Mostrar premios canjeados</label>
                      <select class="form-control select2" style="width:100%;" id="opcion" name="opcion">
                        <option value="">Todos</option>
                        <option value="1" <?php if(!empty($_GET['opcion']) && $_GET['opcion']=="1"){ echo "selected"; } ?>>Pendientes por Asignar a Nota de entrega</option>
                        <option value="2" <?php if(!empty($_GET['opcion']) && $_GET['opcion']=="2"){ echo "selected"; } ?>>Asignados a Nota de entrega</option>
                      </select>
                    </div>
                  </div>

              </form>
                  <br>
                  <div class="row">
                    <div class="col-xs-12">
                      <button class="btn enviar2 FiltrarBusqueda">Filtrar</button>
                    </div>
                  </div>

              <hr>

              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <!-- <th>---</th> -->
                  <th>Líder</th>
                  <th>Premios Canjeados</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                $num = 1;
                $premiosTotales = [];
                foreach ($lideres as $data){ if(!empty($data['id_cliente'])){
                  ?>
                  <tr>
                    <td style="width:5%">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                    </td>
                    <td style="width:35%">
                      <span class="contenido2">
                        <?php echo number_format($data['cedula'], 0, '.','.')." ".$data['primer_nombre']." ".$data['primer_apellido']; ?>
                        <br>
                        <a href="?route=<?=$_GET['route']?>&action=Asignar&id=<?=$data['id_cliente'];?>"><u>Asignar a nota de entrega</u></a>
                      </span>
                    </td>
                    <td style="width:60%;text-align:left;">
                          <table class="table" style="background:none;">
                      <?php 

                        foreach ($premiosCanjeados as $data2) { if(!empty($data2['id_canjeo'])){
                          if($data['id_cliente'] == $data2['id_cliente']){
                            if(!empty($premiosTotales[$data2['id_catalogo']])){
                              $premiosTotales[$data2['id_catalogo']]['gemas'] += $data2['cantidad_gemas'];
                              $premiosTotales[$data2['id_catalogo']]['cantidad'] += 1;

                            }else{
                              $premiosTotales[$data2['id_catalogo']] = ['name'=>$data2['nombre_catalogo'], 'gemas'=>$data2['cantidad_gemas'], 'precio'=>$data2['cantidad_gemas'], 'cantidad'=>1];                                    
                            }
                        ?>
                        <?php if ($data2['estado_canjeo']=="Asignado"){ ?>
                            <tr>
                              <td>
                                <span class="contenido2" style='color:#000'>
                                  <?php echo "<img style='width:20px;margin-right:1px;' src='{$fotoGema}'> ".$data2['cantidad_gemas']." <span style='margin-right:5px;margin-left:5px;'>-</span> ".$data2['nombre_catalogo']." -> ";
                                  $premiosTotales;
                                  foreach ($campanas as $camp) {
                                    if(!empty($camp['id_campana'])){
                                      if(($data2['id_campana'] == $camp['id_campana']) && $data2['id_despacho'] == $camp['id_despacho']){
                                            $ndp = "";
                                            if($camp['numero_despacho']=="1"){ $ndp = "1er"; }
                                            if($camp['numero_despacho']=="2"){ $ndp = "2do"; }
                                            if($camp['numero_despacho']=="3"){ $ndp = "3er"; }
                                            if($camp['numero_despacho']=="4"){ $ndp = "4to"; }
                                            if($camp['numero_despacho']=="5"){ $ndp = "5to"; }
                                            if($camp['numero_despacho']=="6"){ $ndp = "6to"; }
                                            if($camp['numero_despacho']=="7"){ $ndp = "7mo"; }
                                            if($camp['numero_despacho']=="8"){ $ndp = "8vo"; }
                                            if($camp['numero_despacho']=="9"){ $ndp = "9no"; }
                                            echo "(";
                                            if($camp['numero_despacho']>"1"){
                                              echo $ndp." ";
                                            }
                                        echo "Pedido - Camp ".$camp['numero_campana']."/".$camp['anio_campana'].") <br><small> (".$lider->formatFecha($data2['fecha_canjeo'])."-".$data2['hora_canjeo'].")</small>";
                                        // echo "(Ped ".$camp['numero_despacho']." Camp ".$camp['numero_campana']."/".$camp['anio_campana'].")";
                                      }
                                    }
                                  }
                                  // echo "<br>"; 
                                  ?>
                                </span>
                              </td>
                              <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor2" || $_SESSION['nombre_rol']=="Analista2"): ?>
                              <td>
                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data2['id_canjeo'] ?>&permission=1">
                                  <span class="fa fa-trash"></span>
                                </button>
                              </td>
                              <?php endif ?>
                            </tr>
                        <?php } else { ?>
                          <tr>
                            <td>
                              <span class="contenido2">
                                <?php echo "<img style='width:20px;margin-right:1px;' src='{$fotoGema}'> ".$data2['cantidad_gemas']." <span style='margin-right:5px;margin-left:5px;'>-</span> ".$data2['nombre_catalogo']."<br><small> (".$lider->formatFecha($data2['fecha_canjeo'])."-".$data2['hora_canjeo'].")</small><br>"; ?>
                              </span>
                            </td>
                            <?php if ($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Analista Supervisor2" || $_SESSION['nombre_rol']=="Analista2"): ?>
                            <td>
                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?php echo $url; ?>&id=<?php echo $data2['id_canjeo'] ?>&permission=1">
                                <span class="fa fa-trash"></span>
                              </button>
                            </td>
                            <?php endif ?>
                          </tr>
                        <?php } ?>
                        <?php 
                          }
                        } }
                      ?>
                          </table>
                    </td>
                        
                  </tr>
                  <?php
                } }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <!-- <th>---</th> -->
                  <th>Líder</th>
                  <th>Premios Canjeados</th>
                </tr>
                </tfoot>
              </table>
              <table class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <?php foreach ($premiosTotales as $key) { ?>
                <tr>
                  <td style="width:5%">-</td>
                  <td style="width:35%">-</td>
                  <td style="width:60%;text-align:left;">
                    <?php 
                      $cantidadPremios = $key['gemas']/$key['precio'];
                      echo "(<b style='font-size:1.1em;'>".$cantidadPremios."</b>) <b>".$key['name']."</b> <small>por <img style='width:20px;margin-right:1px;' src='{$fotoGema}'> ".$key['precio']." gemas c/u</small>";
                    ?>
                  </td>
                </tr>
                <?php } ?>
              </table>

              <div>

              </div>
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
          title: '¡Premio borrado correctamente!',
                  confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Canjeados";
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

  $(".FiltrarBusqueda").click(function(){
    var newRuta = "";
    newRuta += "route="+$("#route").val();
    var camp = $("#camp").val();
    if(camp!=""){
      newRuta += "&camp="+camp;
    }
    var fechaI = $("#rangoI").val();
    var fechaC = $("#rangoC").val();
    if(fechaI!="" && fechaC!=""){
      newRuta += "&rI="+fechaI+"&rC="+fechaC;
    }
    var opcion = $("#opcion").val();
    if(opcion!=""){
      newRuta += "&opcion="+opcion;
    }
    // alert(newRuta);
    window.location="?"+newRuta;
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
