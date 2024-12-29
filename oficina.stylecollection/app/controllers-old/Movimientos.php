<?php 

$amMovimientos = 0;
$amMovimientosR = 0;
$amMovimientosC = 0;
$amMovimientosE = 0;
$amMovimientosB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Movimientos Bancarios"){
      $amMovimientos = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amMovimientosR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amMovimientosC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amMovimientosE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amMovimientosB = 1;
      }
    }
  }
}
if($amMovimientosC == 1){
	if(!empty($_POST['val']) && !empty($_POST['formatNumber'])){
		$num = number_format($_POST['val'],2,',','.');
		echo $num;
	}
	if(!empty($_POST['detalles'])){
		$component = "";
		$id_pago = $_POST['id_pago'];
		$rangoI = $_POST['rangoI'];
		$rangoF = $_POST['rangoF'];
		$id_banco = $_POST['banco'];
		if(!empty($banco)){
			$component .= " and bancos.id_banco = ".$id_banco;
		}
		if(!empty($rangoI) && !empty($rangoF)){
			$component .= " and movimientos.fecha_movimiento BETWEEN '{$rangoI}' and '{$rangoF}'";
		}
		if(!empty($id_pago)){
			$component .= " and pagos.id_pago = '{$id_pago}'";
		}
		$queryFirmas = "SELECT * FROM bancos, movimientos, pagos, pedidos, clientes, usuarios WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 and clientes.id_cliente = usuarios.id_cliente and movimientos.estado_movimiento = 'Firmado' and movimientos.id_pago = pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente 
		{$component}
		 ORDER BY fecha_movimiento DESC;";
		// echo $queryFirmas;
		$firmas=$lider->consultarQuery($queryFirmas);
		if(count($firmas)>1){
			$array['data'] = $firmas[0];
			$array['ejecucion'] = true;
		}else{
			$array['ejecucion'] = false;
		}
		echo json_encode($array);
		// echo $queryFirmas;

	}
	$complement = "";
	if(!empty($_GET['Banco'])){
		$id_banco = $_GET['Banco'];
		if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
			$rangoI = $_GET['rangoI'];
			$rangoF = $_GET['rangoF'];
			// $movimientos=$lider->consultarQuery("SELECT * FROM bancos, movimientos, pagos, pedidos, clientes WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 and bancos.id_banco = {$id_banco} and movimientos.fecha_movimiento BETWEEN '{$rangoI}' and '{$rangoF}' ORDER BY fecha_movimiento desc;");
			$complement = "and bancos.id_banco = {$id_banco} and movimientos.fecha_movimiento BETWEEN '{$rangoI}' and '{$rangoF}'";
		}else{
			$complement = "and bancos.id_banco = {$id_banco}";
			// $movimientos=$lider->consultarQuery("SELECT * FROM bancos, movimientos WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 and bancos.id_banco = {$id_banco} ORDER BY fecha_movimiento desc;");
		}
	}else{
		if(!empty($_GET['rangoI']) && !empty($_GET['rangoF'])){
			$rangoI = $_GET['rangoI'];
			$rangoF = $_GET['rangoF'];
			$complement = "and movimientos.fecha_movimiento BETWEEN '{$rangoI}' and '{$rangoF}'";
			// $movimientos=$lider->consultarQuery("SELECT * FROM bancos, movimientos WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 and movimientos.fecha_movimiento BETWEEN '{$rangoI}' and '{$rangoF}' ORDER BY fecha_movimiento desc;");
		}else{
			$complement = "";
			// $movimientos=$lider->consultarQuery("SELECT * FROM bancos, movimientos WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 {$complement} ORDER BY fecha_movimiento DESC;");
		}
	}
	// echo $complement;
		$queryMov = "SELECT * FROM bancos, movimientos WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 {$complement} ORDER BY fecha_movimiento DESC;";
			$movimientos=$lider->consultarQuery($queryMov);
	// echo $queryMov;
	// echo "<br><br>";
		// $queryFirmas = "SELECT * FROM bancos, movimientos, pagos, pedidos, clientes, usuarios WHERE bancos.id_banco = movimientos.id_banco and movimientos.estatus = 1 and clientes.id_cliente = usuarios.id_cliente and movimientos.estado_movimiento = 'Firmado' and movimientos.id_pago = pagos.id_pago and pagos.id_pedido = pedidos.id_pedido and pedidos.id_cliente=clientes.id_cliente {$complement} ORDER BY fecha_movimiento DESC;";
			// $firmas=$lider->consultarQuery($queryFirmas);

			// echo $queryMov;
			// echo "<br><br>";
			// echo $queryFirmas;
			// echo "<br><br>";
			// echo print_r($firmas);
			// echo "<br><br>";


	$bancos = $lider->consultarQuery("SELECT * FROM bancos WHERE estatus = 1");
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amMovimientosB == 1){

			$query = "UPDATE movimientos SET estatus = 0 WHERE id_movimiento = '$id'";
			$res1 = $lider->eliminar($query);

			if($res1['ejecucion']==true){
				$response = "1";

					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Movimientos', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

			if(!empty($action)){
				if (is_file('public/views/' .strtolower($url).'/'.$action.'movimientoss.php')) {
					require_once 'public/views/' .strtolower($url).'/'.$action.'movimientoss.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}else{
				if (is_file('public/views/Movimientoss.php')) {
					require_once 'public/views/Movimientoss.php';
				}else{
					require_once 'public/views/error404.php';
				}
			}
		}else{
			require_once 'public/views/error404.php';
		}
		die();
	}

	if(empty($_POST)){
		if($movimientos['ejecucion']==1){
			if(!empty($action)){
				if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
					require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}else{
				if (is_file('public/views/'.$url.'.php')) {
					require_once 'public/views/'.$url.'.php';
				}else{
				    require_once 'public/views/error404.php';
				}
			}

		}else{
			require_once 'public/views/error404.php';
		}
	}

}else{
    require_once 'public/views/error404.php';
}

?>