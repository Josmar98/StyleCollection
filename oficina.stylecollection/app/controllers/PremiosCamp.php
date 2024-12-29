<?php 
$amPremioscamp = 0;
$amPremioscampR = 0;
$amPremioscampC = 0;
$amPremioscampE = 0;
$amPremioscampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Premios De Campaña"){
      $amPremioscamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPremioscampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPremioscampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPremioscampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPremioscampB = 1;
      }
    }
  }
}
if($amPremioscampC == 1){
	
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	
	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amPremioscampB == 1){
			$plan = $_GET['plan'];
			$ppc = $lider->consultarQuery("SELECT * FROM premios_planes_campana WHERE id_plan_campana = $plan");
			$exec = $lider->eliminar("DELETE FROM premios_planes_campana WHERE id_plan_campana = $plan");
			if($exec['ejecucion']==true){
				foreach ($ppc as $id_ppc) {
					if(!empty($id_ppc['id_ppc'])){
						$exec = $lider->eliminar("DELETE FROM tipos_premios_planes_campana WHERE id_ppc = ".$id_ppc['id_ppc']);
						if($exec['ejecucion']==true){
							$response = "1";
						}else{
							$response = "2";
						}
					}
				}

				if(!empty($modulo) && !empty($accion)){
					$fecha = date('Y-m-d');
					$hora = date('H:i:a');
					$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Premios Ce Campaña', 'Borrar', '{$fecha}', '{$hora}')";
					$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
				}
			}else{
				$response = "2";
			}
		}else{
		    require_once 'public/views/error404.php';
		}
	}


	if(empty($_POST)){

		//$despachos = $lider->consultarQuery("SELECT * FROM productos_fragancias, fragancias WHERE fragancias.id_fragancia = productos_fragancias.id_fragancia");
		$planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC;");

		$tipos_planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, premios_planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} ORDER BY premios_planes_campana.id_ppc ASC;");

		$tipos_premios = $lider->consultarQuery("SELECT DISTINCT nombre_plan, tipo_premio, tipo_premio_producto FROM planes, planes_campana, premios_planes_campana, tipos_premios_planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_campana = $id_campana and planes_campana.id_despacho = {$id_despacho}");
		
		$tpremios = $lider->consultarQuery("SELECT * FROM planes, planes_campana, premios_planes_campana, tipos_premios_planes_campana WHERE planes.id_plan = planes_campana.id_plan and planes_campana.id_plan_campana = premios_planes_campana.id_plan_campana and premios_planes_campana.id_ppc = tipos_premios_planes_campana.id_ppc and planes_campana.id_campana = $id_campana and planes_campana.estatus = 1 and planes_campana.id_despacho = {$id_despacho} ORDER BY id_tppc ASC;");

		$productos = $lider->consultarQuery("SELECT * FROM productos");
		$premios = $lider->consultarQuery("SELECT * FROM premios");

		// print_r($tipos_planes);
		// foreach($tipos_planes as $tp){
		// 	print_r($tp);
		// 	echo "<br><br><br><br>";
		// }

		// print_r($tipos_premios);
		if($planes['ejecucion']==1){
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