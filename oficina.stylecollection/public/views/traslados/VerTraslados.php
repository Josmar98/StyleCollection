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
        <?php echo $modulo; ?>
        <small><?php echo "Ver ".$modulo; ?></small>
      </h1>
      <ol class="breadcrumb">
        <li><a href="?route=Home"><i class="fa fa-dashboard"></i> Inicio </a></li>
        <li><a href="?route=<?php echo $url ?>"><?php echo $modulo; ?></a></li>
        <li class="active"><?php if(!empty($action)){echo $action;} echo " ". $modulo; ?></li>
      </ol>
    </section>
    <!-- Main content -->
    <section class="content">
      <div class="row">
        <div class="col-xs-12">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "".$modulo." "; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">
              <form action="" class="form_fechas_operaciones">
                <input type="hidden" name="route" value="<?=$_GET['route']; ?>">
                <input type="hidden" name="action" value="<?=$_GET['action']; ?>">
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <input type="date" class="form-control" id="fechaa" name="fechaa" <?php if(!empty($_GET['fechaa'])){ echo 'value="'.$_GET['fechaa'].'"'; } ?>>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <input type="date" class="form-control" id="fechac" name="fechac" <?php if(!empty($_GET['fechac'])){ echo 'value="'.$_GET['fechac'].'"'; } ?>>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <br>
                    <span class="btn enviar2 enviarFechaas">Enviar</span>
                  </div>
                </div>
              </form>
              <hr>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th style="width:5%;">Nº</th>
                <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                  <th style="width:10%;">---</th>
                <?php } ?>
                  <th style="width:10%;">Codigo</th>
                  <th style="width:10%;">Fecha</th>
                  <th style="width:10%;">Tipo de Inventario</th>
                  <th style="width:15%;">Inventario</th>
                  <th style="width:10%;">Stock</th>
                  <th style="width:15%;">Almacenes</th>
                  <th style="width:10%;">---</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($traslados as $data){ if(!empty($data['numero_documento'])){ 
                    ?>
                    <tr>
                      <td>
                        <span class="contenido2">
                          <?php echo $num++; ?>
                        </span>
                      </td>
                      <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                        <td>
                              <?php $procederEliminar=false; ?>
                              <?php if($amInventarioE==1){ ?>
                                <button class="btn actualizarPreciosBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?=$url; ?>&action=<?=$_GET['action']; ?>&actualizar=1&numero=<?=$data['numero_documento']; ?>">
                                  <span class="fa fa-wrench"></span>
                                </button>
                              <?php } ?>
                              <?php if($procederEliminar==true && $amInventarioB==1){ ?>
                                <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?=$url; ?>&delete=<?=$data['numero_documento']; ?>">
                                  <span class="fa fa-trash"></span>
                                </button>
                              <?php } ?>
                        </td>
                      <?php } ?>
                      <td>
                        <span class="contenido2">
                          <?php
                            $lim = 7;
                            $alterNumeroNew = substr($data['numero_documento'],0,3);
                            $numeroNew = substr($data['numero_documento'],3);
                            $falta = $lim-strlen($numeroNew);
                            $num_doc="";
                            for ($i=0; $i < $falta; $i++) {
                              $num_doc.="0";
                            }
                            $num_doc .= $numeroNew;
                            echo "<b>".$alterNumeroNew.$num_doc."</b>";
                          ?>
                          </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            $timestamp = strtotime($data['fecha_operacion']); 
                            $fechaBonita = date("d/m/Y h:i A", $timestamp); 
                            echo $fechaBonita;
                          ?>
                          </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            foreach($tipoInventarios as $key){
                              if($key['id']==$data['tipo_inventario']){
                                echo $key['name'];
                              }
                            }
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <?php
                            if($data['tipo_inventario']=="Productos"){
                              $elementos = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE estatus=1 and id_producto={$data['id_inventario']}");
                            }
                            if($data['tipo_inventario']=="Mercancia"){
                              $elementos = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE estatus=1 and id_mercancia={$data['id_inventario']}");
                            }
                            foreach($elementos as $keys){ if(!empty($keys[0])){
                              echo $keys['elemento'];
                              echo "<br>";
                              echo "(<small><b>#".$keys['codigo']."</b></small>)";
                            } }
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php echo "(".$data['stock_operacion'].") Unidades"; ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                            <?php 
                                echo " Desde ".$data['nombre_almacen_salida']."<br>Hasta ".$data['nombre_almacen_entrada'];    
                            ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php
                            $rutaPdfTraslados = "route=".$_GET['route']."&action=GenerarOrden&cod=".$data['numero_documento'];
                            $rutaPdfTrasladosPr = "route=".$_GET['route']."&action=GenerarOrdenPr&cod=".$data['numero_documento'];
                            ?>
                            <a href="?<?=$rutaPdfTraslados; ?>" target="_blank" class="btn enviar2"><span>Generar PDF</span></a>
                            <a style='margin-top:10px;' href="?<?=$rutaPdfTrasladosPr; ?>" target="_blank" class="btn enviar2"><span>Generar PDF Precio</span></a>
                          </span>
                      </td>
                    </tr>
                    <?php
                  } }
                ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                <?php if($amInventarioE==1 || $amInventarioB==1){ ?>
                  <th>---</th>
                <?php } ?>
                  <th>Codigo</th>
                  <th>Fecha</th>
                  <th>Tipo de Inventario</th>
                  <th>Inventario</th>
                  <th>Stock</th>
                  <th>Almacenes</th>
                  <th>---</th>
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
  <?php
  if(!empty($_GET['actualizar']) && !empty($_GET['numero']) && empty($_POST)){
    $query = "SELECT * FROM operaciones WHERE numero_documento = '{$_GET['numero']}' and tipo_operacion='Entrada'";
    $operacionesTraslados = $lider->consultarQuery($query);
    $routeAdd="";
    if(!empty($_GET['fechaa']) && !empty($_GET['fechac'])){
      $routeAdd .= "&fechaa=".$_GET['fechaa']."&fechac=".$_GET['fechac'];
    }
    ?>
    <div class="" style="background:#00000077;position:fixed;top:0;z-index:3333;width:100%;height:100%;">
      <section class="content">
        <div class="row">
          <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
            <!-- /.box -->
            <div class="box">
              <div class="box-header">
                <span class="btn cancelActPrecios"  data-num="?route=<?=$_GET['route']; ?>&action=<?=$_GET['action'].$routeAdd; ?>" style="background:#CCC;float:right;">X</span>
                <h3 class="box-title"><?php echo "Actualizar Precio de Traslado ".$data['numero_documento']; ?></h3>
              </div>
              <!-- /.box-header -->
              <form action="" method="post" class="form-precio-traslasdos">
                <div class="box-body">
                  <div class="row">
                    <div class="col-xs-12">
                      <div></div>
                      <table class="table table-bordered" style="width:100%;">
                        <tr>
                          <td style="width:15%;text-align:center;">Stock</td>
                          <td style="width:55%;text-align:left;">Inventario</td>
                          <td style="width:20%;text-align:left;">Precio</td>
                        </tr>
                        <?php
                        foreach ($operacionesTraslados as $opTras) {
                          if(!empty($opTras['numero_documento'])){
                            ?>
                              <tr>
                                <td style="text-align:center;">
                                    <?=$opTras['stock_operacion']; ?>
                                </td>
                                <td>
                                  <?php
                                    if($opTras['tipo_inventario']=="Productos"){
                                      $inventario = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$opTras['id_inventario']} LIMIT 1");
                                    }
                                    if($opTras['tipo_inventario']=="Mercancia"){
                                      $inventario = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$opTras['id_inventario']} LIMIT 1");
                                    }
                                    if(count($inventario)>1){
                                      $inv=$inventario[0];
                                      echo "(#".$inv['codigo'].") ".$inv['elemento'];
                                    }
                                    ?>
                                </td>
                                <td>
                                  <input type="number" step="0.01" class="form-control precios[]" id="precios[]" name="precios[]" value="<?=$opTras['precio_nota']; ?>">
                                  <input type="hidden" name="id_operacion[]" value="<?=$opTras['id_operacion']; ?>">
                                </td>
                              </tr>
                            <?php
                          }
                        }
                        ?>
                      </table>
                    </div>
                  </div>
                </div>
  
                <div class="box-footer">
                  <div class="row">
                    <div class="col-xs-12">
                      <span class="btn enviar2 enviarActualizarPreciosTraslados">Enviar</span>
                      <span class="btn cancelActPrecios" data-num="?route=<?=$_GET['route']; ?>&action=<?=$_GET['action'].$routeAdd; ?>" style="background:#CCC;">Cancelar</span>
                    </div>
                  </div>
                </div>
              </form>
            </div>
          </div>
        </div>
      </section>
    </div>
    <?php
  }
  ?>
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
        window.location = "?route=Traslados&action=Ver";
      });
    }
    if(response == "11"){
      swal.fire({
        type: 'success',
        title: '¡Precios actualizados correctamente!',
        confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Traslados&action=Ver";
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

  // $(".modalesPrecios").hide();
  // $(".modalesPrecios").removeClass("d-none");
  $(".actualizarPreciosBtn").click(function(){
    swal.fire({ 
      title: "¿Desea modificar los precios?",
      text: "Se mostrará una lista para colocar los precios, ¿desea continuar?",
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

  $(".cancelActPrecios").click(function(){
    window.location = $(this).attr("data-num");
  });
  $(".enviarActualizarPreciosTraslados").click(function(){
    $(".form-precio-traslasdos").submit();
  });

  $(".enviarFechaas").click(function(){
    var fechaa = $("#fechaa").val();
    var fechac = $("#fechac").val();
    if(fechaa!="" && fechac!=""){
      $(".form_fechas_operaciones").submit();
    }
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
