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

if($amInventarioC){
	$id_campana = $_GET['campaing'];
	$numero_campana = $_GET['n'];
	$anio_campana = $_GET['y'];
	if(!empty($_GET['permission']) && $_GET['permission'] == 1 ){
		$query = "UPDATE precio_gema SET estatus = 0 WHERE id_precio_gema = $id";
		$res1 = $lider->eliminar($query);
		if($res1['ejecucion']==true){
			$response = "1";
		}else{
			$response = "2"; // echo 'Error en la conexion con la bd';
		}
	}

	if(empty($_POST)){
		$datas = [];
		$premiosinv = $lider->consultarQuery("SELECT * FROM premios, premios_inventario WHERE premios.estatus=1 and premios_inventario.estatus=1 and premios.id_premio=premios_inventario.id_premio;");
		$premios = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus=1");
		$planes = $lider->consultarQuery("SELECT * FROM planes, planes_campana, premios_planes_campana, tipos_premios_planes_campana WHERE planes.id_plan=planes_campana.id_plan and premios_planes_campana.id_plan_campana=planes_campana.id_plan_campana and tipos_premios_planes_campana.id_ppc=premios_planes_campana.id_ppc and planes.estatus=1 and planes_campana.estatus=1 and planes_campana.id_campana={$id_campana} ORDER BY premios_planes_campana.id_ppc ASC");
		$promociones = $lider->consultarQuery("SELECT *, productos_promocion.tipo_producto as tipo_inventario, productos_promocion.id_producto as id_premio FROM promocionesinv, promocion, productos_promocion WHERE promocionesinv.id_promocioninv=promocion.id_promocioninv and promocionesinv.estatus=1 and promocion.estatus=1 and promocion.id_promocion=productos_promocion.id_promocion and productos_promocion.estatus=1 and promocion.id_campana={$id_campana} and productos_promocion.id_campana={$id_campana};");
		$retos = $lider->consultarQuery("SELECT * FROM retosinv, retos_campana, premios WHERE retosinv.id_retoinv=retos_campana.id_retoinv and retosinv.estatus=1 and retos_campana.estatus=1 and premios.id_premio = retos_campana.id_premio and premios.estatus=1 and retos_campana.id_campana={$id_campana}");
		$catalogos = $lider->consultarQuery("SELECT * FROM catalogos, premios WHERE catalogos.id_premio=premios.id_premio and catalogos.estatus=1 and premios.estatus=1");
		$index=0;
		foreach ($premios as $key1) {
			if(!empty($key1['id_premio'])){
				foreach ($planes as $key2) {
					if(!empty($key2['id_premio'])){
						if($key1['id_premio']==$key2['id_premio']){
							$datas[$index]['descripcion'] = "Planes de campana";
							$datas[$index]['tipo_premio'] = $key2['tipo_premio'];
							$datas[$index]['nombre_premio'] = $key1['nombre_premio'];
							$datas[$index]['id_premio'] = $key1['id_premio'];
							$index++;
						}
					}
				}
				foreach ($promociones as $key2) {
					if(!empty($key2['id_premio'])){
						if($key1['id_premio']==$key2['id_premio']){
							$datas[$index]['descripcion'] = "Promociones de campana";
							$datas[$index]['tipo_premio'] = $key2['nombre_promocion'];
							$datas[$index]['nombre_premio'] = $key1['nombre_premio'];
							$datas[$index]['id_premio'] = $key1['id_premio'];
							$index++;
						}
					}
				}
				foreach ($retos as $key2) {
					if(!empty($key2['id_premio'])){
						if($key1['id_premio']==$key2['id_premio']){
							$datas[$index]['descripcion'] = "Retos de campana";
							$datas[$index]['tipo_premio'] = $key2['nombre_retoinv'];
							$datas[$index]['nombre_premio'] = $key1['nombre_premio'];
							$datas[$index]['id_premio'] = $key1['id_premio'];
							$index++;
						}
					}
				}
				foreach ($catalogos as $key2) {
					if(!empty($key2['id_premio'])){
						if($key1['id_premio']==$key2['id_premio']){
							$datas[$index]['descripcion'] = "Catalogos de gemas";
							$datas[$index]['tipo_premio'] = $key2['nombre_catalogo']." X".$key2['cantidad_gemas']." Gemas";
							$datas[$index]['nombre_premio'] = $key1['nombre_premio'];
							$datas[$index]['id_premio'] = $key1['id_premio'];
							$index++;
						}
					}
				}
			}
		}
		$premiosOrder = $lider->consultarQuery("SELECT * FROM premios WHERE premios.estatus=1 ORDER BY premios.id_premio DESC");
		$preciosPremios = [];
		$index = 0;
		foreach ($premiosOrder as $key1) {
			if(!empty($key1['id_premio'])){
				foreach($datas as $key2){
					if($key1['id_premio']==$key2['id_premio']){
						$preciosPremios[$index] = $key2;
						$index++;
					}
				}
			}
		}
		// print_r($preciosPremios);
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