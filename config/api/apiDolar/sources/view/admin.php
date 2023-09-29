<?php 

if(!empty($_POST)){
	// print_r($_POST['coins']);
	if(!empty($_POST['evento']) && $_POST['evento'] == "refrescarCoin"){
		$json = [];
		$i = 0;
		foreach ($_POST['coins'] as $data) {
			
			$json += [$i=>['name'=>strtoupper($data),]
			];

			$i++;
		}
		if(file_exists("sources/file/coins.json")){
			$file = "sources/file/coins.json";
			file_put_contents($file, json_encode($json));
		}
		// echo json_encode($json);
		$_SESSION['refresh']=1;
	}

	if(!empty($_POST['font']) && !empty($_POST['maxTime']) && !empty($_POST['maxLimite']) && !empty($_POST['minLimite'])){
		$datos_app = file_get_contents("sources/file/app.json");
		$array_app = json_decode($datos_app, true);
			$array_app['font']=$_POST['font'];
			$array_app['maxTime']=$_POST['maxTime'];
			$array_app['maxLimite']=number_format($_POST['maxLimite'], 2, '.', '');
			$array_app['minLimite']=number_format($_POST['minLimite'], 2, '.', '');
		if(file_exists("sources/file/app.json")){
			$file = "sources/file/app.json";
			file_put_contents($file, json_encode($array_app));
		}
	}
	if(!empty($_POST['api_keyT']) && !empty($_POST['api_secretT'])){
		$datos_binance = file_get_contents("sources/file/binance.json");
		$array_binance = json_decode($datos_binance, true);
			$array_binance['api_key']=$_POST['api_keyT'];
			$array_binance['api_secret']=$_POST['api_secretT'];
		if(file_exists("sources/file/binance.json")){
			$file = "sources/file/binance.json";
			file_put_contents($file, json_encode($array_binance));
		}
	}
	if(!empty($_POST['tokenT']) && !empty($_POST['idT'])){
		$datos_telegram = file_get_contents("sources/file/telegram.json");
		$array_telegram = json_decode($datos_telegram, true);
			$array_telegram['token']=$_POST['tokenT'];
			$array_telegram['id']=$_POST['idT'];
		if(file_exists("sources/file/telegram.json")){
			$file = "sources/file/telegram.json";
			file_put_contents($file, json_encode($array_telegram));
		}
	}
	// print_r($_POST);



	header("location:?admin");
}else{
	$opacity="dd";
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>Admin PROSIGNAL</title>
	<link rel="shortcut icon" type="image/k-icon" href="sources/img/log.png">

</head>
<body class="background" style="">
<!-- <body style="margin:0;padding:0;background:#ccc;font-family:'Arial'"> -->


	<div style="width:100%;background:#434343;color:#fff;text-align:center;padding:1% 0px;margin:1% auto 3% auto;">
	<!-- <img src="sources/img/log.png" style="border-radius:100%;width:8%;"> -->
			<b style="font-size:2em;">
				ADMIN PROSIGNAL
			</b>
	</div>
	

	<?php 
		$datos_clientes = file_get_contents("sources/file/coins.json");
		$json_clientes = json_decode($datos_clientes, true);
		foreach ($json_clientes as $json) {$coins[] = $json['name'];}
	?>
	<div class='maxWidth' style="">
		<h2><?=strtoupper("Criptomonedas")?></h2>
		<button class="agregarCoin">Agregar</button>
		<br>
		<br>
		<div class="d-none addCoin" style="background:#434343<?=$opacity?>;padding:5px 20px 20px 20px;border-radius:20px;width:100%;box-sizing:border-box;">
			<h3 style="margin-top:2px;margin-bottom:0px;font-size:1.4em;color:#fff">Agregar Coin</h3>
			<br>
			<form action="" method="post" class="addCoin">
				<?php foreach ($coins as $data): ?>
					<input type="hidden" name="coins[]" class="<?php echo $data ?>" value="<?php echo $data ?>">
				<?php endforeach ?>
				<input type="text" style="width:80%;padding:5px 10px;font-size:1.3em;text-transform:uppercase;" name="coins[]" id="newCampoCoin">
				<input type="reset" class="limpiar" value="Limpiar">
				<input type="hidden" name="evento" value="refrescarCoin">
				<br><br>
				<button class="enviarcoin" disabled="">Enviar</button>
			</form>
		</div>
		<br>
		
		<select style="width:100%;max-height:30vh;min-height:30vh;font-size:1.1em;box-sizing:border-box;background:#ffffff<?=$opacity?>;" class="coins" multiple="">
			<?php $x=0; foreach ($coins as $data): ?>
				<option <?php if($x%2==0){echo 'style="background:#ddd"';} ?> >
				<?php echo $data; ?>
				</option>
			<?php $x++; endforeach ?>
		</select>
		<br><br>

		<div style="background:#434343<?=$opacity?>;padding:5px 20px 20px 20px;border-radius:20px;width:100%;box-sizing:border-box;">
			<h3 style="margin-top:2px;margin-bottom:0px;font-size:1.4em;color:#fff">Editar Coin</h3>
			<br>
			<form>
				<input type="text" style="width:80%;padding:5px 10px;font-size:1.3em;text-transform:uppercase;" id="campo" readonly="">
				<input type="reset" class="limpiar" value="Cancelar">
			</form>
			<br>
			<button class="optionsCampo optionsCampoEditar" disabled="">Editar</button>
			<button class="optionsCampo optionsCampoEliminar" disabled="">Eliminar</button>
			<button class="optionsCampo2 optionsCampoEnviar d-none">Enviar</button>
			<button class="optionsCampo2 optionsCampoCancelar d-none">Cancelar</button>
		</div>
			
		<form action="" method="post" class="newcoins">
		<?php foreach ($coins as $data): ?>
			<input type="hidden" name="coins[]" class="<?php echo $data ?>" value="<?php echo $data ?>">
			
		<?php endforeach ?>
			<input type="hidden" name="evento" value="refrescarCoin">
		</form>
		<input type="hidden" class="xd">
	</div>


	<?php 
		$datos_app = file_get_contents("sources/file/app.json");
		$array_app = json_decode($datos_app, true);
		// $array_app = $array_app[0];
	?>
	<div class='maxWidth' style="">
		<h2><?=strtoupper("Bot")?></h2>
		<span style="font-size:1.1em;"><b>Fuente</b></span>
			
			<input type="" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="font" readonly="" class="disabled box1" value="<?=$array_app['font']?>">
			<br><input type="hidden" class="b1hidden" value="<?=$array_app['font']?>">
		<br><br>

		<span style="font-size:1.1em;"><b>Tiempo Limite en Segundos</b> (<span class="tiempoRealSeconds"></span>)</span>
			
			<input type="number" step="1" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="maxTime" readonly="" class="disabled box2" value="<?=$array_app['maxTime']?>">
			<br><input type="hidden" class="b2hidden" value="<?=$array_app['maxTime']?>">
		<br><br>

		<span style="font-size:1.1em;"><b>Limite de Subida</b></span>
			
			<input type="number" step="0.01" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="maxLimite" readonly="" class="disabled box3" value="<?=$array_app['maxLimite']?>">
			<br><input type="hidden" class="b3hidden" value="<?=$array_app['maxLimite']?>">
		<br><br>

		<span style="font-size:1.1em;"><b>Limite de Bajada</b></span>
			
			<input type="number" step="0.01" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="minLimite" readonly="" class="disabled box4" value="<?=$array_app['minLimite']?>">
			<br><input type="hidden" class="b4hidden" value="<?=$array_app['minLimite']?>">
		<br><br>
		<form action="" method="post">
			<input type="hidden" name="font" class="b1">
			<input type="hidden" name="maxTime" class="b2">
			<input type="hidden" name="maxLimite" class="b3">
			<input type="hidden" name="minLimite" class="b4">

			<button class="guardarApp envtApp d-none">Guardar</button>
			<input type="button" class="cancelarApp envtApp d-none" value="Cancelar">
		</form>
		<button class="editarApp">Editar</button>
	</div>

	<div style="clear:both;"></div>



	<?php 
		$datos_binance = file_get_contents("sources/file/binance.json");
		$array_binance = json_decode($datos_binance, true);
	?>
	<div class='maxWidth' style="">
		<h2><?=strtoupper("Api Binance")?></h2>
		<span style="font-size:1.1em;"><b>API Key</b></span>
			
			<input type="text" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="api_key" readonly="" class="disabled boxapi_key" value="<?=$array_binance['api_key']?>">
			<br><input type="hidden" class="api_keyThidden" value="<?=$array_binance['api_key']?>">
		<br><br>

		<span style="font-size:1.1em;"><b>API Secret</b></span>
			
			<input type="text" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="api_secret" readonly="" class="disabled boxapi_secret" value="<?=$array_binance['api_secret']?>">
			<br><input type="hidden" class="api_secretThidden" value="<?=$array_binance['api_secret']?>">
		<br><br>
		<form action="" method="post">
			<input type="hidden" name="api_keyT" class="api_keyT">
			<input type="hidden" name="api_secretT" class="api_secretT">

			<button class="guardarBinance envtBinance d-none">Guardar</button>
			<input type="button" class="cancelarBinance envtBinance d-none" value="Cancelar">
		</form>
		<button class="editarBinance">Editar</button>
	</div>

	


	<?php 
		$datos_telegram = file_get_contents("sources/file/telegram.json");
		$array_telegram = json_decode($datos_telegram, true);
	?>
	<div class='maxWidth' style="">
		<h2><?=strtoupper("Api Telegram")?></h2>
		<span style="font-size:1.1em;"><b>Token</b></span>
			
			<input type="text" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="token" readonly="" class="disabled boxtoken" value="<?=$array_telegram['token']?>">
			<br><input type="hidden" class="tokenThidden" value="<?=$array_telegram['token']?>">
		<br><br>

		<span style="font-size:1.1em;"><b>Identificador del Grupo / Canal</b></span>
			
			<input type="text" style="padding:1% 2%;width:95%;margin:1% auto;border:1px solid #aaa;border-radius:2.5px;" name="id" readonly="" class="disabled boxid" value="<?=$array_telegram['id']?>">
			<br><input type="hidden" class="idThidden" value="<?=$array_telegram['id']?>">
		<br><br>
		<form action="" method="post">
			<input type="hidden" name="tokenT" class="tokenT">
			<input type="hidden" name="idT" class="idT">

			<button class="guardarTelegram envtTelegram d-none">Guardar</button>
			<input type="button" class="cancelarTelegram envtTelegram d-none" value="Cancelar">
		</form>
		<button class="editarTelegram">Editar</button>
	</div>


	<div style="clear:both;"></div>
	
	<br><br>
	<br><br>


<style>
.disabled{
	background:#ccc;
}
.d-none{
	display:none;
}
.maxWidth{
	width:48%;
	margin:1% 1%;
	padding:0% 2% 2% 2%;
	float:left;
	box-sizing:border-box;
	border-radius:20px;
	border:1px solid #ddd;
	background:#ffffff<?=$opacity?>;
}
.background{
	margin:0;
	padding:0;
	background:url('sources/img/log.png');
	background-attachment:fixed;
	background-size:100% 100%;
	font-family:'Arial';
}
@media screen and (max-width:1024px){
	.maxWidth{
		width:98%;
		margin:2% 1%;
	}
	.background{
		background:url('sources/img/log3.png');
	}
}
</style>

<script src="sources/assets/jquery.min.js"></script>
<?php if(!empty($_SESSION['refresh'])){?> 
<input type="hidden" class="refresh" value="<?php echo $_SESSION['refresh'] ?>">
<?php unset($_SESSION['refresh']); } ?>

<script>


$(document).ready(function(){

	if($(".refresh").val()==1){
		alert("Lista de Coins actualizada");
	}
	$(".optionsCampo2").hide();
	$(".optionsCampo2").removeClass("d-none");

	$(".coins option").click(function(){
		var coin = $(this).val();
		$("#campo").val(coin);
		var x = $("#campo").val();
		if(x.length == 0){
			$(".optionsCampo").attr("disabled");			
			$("#campo").addClass("disabled");			
		}else{
			$(".optionsCampo").removeAttr("disabled");
		}
	});
	$("#campo").addClass("disabled");			
	$(".limpiar").click(function(){
		$("#campo").addClass("disabled");			
		$(".optionsCampo").attr("disabled","1");			
	});
	$(".optionsCampoEliminar").click(function(){
		var x = $("#campo").val();
		$("."+x).attr("disabled","1");
		$(".newcoins").submit();
	});
	$(".addCoin").hide();
	$(".addCoin").removeClass("d-none");
	$(".agregarCoin").click(function(){
		$(".addCoin").slideToggle(500);
	});
	$("#newCampoCoin").keyup(function(){
		var x = $(this).val();
		if(x.length > 2){
			$(".enviarcoin").removeAttr("disabled");
		}else{
			$(".enviarcoin").attr("disabled",1);			
		}
	});

	$(".optionsCampoEditar").click(function(){
		var x = $("#campo").val();
		$("#campo").removeAttr("readonly");
		$("#campo").removeClass("disabled");
		$("."+x).val(x);
		$(".optionsCampo").hide();
		$(".optionsCampo2").show();
		$(".xd").val(x);
		$(".coins option").attr("disabled",1);
	});
	$(".optionsCampoCancelar").click(function(){
		$(".limpiar").click();
		$(".optionsCampo").show();
		$(".optionsCampo2").hide();
		$(".xd").val("");
		$(".optionsCampoEnviar").removeAttr("disabled");
		$(".coins option").removeAttr("disabled");

	});
	$("#campo").keyup(function(){
		var x = $(this).val();
		if(x.length > 2){
			$(".optionsCampoEnviar").removeAttr("disabled");
		}else{
			$(".optionsCampoEnviar").attr("disabled",1);			
		}
	});
	$(".optionsCampoEnviar").click(function(){
		var y = $("#campo").val();
		var x = $(".xd").val();
		if(x.length > 2){
			$(".enviarcoin").removeAttr("disabled");
		}else{
			$(".enviarcoin").attr("disabled",1);			
		}
		$("."+x).val(y.toUpperCase());
		$(".newcoins").submit();
	});


	$(".editarApp").click(function(){
		$(".box1").removeClass("disabled");
		$(".box1").removeAttr("readonly");

		$(".box2").removeClass("disabled");
		$(".box2").removeAttr("readonly");

		$(".box3").removeClass("disabled");
		$(".box3").removeAttr("readonly");

		$(".box4").removeClass("disabled");
		$(".box4").removeAttr("readonly");

		$(".envtApp").removeClass("d-none");
		$(this).addClass("d-none");
	});
	$(".cancelarApp").click(function(){

		$(".box1").addClass("disabled");
		$(".box1").attr("readonly","1");

		$(".box2").addClass("disabled");
		$(".box2").attr("readonly","1");

		$(".box3").addClass("disabled");
		$(".box3").attr("readonly","1");

		$(".box4").addClass("disabled");
		$(".box4").attr("readonly","1");

		$(".editarApp").removeClass("d-none");
		$(".envtApp").addClass("d-none");

		$(".b1").val($(".b1hidden").val());
		$(".b2").val($(".b2hidden").val());
		$(".b3").val($(".b3hidden").val());
		$(".b4").val($(".b4hidden").val());

		$(".box1").val($(".b1hidden").val());
		$(".box2").val($(".b2hidden").val());
		$(".box3").val($(".b3hidden").val());
		$(".box4").val($(".b4hidden").val());
		var seconds = $(".box2").val();
		$(".tiempoRealSeconds").html(convertirTiempo(seconds));
	});


	$(".b1").val($(".box1").val());
	$(".box1").keyup(function(){
		$(".b1").val($(this).val());
	});
	$(".box1").change(function(){
		$(".b1").val($(this).val());
	});

	$(".b2").val($(".box2").val());
	var seconds = $(".box2").val();
	$(".tiempoRealSeconds").html(convertirTiempo(seconds));
	$(".box2").keyup(function(){
		var seconds = $(".box2").val();
		$(".tiempoRealSeconds").html(convertirTiempo(seconds));
		$(".b2").val($(this).val());
	});
	$(".box2").change(function(){
		var seconds = $(".box2").val();
		$(".tiempoRealSeconds").html(convertirTiempo(seconds));
		$(".b2").val($(this).val());
	});

	$(".b3").val($(".box3").val());
	$(".box3").keyup(function(){
		$(".b3").val($(this).val());
	});
	$(".box3").change(function(){
		$(".b3").val($(this).val());
	});

	$(".b4").val($(".box4").val());
	$(".box4").keyup(function(){
		$(".b4").val($(this).val());
	});
	$(".box4").change(function(){
		$(".b4").val($(this).val());
	});



	$(".tokenT").val($(".boxtoken").val());
	$(".boxtoken").keyup(function(){
		$(".tokenT").val($(this).val());
	});
	$(".boxtoken").change(function(){
		$(".tokenT").val($(this).val());
	});
	$(".idT").val($(".boxid").val());
	$(".boxid").keyup(function(){
		$(".idT").val($(this).val());
	});
	$(".boxid").change(function(){
		$(".idT").val($(this).val());
	});

	$(".editarTelegram").click(function(){
		$(".boxtoken").removeClass("disabled");
		$(".boxtoken").removeAttr("readonly");

		$(".boxid").removeClass("disabled");
		$(".boxid").removeAttr("readonly");

		$(".envtTelegram").removeClass("d-none");
		$(this).addClass("d-none");
	});

	$(".cancelarTelegram").click(function(){

		$(".boxtoken").addClass("disabled");
		$(".boxtoken").attr("readonly","1");

		$(".boxid").addClass("disabled");
		$(".boxid").attr("readonly","1");

		$(".editarApp").removeClass("d-none");
		$(".envtApp").addClass("d-none");

		$(".tokenT").val($(".tokenThidden").val());
		$(".idT").val($(".idThidden").val());

		$(".boxtoken").val($(".tokenThidden").val());
		$(".boxid").val($(".idThidden").val());

		$(".editarTelegram").removeClass("d-none");
		$(".envtTelegram").addClass("d-none");
	});





	$(".api_keyT").val($(".boxapi_key").val());
	$(".boxapi_key").keyup(function(){
		$(".api_keyT").val($(this).val());
	});
	$(".boxapi_key").change(function(){
		$(".api_keyT").val($(this).val());
	});
	$(".api_secretT").val($(".boxapi_secret").val());
	$(".boxapi_secret").keyup(function(){
		$(".api_secretT").val($(this).val());
	});
	$(".boxapi_secret").change(function(){
		$(".api_secretT").val($(this).val());
	});

	$(".editarBinance").click(function(){
		$(".boxapi_key").removeClass("disabled");
		$(".boxapi_key").removeAttr("readonly");

		$(".boxapi_secret").removeClass("disabled");
		$(".boxapi_secret").removeAttr("readonly");

		$(".envtBinance").removeClass("d-none");
		$(this).addClass("d-none");
	});

	$(".cancelarBinance").click(function(){

		$(".boxapi_key").addClass("disabled");
		$(".boxapi_key").attr("readonly","1");

		$(".boxapi_secret").addClass("disabled");
		$(".boxapi_secret").attr("readonly","1");

		$(".editarApp").removeClass("d-none");
		$(".envtApp").addClass("d-none");

		$(".api_keyT").val($(".api_keyThidden").val());
		$(".api_secretT").val($(".api_secretThidden").val());

		$(".boxapi_key").val($(".api_keyThidden").val());
		$(".boxapi_secret").val($(".api_secretThidden").val());

		$(".editarBinance").removeClass("d-none");
		$(".envtBinance").addClass("d-none");
	});


});
function cargar(){
	$(".b1").val($(".box1").val());
		$(".b2").val($(".box2").val());
		$(".b3").val($(".box3").val());
		$(".b4").val($(".box4").val());
}
function convertirTiempo(sec){
	var min = 0;
	if(sec>=60){
		while((sec-60)>=0){
			min++;
			sec -= 60;
		}
	}
	var hours = 0;
	if(min>=60){
		while((min-60)>=0){
			hours++;
			min -= 60;
		}
	}
	if(hours.toString().length==1){ hours = "0"+hours; }
	if(min.toString().length==1){ min = "0"+min; }
	if(sec.toString().length==1){ sec = "0"+sec; }
	var newTime = hours+":"+min+":"+sec;
	return newTime;
}

</script>
</body>
</html>
<?php } ?>