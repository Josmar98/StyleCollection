<?php 

$amPlanesCamp = 0;
$amPlanesCampR = 0;
$amPlanesCampC = 0;
$amPlanesCampE = 0;
$amPlanesCampB = 0;
foreach ($accesos as $access) {
  if(!empty($access['id_acceso'])){
    if($access['nombre_modulo'] == "Planes De Campaña"){
      $amPlanesCamp = 1;
      if($access['nombre_permiso'] == "Registrar"){
        $amPlanesCampR = 1;
      }
      if($access['nombre_permiso'] == "Ver"){
        $amPlanesCampC = 1;
      }
      if($access['nombre_permiso'] == "Editar"){
        $amPlanesCampE = 1;
      }
      if($access['nombre_permiso'] == "Borrar"){
        $amPlanesCampB = 1;
      }
    }
  }
}
if($amPlanesCampC == 1){
	$opcionesSeconds = [
    ['id'=>0, 'name'=>'No hacer nada'],
    ['id'=>1, 'name'=>'Seleccionar segunda opción de premios'],
  ];

	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];

	$id_despacho = $_GET['dpid'];
	$num_despacho = $_GET['dp'];
	$menu3 = "campaing=".$id_campana."&n=".$numero_campana."&y=".$anio_campana."&dpid=".$id_despacho."&dp=".$num_despacho."&";

	$despachos=$lider->consultarQuery("SELECT * FROM despachos WHERE id_campana = {$id_campana} and estatus = 1");
	// $pagos_despacho = $lider->consultarQuery("SELECT * FROM despachos, pagos_despachos WHERE despachos.id_despacho = pagos_despachos.id_despacho and despachos.id_campana = {$id_campana} and despachos.estatus = 1 and pagos_despachos.estatus = 1");

	$planes=$lider->consultarQuery("SELECT * FROM planes, planes_campana, campanas WHERE planes.id_plan = planes_campana.id_plan and campanas.id_campana = planes_campana.id_campana and campanas.estatus = 1 and planes.estatus = 1 and campanas.id_campana = $id_campana and planes_campana.id_despacho = {$id_despacho}");


	$campana2 = $lider->consultarQuery("SELECT * FROM campanas WHERE estatus = 1 and id_campana = $id_campana");
	$campana = $campana2[0];

	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		if($amPlanesCampB == 1){

			$query = "UPDATE planes_campana SET estatus = 0 WHERE id_plan_campana = $id";
			$res1 = $lider->eliminar($query);
			if($res1['ejecucion']==true){
				$response = "1";
				$query = "UPDATE pagos_planes_campana SET estatus = 0 WHERE id_plan_campana = $id";
				$res1 = $lider->eliminar($query);
				if($res1['ejecucion']==true){
					$response = "1";
					if(!empty($modulo) && !empty($accion)){
						$fecha = date('Y-m-d');
						$hora = date('H:i:a');
						$query = "INSERT INTO bitacora (id_bitacora, id_usuario, modulo, accion, fecha, hora) VALUES (DEFAULT, {$_SESSION['id_usuario']}, 'Planes De Campaña', 'Borrar', '{$fecha}', '{$hora}')";
						$exec = $lider->Registrar($query, "bitacora", "id_bitacora");
					}
				}else{
					$response = "2";
				}
			}else{
				$response = "2"; // echo 'Error en la conexion con la bd';
			}

		}else{
			require_once 'public/views/error404.php';		
		}
	}




	if(empty($_POST)){
		$planes_campana = $lider->consultarQuery("SELECT * FROM planes, planes_campana WHERE planes.id_plan = planes_campana.id_plan and  planes_campana.estatus = 1 and planes_campana.id_campana = {$id_campana} and planes_campana.id_despacho = {$id_despacho} ORDER BY planes.id_plan ASC");
		$pagos_planes_campana=$lider->consultarQuery("SELECT * FROM planes_campana, pagos_planes_campana WHERE planes_campana.id_plan_campana = pagos_planes_campana.id_plan_campana and planes_campana.id_campana = pagos_planes_campana.id_campana and planes_campana.id_despacho = pagos_planes_campana.id_despacho and pagos_planes_campana.id_campana = {$id_campana} and pagos_planes_campana.id_despacho = {$id_despacho} and planes_campana.estatus = 1 and pagos_planes_campana.estatus = 1");
		
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