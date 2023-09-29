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
		<div style="background:url('public/assets/img/resources/fondo4.22.png');background-size:100% 100%;max-width:100%;min-width:100%;height:90vh;">

			<div style="" class="box1cintillo">
				<div style="" class="box2cintillo">
					<img src="public/assets/img/resources/cintillo_campana4.22.png" style="max-width:100%;">
				</div>
			</div>
			<div style="" class="box1logotipotop">
				<div style="" class="box2logotipo">
					<img src="public/assets/img/resources/logotipo4.22.png" style="max-width:100%;">
				</div>
			</div>
			<br>
			<div style="" class="box1emblema">
				<div style="" class="box2emblema">
					<img src="public/assets/img/resources/emblema4.22.png" style="max-width:100%;">
				</div>
			</div>
			<div style="" class="box1escaleras">
				<div style="" class="box2escaleras">
					<img src="public/assets/img/resources/escalera4.22.png" style="max-width:100%;">
				</div>
			</div>
			<div style="" class="box1logotipobottom">
				<div style="" class="box2logotipo">
					<img src="public/assets/img/resources/logotipo4.22.png" style="max-width:100%;">
				</div>
			</div>
		</div>
				<a href="./oficina.stylecollection/" target="_blank">
					<button class="btn btnContent col-xs-8 col-xs-offset-2 col-sm-4 col-sm-offset-4 col-md-2 col-md-offset-5" style="position:absolute;bottom:2%;"> 
						<small><b><i>Ir a la Oficina Virtual</i></b></small>
					</button>
				</a>

<!-- 		<div class="seccion1 seccionFull">
			<div class="seccion1Fondo">
				<div class="row inrow">
				
					<img src="public/assets/img/resources/cintillo_campana3.22.png" class="col-xs-3 col-sm-2 col-md-1 seccion1Cintillo3">
				<img src="public/assets/img/resources/emblema3.22.png" class="col-xs-3 col-sm-2 col-md-1 seccion1Emblema3">
				<img src="public/assets/img/resources/productos3.22.png" class="col-xs-12 col-md-10 col-md-offset-1 seccion1Productos3">
				<img src="public/assets/img/resources/logotipo3.22.png" class="col-xs-12 col-md-10 col-md-offset-1 seccion1Logotipo3">
					
				</div>
			</div>
		</div> -->

		<!-- <div class="seccion1 seccionFull">
			<div class="seccion1Fondo">
				<div class="row inrow">
				
				<img src="https://www.instagram.com/p/CTA9qfLFkAW/" class="col-xs-3 col-sm-2 col-md-1 seccion1Cintillo">
				
					
				</div>
			</div>
		</div> -->


	   <?php require_once 'public/views/assets/aside-config.php'; ?>
	</div>
<?php require_once 'public/views/assets/footered.php'; ?>
<?php require_once 'public/views/assets/footer.php'; ?>
<?php require_once 'public/views/assets/stylesheet.php'; ?>
<style type="text/css">
.emblema{ 
	width:55%;margin: auto; 
}
.mano{
	width:25%;position:absolute;top:32%;right:0;
}
.cintillo { 
	padding-top:0vh;
}
.tablet{
	width:14vh;position:absolute;left:0;bottom:0vh;
}
.celular{
	width:13vh;position:absolute;right:0;top:35vh;
}
.boligrafo{
	width:3%;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:15vh;
}
.gafas{
	width:15%;position:absolute;right:0;
}

@media screen and (min-width: 860px) and (max-width: 1024px){
	/*.emblema{
		width:55%;margin-top:0%;
	}
	.tablet{
		width:13vh;position:absolute;left:0;bottom:5vh;
	}
	.celular{
		width:10vh;position:absolute;right:0;top:35vh;
	}
	.boligrafo{
		width:3vh;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:11vh;
	}
	.gafas{
		width:15%;position:absolute;right:0;
	}*/

}
@media screen and (min-width: 640px) and (max-width: 860px){
	/*.emblema{
		width:55%;margin-top:3vh;
	}
	.mano{
		width:25%;position:absolute;margin-top:5vh;
	}
	.tablet{
		width:8vh;position:absolute;left:0;bottom:10vh;
	}
	.celular{
		width:10vh;position:absolute;right:0;top:35vh;
	}
	.boligrafo{
		width:3vh;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:11vh;
	}
	.gafas{
		width:19%;position:absolute;right:0;
	}*/
	
}
@media screen and (min-width: 520px) and (max-width: 640px){
	/*.emblema{
		width:55%;margin-top:5vh;
	}
	.cintillo { padding-top:1vh }
	.mano{
		width:25%;position:absolute;margin-top:5vh;
	}
	.tablet{
		width:8vh;position:absolute;left:0;bottom:15vh;
	}
	.celular{
		width:10vh;position:absolute;right:0;top:35vh;
	}
	.boligrafo{
		width:3vh;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:11vh;
	}
	.gafas{
		width:20%;position:absolute;right:0;
	}*/
}
@media screen and (min-width: 360px) and (max-width: 520px){
	/*.emblema{
		width:65%;margin-top:13vh;
	}
	.mano{
		width:22%;position:absolute;margin-top:5vh;
	}
	.cintillo { padding-top:1vh }
	.tablet{
		width:8vh;position:absolute;left:0;bottom:20vh;
	}
	.celular{
		width:6vh;position:absolute;right:0;top:35vh;
	}
	.boligrafo{
		width:2vh;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:6vh;
	}
	.gafas{
		width:21%;position:absolute;right:0;
	}*/
}
@media screen and (min-width: 100px) and (max-width: 360px){
	/*.emblema{
		width:60%;margin-top:15vh;
	}
	.mano{
		width:23%;position:absolute;margin-top:11vh;
	}
	.cintillo { padding-top:1vh }
	.tablet{
		width:8vh;position:absolute;left:0;bottom:20vh;
	}
	.celular{
		width:6vh;position:absolute;right:0;top:35vh;
	}
	.boligrafo{
		width:2vh;transform:rotate(-5deg);margin:auto;position:absolute;top:35vh;right:6vh;
	}
	.gafas{
		width:21%;position:absolute;right:0;
	}*/
}
</style>
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
