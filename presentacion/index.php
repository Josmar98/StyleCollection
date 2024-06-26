<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Home</title>
	<?php require_once '../presentacion/headers.php'; ?>
	<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>
<body style="font-family:'arial';background:#FFF;margin:0;padding:0;">
<?php
	$opcion = false;
	$presentacion = [];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion1', 'imagen'=>'./pantalla1.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion2', 'imagen'=>'./pantalla2.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion3', 'imagen'=>'./pantalla3.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion4', 'imagen'=>'./pantalla4.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion5', 'imagen'=>'./pantalla5.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion6', 'imagen'=>'./pantalla6.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion7', 'imagen'=>'./pantalla7.jpg'];
	$presentacion[count($presentacion)]=['nombre'=>'Presentacion8', 'imagen'=>'./pantalla8.jpg'];

	$num=1;
	foreach ($presentacion as $presentar){
		if($num==1){
			$class = '';	
		} else {
			$class = ($num%2==0) ? "fade-right" : "fade-left";
		}
		?>
		<div style="" class="box1content<?=$num;  ?>" style="margin:0;padding:0;background:red;">
			<?php if($opcion){ ?>
			<div id="0" class="box<?=$num; ?>" style="color:#FFf;background:#222;opacity:0.4;position:absolute;width:100%;padding:5px;">
				<span style="float:left;margin-left:3%;"><?=$presentar['nombre']; ?></span>
				<span style="float:right;margin-right:3%;"><a href="<?=$presentar['imagen']; ?>" download="<?=$presentar['nombre']; ?>" target="_blank"><b>Descargar</b></a></span>
			</div>
			<?php } ?>

			<div style="" class="boxContent" id="<?=$num; ?>" style="margin:0;padding:0;position:absolute;top:0;left:0;width:100%;height:100vh;">
				<div  data-aos="<?=$class; ?>" data-aos-duration="3000">
					<img src="<?=$presentar['imagen']; ?>" style="max-width:100%;width:100%;">
				</div>
			</div>
		</div>
		<?php $num++;
	}
	require_once '../presentacion/footered.php';
?>
	<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script> AOS.init(); </script>
<!-- 
// FADE
<div data-aos="fade-up"></div>
<div data-aos="fade-down"></div>
<div data-aos="fade-right"></div>
<div data-aos="fade-left"></div>
<div data-aos="fade-up-right"></div>
<div data-aos="fade-up-left"></div>
<div data-aos="fade-down-right"></div>
<div data-aos="fade-down-left"></div>

// FLIP
<div data-aos="flip-up"></div>
<div data-aos="flip-down"></div>
<div data-aos="flip-right"></div>
<div data-aos="flip-left"></div>

// ZOOM
<div data-aos="zoom-in"></div>
<div data-aos="zoom-in-up"></div>
<div data-aos="zoom-in-down"></div>
<div data-aos="zoom-in-left"></div>
<div data-aos="zoom-in-right"></div>
<div data-aos="zoom-out"></div>
<div data-aos="zoom-out-up"></div>
<div data-aos="zoom-out-down"></div>
<div data-aos="zoom-out-right"></div>
<div data-aos="zoom-out-left"></div>

// DIFFERENT SETTINGS EXAMPLES
<div data-aos="fade-up" data-aos-duration="3000"></div>
<div data-aos="fade-down" data-aos-easing="linear" data-aos-duration="1500"></div>
<div data-aos="fade-right" data-aos-offset="300" data-aos-easing="ease-in-sine"></div>
<div data-aos="fade-left" data-aos-anchor="#example-anchor" data-aos-offset="500" data-aos-duration="500"></div>
<div data-aos="fade-zoom-in" data-aos-easing="ease-in-back" data-aos-delay="300" data-aos-offset="0"></div>
<div data-aos="flip-left" data-aos-easing="ease-out-cubic" data-aos-duration="2000"></div>

//ANCHOR PLACEMENT
<div data-aos="fade-up" data-aos-anchor-placement="top-bottom"></div>
<div data-aos="fade-up" data-aos-anchor-placement="center-bottom"></div>
<div data-aos="fade-up" data-aos-anchor-placement="bottom-bottom"></div>
<div data-aos="fade-up" data-aos-anchor-placement="top-center"></div>
<div data-aos="fade-up" data-aos-anchor-placement="center-center"></div>
-->

<script>
$(document).ready(function(){
	$(".boxContent").click(function(){
		var n = $(this).attr("id");
		var status = $(".box"+n).attr("id");
		if(status==1){
			$(".box"+n).attr("id", 0);
			$(".box"+n).fadeOut(300);
		}else{
			$(".box"+n).attr("id", 1);
			$(".box"+n).fadeIn(300);
		}
	});
});
</script>
</body>
</html>
