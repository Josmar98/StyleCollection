<!DOCTYPE html>
<html>
<head>
	<title>Style Colleccion - Posts</title>
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
		<div style="background:rgba(245,245,245,1);background-size:100% 100%;max-width:100%;min-width:100%;min-height:90vh;">
			<!-- <div style="" class="box1cintillo">
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
			</div> -->
			<section class="content">
				<div class="row">
					<div class="col-xs-12 col-md-8 col-md-offset-2">
						<div class="box" style="background:rgba(230,230,230,.5); !important;padding:1% 5%;">
						<h3 style="font-size:2em;"><b>Posts de Campañas</b></h3>
	
						<?php foreach ($campanas as $data): ?>
							<?php if (!empty($data['id_campana'])): ?>
								<?php 
									$numCamp = $data['numero_campana'];
									$anioCamp = $data['anio_campana'];
									$anioCamp = substr($data['anio_campana'], 2);
								?>
								<div class="box" style="box-shadow:0px 10px 15px #CCC">
									<div class="box-header">
										<h3 class="box-title" style="font-size:1.6em;">
											<b>
											<?php 
												echo "Campaña ";
												//.$data['numero_campana']."/".$data['anio_campana'];
											?>
											</b>
											<img src="public/assets/img/resources/cintillo_campana<?=$numCamp;?>.<?=$anioCamp;?>.png" style="width:15%;position:absolute;right:5%;">
										</h3>
									</div>
									<br>
									<div class="box-body">
										<div class="row">
											<div class="col-xs-10 col-xs-offset-1">
												<div style="width:100%;">
													<img src="public/assets/img/resources/emblema<?=$numCamp;?>.<?=$anioCamp;?>.png" style="max-width:100%;width:100%;margin:0 0% !important;">
												</div>
												<br>
												<h3>
													<a href="?route=PostsNum&id=<?=$data['id_campana']?>">
														<u>
															
													<?php print_r($data['nombre_campana']); ?>
														</u>	
													</a>
												</h3>
											</div>
										</div>
									</div>
								</div>
							<?php endif; ?>
						<?php endforeach; ?>
						</div>

					</div>
				</div>
			</section> 
		</div>


	   <?php require_once 'public/views/assets/aside-config.php'; ?>
	</div>
<?php require_once 'public/views/assets/footered.php'; ?>
<?php require_once 'public/views/assets/footer.php'; ?>
<?php require_once 'public/views/assets/stylesheet.php'; ?>
<style type="text/css">

</style>
<script>
$(document).ready(function(){

}); 
</script>
</body>
</html>
