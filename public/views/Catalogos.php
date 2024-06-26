<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Producto <?php if(!empty($_GET['cod']) ){ echo $_GET['cod']; } ?></title>
	<?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body style="font-family:'arial';background:#FFF">
	<?php
		// $tituloGeneral = "Línea de productos";
		$tituloGeneral = "Catalogos Style";

		$data = $producto;
		// print_r($data);
		if(!empty($_GET['width']) && !empty($_GET['height'])){
			$widthBodyPx = $_GET['width'];
			$heightBodyPx = $_GET['height'];
			
			$anchoModelo = "";
			$altoModelo = "";
			$disenioModelo = "";
			
			$orientacion = "";
			if($widthBodyPx > $heightBodyPx){
				$widthBody = 100;
				$heightBody = ($heightBodyPx * 100) / $widthBodyPx;
				$orientacion = "horizontal";

			}
			if($widthBodyPx <= $heightBodyPx){
				$heightBody = 100;
				$widthBody = ($widthBodyPx * 100) / $heightBodyPx;
				$orientacion = "vertical";
			}
			foreach($indexes as $index){
				if(!empty($data['imagen_catalogo'.$index]) && $data['imagen_catalogo'.$index] != ""){
					$data['imagen_catalogo'.$index] = $routeImg.$producto['imagen_catalogo'.$index];
					$anchoImagen = "";
					$altoImagen = "";
					if(file_exists($data['imagen_catalogo'.$index])){
						$imagen = getimagesize($data['imagen_catalogo'.$index]); //Sacamos la información.
						$anchoImagen = $imagen[0]; //AnchoImagen.
						$altoImagen = $imagen[1]; //AltoImagen.
						if($disenioModelo==""){ $disenioModelo = $data['imagen_catalogo'.$index]; }
					}
					if($anchoModelo==""){ $anchoModelo = $anchoImagen; }
					if($altoModelo==""){ $altoModelo = $altoImagen; }
				}
				if(!empty($data['video_catalogo'.$index]) && $data['video_catalogo'.$index] != ""){
					$data['video_catalogo'.$index] = $routeImg.$producto['video_catalogo'.$index];
					$data['video_catalogo'.$index] = $producto['video_catalogo'.$index];
					$anchoImagen = "";
					$altoImagen = "";
					if(file_exists($data['video_catalogo'.$index])){
						$imagen = getimagesize($data['video_catalogo'.$index]); //Sacamos la información.
						$anchoImagen = $imagen[0]; //AnchoImagen.
						$altoImagen = $imagen[1]; //AltoImagen.
						if($disenioModelo==""){ $disenioModelo = $data['video_catalogo'.$index]; }
					}
					if($anchoModelo==""){ $anchoModelo = $anchoImagen; }
					if($altoModelo==""){ $altoModelo = $altoImagen; }
				}
			}

			// if($data['video_catalogo'] != ""){
			// 	$data['video_catalogo'] = $producto['video_catalogo'];
			// 	$anchoVideo = "";
			// 	$altoVideo = "";
			// 	if(file_exists($data['video_catalogo'])){
			// 		$video = getimagesize($data['video_catalogo']); //Sacamos la información.
			// 		$anchoVideo = $video[0]; //AnchoImagen.
			// 		$altoVideo = $video[1]; //AltoImagen.
			// 		if($disenioModelo==""){ $disenioModelo = $data['video_catalogo']; }
			// 	}
			// 	if($anchoModelo==""){ $anchoModelo = $anchoVideo; }
			// 	if($altoModelo==""){ $altoModelo = $altoVideo; }
			// }

		}
		$elementosCantidad = 30;
		// echo "****".$anchoVideo." ".$altoVideo;
		// die();
		if($orientacion=="horizontal"){
			// $heightBody;
			$laterales = (100 - $heightBody) / 2;
			$central = 100 - ($laterales*2);
			$tamImg = "height:100%;";
			$add = $widthBody - $heightBody;
			$anchoFlechas = "width:".$laterales."%;";
			$positionFlechasL= "";
			$positionFlechasR= "";
			$sizeList = "3vh";
			$tamImgTitle = "12.5%";
			$marginImgTitle = "-5px";
			$padd = "padding:2% 5%;";
			// if($anchoImagen > $altoImagen){
			// 	echo "La imagen en Horizontal";
			// }
			if($anchoModelo <= $altoModelo){
				$altoModeloPorcent = 100;
				$anchoModeloPorcent = ($anchoModelo * 100) / $altoModelo;
				$lateralCentral = ($anchoModeloPorcent / 100) * $central;
				$lateralCentral = (100 - $anchoModeloPorcent);
				$styleLat = "margin-left:".($lateralCentral/2)."%;";
			}
		}
		if($orientacion=="vertical"){
			$laterales = 0;
			$central = 100 - ($laterales*2);
			$tamImg = "width:100%;";
			$add = $heightBody - $widthBody;
			$anchoFlechas = "width:5%;";
			$positionFlechasL = "position:fixed;left:1%;";
			$positionFlechasR = "position:fixed;right:1%;";
			$sizeList = "2vh";
			$tamImgTitle = "25%";
			$marginImgTitle = "-10px";
			$padd = "padding:2% 10%;";
			$styleLat = "";
			// if($anchoImagen <= $altoModelo){
				// $anchoImagenPorcent = 100;
				// $altoModeloPorcent = ($altoModelo * 100) / $anchoImagen;
				// $altoModeloAdaptadosPX = ($altoModelo / 100) * $widthBody;
				// $altoImagenAdaptadosPorcent = ($altoImagenAdaptadosPX * 100) / $heightBodyPx;
				// $lateralCentral = 100 - $altoImagenAdaptadosPorcent;
				// $styleLat = "margin-top:".($lateralCentral/2)."%;";
			// }
		}

		// print_r($data);
		// die();
	?>



	<div class="watch" style="z-index:10;background:#121212;width:100%;height:100vh;position:fixed;top:0;left:0;">		<div style="position:fixed;top:0;left:0%;z-index:20;background:#121212;width:<?=$laterales; ?>%;height:100%;">
			<button style="display:none;" class="buttonStyle buttonBack"><span class="fa fa-chevron-left" style="<?=$positionFlechasL; ?>"></span></button>
		</div>
		
		<div class="bloqueCentral" style="position:fixed;top:0;left:<?=$laterales; ?>%;z-index:15;background:#232323;width:<?=$central; ?>%;height:100%;">
			<?php
				foreach ($list as $key){
					$keyId = $key['name']."_catalogo".$key['namef'];
					if (!empty($data[$keyId])){ 
						if($key['name']=="lista"){
						}else{
							if($key['display']==""){ ?>
								<div class="titleStyle descargar<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="width:<?=$central; ?>%;">
									<b>
										<span class="left">	
											<?=$data['nombre_catalogo']; ?>
										</span>
										<span class="right">
											<a class="descargas descarga<?=$key['num']; ?>" name="<?=$key['num']; ?>" href="<?=$data[$keyId]; ?>" Download="<?=$key['caption'].$data['nombre_catalogo']."#".($key['num']+1); ?>" target="_blank"><u>Descargar</u> <span class="fa fa-download"></span></a>
										</span>	
									</b>
								</div>
							<?php } else { ?>
								<div class="titleStyle descargar<?=$key['num']; ?>" style="width:<?=$central; ?>%;display:none;">
									<b>
										<span class="left">	
											<?=$data['nombre_catalogo']; ?>
										</span>
										<span class="right">
												<a class="descargas descarga<?=$key['num']; ?>" href="<?=$data[$keyId]; ?>" Download="<?=$key['caption'].$data['nombre_catalogo']."#".($key['num']+1); ?>" target="_blank"><u>Descargar</u> <span class="fa fa-download"></span></a>
										</span>	
									</b>
								</div>
							<?php } ?>
							<?php
						}
					}
				}
			?>
			<?php
				$cantElement = [];
				// print_r($producto);
				foreach ($list as $key){
					$keyId = $key['name']."_catalogo".$key['namef'];
					if($key['name']=="lista"){
						?>
						<div class="elemento<?=$key['num']; ?> imgs" style="display:none;font-size:<?=$sizeList; ?>;background-image:url(<?=$disenioModelo; ?>);background-size:100%;width:100% !important;height:100vh;">

							<div style="background:#00000077;max-width:100%;height:100vh;overflow-x:hidden;">
								<?php //echo $padd; ?>
							<h3 class="row" style="color:#FFFFFF;background:#0ca9e1;font-size:1.75em;padding:1% 5%;">
								<div class="col-xs-10" style="margin:0;padding:0;padding-top:2%;box-sizing:border-box;width:;">
									<b><?=mb_strtoupper($tituloGeneral); ?></b>
								</div>
								<!-- 376B5A -->
								<div class="col-xs-1" style="margin:0;padding:0;padding-top:5px;box-sizing:border-box;">
									<img src="public/assets/img/iconB.png" style="width:80%;margin-top:<?=$marginImgTitle; ?>;">
								</div>
							</h3>
							<br>
							<style> .clicLineas:hover{ background:#00000044; } .clicProducto:hover{ background:#00000044; } </style>
							<?php 
							$n = 1;
							foreach ($lineas as $data){
								if(!empty($data['id_linea'])){
									// $ruta = "https://stylecollection.org/?route=Productos&cod=".$data['codigo_catalogo'];
									// $ruta = "?route=Productos&cod=";
									?>

									<div class="clicLineas" id="<?=$data['id_linea']; ?>" style="padding:3% 5% 3% 5%;margin-left:0;display:block;position:relative;z-index:10;width:100%;color:#fff;" >
										<!-- text-shadow:1px 1px 5px #29938C; -->
										<span style=""><b><?=mb_strtoupper($data['nombre_linea']); ?></b></span>
										<span style=""><i id="classClic<?=$data['id_linea']; ?>" class="fa fa-angle-down"></i></span>
									</div>
										
									<div class="boxLines boxLine<?=$data['id_linea']; ?> d-none" style="position:relative;z-index:10;">
									<?php
									foreach ($lineasp as $line) {
										if(!empty($line['id_linea'])){
											if($line['id_linea']==$data['id_linea']){
												$ruta = "";
												if($line['imagen_catalogo']!="" || $line['ficha_catalogo']!="" || $line['ficha_catalogo2']!="" || $line['ficha_catalogo3']!="" || $line['ficha_catalogo4']!=""){
													// $ruta = "https://stylecollection.org/?route=Productos&cod=".$line['codigo_catalogo'];
													$ruta = "?route=Productos&cod=".$line['codigo_catalogo'];
													if(!empty($_GET['width'])){
														$ruta .= "&width=".$_GET['width'];
													}
													if(!empty($_GET['height'])){
														$ruta .= "&height=".$_GET['height'];
													}
												}
												?>
												<a class="clicProducto" <?php if($ruta!=""){ ?> href="<?=$ruta; ?>" <?php } ?> style="background:;padding:1% 3% 1% 5%;margin-left:0;display:block;width:100%;color:#fff;text-shadow:1px 1px 5px #0ca9e1;" ><?=$line['nombre_catalogo']; ?></a>
												<?php
											}
										}
									}
									?>
									</div>
									<br>
									<?php
									$n++;
								}
							}
							?>
							
							</div>
						</div>

						<?php
					}else{
						if (!empty($data[$keyId])){ 

							if($key['display']==""){
								if($key['name']=="imagen"){
									?>
								<img class="imgs elemento<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="<?=$tamImg; ?><?=$styleLat; ?>" src="<?=$data[$keyId]; ?>">
									<?php 
								}
								if($key['name']=="video"){
									?>
									<video class="imgs elemento<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="<?=$tamImg; ?><?=$styleLat; ?>" src="<?=$data[$keyId]; ?>" controls>
										Tu navegador no admite el elemento <code>video</code>.
									</video>
									<!-- <video class="imgs elemento<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="<?=$tamImg; ?><?=$styleLat; ?>" src="<?=$data[$keyId]; ?>" controls></video> -->
									<!-- <video src="<?=$data[$keyId]; ?>" width=320  height=240 controls poster="vistaprevia.jpg" preload>
									Lo sentimos. Este vídeo no puede ser reproducido en tu navegador.<br>
									La versión descargable está disponible en <a href="URL">Enlace</a>. 
									</video> -->

									<?php 
								}
							} else { 
								if($key['name']=="imagen"){
									?>
								<img class="imgs elemento<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="display:none;<?=$tamImg; ?>;<?=$styleLat; ?>;" src="<?=$data[$keyId]; ?>">
									<?php
								}
								if($key['name']=="video"){
									?>
									<iframe class="imgs elemento<?=$key['num']; ?>" name="<?=$key['num']; ?>" style="display:none;<?=$tamImg; ?>;<?=$styleLat; ?>;"  src="<?=$data[$keyId]; ?>" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" referrerpolicy="strict-origin-when-cross-origin" allowfullscreen></iframe>
									<?php
								}
							}
							$cantElement[count($cantElement)] = $key['num'];
						}
					}
				}
			?>
			<input type="hidden" id="cantElement" value="<?php echo json_encode($cantElement); ?>">
		</div>
		
		<div style="position:fixed;top:0;left:<?=$laterales+$central; ?>%;;z-index:20;background:#121212;width:<?=$laterales; ?>%;height:100%;">
			<button style="display:none;" class="buttonStyle buttonNext"><span class="fa fa-chevron-right" style="<?=$positionFlechasR; ?>"></span></button>
		</div>
	</div>
	<span style="display:none;" class="json_list"><?php echo json_encode($list); ?></span>
	<input type="hidden" id="posicionActual" value="0">
	<input type="hidden" id="StatusTitle" value="0">
	<input type="hidden" id="StatusNext" value="0">
	<input type="hidden" id="StatusBack" value="0">

	<div class="divwid3" style="width:3vh;display:none;">...</div>
	<?php require_once 'public/views/assets/footered.php'; ?>

	<?php if(!empty($_GET['width']) && !empty($_GET['height'])){ $recargar = "N"; }else{ $recargar="Y"; } ?>
	<input type="hidden" id="recargar" value="<?=$recargar; ?>">
	<form action="" method="get" class="submitFormMedidas">
		<input type="hidden" name="route" value="<?=$_GET['route']; ?>">
		<input type="hidden" name="cod" value="<?=$_GET['cod']; ?>">
		<input type="hidden" name="width" value="<?=$_GET['width']; ?>" id="width">
		<input type="hidden" name="height" value="<?=$_GET['height']; ?>" id="height">
	</form>

<script>
$(document).ready(function(){
	$(".boxLines").hide();
	$(".clicLineas").click(function(){
		var id = $(this).attr("id");
		var cl = $("#classClic"+id).attr("class");
		$(".boxLine"+id).removeClass("d-none");
		if(cl=="fa fa-angle-down"){
			$(".boxLine"+id).slideDown();
			$("#classClic"+id).removeClass("fa-angle-down");
			$("#classClic"+id).addClass("fa-angle-up");
		}
		if(cl=="fa fa-angle-up"){
			$(".boxLine"+id).slideUp();
			$("#classClic"+id).removeClass("fa-angle-up");
			$("#classClic"+id).addClass("fa-angle-down");
		}
	});
	// alert("alto: "+$(".bloqueCentral").height());
	// alert("ancho: "+$(".bloqueCentral").width());
	if($(".bloqueCentral").height() > $(".bloqueCentral").width()){
		var data = $("#cantElement").val();
		var json = JSON.parse(data);
		for (var i = 0; i < json.length; i++) {
			classElemt = "elemento"+json[i];
			let rst = $(".bloqueCentral").height() - $("."+classElemt).height();
			let st = $("."+classElemt).attr("style");
			let mtrst = rst / 2;
			// alert(rst);
			st = st + "margin-top:"+mtrst+"px;";
			$("."+classElemt).attr("style", "");
			$("."+classElemt).attr("style", st);
		}
	}else{
		// alert($("body").width());
	}
		// let bcst = $(".bloqueCentral").attr("style");
		// bcst = bcst + "background:#000000;";
		// $(".bloqueCentral").attr("style","");
		// $(".bloqueCentral").attr("style", bcst);

	$(".imgs").click(function(){
		var id = $(this).attr("name");
		if($(".descargar"+id).is(":hidden")){
			if($("#StatusTitle").val()==1){
				$(".descargar"+id).fadeIn(250);
				$("#StatusTitle").val(0);
			}
		}else{
			if($("#StatusTitle").val()==0){
				$(".descargar"+id).fadeOut(250);
				$("#StatusTitle").val(1);
			}
		}
		if($(".buttonNext").is(":hidden")){
			if($("#StatusNext").val()==1){
				$(".buttonNext").fadeIn(250);
				$("#StatusNext").val(0);
			}
		}else{
			if($("#StatusNext").val()==0){
				$(".buttonNext").fadeOut(250);
				$("#StatusNext").val(1);
			}
		}
		if($(".buttonBack").is(":hidden")){
			if($("#StatusBack").val()==1){
				$(".buttonBack").fadeIn(250);
				$("#StatusBack").val(0);
			}
		}else{
			if($("#StatusBack").val()==0){
				$(".buttonBack").fadeOut(250);
				$("#StatusBack").val(1);
			}
		}
		// alert($(".buttonBack").is(":hidden"));
		// $(".buttonStyle").fadeToggle(250);

		// alert("asd");
	});

	var recargar = $("#recargar").val();
	var width = $(".watch").width();
	var height = $(".watch").height();
	var widPage = $("#width").val();
	var higPage = $("#height").val();
	$("#width").val(width);
	$("#height").val(height);
	if((width != widPage) || (height != higPage)){
		$(".submitFormMedidas").submit();
	}else{
		if(recargar=="Y"){
			$(".submitFormMedidas").submit();
		}
	}
	$(window).resize(function(){
		var width = $(".watch").width();
		var height = $(".watch").height();
		var widPage = $("#width").val();
		var higPage = $("#height").val();
		var difWidth = 0;
		if(width>widPage){
			difWidth = (width-widPage);
		}
		if(widPage>=width){
			difWidth = (widPage-width);
		}
		var difheight = 0;
		// alert(height);
		// alert(higPage);
		if(height>higPage){
			difheight = (height-higPage);
		}
		if(higPage>=height){
			difheight = (higPage-height);
		}

		if((width != widPage) || (height != higPage)){
			var rec = false;
			if(difWidth>120){
				rec = true;
			}
			if(difheight>290){
				rec = true;
			}
			// alert(difWidth);
			// alert(difheight);
			if(rec==true){
				$(".submitFormMedidas").submit();
			}
		}
	});
	
	var posicionActual = $("#posicionActual").val();
	var json_list = $(".json_list").html();
	var json_data = JSON.parse(json_list);
	var cantidadElementos = json_data.length;
	var idMin = 0;
	var idMax = cantidadElementos-1;
	$(".buttonStyle").show();
	if(posicionActual==idMin){
		$(".buttonBack").hide();
	}
	if(posicionActual==idMax){
		$(".buttonNext").hide();
	}

	$(".buttonNext").click(function(){
		var posicionActual = $("#posicionActual").val();
		var newPosicion = parseInt(posicionActual)+1;
		var json_list = $(".json_list").html();
		var json_data = JSON.parse(json_list);
		var cantidadElementos = json_data.length;
		var idMin = 0;


		// $(".box"+posicionActual).hide();
		// $(".box"+newPosicion).show();

		$(".descargar"+posicionActual).hide();
		$(".descargar"+newPosicion).show();

		$(".elemento"+posicionActual).hide();
		$(".elemento"+newPosicion).show();
		$("#posicionActual").val(newPosicion);

		posicionActual = $("#posicionActual").val();
		$(".buttonStyle").show();
		if(posicionActual==idMin){
			$(".buttonBack").hide();
		}
		if(posicionActual==idMax){
			$(".buttonNext").hide();
		}
	});

	$(".buttonBack").click(function(){
		var posicionActual = $("#posicionActual").val();
		var newPosicion = parseInt(posicionActual)-1;
		var json_list = $(".json_list").html();
		var json_data = JSON.parse(json_list);
		var cantidadElementos = json_data.length;
		var idMin = 0;
		$(".descargar"+posicionActual).hide();
		$(".descargar"+newPosicion).show();

		$(".elemento"+posicionActual).hide();
		$(".elemento"+newPosicion).show();
		$("#posicionActual").val(newPosicion);
		
		posicionActual = $("#posicionActual").val();
		$(".buttonStyle").show();
		if(posicionActual==idMin){
			$(".buttonBack").hide();
		}
		if(posicionActual==idMax){
			$(".buttonNext").hide();
		}
	});

	// height = $("body").height();
	// var titleHeightPx = $(".titleStyle").height();
	// var titleHeightPorcent = ((titleHeightPx * 100)/higPage);
	// alert(height);
	// alert(titleHeightPx);
	// var styleTitle = $(".buttonStyle").attr("style");
	// $(".buttonStyle").attr("style", "height:"+(higPage-titleHeightPorcent)+"%;");
	// alert( ((titlePx * 100)/height) );
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
		width:60%;
		text-shadow:1px 1px 2px #000;
	}
	.titleStyle .right{
		float:right;
		text-align:right;
		width:40%;
		text-shadow:1px 1px 2px #000;
	}
	.buttonStyle{
		height:100vh;
		background:#00000033;border:none;color:#FFFFFF55;font-size:2vh;padding:0 1vh;margin:0;
	}
	.buttonNext{
		position:fixed;
		bottom:0%;
		right:0%;
		<?=$anchoFlechas; ?>;
	}
	.buttonBack{
		position:fixed;
		bottom:0%;
		left:0%;
		<?=$anchoFlechas; ?>;
	}
	.buttonStyle:hover{
		background:#00000055;
		color:#FFFFFF99;
	}
</style>
</body>
</html>
