<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Home</title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body style="font-family:'arial';background:#FFF">
	<?php require_once 'public/views/assets/top-menu.php'; ?>

	<?php
		$ruta = "https://stylecollection.org/?route=Lineas_de_productos";
		// $ruta = "?route=Lineas_de_productos";
		// $ruta = "#";
	?>
	<?php //if((date("Y-m-d")>="2023-05-17")&&(date("H:i")>="10:00")){ ?>
	<div style="background:;position:absolute;bottom:25%;right:0;z-index:500;background:#e5007e;padding:5px 4px;border-radius:5px;">
		<span id="enlaceAccess" class="d-none" style="font-size:1.2em;padding-left:10px;background:#e5007e;color:#FFF;margin-right:2px"><a class="enlaceOpen" href="<?=$ruta; ?>" style="color:#FFF;"><b>Líneas de productos</b></a></span>
		<span class="btn expandAccess">
			<i style="font-size:1.5em;color:#FFF;" id="idExpandAccess" class="fa fa-chevron-circle-left"></i>
		</span>
	</div>
	<?php //} ?>
	<style type="text/css">
		.fondo{
			width: 100%;
			object-fit: cover;
			object-position: bottom;
		}
	</style>
	<!-- <div class="wrapper" style="background:#F9F9FA;background-repeat:no-repeat;background-size:100% 100%;background-position-y:100%;opacity:1;"> -->
	<!-- <div class="wrapper" style="background:url('public/assets/img/resources/2.25/fondo.png');background-repeat:no-repeat;background-size:100% 100%;background-position-y:100%;opacity:1;"> -->
	<div class="wrapper" style="background:url('public/assets/img/resources/2.25/fondo.png');background-repeat:no-repeat;background-size:100% 100%;background-position-y:10%;opacity:1;">
	<!-- <div class="wrapper" style="background:red;width:100%;"> -->

		<!-- <img src="public/assets/img/resources/4.24/fondo.png" class="fondoGeneral"> -->
		<div class="head seccionFull"></div><!-- INDISPENSABLE NO SE PUEDE BORRAR -->
		<div style="max-width:100%;min-width:100%;width:100%;min-height:85vh;max-height:85vh;overflow:hidden;">
			<!-- <div style="background:#FFF;background-size:100% 100%;position:absolute;max-width:100%;min-width:100%;min-height:90vh;max-height:90vh;opacity:0.1;"></div> -->
			<!-- <div style="" class="box1fondo1">
				<div style="" class="box2fondo2">
					<img src="public/assets/img/resources/2.25/fondo.png" style="width: 100%;overflow: hidden;">
				</div>
			</div> -->
			<div style="" class="box1detalle1">
				<div style="" class="box2detalle1">
					<img src="public/assets/img/resources/2.25/detalle-fondo.png" style="max-width:100%;width:100%;">
				</div>
			</div>
			<div style="" class="box1detalle2">
				<div style="" class="box2detalle2">
					<img src="public/assets/img/resources/2.25/detalle-centro.png" style="max-width:100%;width:100%;">
				</div>
			</div>

			<div style="" class="box1emblema">
				<div style="" class="box2emblema">
					<img src="public/assets/img/resources/2.25/emblema.png" style="max-width:100%;width:100%;">
				</div>
			</div>
			
			<div style="" class="box1logotipo">
				<div style="" class="box2logotipo">
					<!-- <img src="public/assets/img/resources/2.25/logo.png" style="max-width:100%;width:100%;"> -->
				</div>
			</div>
			<div style="" class="box1cintillo">
				<div style="" class="box2cintillo">
					<img src="public/assets/img/resources/2.25/cintillo.png" style="max-width:100%;width:100%;">
				</div>
			</div>
		</div>
				<!-- <a href="./oficina.stylecollection/" target="_blank">
					<button class="btn btnContent col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-5" style="position:absolute;bottom:2%;"> 
						<small><b><i style="font-family:'Lucida Sans Unicode';">Oficina Virtual</i></b></small>
					</button>
				</a> -->


	   <?php require_once 'public/views/assets/aside-config.php'; ?>
	</div>
	<div class="row" style="background:#CCC;font-family:'Lucida Sans Unicode'">
		<div class="col-xs-12" style="padding:2% 5%;">
			<div class="row">
				<div class="col-xs-12 col-sm-8 col-sm-offset-2">
					<div style="border:0px solid #aaa;border-radius:20px;background:#FFFFFF;padding:5%;">
						<span style="text-transform:;display:block;text-align:center;"><b>Bienvenido a tu oficina virtual Style Collection</b></span><br>
						<span style="text-transform:;display:block;text-align:center;">1. Haz clic en <b>Entrar</b></span><br>
						<span style="text-transform:;display:block;text-align:center;">2. Ingresa tu usuario y tu contraseña.</span><br>
						<!-- <span style="text-transform:;display:block;text-align:center;">3. Comienza a llevar el control de tu factura.</span><br> -->
						<br>
						<a href="./oficina.stylecollection/" target="_blank">
						<button class="btn btnContent2 col-xs-10 col-xs-offset-1 col-sm-6 col-sm-offset-3 col-md-4 col-md-offset-4" >
							<small><b><i style="font-family:'Lucida Sans Unicode';">Entrar</i></b></small>
						</button>
						</a>
						<br>
						<!-- <br> -->
						<br>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php require_once 'public/views/assets/footered.php'; ?>
<?php require_once 'public/views/assets/footer.php'; ?>
<?php require_once 'public/views/assets/stylesheet.php'; ?>
<style type="text/css">
.expandAccess{
	background:#e5007e;color:#FFF;margin-top:-2px;
}
.enlaceOpen:hover{
	text-decoration:underline;
	cursor:pointer;
}
</style>
<script>
	$(document).ready(function(){
		$("#enlaceAccess").hide();
		$("#enlaceAccess").removeClass("d-none");
		$(".expandAccess").click(function(){
			var clas = $("#idExpandAccess").attr("class");
			if(clas=="fa fa-chevron-circle-left"){
				$("#idExpandAccess").removeClass("fa-chevron-circle-left");
				$("#idExpandAccess").addClass("fa-chevron-circle-right");
				$("#enlaceAccess").show(300);
				$(this).attr("style", "margin-left:2px;border-left:1px solid #FFF");
			}
			if(clas=="fa fa-chevron-circle-right"){
				$("#idExpandAccess").removeClass("fa-chevron-circle-right");
				$("#idExpandAccess").addClass("fa-chevron-circle-left");
				$("#enlaceAccess").hide(300);
				$(this).attr("style", "border-left:none;");
			}
		});
		// var barTop = $(".navbar").height();
		// var resto = 20;
		// var resto = 0;
		// $(".head").attr("style","height:"+(barTop-resto)+"px");
		// $(window).resize(function(){
		// 	var barTop = $(".navbar").height();
		// 	console.log(barTop);
		// 	$(".head").attr("style","height:"+(barTop-resto)+"px");
			
		// });	
	}); 
</script>
</body>
</html>
