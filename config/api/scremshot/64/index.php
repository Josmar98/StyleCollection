<?php 

	$conexion = mysqli_connect('localhost','root','','pruebas');
	$query  = "SELECT imagen FROM t_imagenes";
	$result = mysqli_query($conexion, $query);
	$datos = mysqli_fetch_row($result)[0];
	


	$img = $datos; // agrega a qui tu archivo base 64

	$img = str_replace('data:image/png;base64,', '', $img);
	$img = str_replace(' ', '+', $img);
	$data = base64_decode($img);
	$success = file_put_contents('prueba.jpg', $data);

 ?>