<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Producto <?php if(!empty($_GET['cod']) ){ echo $_GET['cod']; } ?></title>
	<?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body style="font-family:'arial';background:#FFF">
	<?php
		$data = $producto;
		$data['imagen_producto_catalogo'] = $routeImg.$producto['imagen_producto_catalogo'];
		$ancho = "";
		$alto = "";
		if($data['imagen_producto_catalogo'] != ""){
			if(file_exists($data['imagen_producto_catalogo'])){
				$imagen = getimagesize($data['imagen_producto_catalogo']); //Sacamos la información.
				$ancho = $imagen[0]; //Ancho.
				$alto = $imagen[1]; //Alto.
				$alto = $alto / 2;
				// echo "Width:".$ancho." | ";
				// echo "Height:".$alto." | ";
			}
		}
		$elementosCantidad = 30;
	?>
	<?php // require_once 'public/views/assets/top-menu.php'; ?>
	<div style="background:#121212;display:flex;width:100%;height:100vh;"></div>
	<div class="seccionProduct1" style="display:;">
		<div class="contenido1">
			<div class="titleStyle">
				<b>
					<span class="left">	
						<?=$data['nombre_producto_catalogo']; ?>
					</span>
					<span class="right">
						<a href="<?=$data['imagen_producto_catalogo']; ?>" Download="<?=$data['nombre_producto_catalogo']; ?>" target="_blank"><u>Descargar</u> <span class="fa fa-download"></span></a>
					</span>	
				</b>
			</div>
			<img style="" class="imgProducto" src="<?=$data['imagen_producto_catalogo']; ?>">
			<!-- <button class="buttonBack1"><span class="fa fa-chevron-left"></span></button> -->
			<!-- <p style="font-size:3em;"> -->
			<!-- </p> -->
			<?php if (!empty($data2)): ?>
				<button class="buttonStyle buttonNext1"><span class="fa fa-chevron-right"></span></button>
			<?php endif; ?>
		</div>
	</div>

	<?php if (!empty($data2)): ?>
		

	<div class="seccionProduct2" style="display:none;">
		<div class="contenido2">
			<button class="buttonStyle buttonBack2"><span class="fa fa-chevron-left"></span></button>
			<p style="font-size:3em;">
				<?php for ($i=0; $i < $elementosCantidad; $i++) { 
					echo "Hola-2 | ";
				} ?>
			</p>
			<button class="buttonStyle buttonNext2"><span class="fa fa-chevron-right"></span></button>
		</div>
	</div>


	<div class="seccionProduct3" style="display:none;">
		<div class="contenido3">
			<button class="buttonStyle buttonBack3"><span class="fa fa-chevron-left"></span></button>
			<p style="font-size:3em;">
				<?php for ($i=0; $i < $elementosCantidad; $i++) { 
					echo "Hola-3 | ";
				} ?>
			</p>
			<!-- <button class="buttonStyle buttonNext3"><span class="fa fa-chevron-right"></span></button> -->
		</div>
	</div>

	<?php endif; ?>


	<div class="divwid3" style="width:3vh;display:none;">...</div>
	<?php require_once 'public/views/assets/footered.php'; ?>
	<?php //require_once 'public/views/assets/footer.php'; ?>
	<?php //require_once 'public/views/assets/stylesheet.php'; ?>


	<script>
		$(document).ready(function(){
			var width = $("body").width();
			var height = $("body").height();
			var widthImg = $(".imgProducto").width();
			var heightImg = $(".imgProducto").height();
			// alert(width+" | "+height);
			// alert(widthImg+" | "+heightImg);

			var vh3 = $(".divwid3").width();
			if(width > height){

				var pvh3 = (vh3*100) / width;
				pvh3 = 2;
				var pw = 100;
				var ph = (height*100) / width;
				var mglpx = (width - height) / 2;
				var mgl = (mglpx*100) / width;

				// alert(pw);
				// alert(ph); // 48%

				$(".imgProducto").attr("style","position:fixed;padding:0;margin:0;height:"+pw+"vh;");
				var st = $(".imgProducto").attr("style");
				var anchura = $(".imgProducto").width();
				var anp = (anchura*100)/width;
				var anp2 = ph-anp;
				$(".imgProducto").attr("style",st+"margin-left:"+(anp2/2)+"%");

				$(".seccionProduct1").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				var wtot = ph;

				$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
				$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
				$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

				$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
				$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
				$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

				$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
				$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
				$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");
			}
			else if(width < height){

				var pw = 100;
				var ph = (width*100) / height;
				// alert(ph);
				// var mglpx = (height-width) / 2;
				// var mglpx = 0;
				// var mgl = (mglpx*100) / height;
				var mgl = 0;
				// alert(height);
				// alert(heightImg);
				// alert(ph);
				// alert(pw);

				// $(".imgProducto").attr("style","padding:0;margin:0;height:"+pw+"vh;");
				var rPW = 0;
				$(".imgProducto").attr("style","position:fixed;padding:0;margin:0;width:"+(pw-rPW)+"%;margin:"+(rPW/2)+"%;");
				var altImg = $(".imgProducto").height();
				var nAltMax = height-altImg;

				var wtot = pw;

				$(".seccionProduct1").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
				$(".buttonNext1").attr("style","right:0;position:fixed;");
				$(".buttonBack1").attr("style","left:0;position:fixed;");

				$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
				$(".buttonNext2").attr("style","right:0;position:fixed;");
				$(".buttonBack2").attr("style","left:0;position:fixed;");

				$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
				$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
				$(".buttonNext3").attr("style","right:0;position:fixed;");
				$(".buttonBack3").attr("style","left:0;position:fixed;");
			}
			$(".seccionProduct1").show();
			$(".seccionProduct2").hide();
			$(".seccionProduct3").hide();

			var titleStyle = $(".titleStyle").attr("style");
			$(".titleStyle").attr("style", titleStyle+";width:"+wtot+"%;");
			$(window).resize(function(){
				var width = $("body").width();
				var height = $("body").height();
				var vh3 = $(".divwid3").width();

				if(width > height){
					
					var pvh3 = (vh3*100) / width;
					pvh3 = 3;
					var pw = 100;
					var ph = (height*100) / width;
					var mglpx = (width - height) / 2;
					var mgl = (mglpx*100) / width;

					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 horizontal");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}
					else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 horizontal");
						$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}
					else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 horizontal");
						$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}
					
				}
				else if(width < height){

					// alert("maximo es Height");
					var pw = 100;
					var ph = (width*100) / height;
					// var mglpx = (height-width) / 2;
					// var mglpx = 0;
					// var mgl = (mglpx*100) / height;
					var mgl = 0;
					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 vertical");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext1").attr("style","right:0;position:fixed;");
						$(".buttonBack1").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}
					else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 vertical");
						$(".seccionProduct2").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext2").attr("style","right:0;position:fixed;");
						$(".buttonBack2").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}
					else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 vertical");
						$(".seccionProduct3").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext3").attr("style","right:0;position:fixed;");
						$(".buttonBack3").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}

				}
			});

			$(".buttonNext1").click(function(){
				$(".seccionProduct1").hide();
				$(".seccionProduct3").hide();
				$(".seccionProduct2").show();
				
				var width = $("body").width();
				var height = $("body").height();
				var vh3 = $(".divwid3").width();

				if(width > height){
					
					var pvh3 = (vh3*100) / width;
					pvh3 = 3;
					var pw = 100;
					var ph = (height*100) / width;
					var mglpx = (width - height) / 2;
					var mgl = (mglpx*100) / width;

					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 horizontal");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}
					else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 horizontal");
						$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}
					else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 horizontal");
						$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}
					
				}
				else if(width < height){

					// alert("maximo es Height");
					var pw = 100;
					var ph = (width*100) / height;
					// var mglpx = (height-width) / 2;
					// var mglpx = 0;
					// var mgl = (mglpx*100) / height;
					var mgl = 0;
					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 vertical");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext1").attr("style","right:0;position:fixed;");
						$(".buttonBack1").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}
					else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 vertical");
						$(".seccionProduct2").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext2").attr("style","right:0;position:fixed;");
						$(".buttonBack2").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}
					else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 vertical");
						$(".seccionProduct3").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext3").attr("style","right:0;position:fixed;");
						$(".buttonBack3").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}

				}
			});

			$(".buttonBack2").click(function(){
				$(".seccionProduct2").hide();
				$(".seccionProduct3").hide();
				$(".seccionProduct1").show();

				var width = $("body").width();
				var height = $("body").height();
				var vh3 = $(".divwid3").width();

				if(width > height){
					
					var pvh3 = (vh3*100) / width;
					pvh3 = 3;
					var pw = 100;
					var ph = (height*100) / width;
					var mglpx = (width - height) / 2;
					var mgl = (mglpx*100) / width;

					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 horizontal");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 horizontal");
						$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 horizontal");
						$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}
					
				}
				else if(width < height){

					// alert("maximo es Height");
					var pw = 100;
					var ph = (width*100) / height;
					// var mglpx = (height-width) / 2;
					// var mglpx = 0;
					// var mgl = (mglpx*100) / height;
					var mgl = 0;
					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 vertical");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext1").attr("style","right:0;position:fixed;");
						$(".buttonBack1").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 vertical");
						$(".seccionProduct2").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext2").attr("style","right:0;position:fixed;");
						$(".buttonBack2").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 vertical");
						$(".seccionProduct3").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext3").attr("style","right:0;position:fixed;");
						$(".buttonBack3").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}

				}
			});

			$(".buttonNext2").click(function(){
				$(".seccionProduct1").hide();
				$(".seccionProduct2").hide();
				$(".seccionProduct3").show();
				
				var width = $("body").width();
				var height = $("body").height();
				var vh3 = $(".divwid3").width();

				if(width > height){
					
					var pvh3 = (vh3*100) / width;
					pvh3 = 3;
					var pw = 100;
					var ph = (height*100) / width;
					var mglpx = (width - height) / 2;
					var mgl = (mglpx*100) / width;

					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 horizontal");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 horizontal");
						$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 horizontal");
						$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}
					
				}
				else if(width < height){

					// alert("maximo es Height");
					var pw = 100;
					var ph = (width*100) / height;
					// var mglpx = (height-width) / 2;
					// var mglpx = 0;
					// var mgl = (mglpx*100) / height;
					var mgl = 0;
					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 vertical");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext1").attr("style","right:0;position:fixed;");
						$(".buttonBack1").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 vertical");
						$(".seccionProduct2").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext2").attr("style","right:0;position:fixed;");
						$(".buttonBack2").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 vertical");
						$(".seccionProduct3").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext3").attr("style","right:0;position:fixed;");
						$(".buttonBack3").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}

				}
			});

			$(".buttonBack3").click(function(){
				$(".seccionProduct1").hide();
				$(".seccionProduct3").hide();
				$(".seccionProduct2").show();
				
				var width = $("body").width();
				var height = $("body").height();
				var vh3 = $(".divwid3").width();

				if(width > height){
					
					var pvh3 = (vh3*100) / width;
					pvh3 = 3;
					var pw = 100;
					var ph = (height*100) / width;
					var mglpx = (width - height) / 2;
					var mgl = (mglpx*100) / width;

					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 horizontal");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack1").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 horizontal");
						$(".seccionProduct2").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack2").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 horizontal");
						$(".seccionProduct3").attr("style","display:none;padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:101vh;max-width:101vh;margin:0% 0vh 0% 0vh;padding:0;font-size:2vh;");
						$(".buttonNext3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;right:0;position:fixed;");
						$(".buttonBack3").attr("style","min-width:"+mgl+"%;max-width:"+mgl+"%;left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}
					
				}
				else if(width < height){

					// alert("maximo es Height");
					var pw = 100;
					var ph = (width*100) / height;
					// var mglpx = (height-width) / 2;
					// var mglpx = 0;
					// var mgl = (mglpx*100) / height;
					var mgl = 0;
					if($(".seccionProduct1").is(":visible")){
						// alert("see 1 vertical");
						$(".seccionProduct1").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido1").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext1").attr("style","right:0;position:fixed;");
						$(".buttonBack1").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").show();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").hide();
					}else if($(".seccionProduct2").is(":visible")){
						// alert("see 2 vertical");
						$(".seccionProduct2").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido2").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext2").attr("style","right:0;position:fixed;");
						$(".buttonBack2").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct3").hide();
						$(".seccionProduct2").show();
					}else if($(".seccionProduct3").is(":visible")){
						// alert("see 3 vertical");
						$(".seccionProduct3").attr("style","padding:0;margin:0;background:#232323;position:absolute;top:0;left:0;width:"+ph+"%;height:"+pw+"vh;margin-left:"+mgl+"%;margin-right:"+mgl+"%;");
						$(".contenido3").attr("style","background:#434343;position:absolute;top:0;left:0;min-height:100vh;max-height:100vh;overflow:auto;min-width:"+width+"px;max-width:"+width+"px;margin:0% 0vh 0% 0vh;padding:0% 0vh 0% 0vh;font-size:2vh;");
						$(".buttonNext3").attr("style","right:0;position:fixed;");
						$(".buttonBack3").attr("style","left:0;position:fixed;");

						$(".seccionProduct1").hide();
						$(".seccionProduct2").hide();
						$(".seccionProduct3").show();
					}

				}

			});

		}); 
	</script>
	<style type="text/css">
		.titleStyle{
			position:fixed;
			z-index:9999;
			top:0;
			background:#00000033;
			border:none;
			color:#FFFFFF55;
			font-size:2vh;
			margin:0;
			padding:1vh 3vh;
		}
		.titleStyle .left{
			float:left;
			/*background:red;*/
			width:60%;
			text-shadow:1px 1px 2px #000;
		}
		.titleStyle .right{
			float:right;
			/*background:blue;*/
			text-align:right;
			width:40%;
			text-shadow:1px 1px 2px #000;
		}
		.buttonStyle{
			position:absolute;
			top:0;
			background:#00000033;
			border:none;
			color:#FFFFFF55;
			height:100vh;
			max-width:3vh;
			font-size:2vh;
			padding:0 1vh;
			margin:0;
		}
		.buttonNext1:hover, .buttonNext2:hover, .buttonNext3:hover, .buttonStyle:hover{
			background:#00000055;
			color:#FFFFFF99;
		}
	</style>
</body>
</html>
