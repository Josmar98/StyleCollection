<?php

if(!empty($_POST)){
	if(!empty($_POST['file'])){
		$file = $_POST['file']; 
		// echo $file;
		echo unlink($file);
	}
	if(!empty($_POST['img']) && !empty($_POST['nombre']) && !empty($_POST['format'])){
		function subeimagen64temp($img, $nombre, $format) {
			$carpetaDestino = "./imgcodegenerate/";
			$img = str_replace('data:image/png;base64,', '', $img);
			$img = str_replace(' ', '+', $img);
			$data = base64_decode($img);
			// $file = $carpetaDestino . $nombre . '.png';
			$file = $carpetaDestino . $nombre . $format;
			echo "FILE: ".$file."\n\n";
			echo "DATA: ".$data."\n\n";
			$success = file_put_contents($file, $data);
			return $success;
		}
		$img = $_POST['img'];
		$nombre="qr-".$_POST['nombre'];
		$format = $_POST['format'];
		echo subeimagen64temp($img, $nombre, $format);
	}
}else{


?>
	<!DOCTYPE html>
	<html lang="es">

	<head>
		<meta charset="UTF-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<!--Puedes descargar el script e incluirlo de manera local si así prefieres-->
	    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
		<script src="https://unpkg.com/qrious@4.0.2/dist/qrious.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/0.5.0-beta4/html2canvas.min.js"></script>
		<title>Generar códigos QR</title>
	</head>

	<body>
		<div style="width:100%;text-align:center;">
	      <input type="text" name="barcode" style='width:80%;height:35px;border-radius:5px;border:1px solid #CCC;padding:2px 10px;' id="inputcode">
	      <br>
	      <button id="generarcodigo">Generar codigo QR</button>
	      <br>
	      <button style="display:none;" id="volverEscanear">Escanear Código</button>
	    </div>

		<br>
		<img alt="Código de Barra" id="codigo" style="display:none;">
		<br>
		<button class="btn btn-success" id="btndescargarcodigo" style="display:none;">
			Descargar Código QR
		</button>
		<!-- <a id="a" href="#" download="true" target="_blank">vamo a ve</a> -->
		
		<script>
			$(document).ready(function(){
				$("#generarcodigo").click(function(){
					var value = $("#inputcode").val();
					// "https://parzibyte.me/blog"

					new QRious({
						element: document.querySelector("#codigo"),
						value: value, // La URL o el texto
						size: 200,
						backgroundAlpha: 0, // 0 para fondo transparente
						foreground: "#000", // Color del QR
						level: "H", // Puede ser L,M,Q y H (L es el de menor nivel, H el mayor)
					});
					if(value!=""){
						$("#codigo").show();
						$("#btndescargarcodigo").show();

					}
				});
				$('#btndescargarcodigo').click(function(){
					var nombre = $("#inputcode").val();
					nombre = nombre.replace(/ /g,'');
					tomarImagenPorSeccion('codigo', nombre, ".png");
				});
			});


			function tomarImagenPorSeccion(div,nombre, format) {

				html2canvas(document.querySelector("#" + div)).then(canvas => {
					var img = canvas.toDataURL();
					console.log(img);
					base = "img=" + img + "&nombre=" + nombre + "&format="+format;
					$.ajax({
						type:"POST",
						url:'',
						data:base,
						success:function(respuesta) {
							alert(respuesta);	
							respuesta = parseInt(respuesta);
							if (respuesta > 0) {
								alert("Imagen creada con exito!");

								var source = "./imgcodegenerate/qr-"+nombre+format;

								// $("#a").attr("href", source);
								// $("#a").click();

								var a = document.createElement('a');
								a.download = 'qr-'+nombre;
								a.target = '_blank';
								a.href= source;
								a.click();

								var newbase = "file="+source;
								$.ajax({
									type:"POST",
									url:'',
									data:newbase,
									success:function(respuesta) {	
										respuesta = parseInt(respuesta);
										if (respuesta == 1) {
											
										}
									}
								});

							} else {
							}
						}
					});
				});	
			}
		</script>
	</body>

	</html>
<?php
}
?>