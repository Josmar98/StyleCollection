<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Home</title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body style="font-family:'arial';background:#FFF">
	<?php require_once 'public/views/assets/top-menu.php'; ?>



	<div class="wrapper">

		<div class="head seccionFull"></div><!-- INDISPENSABLE NO SE PUEDE BORRAR -->

		<!-- <div class="seccion1 seccionFull">
			<div>
				<img class="imgFondoResor" src="public/assets/img/resources/web_work1.png">
			</div>
		</div> -->

		<div class="seccion1 seccionFull">
			<div class="seccion1Fondo">
				<div class="row inrow">
				
				<img src="public/assets/img/resources/cintillo_campana.png" class="col-xs-3 col-sm-2 col-md-1 seccion1Cintillo">
				<img src="public/assets/img/resources/emblema.png" class="col-xs-3 col-sm-2 col-md-1 seccion1Emblema">
				<img src="public/assets/img/resources/productos2.png" class="col-xs-12 col-md-10 col-md-offset-1 seccion1Productos">
				<a href="./oficina.stylecollection/" target="_blank">
					<button class="btn btnContent col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-5"> 
						<small><b>Ir a la Oficina Virtual</b></small>
					</button>
				</a>
					
				</div>
			</div>
		</div>


	   <?php require_once 'public/views/assets/aside-config.php'; ?>
	</div>
<?php require_once 'public/views/assets/footered.php'; ?>
<?php require_once 'public/views/assets/footer.php'; ?>
<?php require_once 'public/views/assets/stylesheet.php'; ?>

<script>
$(document).ready(function(){
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
