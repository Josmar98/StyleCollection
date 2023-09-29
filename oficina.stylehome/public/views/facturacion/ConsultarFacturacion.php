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
				<small><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></small>
			</h1>
			<ol class="breadcrumb">
				<li><a href="?<?php echo $menu ?>&route=CHome"><i class="fa fa-dashboard"></i> Ciclo <?php echo $num_ciclo."/".$ano_ciclo; ?> </a></li>
				<li><a href="?<?php echo $menu ?>&route=<?php echo $url ?>"><?php echo " ".$modulo; ?></a></li>
				<li class="active"><?php if(!empty($action)){echo $action;} echo " ".$modulo; ?></li>
			</ol>
		</section>
		<br>

		<div style="width:100%;text-align:center;"><a href="?<?php echo $menu; ?>&route=<?php echo $url ?>" class="color_btn_sweetalert" style="text-decoration-line:underline;">Ver <?=$modulo ?></a></div>

		<!-- Main content -->
		<section class="content">
			<div class="row">
				<?php $estado_ciclo = $ciclo['estado_ciclo']; ?>
				<?php require_once 'public/views/assets/bloque_precio_dolar.php'; ?>
				<?php require_once 'public/views/assets/bloque_estado_ciclo.php'; ?>
			</div>
			<div class="row">
				<!-- left column -->
				<div class="col-xs-12" >
					<!-- general form elements -->
					<div class="box">
            <div class="box-header">
              <h3 class="box-title"><?php echo "Facturas de Despacho"; ?></h3>
            </div>
            <!-- /.box-header -->

            <div class="box-body">

              <table id="datatable" class="table table-bordered table-striped" style="text-align:center;width:100%;">
                <thead>
                <tr>
                  <th>Nº</th>
                  <?php if($accesoFacturacionE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Nombre y Apellido</th>
                  <th>Fecha de Facturacion</th>
                  <th>Costo de Factura</th>
                  <th>---</th>
                </tr>
                </thead>
                <tbody>
            <?php 
              $num = 1;
              foreach ($facturas as $data){ if(!empty($data['id_factura'])){ 
                $continuar = false;
                if(!empty($accesosEstructuras) && count($accesosEstructuras)>1){
                  foreach ($accesosEstructuras as $struct) {
                    if(!empty($struct['id_cliente'])){
                      if($struct['id_cliente']==$data['id_cliente']){
                        $continuar = true;
                      }
                    }
                  }
                } else if($personalInterno){
                	$continuar = 1;
                }
                if($continuar == true){
                    ?>
                  <tr>
                    <td style="width:5%">
                      <span class="contenido2">
                        <?php echo $num++; ?>
                      </span>
                    </td>
                    <?php if($accesoFacturacionE){ ?>
                      <td style="width:20%">
                        <button class="btn eliminarBtn" style="border:0;background:none;color:red" value="?<?=$menu; ?>&route=<?=$url; ?>&id=<?=$data['id_factura']; ?>&permission=1">
                          <span class="fa fa-trash"></span>
                        </button>
                      </td>
                    <?php } ?>
                    <td style="width:20%">
                      <span class="contenido2">
                        <?php echo  $data['primer_nombre']. " " . $data['primer_apellido']; ?>
                        <br>
                        <?php 
                          switch (strlen($data['numero_factura'])) {
                            case 1: $numero_factura = "000000".$data['numero_factura'];
                              break;
                            case 2: $numero_factura = "00000".$data['numero_factura'];
                              break;
                            case 3: $numero_factura = "0000".$data['numero_factura'];
                              break;
                            case 4: $numero_factura = "000".$data['numero_factura'];
                              break;
                            case 5: $numero_factura = "00".$data['numero_factura'];
                              break;
                            case 6: $numero_factura = "0".$data['numero_factura'];
                              break;
                            case 7: $numero_factura = "".$data['numero_factura'];
                              break;
                            default: $numero_factura = "".$data['numero_factura'];
                              break; 
                          }
                          echo $numero_factura;
                        ?>
                      </span>
                    </td>
                    <td style="width:20%">
                      <span class="contenido2">
                        <?php echo "E: ".$lider->formatFecha($data['fecha_emision']) . " <br>V: " . $lider->formatFecha($data['fecha_vencimiento']); ?>
                      </span>
                    </td>
                    <td style="width:20%">
                      <span class="contenido2">
                        <?php echo "$".number_format($data['cantidad_aprobada'],2,',','.'); ?>
                      </span>
                    </td>
    
   
                    <td style="width:20%">
                      <table style="background:;text-align:center;width:100%">
                        <tr>
                          <td style="width:50%">
                              <?php 
                                $emision = $data['fecha_emision'];
                                $statusd="target='_blank' href='?{$menu}&route={$url}&action=Generarusd&id={$data['id_factura']}'";
                                if(Count($tasas)>1){
                                	$colorbs=$color_btn_sweetalert;
                                	$statbs="target='_blank' href='?{$menu}&route={$url}&action=Generarbs&id={$data['id_factura']}'";
                                }else{
                                	$colorbs="#aaa";
                                	$statbs="disabled";
                                }
                                $fiscal = $lider->consultarQuery("SELECT * FROM precio_fiscal WHERE id_ciclo = {$id_ciclo} and estatus = 1");
                                if(count($fiscal)>1){
                                	$statFiscal="target='_blank' href='?{$menu}&route={$url}&action=GenerarFiscal&id={$data['id_factura']}'";
                                	$colorFiscal=$color_btn_sweetalert;
                                }else{
                                	$statFiscal="disabled";
                                	$colorFiscal="#aaa";
                                }
                              ?>
                              <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?=$colorbs; ?>;color:#FFF" <?=$statbs; ?>>Generar Factura en Bs.D.</a>

                              <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?=$color_btn_sweetalert; ?>;color:#FFF" <?=$statusd; ?>>Generar Factura en USD.</a>

                              <a class="btn" style="border:1px solid #fff;border-radius:5px;background:<?=$colorFiscal; ?>;color:#FFF" <?=$statFiscal; ?>>Generar Factura Fiscal.</a>
                            
                          </td>
                        </tr>
                      </table>
                    </td>
                        
                        
                  </tr>
                    <?php
                  }
              } }
            ?>
                </tbody>
                <tfoot>
                <tr>
                  <th>Nº</th>
                  <?php if($accesoFacturacionE){ ?>
                  <th>---</th>
                  <?php } ?>
                  <th>Nombre y Apellido</th>
                  <th>Fecha de Facturacion</th>
                  <th>Costo de Factura</th>
                  <th>---</th>
                </tr>
                </tfoot>
              </table>

                <input type="hidden" class="d-none color-button-sweetalert" value="<?php echo $color_btn_sweetalert ?>">

              <!-- <br> -->

                            <!-- <input type="color" name=""> -->
            <?php 
              // $color[0] = "rgb(14, 216, 27)";
              // $color[1] = "rgb(216, 14, 152)";
              // $color[2] = "rgb(105, 14, 216)";
              // $color[3] = "rgb(194, 169, 46)";
              // $color[4] = "rgb(185, 182, 167)";
              // $color[5] = "rgb(140, 218, 238)";
              // $num = 0;
              // foreach ($liderazgos as $data):
              //   if(!empty($data['id_liderazgo'])):
            ?>
                <!-- <div style="border:1px solid #000;background: <?php echo $color[$num] ?>; width: <?php echo ($data['total_descuento'] * 30)."px" ?>; padding:10px;margin-left:5%;"> -->
                  <?php 
                    // echo "Líder <b>".$data['nombre_liderazgo']."</b>"; 
                    // echo "<br>";
                    // if($data['maxima_cantidad'] == ""){
                    //   echo "<b>".$data['minima_cantidad']." o más</b>";
                    // }else{
                    //   echo "<b>".$data['minima_cantidad']." - ".$data['maxima_cantidad']."</b>";
                    // }
                    // echo "<br>";
                    // echo "Colecciones";
                  ?>    
                <!-- </div> -->
                <?php //$num++; ?>
           <?php //endif; endforeach;?>

              <!-- <br><br> -->




            </div>
            <!-- /.box-body -->
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
<?php endif; ?>
<!-- <input type="hidden" class="c" value="<?php echo $id_ciclo ?>"> -->
<!-- <input type="hidden" class="n" value="<?php echo $num_ciclo ?>"> -->
<!-- <input type="hidden" class="y" value="<?php echo $ano_ciclo ?>"> -->
<input type="hidden" class="cant" value="<?php echo $cant; ?>">
<input type="hidden" class="max_total_descuento" value="<?php echo number_format($max, 2) ?>">
<!-- <input type="hidde" class="max_minima_cantidad" value="<?php echo $register['minima_cantidad']; ?>"> -->
<!-- <input type="hidde" class="max_maxima_cantidad" value="<?php echo $register['maxima_cantidad']; ?>"> -->
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
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>";
        window.location.href=menu;
      });
    }
    if(response == "2"){
      swal.fire({
          type: 'error',
          title: '¡Error al realizar la operacion!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      });
    }
    if(response == "9"){
      swal.fire({
          type: 'warning',
          title: '¡Factura Repetida!',
          confirmButtonText: "¡Guardar!",
          confirmButtonColor: "<?=$colorPrimaryAll; ?>"
      }).then(function(){
        var campaing = $(".campaing").val();
        var n = $(".n").val();
        var y = $(".y").val();
        var dpid = $(".dpid").val();
        var dp = $(".dp").val();
        var menu = "?<?=$menu; ?>&route=<?=$url; ?>";
        window.location.href=menu;
      });
    }
    
  }

  $(".eliminarBtn").click(function(){
      swal.fire({ 
          title: "¿Desea borrar los datos?",
          text: "Se borraran los datos escogidos, ¿desea continuar?",
          type: "error",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
                    confirmButtonColor: "<?=$colorPrimaryAll; ?>",
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
