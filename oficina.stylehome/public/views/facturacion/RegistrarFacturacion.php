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
						<div class="box-header with-border">
							<h3 class="box-title">Agregar Nuevos <?php echo $modulo; ?></h3>
						</div>
						<!-- /.box-header -->

						<!-- form start -->
						<form action="" method="post" role="form" class="form_register">
							<div class="box-body">
								<div class="row">
									<div class="form-group col-sm-6">
										<label for="">Numero de Factura</label>
										<input type="number" class="form-control" name="num_factura" value="<?php echo $numero_factura; ?>">
										<span id="error_fecha1" class="errors"></span>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label for="pedido">Líder y Pedido</label>
										<select class="form-control select2" id="pedido" name="pedido">
											<option value=""></option>
											<?php
												foreach ($pedidosFull as $data) { if(!empty($data['id_pedido'])){
													$permitido = 0;
													if(!empty($accesosEstructuras)){
														foreach ($accesosEstructuras as $struct) {
															if(!empty($struct['id_cliente'])){
																if($struct['id_cliente']==$data['id_cliente']){
																	$permitido = 1;
																}
															}
														}
													}
													if(
														$_SESSION['home']['nombre_rol'] == "Superusuario" || 
														$_SESSION['home']['nombre_rol'] == "Administrador" || 
														$_SESSION['home']['nombre_rol'] == "Administrativo" || 
														$_SESSION['home']['nombre_rol']=="Analista Supervisor" || 
														$_SESSION['home']['nombre_rol'] == "Analista2"
													){
														$permitido = 1;
													}
													if($permitido==1){
														?>
														<option value="<?=$data['id_pedido']; ?>" 
															<?php foreach ($facturas as $key){ if (!empty($key['id_pedido'])){ if ($data['id_pedido'] == $key['id_pedido']){ echo "disabled"; } } } ?> 
															><!-- Aqui cierra el Option de apertura  -->
															<?=$data['cedula']." ".$data['primer_nombre']." ".$data['primer_apellido']. " Pedido: $".number_format($data['cantidad_aprobada'],2,',','.'); ?>
														</option>
														<?php
													}
												} }
											?>
										</select>
										<span id="error_pedido" class="errors"></span>
									</div>
									<div class="form-group col-sm-6">
										<label for="forma">Forma de pago</label>
										<select class="form-control select2" id="forma" name="forma">
											<option>Crédito</option>
											<option>Contado</option>
										</select>
										<span id="error_forma" class="errors"></span>
									</div>
								</div>
								<div class="row">
									<div class="form-group col-sm-6">
										<label for="fecha1">Emision de Factura</label>
										<input type="date" class="form-control" id="fecha1" name="fecha1" value="<?php echo date('Y-m-d'); ?>">
										<span id="error_fecha1" class="errors"></span>
									</div>
									<div class="form-group col-sm-6">
										<label for="fecha2">Vencimiento de Factura</label>
										<input type="date" class="form-control" id="fecha2" name="fecha2" min="<?php echo date('Y-m-d'); ?>">
										<span id="error_fecha2" class="errors"></span>
									</div>
								</div>
							</div>
							<!-- /.box-body -->

							<div class="box-footer">
								<span type="submit" class="btn btn-default enviar color-button-sweetalert" >Enviar</span>
								<button class="btn-enviar d-none" disabled="">enviar</button>
							</div>
						</form>
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

  $(".enviar").click(function(){
    var response = validar();

    if(response == true){
      $(".btn-enviar").attr("disabled");

       swal.fire({ 
          title: "¿Desea guardar los datos?",
          text: "Se guardaran los datos ingresados, ¿desea continuar?",
          type: "question",
          showCancelButton: true,
          confirmButtonColor: "<?=$colorPrimaryAll; ?>",
          confirmButtonText: "¡Guardar!",
          cancelButtonText: "Cancelar", 
          closeOnConfirm: false,
          closeOnCancel: false 
      }).then((isConfirm) => {
          if (isConfirm.value){      
              // var campaing = $(".campaing").val();
              // var n = $(".n").val();
              // var y = $(".y").val();
              // var menu = "?campaing="+campaing+"&n="+n+"&y="+y+"&route=LiderazgosCamp";
              // $.ajax({
              //       url: '?campaing='+campaing+'&n='+n+'&y='+y+'&route=LiderazgosCamp&action=Registrar',
              //       type: 'POST',
              //       data: {
              //         validarData: true,
              //         id_liderazgo: $("#titulo").val(),
              //       },
              //       success: function(respuesta){
              //         // alert(respuesta);
              //         if (respuesta == "1"){
                          $(".btn-enviar").removeAttr("disabled");
                          $(".btn-enviar").click();
                //       }
                //       if (respuesta == "9"){
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Los datos ingresados estan repetidos!',
                //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                //         });
                //       }
                //       if (respuesta == "5"){ 
                //         swal.fire({
                //             type: 'error',
                //             title: '¡Error de conexion con la base de datos, contacte con el soporte!',
                //             confirmButtonColor: "<?=$colorPrimaryAll; ?>",
                //         });
                //       }
                //     }
                // });
              
          }else { 
              swal.fire({
                  type: 'error',
                  title: '¡Proceso cancelado!',
                  confirmButtonColor: "<?=$colorPrimaryAll; ?>",
              });
          } 
      });



    
    }
  });




});
function validar(){
  $(".btn-enviar").attr("disabled");
  /*===================================================================*/
  var pedido = $("#pedido").val();
  var rpedido = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( pedido.length  != 0 ){
      $("#error_pedido").html("");
      rpedido = true;
    }else{
      rpedido = false;
      $("#error_pedido").html("Debe seleccionar al líder con su pedido");
    }
  /*===================================================================*/
  var fecha1 = $("#fecha1").val();
  var rfecha1 = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( fecha1.length  != 0 ){
      $("#error_fecha1").html("");
      rfecha1 = true;
    }else{
      rfecha1 = false;
      $("#error_fecha1").html("Debe seleccionar la fecha de emision de factura");
    }
  /*===================================================================*/
    var fecha2 = $("#fecha2").val();
  var rfecha2 = false;
  // var rnombre_liderazgo = checkInput(nombre_liderazgo, textPattern);
    if( fecha2.length  != 0 ){
      $("#error_fecha2").html("");
      rfecha2 = true;
    }else{
      rfecha2 = false;
      $("#error_fecha2").html("Debe seleccionar la fecha de vencimiento de factura");
    }
  /*===================================================================*/

  /*===================================================================*/
  var result = false;
  if( rpedido==true && rfecha1==true && rfecha2==true){
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
