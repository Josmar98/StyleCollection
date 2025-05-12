<?php 

$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
	if($access['nombre_modulo'] == "Premios"){
	  $amInventario = 1;
	  if($access['nombre_permiso'] == "Registrar"){
		$amInventarioR = 1;
	  }
	  if($access['nombre_permiso'] == "Ver"){
		$amInventarioC = 1;
	  }
	  if($access['nombre_permiso'] == "Editar"){
		$amInventarioE = 1;
	  }
	  if($access['nombre_permiso'] == "Borrar"){
		$amInventarioB = 1;
	  }
	}
  }
}
if($amInventarioC == 1){
	if(!empty($_POST)){
		if(!empty($_POST['id_operacion']) && isset($_POST['transaccion']) && isset($_POST['concepto']) && isset($_POST['leyenda'])){
			$id_operacion=$_POST['id_operacion'];
			$transaccion=ucwords(mb_strtolower($_POST['transaccion']));
			$concepto=ucwords(mb_strtolower($_POST['concepto']));
			$leyenda=$_POST['leyenda'];
			$query="UPDATE operaciones SET transaccion='{$transaccion}', concepto='{$concepto}', leyenda='{$leyenda}' WHERE id_operacion={$id_operacion}";
			$exec = $lider->modificar($query);
			if($exec['ejecucion']==true){
				echo "1";
			}else{
				echo "2";
			}
		}
		if(!empty($_POST['id_operacion']) && !empty($_POST['fichaTecnicaDetalle'])){
			$id_operacion=$_POST['id_operacion'];
			$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE id_operacion={$id_operacion}");
			$results=[];
			if(count($operaciones)>1){
				$operacion=$operaciones[0];
				$results['msj']=1;
				// $results['data']=$operacion;
				$results['data']['tipo_operacion']=$operacion['tipo_operacion'];
				$results['data']['transaccion']=$operacion['transaccion'];
				$results['data']['concepto']=$operacion['concepto'];
				$results['data']['fecha_documento']=$lider->formatFechaSlash($operacion['fecha_documento']);

				$horaOp = substr($operacion['fecha_operacion'],11);
				$anioOp = substr($operacion['fecha_operacion'],0,4);
				$mesOp = substr($operacion['fecha_operacion'],5,2);
				$diaOp = substr($operacion['fecha_operacion'],8,2);
				$mesInt = (int) $mesOp;
				$mesOpTxt="";
				if($mesInt==1){ $mesOpTxt=" de Enero del "; }
				if($mesInt==2){ $mesOpTxt=" de Febrero del "; }
				if($mesInt==3){ $mesOpTxt=" de Marzo del "; }
				if($mesInt==4){ $mesOpTxt=" de Abril del "; }
				if($mesInt==5){ $mesOpTxt=" de Mayo del "; }
				if($mesInt==6){ $mesOpTxt=" de Junio del "; }
				if($mesInt==7){ $mesOpTxt=" de Julio del "; }
				if($mesInt==8){ $mesOpTxt=" de Agosto del "; }
				if($mesInt==9){ $mesOpTxt=" de Septiembre del "; }
				if($mesInt==10){ $mesOpTxt=" de Octubre del "; }
				if($mesInt==11){ $mesOpTxt=" de Noviembre del "; }
				if($mesInt==12){ $mesOpTxt=" de Diciembre del "; }
				$fechaOperacion = $diaOp.$mesOpTxt.$anioOp;
				// $fechaOperacion = $diaOp."/".$mesOp."/".$anioOp;
				$results['data']['fecha_operacion']=$fechaOperacion." ".$horaOp;

				if($operacion['tipo_inventario']=="Productos"){
					$inventario = $lider->consultarQuery("SELECT *, codigo_producto as codigo, producto as elemento FROM productos WHERE id_producto={$operacion['id_inventario']}");
					$id_tipo_inventario=2;
				}
				if($operacion['tipo_inventario']=="Mercancia"){
					$inventario = $lider->consultarQuery("SELECT *, codigo_mercancia as codigo, mercancia as elemento FROM mercancia WHERE id_mercancia={$operacion['id_inventario']}");
					$id_tipo_inventario=3;
				}
				$results['data']['tipo_inventario']=$tipoInventarios[$id_tipo_inventario]['name'];
				if(count($inventario)>1){
					$inv = $inventario[0];
					$results['data']['codigo']=$inv['codigo'];
					$results['data']['elemento']=$inv['elemento'];
				}

				$results['data']['numero_documento']="";
				if(!empty($operacion['numero_documento'])){
					$numberCodes = "";
					$lenCode = strlen($operacion['numero_documento']);
					for ($i=0; $i < (9-$lenCode); $i++) { 
						$numberCodes.="0";
					}
					$results['data']['numero_documento']=$numberCodes.$operacion['numero_documento'];
				}
				$results['data']['numero_lote']="";
				if(!empty($operacion['numero_lote'])){
					$results['data']['numero_lote']=$operacion['numero_lote'];
				}
				$results['data']['tipo_persona']="";
				if(!empty($operacion['tipo_persona'])){
					$results['data']['tipo_persona']=$operacion['tipo_persona'];
					if($operacion['tipo_persona']=="Autorizado"){
						$autorizado = $infoInternos[$operacion['id_personal']];
						$results['data']['persona']=$autorizado['primer_nombre']." ".$autorizado['segundo_nombre']." ".$autorizado['primer_apellido']." ".$autorizado['segundo_apellido'];
						$results['data']['rif_persona']=$autorizado['cod_rif']."-".$autorizado['rif'];
					}
					if($operacion['tipo_persona']=="Cliente"){
						$clientes = $lider->consultarQuery("SELECT * FROM clientes WHERE id_cliente={$operacion['id_personal']}");
						$cliente=$clientes[0];
						$results['data']['persona']=$cliente['primer_nombre']." ".$cliente['segundo_nombre']." ".$cliente['primer_apellido']." ".$cliente['segundo_apellido'];
						$results['data']['rif_persona']=$cliente['cod_rif']."-".$cliente['rif'];
					}
					if($operacion['tipo_persona']=="Empleado"){
						$empleados = $lider->consultarQuery("SELECT * FROM empleados WHERE id_empleado={$operacion['id_personal']}");
						$empleado=$empleados[0];
						$results['data']['persona']=$empleado['primer_nombre']." ".$empleado['segundo_nombre']." ".$empleado['primer_apellido']." ".$empleado['segundo_apellido'];
						$results['data']['rif_persona']=$empleado['cod_rif']."-".$empleado['rif'];
					}
					if($operacion['tipo_persona']=="Proveedor"){
						$proveedores = $lider->consultarQuery("SELECT * FROM proveedores_inventarios WHERE id_proveedor_inventario={$operacion['id_personal']}");
						$proveedor=$proveedores[0];	
						$results['data']['persona']=$proveedor['nombreProveedor'];
						$results['data']['rif_persona']=$proveedor['codRif']."-".$proveedor['rif'];
					}
					
				}else{
					$results['data']['persona']="";
					$results['data']['rif_persona']="";
				}
				$stock=(int) $operacion['stock_operacion'];
				$total_costo=(float) number_format($operacion['total_operacion'],2,'.','');
				$costo_unitario=($total_costo/$stock);
				$results['data']['cant']="".$stock."";
				$results['data']['costo_unitario']=number_format($costo_unitario,2,',','.');
				$results['data']['total_costo']=number_format($total_costo,2,',','.');
				
			}else{
				$results['msj']=2;
			}
			echo json_encode($results);
		}
	}
	

	// echo "PRODUCTOSSS<br>";
	// foreach ($productoss as $key) {
	// 	print_r($key);
	// 	echo "<br><br>";
	// }

	// echo "MERCANCIASS<br>";
	// foreach ($mercancias as $key) {
	// 	print_r($key);
	// 	echo "<br><br>";
	// }

	// if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
	// 	if($amInventarioB == 1){

	// 		$query = "UPDATE mercancia SET estatus = 0 WHERE codigo_mercancia = '$cod'";
	// 		$res1 = $lider->eliminar($query);

	// 		if($res1['ejecucion']==true){
	// 			$response = "1";

	// 				if(!empty($modulo) && !empty($accion)){
	// 					$fecha = date('Y-m-d');
	// 					$hora = date('H:i:a');
	// 					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Productos', 'Borrar', '{$fecha}', '{$hora}')";
	// 					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
	// 				}
	// 		}else{
	// 			$response = "2"; // echo 'Error en la conexion con la bd';
	// 		}
	// 	}else{
	// 		require_once 'public/views/error404.php';
	// 	}
	// }
	if(empty($_POST)){

		if(!empty($_GET['delete'])){
			$id_operacion_delete = $_GET['delete'];
			$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 and id_operacion={$id_operacion_delete}");
			$id_inventario = $operaciones[0]['id_inventario'];
			$tipo_inventario = $operaciones[0]['tipo_inventario'];
			$id_almacen = $operaciones[0]['id_almacen'];
			$stock_operacion = $operaciones[0]['stock_operacion'];
			$tipo_operacion = $operaciones[0]['tipo_operacion'];
			
			
			$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 and id_inventario={$id_inventario} and tipo_inventario='{$tipo_inventario}' and id_almacen={$id_almacen} ORDER BY id_operacion DESC;");
			$operacion=$operaciones[0];
			// print_r($operacion);

			$stock = $operacion['stock_operacion'];
			$total_operacion = $operacion['total_operacion'];
			$precioUnitario = $total_operacion/$stock;
			$stock_almacen = $operacion['stock_operacion_almacen'];
			$total_almacen = $operacion['total_operacion_almacen'];
			if($tipo_operacion=="Salida"){
				$nuevo_stock_almacen = $stock_almacen+$stock_operacion;
			}
			if($tipo_operacion=="Entrada"){
				$nuevo_stock_almacen = $stock_almacen-$stock_operacion;
			}
			$nuevo_total_almacen = $nuevo_stock_almacen*$precioUnitario;
			$operaciones = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 andid_inventario={$id_inventario} and tipo_inventario='{$tipo_inventario}' and id_almacen={$id_almacen} and id_operacion<>{$id_operacion_delete} ORDER BY id_operacion DESC;");
			$operacion=$operaciones[0];
			$id_operacion = $operacion['id_operacion'];
			$query1="UPDATE operaciones SET stock_operacion_almacen={$nuevo_stock_almacen}, total_operacion_almacen={$nuevo_total_almacen} WHERE id_operacion={$id_operacion}";


			$operacionesG = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 andid_inventario={$id_inventario} and tipo_inventario='{$tipo_inventario}' ORDER BY id_operacion DESC;");
			$operacion=$operacionesG[0];
			$id_operacion = $operacion['id_operacion'];
			$stock = $operacion['stock_operacion'];
			$total_operacion = $operacion['total_operacion'];
			$precioUnitario = $total_operacion/$stock;
			$stock_total = $operacion['stock_operacion_total'];
			$total_total = $operacion['total_operacion_total'];
			if($tipo_operacion=="Salida"){
				$nuevo_stock_total = $stock_total+$stock_operacion;
			}
			if($tipo_operacion=="Entrada"){
				$nuevo_stock_total = $stock_total-$stock_operacion;
			}
			$nuevo_total_total = $nuevo_stock_total*$precioUnitario;
			$operacionesG = $lider->consultarQuery("SELECT * FROM operaciones WHERE estatus=1 and id_inventario={$id_inventario} and tipo_inventario='{$tipo_inventario}' and id_operacion<>{$id_operacion_delete} ORDER BY id_operacion DESC;");
			$operacion=$operacionesG[0];
			$id_operacion = $operacion['id_operacion'];
			$query2="UPDATE operaciones SET stock_operacion_total={$nuevo_stock_total}, total_operacion_total={$nuevo_total_total} WHERE id_operacion={$id_operacion}";

			$query0 = "UPDATE operaciones SET estatus=0 WHERE id_operacion={$id_operacion_delete}";
			// echo $query0."<br><br>";
			// echo $query1."<br><br>";
			// echo $query2."<br><br>";
			$errores = 0;
			$borrarOperacion = $lider->eliminar($query0);
			if($borrarOperacion['ejecucion']==true){}else{
				$errores++;
			}
			$actualizarAlmacen = $lider->modificar($query1);
			if($actualizarAlmacen['ejecucion']==true){}else{
				$errores++;
			}
			$actualizarTotal = $lider->modificar($query2);
			if($actualizarTotal['ejecucion']==true){}else{
				$errores++;
			}
			if($errores==0){
				$response="1";
			}else{
				$response="2";
			}
			// die();
		}
		
			// $fragancias = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		$filtros = "";
		if( !empty($_GET['fechaa']) && !empty($_GET['fechac']) ){
			$fechaa = str_replace("T"," ",$_GET['fechaa']).":00";
			$fechac = str_replace("T"," ",$_GET['fechac']).":00";
			// $fechac = $_GET['fechac'].":00";
			$filtros .= " and operaciones.fecha_operacion BETWEEN '{$fechaa}' and '{$fechac}'";
		}
		if( !empty($_GET['tipo_operacion']) ){
			$tipo_operacion = $_GET['tipo_operacion'];
			$filtros .= " and operaciones.tipo_operacion='{$tipo_operacion}'";
		}
		if( !empty($_GET['id_inventario']) ){
			list($tipo_inventario, $id_inventario) = explode('-', $_GET['id_inventario']);
			$filtros .= " and operaciones.tipo_inventario='{$tipo_inventario}'";
			$filtros .= " and operaciones.id_inventario='{$id_inventario}'";
		}
		if($filtros==""){
			// $fechaa = date('Y-m-dTH:i:a', time()-(((60*60)*24)*1) )."T00:00:00";
			// $fechac = date('Y-m-dTH:i:a')."T00:00:00";
			$fechaa = date('Y-m-d H:i', time()-((60*15)) );
			$fechac = date('Y-m-d H:i');
			$filtros .= " and operaciones.fecha_operacion BETWEEN '{$fechaa}' and '{$fechac}'";
		}
		if($_GET['filtro']=0){
			$filtros="";
		}
		// echo "Apertura: ".$fechaa."<br>";
		// echo "Cierre: ".$fechac."<br>";
		$queryOperaciones = "SELECT * FROM operaciones WHERE operaciones.estatus=1 {$filtros} ORDER BY operaciones.fecha_operacion DESC;";
		// echo $queryOperaciones;
		$operaciones = $lider->consultarQuery($queryOperaciones);
		// foreach($operaciones as $key){
		// 	print_r($key);
		// 	echo "<br><br>";
		// }
		$productoss=[];
		$mercancias=[];
		$almacenes = $lider->consultarQuery("SELECT * FROM almacenes WHERE estatus=1");
		$productos=$lider->consultarQuery("SELECT * FROM productos ORDER BY id_producto asc;");
		$mercancia=$lider->consultarQuery("SELECT * FROM mercancia ORDER BY id_mercancia asc;");

		
		$productosOn=$lider->consultarQuery("SELECT * FROM productos WHERE estatus=1 ORDER BY id_producto asc;");
		$mercanciaOn=$lider->consultarQuery("SELECT * FROM mercancia WHERE estatus=1 ORDER BY id_mercancia asc;");
		$index=0;
		foreach($productos as $pd){
			if(!empty($pd['id_producto'])){
				if($pd['id_producto']>125){
					$productoss[$pd['id_producto']]=$pd;
					$operacionesInv = $lider->consultarQuery("SELECT stock_operacion_total FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
					if(count($operacionesInv)>1){
						$productoss[$pd['id_producto']]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
					}else{
						$productoss[$pd['id_producto']]['stock_operacion_total'] = 0;
					}
					$num_almacen = 1;
					foreach ($almacenes as $key) {
						if(!empty($key['id_almacen'])){
							$operacionesInv = $lider->consultarQuery("SELECT stock_operacion_almacen FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_producto']} and id_almacen={$key['id_almacen']} and tipo_inventario='Productos' ORDER BY id_operacion DESC");
							if(count($operacionesInv)>1){
								$productoss[$pd['id_producto']]['stock_operacion_almacen'.$num_almacen] = $operacionesInv[0]['stock_operacion_almacen'];
							}else{
								$productoss[$pd['id_producto']]['stock_operacion_almacen'.$num_almacen] = 0;
							}
							$num_almacen++;
						}
					}
					$index++;
				}
			}
		}
		foreach($mercancia as $pd){
			if(!empty($pd['id_mercancia'])){
				if($pd['estatus']==1){
					$mercancias[$pd['id_mercancia']]=$pd;
					$operacionesInv = $lider->consultarQuery("SELECT stock_operacion_total FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
					if(count($operacionesInv)>1){
						$mercancias[$pd['id_mercancia']]['stock_operacion_total'] = $operacionesInv[0]['stock_operacion_total'];
					}else{
						$mercancias[$pd['id_mercancia']]['stock_operacion_total'] = 0;
					}
					$num_almacen = 1;
					foreach ($almacenes as $key) {
						if(!empty($key['id_almacen'])){
							$operacionesInv = $lider->consultarQuery("SELECT stock_operacion_almacen FROM `operaciones` WHERE estatus=1 and id_inventario = {$pd['id_mercancia']} and id_almacen={$key['id_almacen']} and tipo_inventario='Mercancia' ORDER BY id_operacion DESC");
							if(count($operacionesInv)>1){
								$mercancias[$pd['id_mercancia']]['stock_operacion_almacen'.$num_almacen] = $operacionesInv[0]['stock_operacion_almacen'];
							}else{
								$mercancias[$pd['id_mercancia']]['stock_operacion_almacen'.$num_almacen] = 0;
							}
							$num_almacen++;
						}
					}
					$index++;
				}
			}
		}
		// foreach ($productoss as $key => $value) {
		// 	print_r($key);
		// 	echo "<br><br>";
		// }

			if($operaciones['ejecucion']==1){
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