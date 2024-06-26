<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Home</title>
  <?php require_once 'public/views/assets/headers.php'; ?>
</head>
<body style="font-family:'arial';background:#FFF">
	<?php //require_once 'public/views/assets/top-menu.php'; ?>

	<?php
		$ruta = "https://stylecollection.org/?route=Lineas_de_productos";
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
	<div class="wrapper" style="">

		<?php
			$presentacion = [
				'public/assets/img/resources/2.24/fondo2.24.1.png',
				'public/assets/img/resources/2.24/fondo2.24.1.png',
				'public/assets/img/resources/2.24/fondo2.24.1.png',
				'public/assets/img/resources/2.24/fondo2.24.1.png',
				'public/assets/img/resources/2.24/fondo2.24.1.png',
			];

		?>

		<!-- <div style="max-width:100%;min-width:100%;width:100%;min-height:100vh;max-height:100vh;overflow:hidden;"> -->
			<?php
				$num=1;
				foreach ($presentacion as $presentar){
					?>
						<div style="" class="box1content<?=$num;  ?>">
							<div style="" class="box2content<?=$num;  ?>" style="position:absolute;top:0;left:0;width:100%;height:100vh;">
								<img src="<?=$presentar; ?>" style="max-width:100%;width:100%;">
							</div>
						</div>
					<?php
					$num++;
				}
			?>
			
		<!-- </div> -->
				
	</div>
	
<?php require_once 'public/views/assets/footered.php'; ?>
<?php //require_once 'public/views/assets/footer.php'; ?>
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