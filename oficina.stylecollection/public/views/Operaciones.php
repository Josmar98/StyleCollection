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
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <input type="datetime-local" class="form-control" id="fechaa" name="fechaa" <?php if(!empty($fechaa)){ echo 'value="'.$fechaa.'"'; } ?>>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <input type="datetime-local" class="form-control" id="fechac" name="fechac" <?php if(!empty($fechac)){ echo 'value="'.$fechac.'"'; } ?>>
                  </div>
                </div>
                <br>
                <div class="row">
                  <div class="col-xs-12 col-sm-6">
                    <select class="form-control select2" name="tipo_operacion" id="tipo_operacion" style="width:100%;">
                      <option value=""></option>
                      <option value="Entrada" <?php if(!empty($_GET['tipo_operacion']) && $_GET['tipo_operacion']=="Entrada"){ echo "selected"; } ?>>Entrada</option>
                      <option value="Salida" <?php if(!empty($_GET['tipo_operacion']) && $_GET['tipo_operacion']=="Salida"){ echo "selected"; } ?>>Salida</option>
                    </select>
                  </div>
                  <div class="col-xs-12 col-sm-6">
                    <select class="form-control select2" name="id_inventario" id="id_inventario" style="width:100%;">
                        <option value=""></option>
                        <?php 
                          foreach($productosOn as $key){
                            if(!empty($key['producto'])){
                              ?>
                                <option value="Productos-<?=$key['id_producto']; ?>" <?php if(!empty($_GET['id_inventario']) && $_GET['id_inventario']=="Productos-".$key['id_producto']){ echo "selected"; } ?> ><?="(#".$key['codigo_producto'].") ".$key['producto']; ?></option>
                              <?php
                            }
                          }
                        ?>
                        <?php 
                          foreach($memercanciaOncancia as $key){
                            if(!empty($key['mercancia'])){
                              ?>
                                <option value="Mercancia-<?=$key['id_mercancia']; ?>" <?php if(!empty($_GET['id_inventario']) && $_GET['id_inventario']=="Mercancia-".$key['id_mercancia']){ echo "selected"; } ?> ><?="(#".$key['codigo_mercancia'].") ".$key['mercancia']; ?></option>
                              <?php
                            }
                          }
                        ?>
                      </select>
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <br>
                    <span class="btn enviar2 enviarFechaas">Enviar</span>
                  </div>
                  <div class="col-xs-12" style="text-align:right;">
                    <br>
                    <a href="?route=<?=$_GET['route']; ?>" class="btn enviar2">Quitar Filtros</a>
                    <a href="?route=<?=$_GET['route']; ?>&filtros=0" class="btn enviar2">Mostrar Todos los Registros</a>
                  </div>
                </div>
              </form>
              <hr>
              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th style="width:5%;">Nº</th>
                <?php if(($amInventarioE==1 || $amInventarioB==1)){ ?>
                  <th style="width:5%;">---</th>
                <?php } ?>
                  <th style="width:10%;">Fecha</th>
                  <th style="width:30%;">Inventario</th>
                  <th style="width:15%;">Tipo de Inventario</th>
                  <th style="width:5%;">Entrada</th>
                  <th style="width:5%;">Salida</th>
                  <th style="width:25%;">Transacción</th>
                </tr>
                </thead>
                <tbody>
                <?php 
                  $num = 1;
                  foreach ($operaciones as $data){ if(!empty($data['id_operacion'])){ 
                    ?>
                    <tr>
                      <td>
                        <span class="contenido2">
                          <?php echo $num++; ?>
                        </span>
                      </td>
                      <?php if(($amInventarioE==1 || $amInventarioB==1) ){ ?>
                      <td>
                        <?php
                          // echo $data['id_almacen']."<br>";
                          $existenciaActual = 0;
                          if($data['tipo_inventario']=="Productos"){
                            $existenciaActual = $productoss[$data['id_inventario']]['stock_operacion_almacen'.$data['id_almacen']];
                          }
                          if($data['tipo_inventario']=="Mercancia"){
                            $existenciaActual = $mercancias[$data['id_inventario']]['stock_operacion_almacen'.$data['id_almacen']];
                          }
                          // echo "<br>".$existenciaActual."<br>";
                          $procederEliminar = true;
                          if($data['tipo_operacion']=="Entrada"){
                            $procederEliminar = false;
                            if($existenciaActual>=$data['stock_operacion']){
                              $procederEliminar = true;
                            }else{
                              $procederEliminar = false;
                            }
                          }
                        ?>
                              <button class="btn fichaDetalleBtn" style="border:0;background:none;color:#9904a7" value="<?=$data['id_operacion']; ?>">
                                <span class="fa fa-file-text"></span>
                              </button>
                          <?php if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Administrador" || $_SESSION['nombre_rol']=="Administrativo"){ ?>
                            <?php if($amInventarioE==1){ ?>
                              <!-- <button class="btn modificarBtn" style="border:0;background:none;color:#04a7c9" value="?route=<?=$url; ?>&action=Modificar&cod=<?=$data['id_operacion']; ?>">
                                <span class="fa fa-wrench">
                                  <?=$data['tipo_operacion']; ?>
                                </span>
                              </button> -->
                            <?php } ?>
                            <?php if($procederEliminar==true && $amInventarioB==1){ ?>
                              <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?route=<?=$url; ?>&delete=<?=$data['id_operacion']; ?>">
                                <span class="fa fa-trash"></span>
                              </button>
                            <?php } ?>
                          <?php } ?>
                      </td>
                      <?php } ?>
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
                            if($data['tipo_inventario']=="Productos"){
                              $elementos = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$data['id_inventario']}");
                            }
                            if($data['tipo_inventario']=="Mercancia"){
                              $elementos = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$data['id_inventario']}");
                            }
                            if($data['tipo_inventario']=="Catalogos"){
                              $elementos = $lider->consultarQuery("SELECT *, CONCAT(cantidad_gemas, ' gemas') as codigo, nombre_catalogo as elemento FROM catalogos WHERE id_catalogo={$data['id_inventario']}");
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
                        <span class="contenido2">
                          <?php
                            if($data['tipo_inventario']!="Catalogos"){
                              foreach($tipoInventarios as $key){
                                if($key['id']==$data['tipo_inventario']){
                                  echo $key['name'];
                                }
                              }
                            }
                            if($data['tipo_inventario']=="Catalogos"){
                              echo "Servicios";
                            }
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php 
                            if($data['tipo_operacion']=="Entrada"){
                              echo $data['stock_operacion'];    
                            }
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2" style="font-size:.9em;">
                          <?php 
                            if($data['tipo_operacion']=="Salida"){
                              echo $data['stock_operacion'];    
                            }
                          ?>
                        </span>
                      </td>
                      <td>
                        <span class="contenido2">
                          <span class="txtTransaccion<?=$data['id_operacion']; ?>" ><?=$data['transaccion']; ?></span><br>
                          <?php
                            if($data['leyenda']!="" && $data['transaccion']!=$data['leyenda']){
                              ?>
                              <small>(<span class="txtLeyenda<?=$data['id_operacion']; ?>" ><?=$data['leyenda']; ?></span>)</small>
                              <?php
                            }
                            if($_SESSION['nombre_rol']=="Superusuario" || $_SESSION['nombre_rol']=="Contable"){
                              ?>
                                <style>
                                  .bntActualizar:hover{ cursor:pointer;}
                                </style>
                                <p class="bntActualizar bntActualizar<?=$data['id_operacion']; ?>" id="<?=$data['id_operacion']; ?>" data-transaccion="<?=$data['transaccion']; ?>" data-concepto="<?=$data['concepto']; ?>" data-leyenda="<?=$data['leyenda']; ?>" style="color:<?=$fucsia;?>;">Actualizar</p>
                              <?php
                            }
                          ?>
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
                <?php if(($amInventarioE==1 || $amInventarioB==1)){ ?>
                  <th>---</th>
                <?php } ?>
                  <th>Fecha</th>
                  <th>Inventario</th>
                  <th>Tipo de Inventario</th>
                  <th>Entrada</th>
                  <th>Salida</th>
                  <th>Transacción</th>
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

  <div class="modalleyenda d-none" style="background:#00000077;position:fixed;top:0;z-index:3333;width:100%;height:100%;">
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <span class="btn cancelActLeyenda" style="background:#CCC;float:right;">X</span>
              <h3 class="box-title"><?php echo "Actualizar Transacción, Concepto y Leyenda"; ?></h3>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <input type="hidden" class="form-control id_operacion" id="id_operacion" name="id_operacion">
                <div class="row">
                  <div class="col-xs-12">
                    <label for="transaccion">Transacción</label>
                    <select class="form-control transaccion" id="transaccion" name="transaccion">
                      <option class="opt-transacciones opt-ajuste" value="Ajuste">Ajuste</option>
                      <option class="opt-transacciones opt-produccion" value="Produccion">Producción</option>
                      <option class="opt-transacciones opt-compra" value="Compra">Compra</option>
                      <option class="opt-transacciones opt-inicial" value="Inventario Inicial">Inventario Inicial</option>
                      <option class="opt-transacciones opt-traslados" value="Traslados">Traslados</option>
                      <option class="opt-transacciones opt-venta" value="Venta">Venta</option>
                      <option class="opt-transacciones opt-averia" value="Averia">Avería</option>
                      <option class="opt-transacciones opt-desincorporacion" value="Desincorporacion">Desincorporación</option>
                      <option class="opt-transacciones opt-reposicion" value="Reposicion">Reposición De Avería</option>
                      <option class="opt-transacciones opt-dev-venta" value="Devolucion En Venta">Devolución En Venta</option>
                      <option class="opt-transacciones opt-dev-compra" value="Devolucion En Compra">Devolución En Compra</option>
                    </select>
                    <!-- <input type="text" class="form-control transaccion" id="transaccion" name="transaccion"> -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <label for="concepto">Concepto</label>
                    <select class="form-control concepto" id="concepto" name="concepto">
                      <option class="opt-conceptos opt-concepto-ajuste" value="Ajuste De Inventario">Ajuste De Inventario</option>
                      <option class="opt-conceptos opt-concepto-produccion" value="Produccion Laboratorio">Producción Laboratorio</option>
                      <option class="opt-conceptos opt-concepto-compra" value="Compra De Mercancia">Compra De Mercancia</option>
                      <option class="opt-conceptos opt-concepto-inicial" value="Inventario Inicial">Inventario Inicial</option>
                      <option class="opt-conceptos opt-concepto-traslados" value="Traslados De Almacen">Traslados De Almacen</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-venta-cerrada" value="Venta A Lideres">Venta A Líderes</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-venta-abierta" value="Factura Abierta">Factura Abierta</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-credito-style" value="Credito Style">Crédito Style</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-venta-rifas" value="Rifas o Premios">Rifas o Premios</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-venta-obsequios" value="Obsequio a terceros">Obsequio a terceros</option>
                      <option class="opt-conceptos opt-concepto-ventas opt-concepto-venta-interno"  value="Consumo Interno">Consumo Interno</option>
                      <option class="opt-conceptos opt-concepto-averia" value="Averia">Avería</option>
                      <option class="opt-conceptos opt-concepto-desincorporacion" value="Desincorporacion">Desincorporación</option>
                      <option class="opt-conceptos opt-concepto-reposicion" value="Reposicion De Averia">Reposición De Avería</option>
                      <option class="opt-conceptos opt-concepto-dev-venta" value="Devolucion En Venta">Devolución En Venta</option>
                      <option class="opt-conceptos opt-concepto-dev-compra" value="Devolucion En Compra">Devolución En Compra</option>
                    </select>
                    <!-- <input type="text" class="form-control transaccion" id="transaccion" name="transaccion"> -->
                  </div>
                </div>
                <div class="row">
                  <div class="col-xs-12">
                    <label for="leyenda">Leyenda</label>
                    <input type="text" class="form-control leyenda" id="leyenda" name="leyenda">
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <div class="row">
                  <div class="col-xs-12">
                    <span class="btn enviar2 enviarActualizarLeyenda">Enviar</span>
                    <span class="btn cancelActLeyenda" style="background:#CCC;">Cancelar</span>
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
  <div class="modalDetalle d-none" style="background:#00000077;position:fixed;top:0;z-index:3333;width:100%;height:100%;">
    <section class="content">
      <div class="row">
        <div class="col-xs-12 col-sm-offset-1 col-sm-10 col-md-offset-2 col-md-8">
          <!-- /.box -->
          <div class="box">
            <div class="box-header">
              <span class="btn cancelDetalleModal" style="background:#CCC;float:right;">X</span>
            </div>
            <!-- /.box-header -->
              <div class="box-body">
                <div class="row">
                  <div class="col-xs-12">
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Tipo de operación:</span>
                        </div>
                        <div class="col-xs-2" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_tipo_operacion"></span>
                        </div>
                        <div class="col-xs-3" style="text-align:right;">
                          <span>Transacción:</span>
                        </div>
                        <div class="col-xs-3" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_fucsia txt_transaccion"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Concepto:</span>
                        </div>
                        <div class="col-xs-8" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_fucsia txt_concepto"></span>
                        </div>
                      </div>
                    </div>
                    <br><br>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Inventario:</span>
                        </div>
                        <div class="col-xs-8" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_fucsia txt_tipo_inventario"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Fecha:</span>
                        </div>
                        <div class="col-xs-8" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_fucsia txt_fecha_operacion"></span>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12" style="">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Elemento Inv.</span>
                        </div>
                        <div class="col-xs-8" style="text-align:lrft;border:1px solid #999999;">
                          (#<span class="txt_txt txt_codigo"></span>)
                          <span class="txt_txt txt_elemento"></span>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Nro. Doc.:</span>
                        </div>
                        <div class="col-xs-2" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          00-<span class="txt_txt txt_fucsia txt_numero_documento"></span>
                        </div>
                        <div class="col-xs-3" style="text-align:right;">
                          <span>Nro. Lote:</span>
                        </div>
                        <div class="col-xs-3" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_numero_lote"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>Nombre o Razón Social:</span>
                        </div>
                        <div class="col-xs-8" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_persona"></span>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-4" style="text-align:right;">
                          <span>R.I.F.:</span>
                        </div>
                        <div class="col-xs-8" style="text-align:left;border-bottom:1px solid #CCCCCC;">
                          <span class="txt_txt txt_rif_persona"></span>
                        </div>
                      </div>
                    </div>
                    <br>
                    <div class="row">
                      <div class="col-xs-12">
                        <div class="col-xs-3"></div>
                        <div class="col-xs-9">
                          <table class="table table-bordered" style="">
                            <tr style='text-align:center;'>
                              <td>Cant.</td>
                              <td>Costo Unt.</td>
                              <td>Total Costo</td>
                            </tr>
                            <tr style='text-align:center;'>
                              <td class="txt_txt txt_cant"></td>
                              <td class="txt_txt txt_costo_unitario"></td>
                              <td class="txt_txt txt_total_costo"></td>
                            </tr>
                          </table>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>

              <div class="box-footer">
                <div class="row">
                  <div class="col-xs-12">
                    <!-- <span class="btn enviar2 enviarActualizarLeyenda">Enviar</span> -->
                    <!-- <span class="btn cancelActLeyenda" style="background:#CCC;">Cancelar</span> -->
                  </div>
                </div>
              </div>
          </div>
        </div>
      </div>
    </section>
  </div>
        <!-- /.content-wrapper -->
  <?php require_once 'public/views/assets/footer.php'; ?>
  

  <?php require_once 'public/views/assets/aside-config.php'; ?>
</div>
<!-- ./wrapper -->
<style>
.txt_txt{
  /* font-weight:700; */
}
.txt_fucsia{
  color:<?=$fucsia; ?>;
}
</style>

  <?php require_once 'public/views/assets/footered.php'; ?>
<?php if(!empty($response)): ?>
<input type="hidden" class="responses" value="<?php echo $response ?>">
<?php endif; ?>
<style>
.alert-superior{
  z-index:9999;
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
        title: '¡Datos borrados correctamente!',
        confirmButtonColor: "#ED2A77",
      }).then(function(){
        window.location = "?route=Operaciones";
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
  $(".modalDetalle").hide();
  $(".modalDetalle").removeClass("d-none");
  $(".fichaDetalleBtn").click(function(){
    var id = $(this).val();
    $.ajax({
      url: '',
      type: 'POST',
      data: {
        id_operacion: id,
        fichaTecnicaDetalle: true,
      },
      success: function(respuesta){
        // alert(respuesta);
        var data = JSON.parse(respuesta);
        console.log(data);
        if (data.msj == "1"){
          var dato=data.data;
          $(".txt_tipo_operacion").html(dato.tipo_operacion);
          $(".txt_transaccion").html(dato.transaccion);
          $(".txt_concepto").html(dato.concepto);
          $(".txt_tipo_inventario").html(dato.tipo_inventario);
          $(".txt_fecha_operacion").html(dato.fecha_operacion+' ('+dato.fecha_documento+')');
          $(".txt_codigo").html(dato.codigo);
          $(".txt_elemento").html(dato.elemento);
          $(".txt_numero_documento").html(dato.numero_documento);
          $(".txt_numero_lote").html(dato.numero_lote);
          $(".txt_persona").html(dato.persona);
          $(".txt_rif_persona").html(dato.rif_persona);
          $(".txt_cant").html(dato.cant);
          $(".txt_total_costo").html(dato.total_costo);
          $(".txt_costo_unitario").html(dato.costo_unitario);
          $(".modalDetalle").fadeIn();
        }
        if (data.msj == "2"){
          swal.fire({
            type: 'error',
            title: '¡Busqueda sin resultados!',
            confirmButtonColor: "#ED2A77",
          });
        }
      }
    });
  });
  $(".cancelDetalleModal").click(function(){
    $(".modalDetalle").fadeOut();
  });

  $(".modalleyenda").hide();
  $(".modalleyenda").removeClass("d-none");
  $(".bntActualizar").click(function(){
    swal.fire({ 
      title: "¿Desea actualizar los datos?",
      text: "Se visualizara un modal para actualizar los datos, ¿desea continuar?",
      type: "question",
      showCancelButton: true,
      confirmButtonColor: "#ED2A77",
      confirmButtonText: "¡Si!",
      cancelButtonText: "No", 
      closeOnConfirm: false,
      closeOnCancel: false 
    }).then((isConfirm) => {
      if (isConfirm.value){        
        var id = $(this).attr("id");
        var transaccion = $(this).attr("data-transaccion");
        var concepto = $(this).attr("data-concepto");
        var leyenda = $(this).attr("data-leyenda");
        $(".modalleyenda .id_operacion").val(id);

        $(".modalleyenda .transaccion option").attr("selected", "selected");
        $(".modalleyenda .transaccion option").removeAttr("selected");
        $(".modalleyenda .transaccion .opt-transacciones").removeAttr("selected");

        $(".modalleyenda .concepto .opt-conceptos").removeAttr("disabled");
        $(".modalleyenda .concepto .opt-conceptos").removeAttr("selected");
        $(".modalleyenda .concepto .opt-conceptos").attr("disabled", "disabled");
        $(".modalleyenda .concepto .opt-conceptos").attr("style", "background:#CCC;");
        if(transaccion.toLowerCase()=='Ajuste'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-ajuste").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-ajuste").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-ajuste").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-ajuste").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Produccion'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-produccion").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-produccion").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-produccion").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-produccion").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Compra'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-compra").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-compra").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-compra").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-compra").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Inventario Inicial'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-inicial").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-inicial").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-inicial").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-inicial").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Venta'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-venta").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("style");
          // $(".modalleyenda .concepto .opt-concepto-ventas").attr("selected", "selected");
          // $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("selected");
          if(concepto.toLowerCase()=='Venta A Lideres'.toLowerCase() || leyenda.toLowerCase()=='Factura Cerrada'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-venta-cerrada").attr("selected", "selected");
          }
          if(concepto.toLowerCase()=='Factura Abierta'.toLowerCase() || leyenda.toLowerCase()=='Factura Abierta'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-venta-abierta").attr("selected", "selected");
          }
          if(concepto.toLowerCase()=='Credito Style'.toLowerCase() || leyenda.toLowerCase()=='Credito Style'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-credito-style").attr("selected", "selected");
          }
          if(concepto.toLowerCase()=='Rifas o Premios'.toLowerCase() || leyenda.toLowerCase()=='Rifas o Premios'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-venta-rifas").attr("selected", "selected");
          }
          if(concepto.toLowerCase()=='Obsequio a terceros'.toLowerCase() || leyenda.toLowerCase()=='Obsequio a terceros'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-venta-obsequios").attr("selected", "selected");
          }
          if(concepto.toLowerCase()=='Consumo Interno'.toLowerCase() || leyenda.toLowerCase()=='Consumo Interno'.toLowerCase()){
            $(".modalleyenda .concepto .opt-concepto-venta-interno").attr("selected", "selected");
          }
        }
        if(transaccion.toLowerCase()=='Traslados'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-traslados").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-traslados").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-traslados").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-traslados").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Averia'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-averia").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-averia").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-averia").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-averia").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Desincorporacion'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-desincorporacion").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-desincorporacion").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-desincorporacion").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-desincorporacion").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Reposicion'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-reposicion").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-reposicion").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-reposicion").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-reposicion").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Devolucion En Venta'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-dev-venta").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-dev-compra").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-dev-compra").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-dev-venta").attr("selected", "selected");
        }
        if(transaccion.toLowerCase()=='Devolucion En Compra'.toLowerCase()){
          $(".modalleyenda .transaccion .opt-dev-compra").attr("selected", "selected");
          $(".modalleyenda .concepto .opt-concepto-dev-venta").removeAttr("disabled");
          $(".modalleyenda .concepto .opt-concepto-dev-venta").removeAttr("style");
          $(".modalleyenda .concepto .opt-concepto-dev-compra").attr("selected", "selected");
        }
        // $(".modalleyenda .transaccion .opt-reposicion").val(transaccion);

        $(".modalleyenda .leyenda").val(leyenda);
        $(".modalleyenda").fadeIn();
      }else { 
        swal.fire({
          type: 'error',
          title: '¡Proceso cancelado!',
          confirmButtonColor: "#ED2A77",
        });
      } 
    });
  });
  $(".cancelActLeyenda").click(function(){
    $(".modalleyenda").fadeOut();
    $(".modalleyenda .id_operacion").val("");
    $(".modalleyenda .transaccion option").removeAttr("selected");
    $(".modalleyenda .concepto option").removeAttr("selected");
    $(".modalleyenda .leyenda").val("");
  });
  $(".enviarActualizarLeyenda").click(function(){
    var id = $(".modalleyenda .id_operacion").val();
    var transaccion = $(".modalleyenda .transaccion").val();
    var concepto = $(".modalleyenda .concepto").val();
    var leyenda = $(".modalleyenda .leyenda").val();
    $.ajax({
      url: '',
      type: 'POST',
      data: {
        id_operacion: id,
        transaccion: transaccion,
        concepto: concepto,
        leyenda: leyenda,
      },
      success: function(respuesta){
        // alert(respuesta); 
        $(".modalleyenda").fadeOut();
        if (respuesta == "1"){
          swal.fire({
            type: 'success',
            title: '¡Datos actualizados correctamente!',
            confirmButtonColor: "#ED2A77",
          }).then(function(){
            $(".txtTransaccion"+id).html(transaccion);
            $(".txtLeyenda"+id).html(leyenda);
            $(".bntActualizar"+id).attr('data-transaccion', transaccion);
            $(".bntActualizar"+id).attr('data-leyenda', leyenda);
            // $(".modalleyenda .id_operacion").val("");
            // $(".modalleyenda .transaccion").val("");
            // $(".modalleyenda .leyenda").val("");
          });
        }
        if (respuesta == "2"){
          swal.fire({
            type: 'error',
            title: '¡Los datos ingresados estan repetidos!',
            confirmButtonColor: "#ED2A77",
          });
        }
      }
    });
  });
  
  $('.transaccion').change(function(){
    var transaccion = $(this).val();
    // alert(transaccion);
    $(".modalleyenda .concepto .opt-conceptos").removeAttr("disabled");
    $(".modalleyenda .concepto .opt-conceptos").removeAttr("selected");
    $(".modalleyenda .concepto .opt-conceptos").attr("disabled", "disabled");
    $(".modalleyenda .concepto .opt-conceptos").attr("style", "background:#CCC;");
    if(transaccion.toLowerCase()=='Ajuste'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-ajuste").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-ajuste").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-ajuste").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Produccion'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-produccion").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-produccion").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-produccion").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Compra'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-compra").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-compra").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-compra").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Inventario Inicial'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-inicial").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-inicial").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-inicial").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Venta'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-ventas").attr("selected", "selected");
      $(".modalleyenda .concepto .opt-concepto-ventas").removeAttr("selected");
      
    }
    if(transaccion.toLowerCase()=='Traslados'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-traslados").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-traslados").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-traslados").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Averia'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-averia").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-averia").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-averia").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Desincorporacion'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-desincorporacion").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-desincorporacion").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-desincorporacion").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Reposicion'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-reposicion").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-reposicion").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-reposicion").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Devolucion En Compra'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-dev-compra").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-dev-compra").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-dev-compra").attr("selected", "selected");
    }
    if(transaccion.toLowerCase()=='Devolucion En Venta'.toLowerCase()){
      $(".modalleyenda .concepto .opt-concepto-dev-venta").removeAttr("disabled");
      $(".modalleyenda .concepto .opt-concepto-dev-venta").removeAttr("style");
      $(".modalleyenda .concepto .opt-concepto-dev-venta").attr("selected", "selected");
    }
  });


  $(".enviarFechaas").click(function(){
    // var fechaa = $("#fechaa").val();
    // var fechac = $("#fechac").val();
    // if(fechaa!="" && fechac!=""){
    // }
    $(".form_fechas_operaciones").submit();
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
