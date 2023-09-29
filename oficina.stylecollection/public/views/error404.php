<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>404 - Página no encontrada</title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="vistas/css/style.css" />
	<link rel="stylesheet" href="vistas/vendor/bootstrap/css/bootstrap.min.css">
 <?php require_once 'public/views/assets/headers.php'; ?>
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
	<!--[if lt IE 9]>
		  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
		  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
		<![endif]-->

</head>

<body style="padding:0% 2%">

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1>404</h1>
			<h2>Oops! Página no encontrada</h2>
			<p><br>La página que estás buscando no existe, fue removida, su nombre cambió o está temporalmente inhabilitada; disculpe las molestias.<br><br>
			<small><?php echo 'Página: '.$url; ?></small></p>
			<a onclick="regresarAtras()" id="link" class="btn" style="color:#FFF;background:<?php echo $color_btn_sweetalert ?>">Regresar</a>

		</div>
	</div>
<?php require_once 'public/views/assets/footered.php'; ?>
<!-- <script src="vistas/vendor/jquery/jquery.js"></script> -->
<!-- <script src="vistas/vendor/bootstrap/js/bootstrap.min.js"></script> -->
<!-- <script src="vistas/js/error404/volver.js"></script> -->
</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
