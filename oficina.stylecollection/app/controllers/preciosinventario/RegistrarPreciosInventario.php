<?php 
$amInventario = 0;
$amInventarioR = 0;
$amInventarioC = 0;
$amInventarioE = 0;
$amInventarioB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Inventarios"){
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

$id_campana = $_GET['campaing'];
$numero_campana = $_GET['n'];
$anio_campana = $_GET['y'];
if($amInventarioR){
	$optionsss = [
		0=>[
			'id'=>'planes',
			'name'=>"Premios de los planes"
		],
		1=>[
			'id'=>'promociones',
			'name'=>"Promociones"
		],
		2=>[
			'id'=>'retos',
			'name'=>"Retos Junior"
		],
		3=>[
			'id'=>'catalogo',
			'name'=>"Catálogo de gemas"
		],
	];

	// if(!empty($_POST['precio']) ){
	// 	$precio = $_POST['precio'];

	// 	$query = "SELECT * FROM precio_gema WHERE id_campana = {$id_campana} and estatus = 0";
	// 	$res1 = $lider->consultarQuery($query);
	// 	if(count($res1)>1){
	// 		$desper = $res1[0];
	// 		$query = "UPDATE precio_gema SET precio_gema='{$precio}', estatus=1 WHERE id_precio_gema={$desper['id_precio_gema']}";
	// 		$exec = $lider->modificar($query);
	// 		if($exec['ejecucion']==true ){
	// 			$response = "1";
	// 		}else{
	// 			$response = "2";
	// 		}
	// 	}else{
	// 		$query = "INSERT INTO precio_gema (id_precio_gema, precio_gema, id_campana, estatus) VALUES (DEFAULT, '{$precio}', {$id_campana}, 1)";
	// 		$exec = $lider->registrar($query, "precio_gema", "id_precio_gema");
	// 		if($exec['ejecucion']==true ){
	// 			$response = "1";
	// 		}else{
	// 			$response = "2";
	// 		}
	// 	}
     

	// 	if(!empty($action)){
	// 		if (is_file('public/views/' .strtolower($url).'/'.$action.$url.'.php')) {
	// 			require_once 'public/views/' .strtolower($url).'/'.$action.$url.'.php';
	// 		}else{
	// 			require_once 'public/views/error404.php';
	// 		}
	// 	}else{
	// 		if (is_file('public/views/'.$url.'.php')) {
	// 			require_once 'public/views/'.$url.'.php';
	// 		}else{
	// 			require_once 'public/views/error404.php';
	// 		}
	// 	}
	// }
	if(!empty($_POST)){
		// print_r($_POST);
		if(!empty($_POST['id_premio_inventario']) && !empty($_POST['unidades_inventario']) && !empty($_POST['elementos']) ){
			$ids = $_POST['id_premio_inventario'];
			$precios = $_POST['precios_inventario'];
			$cantidades = count($ids);
			$errores = 0;
			for ($i=0; $i < $cantidades; $i++) {
				$id = $ids[$i];
				if(!empty($precios[$i])){
					$precio = $precios[$i];
				}else{
					$precio=0;
				}
				$query = "UPDATE premios_inventario SET precio_inventario={$precio} WHERE id_premio_inventario={$id};";
				$exec = $lider->modificar($query);
				if($exec['ejecucion']==true){
				}else{
					$errores++;
				}
				// echo $query."<br>";
			}
			if($errores==0){
				$response=1;
			}else{
				$response=2;
			}


			
			// $optionsss = [
			// 	0=>[
			// 		'id'=>'planes',
			// 		'name'=>"Premios de los planes"
			// 	],
			// 	1=>[
			// 		'id'=>'promociones',
			// 		'name'=>"Premios de promociones"
			// 	],
			// 	2=>[
			// 		'id'=>'retos',
			// 		'name'=>"Premios de los retos"
			// 	],
			// 	3=>[
			// 		'id'=>'catalogo',
			// 		'name'=>"Premios del catalogo de gemas"
			// 	],
			// ];
			if(!empty($_GET['tipo_premio'])){
				$tipo = $_GET['tipo_premio'];
				$titulos = [];
				$adicional = [];
				$premios = [];
				if($tipo=='planes'){
					$titulosInfo = $lider->consultarQuery("SELECT DISTINCT planes.id_plan, planes.nombre_plan, planes.cantidad_coleccion FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} ORDER BY planes_campana.id_plan ASC;");
					$adicioanlInfo = $lider->consultarQuery("SELECT * FROM planes, planes_campana, despachos WHERE planes_campana.id_campana=despachos.id_campana and  planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY planes_campana.id_plan_campana ASC;");
					$adicionalTipos = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.tipo_premio FROM planes, planes_campana, despachos, premios_planes_campana WHERE premios_planes_campana.id_plan_campana=planes_campana.id_plan_campana and planes_campana.id_campana=despachos.id_campana and planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC;");
					// echo "SELECT * FROM planes, planes_campana, despachos WHERE planes_campana.id_campana=despachos.id_campana and  planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY planes_campana.id_plan ASC;";
					// echo "<br><br>";
					$index=0;
					$index2 = 0;
					foreach($titulosInfo as $info){
						if(!empty($info['id_plan'])){
							$titulos[$index]['id_conector']=$info['id_plan'];
							$titulos[$index]['name']="Plan ".$info['nombre_plan'];
							$titulos[$index]['numero']=$info['cantidad_coleccion'];
							foreach($adicioanlInfo as $add){
								if(!empty($add['id_plan'])){
									if($add['id_plan']==$info['id_plan']){
										$adicional[$index2]['id_conector']=$info['id_plan'];
										$adicional[$index2]['id_conectorTwo']=$add['id_despacho'];
										$adicional[$index2]['informacion']="Despacho ".$add['numero_despacho'];
										$index2++;
									}
								}
							}
							$index++;
						}
					}
					$premiosInfo = $lider->consultarQuery("SELECT * FROM planes, planes_campana, despachos, premios_planes_campana, tipos_premios_planes_campana, premios WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_despacho=despachos.id_despacho and planes_campana.id_campana=despachos.id_campana and planes_campana.id_plan_campana=premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc=tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.id_premio=premios.id_premio and despachos.estatus=1 and premios.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC;");
					$index=0;
					foreach($premiosInfo as $info){
						if(!empty($info['id_premio'])){
							$premios[$index]['id_premio'] = $info['id_premio'];
							$premios[$index]['nombre_premio'] = $info['nombre_premio'];
							$premios[$index]['id_conector'] = $info['id_plan'];
							$premios[$index]['id_conectorTwo'] = $info['id_despacho'];
							$premios[$index]['informacion'] = " Premio de ".$info['tipo_premio'];
							$premios[$index]['tipo_premio'] = $info['tipo_premio'];
							$premios[$index]['descripcion'] = "Plan ".$info['nombre_plan'];
							$index++;	
						}
					}
				}
				if($tipo=='retos'){
					$titulosInfo = $lider->consultarQuery("SELECT DISTINCT retosinv.id_retoinv, retosinv.nombre_retoinv, retosinv.num_coleccionesreto FROM retosinv, retos_campana WHERE retosinv.id_retoinv=retos_campana.id_retoinv and retosinv.estatus=1 and retos_campana.estatus=1 and retos_campana.id_campana={$id_campana}");
					$index=0;
					foreach ($titulosInfo as $info) {
						if(!empty($info['id_retoinv'])){
							$titulos[$index]['id_conector']=$info['id_retoinv'];
							$titulos[$index]['name']="Retos X".$info['num_coleccionesreto']." Colecciones";
							$titulos[$index]['numero']=$info['num_coleccionesreto'];
							$index++;
						}
					}
					$premiosInfo = $lider->consultarQuery("SELECT * FROM retosinv, retos_campana, premios WHERE retosinv.id_retoinv=retos_campana.id_retoinv and retosinv.estatus=1 and retos_campana.estatus=1 and premios.id_premio=retos_campana.id_premio and premios.estatus=1 and retos_campana.id_campana={$id_campana}");
					$index=0;
					foreach($premiosInfo as $info){
						if(!empty($info['id_premio'])){
							$premios[$index]['id_premio'] = $info['id_premio'];
							$premios[$index]['nombre_premio'] = $info['nombre_premio'];
							$premios[$index]['id_conector'] = $info['id_retoinv'];
							$premios[$index]['descripcion'] = "Retos X ".$info['num_coleccionesreto'];
							$index++;	
						}
					}
				}
				if($tipo=='promociones'){
					$titulosInfo = $lider->consultarQuery("SELECT DISTINCT promocionesinv.id_promocioninv, promocion.id_promocion, promocion.nombre_promocion, promocion.precio_promocion FROM promocionesinv, promocion WHERE promocion.id_promocioninv=promocionesinv.id_promocioninv and promocionesinv.estatus=1 and promocion.estatus=1 and promocion.id_campana={$id_campana}");
					$index=0;
					foreach ($titulosInfo as $info) {
						if(!empty($info['id_promocion'])){
							$titulos[$index]['id_conector']=$info['id_promocion'];
							$titulos[$index]['name']="Promocion ".$info['nombre_promocion'];
							$titulos[$index]['numero']=$info['precio_promocion'];
							$index++;
						}
					}
					$premiosInfo = $lider->consultarQuery("SELECT * FROM promocionesinv, promocion, productos_promocion, premios WHERE promocion.id_promocioninv=promocionesinv.id_promocioninv and productos_promocion.id_promocion=promocion.id_promocion and productos_promocion.id_producto=premios.id_premio and promocionesinv.estatus=1 and promocion.estatus=1 and productos_promocion.estatus=1 and promocion.id_campana={$id_campana} and productos_promocion.id_campana={$id_campana}");
					$index=0;
					foreach($premiosInfo as $info){
						if(!empty($info['id_premio'])){
							$premios[$index]['id_premio'] = $info['id_premio'];
							$premios[$index]['nombre_premio'] = $info['nombre_premio'];
							$premios[$index]['id_conector'] = $info['id_promocion'];
							$premios[$index]['descripcion'] = "Promocion ".$info['nombre_promocion'];
							$index++;	
						}
					}
				}
				if($tipo=='catalogo'){
					$titulosInfo = $lider->consultarQuery("SELECT DISTINCT catalogos.cantidad_gemas FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1 ORDER BY catalogos.cantidad_gemas ASC;");
					$index=0;
					foreach ($titulosInfo as $info) {
						if(!empty($info['cantidad_gemas'])){
							$titulos[$index]['id_conector']=$info['cantidad_gemas'];
							$titulos[$index]['name']="".$info['cantidad_gemas']." Gemas";
							$titulos[$index]['numero']=$info['cantidad_gemas'];
							$index++;
						}
					}
					$premiosInfo = $lider->consultarQuery("SELECT * FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1 ORDER BY premios.id_premio;");
					$index=0;
					foreach($premiosInfo as $info){
						if(!empty($info['id_premio'])){
							$premios[$index]['id_premio'] = $info['id_premio'];
							$premios[$index]['nombre_premio'] = $info['nombre_premio'];
							$premios[$index]['id_conector'] = $info['cantidad_gemas'];
							$premios[$index]['name']="".$info['nombre_catalogo'];
							$index++;	
						}
					}
				}
			}
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
		}
	}
    if(empty($_POST)){
		
		if(!empty($_GET['tipo_premio'])){
			$tipo = $_GET['tipo_premio'];
			$titulos = [];
			$adicional = [];
			$premios = [];
			if($tipo=='planes'){
				$titulosInfo = $lider->consultarQuery("SELECT DISTINCT planes.id_plan, planes.nombre_plan, planes.cantidad_coleccion FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} ORDER BY planes_campana.id_plan ASC");
				$adicioanlInfo = $lider->consultarQuery("SELECT * FROM planes, planes_campana, despachos WHERE planes_campana.id_campana=despachos.id_campana and  planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY planes_campana.id_plan_campana ASC;");
				$adicionalTipos = $lider->consultarQuery("SELECT DISTINCT premios_planes_campana.tipo_premio FROM planes, planes_campana, despachos, premios_planes_campana WHERE premios_planes_campana.id_plan_campana=planes_campana.id_plan_campana and planes_campana.id_campana=despachos.id_campana and planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC;");
				// echo "SELECT * FROM planes, planes_campana, despachos WHERE planes_campana.id_campana=despachos.id_campana and  planes_campana.id_despacho=despachos.id_despacho and planes.id_plan = planes_campana.id_plan and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY planes_campana.id_plan ASC;";
				// echo "<br><br>";
				$index=0;
				$index2 = 0;
				foreach($titulosInfo as $info){
					if(!empty($info['id_plan'])){
						$titulos[$index]['id_conector']=$info['id_plan'];
						$titulos[$index]['name']="Plan ".$info['nombre_plan'];
						$titulos[$index]['numero']=$info['cantidad_coleccion'];
						foreach($adicioanlInfo as $add){
							if(!empty($add['id_plan'])){
								if($add['id_plan']==$info['id_plan']){
									// echo $add['id_plan']." | ";
									$adicional[$index2]['id_conector']=$info['id_plan'];
									$adicional[$index2]['id_conectorTwo']=$add['id_despacho'];
									$adicional[$index2]['informacion']="Despacho ".$add['numero_despacho'];
									// print_r($add);
									// echo "<br><br>";
									// $titulos[$index]['id_conectorTow']=$add['id_despacho'];
									// $titulos[$index]['informacion']="Despacho ".$add['numero_despacho'];
									$index2++;
								}
							}
						}
						$index++;
					}
				}
				$premiosInfo = $lider->consultarQuery("SELECT * FROM planes, planes_campana, despachos, premios_planes_campana, tipos_premios_planes_campana, premios WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_despacho=despachos.id_despacho and planes_campana.id_campana=despachos.id_campana and planes_campana.id_plan_campana=premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc=tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.id_premio=premios.id_premio and despachos.estatus=1 and premios.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC;");
				// echo "SELECT * FROM planes, planes_campana, despachos, premios_planes_campana, tipos_premios_planes_campana, premios WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_despacho=despachos.id_despacho and planes_campana.id_campana=despachos.id_campana and planes_campana.id_plan_campana=premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc=tipos_premios_planes_campana.id_ppc and tipos_premios_planes_campana.id_premio=premios.id_premio and despachos.estatus=1 and premios.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} and despachos.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC;";
				// echo "<br><br>";
				$index=0;
				foreach($premiosInfo as $info){
					if(!empty($info['id_premio'])){
						$premios[$index]['id_premio'] = $info['id_premio'];
						$premios[$index]['nombre_premio'] = $info['nombre_premio'];
						$premios[$index]['id_conector'] = $info['id_plan'];
						$premios[$index]['id_conectorTwo'] = $info['id_despacho'];
						$premios[$index]['informacion'] = " Premio de ".$info['tipo_premio'];
						$premios[$index]['tipo_premio'] = $info['tipo_premio'];
						$premios[$index]['descripcion'] = "Plan ".$info['nombre_plan'];
						$index++;	
					}
				}
			}
			if($tipo=='retos'){
				$titulosInfo = $lider->consultarQuery("SELECT DISTINCT retosinv.id_retoinv, retosinv.nombre_retoinv, retosinv.num_coleccionesreto FROM retosinv, retos_campana WHERE retosinv.id_retoinv=retos_campana.id_retoinv and retosinv.estatus=1 and retos_campana.estatus=1 and retos_campana.id_campana={$id_campana}");
				$index=0;
				foreach ($titulosInfo as $info) {
					if(!empty($info['id_retoinv'])){
						$titulos[$index]['id_conector']=$info['id_retoinv'];
						$titulos[$index]['name']="Retos X".$info['num_coleccionesreto']." Colecciones";
						$titulos[$index]['numero']=$info['num_coleccionesreto'];
						$index++;
					}
				}
				$premiosInfo = $lider->consultarQuery("SELECT * FROM retosinv, retos_campana, premios WHERE retosinv.id_retoinv=retos_campana.id_retoinv and retosinv.estatus=1 and retos_campana.estatus=1 and premios.id_premio=retos_campana.id_premio and premios.estatus=1 and retos_campana.id_campana={$id_campana}");
				$index=0;
				foreach($premiosInfo as $info){
					if(!empty($info['id_premio'])){
						$premios[$index]['id_premio'] = $info['id_premio'];
						$premios[$index]['nombre_premio'] = $info['nombre_premio'];
						$premios[$index]['id_conector'] = $info['id_retoinv'];
						$premios[$index]['descripcion'] = "Retos X ".$info['num_coleccionesreto'];
						$index++;	
					}
				}
			}
			if($tipo=='promociones'){
				$titulosInfo = $lider->consultarQuery("SELECT DISTINCT promocionesinv.id_promocioninv, promocion.id_promocion, promocion.nombre_promocion, promocion.precio_promocion FROM promocionesinv, promocion WHERE promocion.id_promocioninv=promocionesinv.id_promocioninv and promocionesinv.estatus=1 and promocion.estatus=1 and promocion.id_campana={$id_campana}");
				$index=0;
				foreach ($titulosInfo as $info) {
					if(!empty($info['id_promocion'])){
						$titulos[$index]['id_conector']=$info['id_promocion'];
						$titulos[$index]['name']="Promocion ".$info['nombre_promocion'];
						$titulos[$index]['numero']=$info['precio_promocion'];
						$index++;
					}
				}
				$premiosInfo = $lider->consultarQuery("SELECT * FROM promocionesinv, promocion, productos_promocion, premios WHERE promocion.id_promocioninv=promocionesinv.id_promocioninv and productos_promocion.id_promocion=promocion.id_promocion and productos_promocion.id_producto=premios.id_premio and promocionesinv.estatus=1 and promocion.estatus=1 and productos_promocion.estatus=1 and promocion.id_campana={$id_campana} and productos_promocion.id_campana={$id_campana}");
				$index=0;
				foreach($premiosInfo as $info){
					if(!empty($info['id_premio'])){
						$premios[$index]['id_premio'] = $info['id_premio'];
						$premios[$index]['nombre_premio'] = $info['nombre_premio'];
						$premios[$index]['id_conector'] = $info['id_promocion'];
						// $premios[$index]['tipo_premio'] = $info['tipo_producto'];
						$premios[$index]['descripcion'] = "Promocion ".$info['nombre_promocion'];
						$index++;	
					}
				}
			}
			if($tipo=='catalogo'){
				$titulosInfo = $lider->consultarQuery("SELECT DISTINCT catalogos.cantidad_gemas FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1 ORDER BY catalogos.cantidad_gemas ASC;");
				$index=0;
				foreach ($titulosInfo as $info) {
					if(!empty($info['cantidad_gemas'])){
						$titulos[$index]['id_conector']=$info['cantidad_gemas'];
						$titulos[$index]['name']="".$info['cantidad_gemas']." Gemas";
						$titulos[$index]['numero']=$info['cantidad_gemas'];
						$index++;
					}
				}
				$premiosInfo = $lider->consultarQuery("SELECT * FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1 ORDER BY premios.id_premio;");
				$index=0;
				foreach($premiosInfo as $info){
					if(!empty($info['id_premio'])){
						$premios[$index]['id_premio'] = $info['id_premio'];
						$premios[$index]['nombre_premio'] = $info['nombre_premio'];
						$premios[$index]['id_conector'] = $info['cantidad_gemas'];
						$premios[$index]['name']="".$info['nombre_catalogo'];
						// $premios[$index]['tipo_premio'] = $info['tipo_producto'];
						// $premios[$index]['descripcion'] = "Promocion ".$info['nombre_promocion'];
						$index++;	
					}
				}
			}
			// SELECT DISTINCT catalogos.cantidad_gemas FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1;
			// SELECT * FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and premios.estatus=1 and catalogos.estatus=1;

			// foreach($titulos as $ti){
			// 		echo $ti['name'].": ".$ti['id_conector'];
			// 		echo "<br>";
			// 		foreach($adicional as $ad){
			// 			if($ad['id_conector']==$ti['id_conector']){
			// 				echo $ad['informacion'].": ".$ad['id_conector'];
			// 				echo "<br>";

			// 				foreach($premios as $pr){
			// 					if($ti['id_conector']==$pr['id_conector']){
			// 						if($ad['id_conectorTwo']==$pr['id_conectorTwo']){
			// 							echo $pr['informacion'];
			// 							// echo "<br>";
			// 							// echo $pr['descripcion'];
			// 							echo "<br>";
			// 							echo $pr['nombre_premio'];
			// 							// print_r($pr);
			// 							echo "<br><br>";
			// 						}
			// 					}
			// 				}
			// 			}
			// 		}
			// }
		}
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
	}
}else{
	require_once 'public/views/error404.php';
}

?>